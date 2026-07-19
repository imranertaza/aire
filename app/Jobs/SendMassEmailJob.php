<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\EmailCampaign;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendMassEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaignId;
    public $audiences;
    public $subject;
    public $messageBody;
    
    protected $sentCount = 0;
    protected $failedCount = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $campaignId, array $audiences, string $subject, string $messageBody)
    {
        $this->campaignId = $campaignId;
        $this->audiences = $audiences;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = EmailCampaign::find($this->campaignId);
        if (!$campaign) {
            return;
        }

        // 1. Chunk and send to Customers if requested
        if (in_array('customer', $this->audiences)) {
            Customer::select('id', 'email')
                ->whereNotNull('email')
                ->chunkById(1000, function ($customers) use ($campaign) {
                    foreach ($customers as $customer) {
                        $this->sendEmail($customer->email);
                    }
                    $campaign->increment('sent_count', $this->sentCount);
                    $campaign->increment('failed_count', $this->failedCount);
                    $this->sentCount = 0;
                    $this->failedCount = 0;
                });
        }

        // 2. Chunk and send to Subscribers if requested
        if (in_array('subscribe', $this->audiences)) {
            Newsletter::select('id', 'email')
                ->whereNotNull('email')
                ->where('status', 1)
                ->chunkById(1000, function ($subscribers) use ($campaign) {
                    foreach ($subscribers as $subscriber) {
                        $this->sendEmail($subscriber->email);
                    }
                    $campaign->increment('sent_count', $this->sentCount);
                    $campaign->increment('failed_count', $this->failedCount);
                    $this->sentCount = 0;
                    $this->failedCount = 0;
                });
        }

        // Mark campaign as completed
        $campaign->update(['status' => 'completed']);
    }

    private function sendEmail(string $email)
    {
        try {
            Mail::raw($this->messageBody, function ($message) use ($email) {
                $message->to($email)->subject($this->subject);
            });
            $this->sentCount++;
        } catch (\Exception $e) {
            Log::error("SendMassEmailJob: Failed to send email to {$email}: " . $e->getMessage());
            $this->failedCount++;
        }
    }
}
