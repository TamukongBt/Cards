<?php

namespace App\Exports;

use App\Transmissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestExports implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings
{

    use Exportable;



    public function __construct(string $startdate, string $enddate)
    {
         $this->startdate = $startdate;
        $this->enddate = $enddate;

    }

    public function headings(): array
    {
        return [
            'Branch',
            'Account Number',
            'Account Name',
            'Card Type',
            'Type Of Request',
            'Type Of Account',
            'Keyer ID',
            'Requested By',
            'Requested Date'
        ];
    }

        public function map($requested): array
                {
                    return [
                        $requested->branch_id,
                        $requested->account_number,
                        $requested->accountname,
                        $requested->cards,
                        $requested->request_type,
                        $requested->account_type,
                        $requested->done_by,
                        $requested->requested_by,
                        Date::dateTimeToExcel($requested->created_at),
                    ];
                }

                public function columnFormats(): array
                {
                    return [
                        'A' => NumberFormat::FORMAT_NUMBER,
                        'B' => NumberFormat::FORMAT_NUMBER,
                        'C' => NumberFormat::FORMAT_TEXT,
                        'D' => NumberFormat::FORMAT_TEXT,
                        'E' => NumberFormat::FORMAT_TEXT,
                        'F' => NumberFormat::FORMAT_TEXT,
                        'G' => NumberFormat::FORMAT_TEXT,
                        'H' => NumberFormat::FORMAT_TEXT,
                        'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                    ];
                }

    public function query()
    {
        return Requested::query()->select('branch_id','account_number','accountname','cards','request_type','account_type','done_by','requested_by','created_at')->wherebetween('created_at', [$this->startdate, $this->enddate]);;
    }
}
