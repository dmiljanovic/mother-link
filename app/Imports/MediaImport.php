<?php

namespace App\Imports;

use App\Models\Media;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MediaImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $collection)
    {
        $totalCount = $collection->count();
        $totalImported = 0;
        $importStatuses = [];

        foreach ($collection as $index => $row)
        {
            try {
                $this->validateRow($row->toArray());

                if ($this->mediaExists($row->toArray())) {
                    $importStatuses[$index + 1] = 'Clone Imported';

                    continue;
                }

                $res = Media::create([
                    'media'             => $row['media'],
                    'publisher'         => $row['publisher'],
                    'publisher_name'    => $row['publisher_name'],
                    'publisher_email'   => $row['publisher_email'],
                    'info_for_admin'    => $row['info_for_admin'],
                    'category'          => $row['category'],
                ]);

                if ($res instanceof Media) {
                    $totalImported++;
                    $importStatuses[$index + 1] = 'Imported';
                }
            } catch (QueryException|ValidationException $e) {
                $importStatuses[$index + 1] = 'Import failed';
            }
        }

        session()->put('total_count', $totalCount);
        session()->put('total_imported', $totalImported);
        session()->put('import_statuses', $importStatuses);
    }

    public function rules(): array
    {
        return [
            'media' => 'required|string',
            'publisher' => 'required|string',
            'publisher_name' => 'nullable|string',
            'publisher_email' => 'required|string',
            'info_for_admin' => 'nullable|string',
            'category' => [
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

    /**
     * @throws ValidationException
     */
    private function validateRow(array $row): void
    {
        $validator = Validator::make($row, $this->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    private function mediaExists(array $row): bool
    {
        $media = Media::where('media', $row['media'])
            ->where('publisher', $row['publisher'])
            ->where('publisher_name', $row['publisher_name'])
            ->where('publisher_email', $row['publisher_email'])
            ->where('info_for_admin', $row['info_for_admin'])
            ->where('category', $row['category'])
            ->exists();

        if ($media) {
            return true;
        }

        return false;
    }
}
