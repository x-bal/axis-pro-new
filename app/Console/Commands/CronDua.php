<?php

namespace App\Console\Commands;

use App\Models\CaseList;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CronDua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:dua';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $caseLists = CaseList::get();

        foreach ($caseLists as $case) {
            $limit = Carbon::parse($case->pr_limit)->format('Ymd');
            $date = Carbon::now()->format('Ymd');

            if ($case->pr_status == 0) {
                if ($date > $limit) {
                    $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                    $beautymail->send('emails.welcome', ['adjuster' => $case->adjuster->nama_lengkap, 'content' => 'Your time has been exceeded from limit, please upload the report 2.', 'report' => 'Report 2'], function ($message) use ($case) {
                        $message
                            ->to($case->adjuster->email, $case->adjuster->nama_lengkap)
                            ->subject('Reminder - Report 2');
                    });
                    $case->update(['pr_limit' => Carbon::parse($limit)->addDay(14)->format('Y-m-d')]);
                }
            }
        }
    }
}
