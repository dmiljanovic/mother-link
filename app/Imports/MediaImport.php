<?php

namespace App\Imports;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class MediaImport implements ToModel, WithValidation
{
    use Importable;

    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Media([
            'media'             => $row[0],
            'publisher'         => $row[1],
            'publisher_name'    => $row[2],
            'publisher_email'   => $row[3],
            'info_for_admin'    => $row[4],
            'category'          => $row[5],
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|string',
            '2' => 'nullable|string',
            '3' => 'required|string|unique:media,publisher_email',
            '4' => 'nullable|string',
            '5' => [
                'nullable',
                'string',
                Rule::in(
                    [
                        'Arts, Culture and Events',
                        'Auto and Moto',
                        'Beauty, Cosmetics, Pharmaceuticals',
                        'Economy, Business and Banking',
                        'Food and Gastronomy',
                    ]
                ),
            ],
        ];
    }
}
