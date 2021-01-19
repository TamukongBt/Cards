<?php

namespace App\Imports;

use App\ChequeTransmissions;
use App\Events\ChequeAvailable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;


class ChequeTransmissionsImport implements WithEvents, ToModel, WithHeadingRow
{
    use  RegistersEventListeners;



    public static function afterImport(AfterImport $event)
    {
        $transmission=ChequeTransmissions::all();
        ChequeAvailable::dispatch($transmission);
        // event(new CardsAvailable($event));
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
