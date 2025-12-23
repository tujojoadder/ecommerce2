<?php

namespace App\Console\Commands;

use App\Models\SmsLog;
use Illuminate\Console\Command;

class ScheduleSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send sms to selected clients!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $smsLogs = SmsLog::where('status', 0)->where('schedule_at', date('Y-m-d'))->whereNotNull('schedule_at')->get();
        foreach ($smsLogs as $log) {
            sendSms('client', $log->client_id, 'custom', null, null, $log->message_body);
            $smsLog = SmsLog::findOrFail($log->id);
            $smsLog->update(['status' => 1]);
        }
        $this->info('Successfully sms to selected clients!');
    }
}
