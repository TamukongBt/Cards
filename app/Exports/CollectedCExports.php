<?php

namespace App\Exports;

use App\ChequeTransmissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class CollectedCExports implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings
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
                'Cheque Holder',
                'Branch Code',
                'Collected By',
                'Date Uploaded',
                'Date Collected',
            ];
        }

            public function map($requested): array
                    {
                        return [
                            $requested->chequeholder,
                            $requested->branchcode,
                            $requested->collected_by,
                            Date::dateTimeToExcel($requested->created_at),
                            Date::dateTimeToExcel($requested->collected_at),
                        ];
                    }

                    public function columnFormats(): array
                    {
                        return [
                            'A' => NumberFormat::FORMAT_TEXT,
                            'B' => NumberFormat::FORMAT_NUMBER,
                            'C' => NumberFormat::FORMAT_TEXT,
                            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                        ];
                    }



        public function query()
        {
            ob_end_clean();
             ob_start();
            return ChequeTransmissions::query()->select('chequeholder','branchcode','collected_by','created_at','collected_at')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('collected',1);
        }
}
