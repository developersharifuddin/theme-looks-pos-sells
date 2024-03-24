<?php

namespace App\Console\Commands;

use App\Jobs\SendBulkEmails;
use Illuminate\Console\Command;

class SendBulkEmailCommand extends Command
{
    protected $signature = 'email:send-bulk';

    protected $description = 'Send bulk emails to all users';

    public function handle()
    {
        $this->info('Sending bulk emails...');
        SendBulkEmails::dispatch();
        $this->info('Bulk emails are being sent!');
    }
}
