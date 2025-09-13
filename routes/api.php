<?php

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::get("classes", [ApiController::class, "fetchClasses"])->middleware([
    "auth:api",
    "student",
]);

Route::post("/classes/{id}/enroll", [
    ApiController::class,
    "enrollToClass",
])->middleware(["auth:api", "student"]);
