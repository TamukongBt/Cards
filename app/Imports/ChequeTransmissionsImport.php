<?php

namespace App\Imports;

use App\ChequeTransmissions;
use App\Events\ChequeAvailable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ChequeTransmissionsImport implements ToModel, WithUpserts
{
    use  RegistersEventListeners;


    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'email';
    }


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
                        'email'=>$row['email'],
                        'phone_number'=>$row['phone_number'],
                        'remarks'=>$row['remarks'],
                    ]);



    }
}
