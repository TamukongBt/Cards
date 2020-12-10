<?php

namespace App\Exports;

use App\Transmissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollectedExports implements FromQuery
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
            return Transmissions::query()->select('cardholder','card_type','branchcode','card_number','remarks','collected_by','created_at','collected_at')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('collected',1);
        }
}
