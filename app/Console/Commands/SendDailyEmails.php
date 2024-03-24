<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\DailyEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyEmails extends Command
{
    protected $signature = 'email:daily';

    protected $description = 'Send daily emails to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new DailyEmail($user));
        }

        $this->info('Daily emails sent successfully!');
    }
}
