<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class RunTestSuiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $reportDir = storage_path('app/test-reports');
        if (!File::exists($reportDir)) {
            File::makeDirectory($reportDir, 0755, true);
        }

        $reportLogPath = $reportDir . '/latest.log';

        // Cross-platform PHP CLI detection
        $phpCli = 'php';
        if (PHP_OS_FAMILY === 'Windows') {
            $candidate = str_replace('php-cgi.exe', 'php.exe', PHP_BINARY);
            if (file_exists($candidate)) {
                $phpCli = $candidate;
            }
        } else {
            $majorMinor = defined('PHP_MAJOR_VERSION') && defined('PHP_MINOR_VERSION')
                ? PHP_MAJOR_VERSION . PHP_MINOR_VERSION
                : '83';
            $candidates = [
                "/usr/local/bin/ea-php{$majorMinor}",
                "/opt/cpanel/ea-php{$majorMinor}/root/usr/bin/php",
                "/opt/alt/php{$majorMinor}/usr/bin/php",
                "/usr/bin/ea-php{$majorMinor}",
                "/usr/bin/php{$majorMinor}",
                "/usr/bin/php-cli",
                "/usr/local/bin/php",
                "/usr/bin/php",
            ];
            foreach ($candidates as $cand) {
                if (@file_exists($cand)) {
                    $phpCli = $cand;
                    break;
                }
            }
        }

        $phpunitPath = base_path('vendor/bin/phpunit');
        if (!file_exists($phpunitPath)) {
            $phpunitPath = base_path('vendor/phpunit/phpunit/phpunit');
        }

        cache()->put('latest_test_run', [
            'status'      => 'running',
            'started_at'  => now()->toDateTimeString(),
        ], now()->addDays(7));

        try {
            $output = '';

            if (function_exists('proc_open')) {
                $process = new Process(
                    [$phpCli, '-q', '-d', 'cgi.force_redirect=0', $phpunitPath, '--configuration', base_path('phpunit.xml'), '--colors=never'],
                    base_path(),
                    [
                        'APP_ENV'          => 'testing',
                        'DB_CONNECTION'    => 'sqlite',
                        'DB_DATABASE'      => ':memory:',
                        'CACHE_STORE'      => 'array',
                        'SESSION_DRIVER'   => 'array',
                        'MAIL_MAILER'      => 'array',
                        'QUEUE_CONNECTION' => 'sync',
                        'REDIRECT_STATUS'  => '200',
                        'SCRIPT_FILENAME'  => $phpunitPath,
                        'SYSTEMROOT'       => getenv('SYSTEMROOT') ?: 'C:\\Windows',
                        'PATH'             => getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin',
                        'HOME'             => getenv('HOME') ?: base_path(),
                    ]
                );

                $process->setTimeout(600);
                $process->run();
                $output = $process->getOutput() ?: $process->getErrorOutput();
                $isSuccessful = $process->isSuccessful();
                $exitCode = $process->getExitCode();
            } else {
                putenv('APP_ENV=testing');
                putenv('DB_CONNECTION=sqlite');
                putenv('DB_DATABASE=:memory:');
                \Illuminate\Support\Facades\Artisan::call('test', ['--env' => 'testing']);
                $output = \Illuminate\Support\Facades\Artisan::output();
                $isSuccessful = true;
                $exitCode = 0;
            }

            File::put($reportLogPath, $output ?: 'Tests ran with no output.');

            cache()->put('latest_test_run', [
                'status'       => $isSuccessful ? 'passed' : 'failed',
                'completed_at' => now()->toDateTimeString(),
                'exit_code'    => $exitCode,
            ], now()->addDays(7));

            Log::info('Automated test suite execution completed via RunTestSuiteJob.');
        } catch (\Throwable $e) {
            $errorMsg = "Test suite job error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
            File::put($reportLogPath, $errorMsg);

            cache()->put('latest_test_run', [
                'status'       => 'error',
                'completed_at' => now()->toDateTimeString(),
                'error'        => $e->getMessage(),
            ], now()->addDays(7));

            Log::error($errorMsg);
        }
    }
}
