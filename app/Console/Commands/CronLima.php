<?php

namespace App\Console\Commands;

use App\Models\CaseList;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CronLima extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:lima';

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
            $date = Carbon::now()->format('Ymd');

            if ($case->ir_status == 1) {
                $limit = Carbon::parse($case->fr_limit)->format('Ymd');

                if ($case->fr_status == 0) {
                    if ($date > $limit) {
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.welcome', ['adjuster' => $case->adjuster->nama_lengkap, 'content' => 'Your time has been exceeded from limit, please upload the report 5.', 'report' => 'Report 5'], function ($message) use ($case) {
                            $message
                                ->to($case->adjuster->email, $case->adjuster->nama_lengkap)
                                ->subject('Reminder - Report 5');
                        });
                        $case->update(['fr_limit' => Carbon::parse($limit)->addDay(7)->format('Y-m-d')]);
                    }
                }
            }
        }
    }
}
