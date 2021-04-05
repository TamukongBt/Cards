<?php

namespace App\Exports;

use App\CheckRequest;
use App\Requested;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChecksExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings
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
                'Requested Date',
                'Branch',
                'Bank Code',
                'Branch Code',
                'Account Number',
                'RIB',
                'Account Name',
                'Check Type',
                'Telephone',
                'Email',
                'Type Of Account',
                'Keyer ID',
                'Requested By',
            ];
        }

            public function map($requested): array
                    {
                        return [
                            Date::dateTimeToExcel($requested->created_at),
                            $requested->branch_id,
                            $requested->bankcode,
                            $requested->branchcode,
                            $requested->account_number,
                            $requested->RIB,
                            $requested->accountname,
                            $requested->checks,
                            $requested->tel,
                            $requested->email,
                            $requested->account_type,
                            $requested->done_by,
                            $requested->requested_by,
                        ];
                    }

                    public function columnFormats(): array
                    {
                        return [
                            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                            'B' => NumberFormat::FORMAT_NUMBER,
                            'C' => NumberFormat::FORMAT_NUMBER,
                            'D' => NumberFormat::FORMAT_NUMBER,
                            'E' => NumberFormat::FORMAT_NUMBER,
                            'F' => NumberFormat::FORMAT_TEXT,
                            'G' => NumberFormat::FORMAT_TEXT,
                            'H' => NumberFormat::FORMAT_GENERAL,
                            'I' => NumberFormat::FORMAT_TEXT,
                            'J' => NumberFormat::FORMAT_TEXT,
                            'K' => NumberFormat::FORMAT_TEXT,
                            'L' => NumberFormat::FORMAT_TEXT,
                        ];
                    }


            public function query()
            {

                 ob_start();
                 return CheckRequest::query()->select('created_at','branch_id','bankcode','branchcode','account_number','RIB','accountname','checks','tel','email','account_type','done_by','requested_by')->wherebetween('created_at', [$this->startdate, $this->enddate])->where('confirmed',1)->where('in_production',1);
                 ob_end_clean();
            }
}
