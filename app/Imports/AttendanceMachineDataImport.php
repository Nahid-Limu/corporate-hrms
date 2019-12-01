<?php

namespace App\Imports;

use App\AttendanceMachineData;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class AttendanceMachineDataImport implements ToModel
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AttendanceMachineData([


        ]);


    }
}
