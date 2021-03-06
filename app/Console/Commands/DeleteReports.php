<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Reports;

class DeleteReports extends Command
{

    protected $signature = 'Delete:Reports';

    protected $description = 'Deletes unused reports';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $days = env('REPORT_DAYS',100);
        $deleteDate = Carbon::now()->subDays($days)->format('Y-m-d');
                
        echo "\n".'*************************************Deleting reports for date '.$deleteDate.' ******************************************'."\n";
        Reports::where('deldate','<',$deleteDate)->delete();
        
    }
}
