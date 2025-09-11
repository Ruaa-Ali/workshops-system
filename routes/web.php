<?php

use App\Livewire\Enrollments\IndexEnrollments;
use App\Livewire\Offerings\CreateWorkshopOffering;
use App\Livewire\Offerings\IndexWorkshopOfferings;
use App\Livewire\Offerings\UpdateWorkshopOfferings;
use App\Livewire\Teachers\IndexTeachers;
use App\Livewire\Workshops\CreateWorkshop;
use App\Livewire\Workshops\IndexWorkshops;
use App\Livewire\Workshops\UpdateWorkshop;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\ProfileController;

Route::group(
    [
        "prefix" => LaravelLocalization::setLocale(),
        "middleware" => [
            "localeSessionRedirect",
            "localizationRedirect",
            "localeViewPath",
        ],
    ],
    function () {
        Route::get("/", fn() => view("dashboard"))
            ->middleware(["auth", "verified"])
            ->name("dashboard");

        require __DIR__ . "/auth.php";

        Route::middleware("auth")->group(function () {
            Route::get("/profile", [ProfileController::class, "edit"])->name(
                "profile.edit",
            );

            //
            Route::patch("/profile", [
                ProfileController::class,
                "update",
            ])->name("profile.update");

            //
            Route::delete("/profile", [
                ProfileController::class,
                "destroy",
            ])->name("profile.destroy");

            // IMPORTANT: to tell livewire to handle localized url
            Livewire::setUpdateRoute(
                fn($handle) => Route::post("/custom/livewire/update", $handle),
            );

            Route::get("workshops/create", CreateWorkshop::class)->name(
                "workshops.create",
            );

            Route::get("workshops", IndexWorkshops::class)->name(
                "workshops.index",
            );

            Route::get(
                "workshops/{workshop}/update",
                UpdateWorkshop::class,
            )->name("workshops.update");

            Route::get("offerings/create", CreateWorkshopOffering::class)->name(
                "offerings.create",
            );

            Route::get("offerings", IndexWorkshopOfferings::class)->name(
                "offerings.index",
            );

            Route::get(
                "offerings/{offering}/update",
                UpdateWorkshopOfferings::class,
            )->name("offerings.update");

            Route::get("enrollments", IndexEnrollments::class)->name(
                "enrollments.index",
            );

            Route::get("teachers", IndexTeachers::class)->name(
                "teachers.index",
            );
        });
    },
);
