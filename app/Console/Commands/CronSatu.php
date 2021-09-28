<?php

namespace App\Console\Commands;

use App\Models\CaseList;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CronSatu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:satu';

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
            $limit = Carbon::parse($case->ia_limit)->format('Ymd');
            $date = Carbon::now()->format('Ymd');

            if ($case->ia_status == 0) {
                if ($date > $limit) {
                    Mail::raw("Your time has been exceeded from limit, please upload the report.", function ($message) use ($case) {
                        // $message->from('axis-pro@gmail.com');
                        $message->to($case->adjuster->email)->subject('Reminder');
                    });
                    $case->update(['ia_limit' => Carbon::parse($limit)->addDay(7)->format('Y-m-d')]);
                }
            }
        }
        
    }
}
