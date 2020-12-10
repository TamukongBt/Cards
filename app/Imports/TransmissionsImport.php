<?php

namespace App\Imports;

use App\Transmission;
use App\Transmissions;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransmissionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Transmissions
                    ([
                        'cardholder' => $row['card_holder'],
                        'card_type'=>$row['type_of_card'],
                        'branchcode'=>$row['branch_ordering'],
                        'card_number'=>$row['card_number'],
                        'remarks'=>$row['remarks'],
                    ]);



    }
}
