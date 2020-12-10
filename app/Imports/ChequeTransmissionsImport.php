<?php

namespace App\Imports;

use App\Transmission;
use App\ChequeTransmissions;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChequeTransmissionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new ChequeTransmissions
                    ([
                        'chequeholder' => $row['cheque_holder'],
                        'branchcode'=>$row['branch_ordering'],
                        'remarks'=>$row['remarks'],
                    ]);



    }
}
