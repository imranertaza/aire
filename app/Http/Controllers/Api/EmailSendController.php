<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\EmailCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMassEmailJob;

class EmailSendController extends Controller
{
    public function getRecipients()
    {
        $customers = Customer::select('id', 'firstname', 'lastname', 'email')->get()->map(function ($c) {
            return ['value' => 'c_' . $c->id, 'label' => 'Customer: ' . $c->firstname . ' ' . $c->lastname . ' (' . $c->email . ')'];
        });

        $subscribers = Newsletter::where('status', 1)->select('id', 'email')->get()->map(function ($s) {
            return ['value' => 's_' . $s->id, 'label' => 'Subscriber: ' . $s->email];
        });

        return ApiResponse::success([
            'customers' => $customers,
            'subscribers' => $subscribers,
        ], 'Recipients fetched');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'user'    => 'required|array|min:1',
            'user.*'  => 'in:subscribe,customer',
        ]);

        $totalRecipients = 0;

        if (in_array('subscribe', $validated['user'])) {
            $totalRecipients += Newsletter::where('status', 1)->whereNotNull('email')->count();
        }
        
        if (in_array('customer', $validated['user'])) {
            $totalRecipients += Customer::whereNotNull('email')->count();
        }

        if ($totalRecipients === 0) {
            return ApiResponse::error('No valid email addresses found for the selected group.', 404);
        }

        // Create campaign tracker
        $campaign = EmailCampaign::create([
            'subject' => $validated['subject'],
            'audiences' => implode(',', $validated['user']),
            'total_recipients' => $totalRecipients,
            'status' => 'processing',
        ]);

        // Dispatch the job to run in the background
        SendMassEmailJob::dispatch($campaign->id, $validated['user'], $validated['subject'], $validated['message']);

        return ApiResponse::success(null, 'Emails are being processed in the background. You can safely close this page.');
    }
}
