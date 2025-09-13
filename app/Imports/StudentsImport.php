<?php

namespace App\Imports;

use App\Enums\LocalRole;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToCollection, ToModel
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
        if ($row[0] === "name" && $row[1] === "email") {
            return null;
        }

        $user = new User([
            "name" => $row[0],
            "email" => $row[1],
            "password" => Hash::make($row[1]),
        ]);

        $user->save();
        $user->assignRole(LocalRole::STUDENT->value);

        return $user;
    }
}
