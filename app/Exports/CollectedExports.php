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

class CollectedExports implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings
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
                'Card Holder',
                'Card Type',
                'Card Number',
                'Branch Code',
                'Remarks',
                'PIN Collected',
                'Collected By',
                'Date Uploaded',
                'Date Collected',
            ];
        }

            public function map($requested): array
                    {
                        return [
                            $requested->cardholder,
                            $requested->cardtype,
                            $requested->card_number,
                            $requested->branchcode,
                            $requested->remarks,
                            $requested->pin_collected,
                            $requested->collected_by,
                            Date::dateTimeToExcel($requested->created_at),
                            Date::dateTimeToExcel($requested->collected_at),
                        ];
                    }

                    public function columnFormats(): array
                    {
                        return [
                            'A' => NumberFormat::FORMAT_TEXT,
                            'A' => NumberFormat::FORMAT_TEXT,
                            'B' => NumberFormat::FORMAT_TEXT,
                            'C' => NumberFormat::FORMAT_NUMBER,
                            'D' => NumberFormat::FORMAT_TEXT,
                            'E' => NumberFormat::FORMAT_TEXT,
                            'F' => NumberFormat::FORMAT_TEXT,
                            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                        ];
                    }


        public function query()
        {
            ob_end_clean();
             ob_start();
            return Transmissions::query()->select('cardholder','card_type','card_number','branchcode','remarks','pin_collected','collected_by','created_at','collected_at')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('collected',1);
        }
}
