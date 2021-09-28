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
                        Mail::raw("Your time has been exceeded from limit, please upload the report.", function ($message) use ($case) {
                            // $message->from('axis-pro@gmail.com');
                            $message->to($case->adjuster->email)->subject('Reminder');
                        });
                        $case->update(['fr_limit' => Carbon::parse($limit)->addDay(7)->format('Y-m-d')]);
                    }
                }
            }
        }
    }
}
