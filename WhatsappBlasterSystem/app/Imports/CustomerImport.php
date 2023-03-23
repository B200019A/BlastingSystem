<?php

namespace App\Imports;

use App\Models\Customer;
use Attribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;
class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $blaster_id;
    public function  __construct($blaster_id)
    {
        dd($blaster_id);
        $this->blaster_id = $blaster_id;
    }
    public function model(array $row)
    {
        return new Customer([
            'user_id'  => Auth::id(),
            'blasting_id'  => $this->blaster_id,
            'attribute1' => $row['attribute1'],
            'attribute2' => $row['attribute2'],
            'attribute3' => $row['attribute3'],
            'attribute4' => $row['attribute4'],
            'attribute5' => $row['attribute5'],
            'attribute6' => $row['attribute6'],
            'attribute7' => $row['attribute7']
        ]);
    }
}
