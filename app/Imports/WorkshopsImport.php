<?php

namespace App\Imports;

use App\Models\Workshop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class WorkshopsImport implements ToCollection, ToModel
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        if (
            $row[0] === "title_en" &&
            $row[1] === "title_ar" &&
            $row[2] === "description_en" &&
            $row[3] === "description_ar" &&
            $row[4] === "duration_hours" &&
            $row[5] === "initial_price" &&
            $row[6] === "image"
        ) {
            return null;
        }

        return new Workshop([
            "title_en" => $row[0],
            "title_ar" => $row[1],
            "description_en" => $row[2],
            "description_ar" => $row[3],
            "duration_hours" => $row[4],
            "initial_price" => $row[5],
            "image" => $row[6] ?? "",
            "created_by" => auth()->id(),
        ]);
    }
}
