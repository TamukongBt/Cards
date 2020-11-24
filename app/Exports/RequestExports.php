<?php

namespace App\Exports;

use App\Requested;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class RequestExports implements FromQuery{

    use Exportable;



    public function __construct(string $startdate, string $enddate)
    {
         $this->startdate = $startdate;
        $this->enddate = $enddate;

    }

    public function query()
    {
        return Requested::query()->wherebetween('created_at', [$this->startdate, $this->enddate]);;
    }
}
