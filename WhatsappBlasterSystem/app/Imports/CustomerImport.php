<?php

namespace App\Imports;

use App\Models\Customer;
use Attribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'user_id'  => $row['user_id'],
            'blasting_id'  => $row['blasting_id'],
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
