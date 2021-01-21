<?php

namespace App\Imports;

use App\Events\CardsAvailable;
use App\Transmission;
use App\Transmissions;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class TransmissionsImport implements ToModel, WithHeadingRow,  WithEvents
{
    use  RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (CardsAvailable $transmission) {
                $transmission=Transmissions::all();


            },
        ];
    }


    public function model(array $row)
    {

        return new Transmissions
                    ([
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
