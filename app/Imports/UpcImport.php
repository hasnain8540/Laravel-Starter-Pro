<?php

namespace App\Imports;

use App\Models\Upc;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class UpcImport implements ToModel, WithHeadingRow, WithValidation, WithColumnFormatting
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function rules(): array
    {
        return [
            'upc'             => 'required|min:13',
        ];
    }

    public function customValidationMessages()
    {
        return [

            #All Email Validation for Teacher Email
            'upc.required'    => 'Upc Number Must Be Filled',
            'upc.min'       => 'Upc Number Must Contain 13 Digits',


        ];
    }

    public function model(array $row)
    {
        return new Upc([
            'upc_no' => $row['upc'],
            'status' => 'stock'
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'upc' => DataType::TYPE_STRING,
        ];
    }
}
