<?php

namespace App\Imports;



use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Transmissions;

class TransmissionsImport implements ToCollection, WithHeadingRow
{


    /**
     * @return string|array
     */


    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Transmissions::updateOrCreate([
                'cardholder' => $row['card_holder'],
                'card_type'=>$row['type_of_card'],
                'email'=>$row['email'],
                'branchcode'=>$row['branch_ordering'],
                'card_number'=>$row['card_number'],
                'phone_number'=>$row['phone_number'],
                'remarks'=>$row['remarks'],
            ]);
        }
    }





}
