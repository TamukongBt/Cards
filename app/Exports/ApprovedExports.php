<?php

namespace App\Exports;

use App\Requested;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApprovedExports implements FromQuery
{
    use Exportable;



        public function __construct(string $startdate, string $enddate)
        {
             $this->startdate = $startdate;
            $this->enddate = $enddate;

        }

        public function query()
        {
            ob_end_clean();
             ob_start();
            return Requested::query()->select('branch_id','account_number','account_name','cards','request_type','account_type','done_by','requested_by','created_at')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('confirmed',1);
        }
}