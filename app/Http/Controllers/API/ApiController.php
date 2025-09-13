<?php

namespace App\Http\Controllers\API;

use App\Enums\LocalRole;
use App\Enums\PermissionsTypes;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\WorkshopOffering;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;

class ApiController extends Controller
{
    public function register(RegisterRequest $r)
    {
        $p = User::create([
            "name" => $r->name,
            "email" => $r->email,
            "password" => Hash::make($r->password),
        ]);

        $p->assignRole(LocalRole::STUDENT);
        $data["token"] = $p->createToken("people-token")->plainTextToken;
        $data["people"] = $p->name;
        return response()->json($data);
    }

    public function login(LoginRequest $r)
    {
        $p = User::where("email", $r->email)->first();
        if (!$p || !Hash::check($r->password, $p->password)) {
            return response()->json("wrong credentials");
        }

        $data["token"] = $p->createToken("people-token")->plainTextToken;
        $data["people"] = $p->name;
        return response()->json($data);
    }

    public function fetchClasses()
    {
        // $studentRole = Role::findByName('student');
        // $studentRole->givePermissionTo(PermissionsTypes::VIEW_CLASSES->value);
        // if (!auth()->user()->can(PermissionsTypes::VIEW_CLASSES->value)) {
        //     return response()->json(["error" => "Unauthorized"], 403);
        // }
        // if (!auth()->user()->hasRole("student")) {
        //     return response()->json(["error" => "Unauthorized"], 403);
        // }
        return WorkshopOffering::with(["workshop", "teacher"])
            ->whereHas("workshop", function ($query) {
                $query->whereNull("deleted_at"); // For soft deletes
            })
            ->whereDate("start_date", ">=", now()) // Offerings starting today or later
            ->orderBy("start_date", "asc") // Order by upcoming first
            ->get();
    }

    public function enrollToClass(string $id)
    {
        if (!auth()->user()->hasRole("student")) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        $enrollment = Enrollment::firstOrCreate([
            "workshop_offering_id" => $id,
            "student_id" => auth()->id(),
        ]);

        if ($enrollment->wasRecentlyCreated) {
            return response()->json([
                "msg" => "Enrolled Successfully",
            ]);
        } else {
            return response()->json([
                "msg" => "You are already enrolled in this class.",
            ]);
        }
    }
}
