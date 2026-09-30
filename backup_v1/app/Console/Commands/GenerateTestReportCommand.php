<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class GenerateTestReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the automated test suite and save the report for web viewing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting automated test suite execution...');

        $reportDir = storage_path('app/test-reports');
        if (!File::exists($reportDir)) {
            File::makeDirectory($reportDir, 0755, true);
        }

        $reportLogPath = $reportDir . '/latest.log';

        $phpunitPath = base_path('vendor/bin/phpunit');
        if (!file_exists($phpunitPath)) {
            $phpunitPath = base_path('vendor/phpunit/phpunit/phpunit');
        }

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

        $output = '';
        $isPassed = false;
        $exitCode = 0;

        try {
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
                $isPassed = $process->isSuccessful();
                $exitCode = $process->getExitCode();
            }

            // If proc_open produced CGI 500 error or is unavailable, fallback to Artisan::call
            if (empty($output) || str_contains($output, '500 Internal Server Error') || !function_exists('proc_open')) {
                $this->info('Running tests via internal Artisan test runner...');
                putenv('APP_ENV=testing');
                putenv('DB_CONNECTION=sqlite');
                putenv('DB_DATABASE=:memory:');

                $exitCode = \Illuminate\Support\Facades\Artisan::call('test', [
                    '--env'     => 'testing',
                    '--no-ansi' => true,
                ]);

                $output = \Illuminate\Support\Facades\Artisan::output();
                $isPassed = ($exitCode === 0);
            }
        } catch (\Throwable $e) {
            $output = "Execution Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString();
            $isPassed = false;
            $exitCode = 1;
        }

        File::put($reportLogPath, $output ?: 'Tests ran with no output.');

        cache()->put('latest_test_run', [
            'status'       => $isPassed ? 'passed' : 'failed',
            'completed_at' => now()->toDateTimeString(),
            'exit_code'    => $exitCode,
        ], now()->addDays(7));

        if ($isPassed) {
            $this->info('All tests passed successfully! Report saved to storage/app/test-reports/latest.log');
            return Command::SUCCESS;
        }

        $this->error('Some tests failed. Report saved to storage/app/test-reports/latest.log');
        return Command::FAILURE;
    }
}
