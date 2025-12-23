<?php

namespace App\Helpers;

use Maatwebsite\Excel\Concerns\FromArray;

class GenericExport implements FromArray
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
}
