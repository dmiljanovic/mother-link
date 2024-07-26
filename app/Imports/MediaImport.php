<?php

namespace App\Imports;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MediaImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            try {
                $this->validateRow($row->toArray());

                if ($this->mediaExists($row->toArray())) {
                    Log::error('Media already imported.');

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
                    Log::error('Row successfully imported.');
                }
            } catch (QueryException $e) {
                Log::error('Database error during user creation: ' . $e->getMessage());
            } catch (ValidationException $e) {
                Log::error('Validation failed for row: ' . json_encode($row) . ' with errors: ' . $e->getMessage());
            }
        }
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
