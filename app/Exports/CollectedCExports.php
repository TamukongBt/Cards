<?php

namespace App\Exports;

use App\ChequeTransmissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollectedCExports implements FromQuery
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
            return ChequeTransmissions::query()->select('chequeholder','branchcode','collected_by','created_at','collected_at')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('collected',1);
        }
}
