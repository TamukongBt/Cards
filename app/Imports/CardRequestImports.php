<?php

namespace App\Imports;

use App\CardRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CardRequestImports implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
       foreach ($collection as $row) {

        CardRequest::where('account_number', $row['account_number'])
                    ->where('request_type','new_card')
                    ->where('cards',$row['card_type'])
                    ->update(['card_number' => $row['card_number'],'distrubuted'=> '1']);
       }
    }
}

