<?php

namespace App\Exports;

use App\Models\Makanan;
use Maatwebsite\Excel\Concerns\FromCollection;

class MakananExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Makanan::all();
    }
}
