<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return $row;
    }
}
