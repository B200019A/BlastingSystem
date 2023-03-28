<?php

namespace App\Imports;

use App\Models\Customer;
use Attribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithLimit;

use Auth;
class CustomerImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithLimit
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $blaster_id;
    private $current_existed;
    public function __construct($blaster_id,$current_existed)
    {
        $this->blaster_id = $blaster_id;
        $this->current_existed = $current_existed;
    }

    public function model(array $row)
    {
        return new Customer([
            // 'id'  => $row['user_id'],
            'blaster_id'  => $this->blaster_id,
            'attribute1' => $row['attribute1'],
            'attribute2' => $row['attribute2'],
            'attribute3' => $row['attribute3'],
            'attribute4' => $row['attribute4'],
            'attribute5' => $row['attribute5'],
            'attribute6' => $row['attribute6'],
            'attribute7' => $row['attribute7']
        ]);
    }

    public function limit(): int{
        return 301 - $this->current_existed;
    }
}
