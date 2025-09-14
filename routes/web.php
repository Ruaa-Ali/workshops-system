<?php

use App\Enums\PermissionsTypes;
use App\Livewire\Enrollments\IndexEnrollments;
use App\Livewire\Offerings\CreateWorkshopOffering;
use App\Livewire\Offerings\IndexOfferingsForStudents;
use App\Livewire\Offerings\IndexWorkshopOfferings;
use App\Livewire\Offerings\ShowOffering;
use App\Livewire\Offerings\UpdateWorkshopOfferings;
use App\Livewire\Stat\StatPage;
use App\Livewire\StudentClasses\IndexStudentClasses;
use App\Livewire\Teachers\IndexTeacherClasses;
use App\Livewire\Teachers\MarkClassAttendance;
use App\Livewire\Teachers\ShowTeacherClass;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\IndexUsers;
use App\Livewire\Workshops\CreateWorkshop;
use App\Livewire\Workshops\IndexWorkshops;
use App\Livewire\Workshops\ShowWorkshop;
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
        Route::get("/", StatPage::class)
            ->middleware([
                "auth",
                "verified",
                "can:" . PermissionsTypes::VIEW_STATS->value,
            ])
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

            Route::middleware(["admin"])->group(function () {
                Route::get("workshops/create", CreateWorkshop::class)->name(
                    "workshops.create",
                );

                Route::get("workshops/{id}", ShowWorkshop::class)->name(
                    "workshops.show",
                );

                Route::get(
                    "workshops/{workshop}/update",
                    UpdateWorkshop::class,
                )->name("workshops.update");

                Route::get("users/", IndexUsers::class)->name("users.index");

                Route::get("users/create", CreateUser::class)
                    ->where("role", "teacher|student|admin")
                    ->name("users.create");
            });

            Route::get("workshops", IndexWorkshops::class)
                ->name("workshops.index")
                ->middleware("can:" . PermissionsTypes::VIEW_WORKSHOPS->value);

            Route::middleware([
                "can:" . PermissionsTypes::MANAGE_OFFERINGS->value,
            ])->group(function () {
                Route::get(
                    "offerings/create",
                    CreateWorkshopOffering::class,
                )->name("offerings.create");

                Route::get("offerings", IndexWorkshopOfferings::class)->name(
                    "offerings.index",
                );

                Route::get("offerings/{id}", ShowOffering::class)->name(
                    "offerings.show",
                );

                Route::get(
                    "offerings/{offering}/update",
                    UpdateWorkshopOfferings::class,
                )->name("offerings.update");
            });

            Route::get("enrollments", IndexEnrollments::class)
                ->name("enrollments.index")
                ->middleware(
                    "can:" . PermissionsTypes::VIEW_ENROLLMENTS->value,
                );

            // TODO: change into oped-claases or available classes
            Route::middleware(["auth", "student"])->group(function () {
                Route::get("classes", IndexOfferingsForStudents::class)->name(
                    "classes.index",
                );

                Route::get("student/classes", IndexStudentClasses::class)->name(
                    "students.classes.index",
                );
            });

            Route::middleware([
                "auth",
                "can:" . PermissionsTypes::MANAGE_OWN_OFFERINGS->value,
            ])->group(function () {
                Route::get("teacher/classes", IndexTeacherClasses::class)->name(
                    "teacher.offerings.index",
                );

                Route::get(
                    "teacher/classes/{id}",
                    ShowTeacherClass::class,
                )->name("teacher.offerings.show");

                Route::get(
                    "teacher/classes/{id}/attendance",
                    MarkClassAttendance::class,
                )->name("teacher.offerings.attendance");
            });
        });
    },
);
