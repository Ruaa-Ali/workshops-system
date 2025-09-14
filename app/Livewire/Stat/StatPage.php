<?php

namespace App\Livewire\Stat;

use Illuminate\Support\Facades\DB;
use App\Enums\LocalRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\WorkshopOffering;
use App\Models\User;
use App\Models\Enrollment;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class StatPage extends Component
{
    public function readActiveOfferings()
    {
        if (!Auth::user()->hasRole(LocalRole::ADMIN)) {
            return WorkshopOffering::whereDate("start_date", "<=", now())
                ->whereDate("end_date", ">", now())
                ->count();
        } else {
            return WorkshopOffering::whereDate("start_date", "<=", now())
                ->whereDate("end_date", ">", now())
                ->where("teacher_id", auth()->id())
                ->count();
        }
    }

    public function readCompleteOfferings()
    {
        if (!Auth::user()->hasRole(LocalRole::ADMIN)) {
            return WorkshopOffering::whereDate(
                "end_date",
                "<=",
                now(),
            )->count();
        } else {
            return WorkshopOffering::whereDate("end_date", "<=", now())
                ->where("teacher_id", auth()->id())
                ->count();
        }
    }

    public function readStudents()
    {
        return User::whereHas("roles", function ($query) {
            $query->where("name", "student");
        })->count();
    }

    public function readTeachers()
    {
        return User::whereHas("roles", function ($query) {
            $query->where("name", "teacher");
        })->count();
    }

    public function bestStudents()
    {
        $user = Auth::user();
        $isTeacher =
            $user && $user->hasRole("teacher") && !$user->hasRole("admin");
        return Enrollment::with("class", "student")
            ->when($isTeacher, function ($query) use ($user) {
                $query->whereHas("class", function ($subQuery) use ($user) {
                    $subQuery->where("teacher_id", $user->id);
                });
            })
            ->select("enrollments.*")
            ->selectSub(function ($query) {
                $query
                    ->from("attendances")
                    ->selectRaw("count(*)")
                    ->whereColumn("enrollment_id", "enrollments.id")
                    ->where("status", "present");
            }, "attended_sessions_count")
            ->selectSub(function ($query) {
                $query
                    ->from("offering_sessions")
                    ->selectRaw("count(*)")
                    ->whereColumn(
                        "workshop_offering_id",
                        "enrollments.workshop_offering_id",
                    );
            }, "total_sessions_count")
            ->selectRaw(
                '
                    CONCAT(
                        (SELECT attended_sessions_count),
                        "/",
                        (SELECT total_sessions_count)
                    ) AS attendance_percentage_text
                ',
            )
            ->selectRaw(
                '
                    IF(
                        (SELECT total_sessions_count) > 0,
                        ((SELECT attended_sessions_count) / (SELECT total_sessions_count)) * 100,
                        0
                    ) AS attendance_percentage_numeric
                ',
            )
            ->orderByDesc("attendance_percentage_numeric")
            ->take(3)
            ->get();
    }

    public function render()
    {
        $workshopChart = Chartjs::build()
            ->name("offerings")
            ->type("bar")
            ->size(["width" => 400, "height" => 200])
            ->labels([__("messages.active"), __("messages.complete")])
            ->datasets([
                [
                    "label" => __("messages.workshop_offerings"),
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => [
                        $this->readActiveOfferings(),
                        $this->readCompleteOfferings(),
                    ],
                    "fill" => false,
                ],
            ])
            ->options([
                "responsive" => true,
            ]);

        $studentChart = Chartjs::build()
            ->name("users")
            ->type("bar")
            ->size(["width" => 400, "height" => 200])
            ->labels([__("messages.students"), __("messages.teachers")])
            ->datasets([
                [
                    "label" => __("messages.users"),
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => [$this->readStudents(), $this->readTeachers()],
                    "fill" => false,
                ],
            ])
            ->options([
                "responsive" => true,
            ]);

        $best = $this->bestStudents();

        $bestStudents = Chartjs::build()
            ->name("best_students")
            ->type("pie")
            ->labels($best->pluck("student.name")->toArray())
            ->datasets([
                [
                    "label" => __("messages.best_students"),
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $best
                        ->pluck("attendance_percentage_numeric")
                        ->toArray(),
                    "fill" => false,
                ],
            ])
            ->options([
                "responsive" => true,
            ]);

        return view(
            "livewire.stat.stat-page",
            compact("workshopChart", "studentChart", "bestStudents", "best"),
        );
    }
}

// [
//   {
//     "id": 6,
//     "workshop_offering_id": 13,
//     "student_id": 9,
//     "created_at": "2025-09-13T02:39:53.000000Z",
//     "updated_at": "2025-09-13T02:39:53.000000Z",
//     "attended_sessions_count": 1,
//     "total_sessions_count": 13,
//     "attendance_percentage": "7.6923",
//     "class": {
//       "id": 13,
//       "start_date": "2025-09-14T00:00:00.000000Z",
//       "end_date": "2025-09-30T00:00:00.000000Z",
//       "off_days": "5",
//       "hours_per_day": 3,
//       "max_capacity": 10,
//       "price": "100.00",
//       "workshop_id": 22,
//       "teacher_id": 4,
//       "created_at": "2025-09-14T00:05:04.000000Z",
//       "updated_at": "2025-09-14T00:05:04.000000Z",
//       "deleted_at": null
//     },
//     "student": {
//       "id": 9,
//       "name": "ruaaaa",
//       "email": "eeee@gmail.com",
//       "email_verified_at": null,
//       "created_at": "2025-09-13T02:23:13.000000Z",
//       "updated_at": "2025-09-13T02:23:13.000000Z",
//       "deleted_at": null
//     }
//   },
//   {
//     "id": 8,
//     "workshop_offering_id": 13,
//     "student_id": 11,
//     "created_at": "2025-09-13T02:39:53.000000Z",
//     "updated_at": "2025-09-13T02:39:53.000000Z",
//     "attended_sessions_count": 1,
//     "total_sessions_count": 13,
//     "attendance_percentage": "7.6923",
//     "class": {
//       "id": 13,
//       "start_date": "2025-09-14T00:00:00.000000Z",
//       "end_date": "2025-09-30T00:00:00.000000Z",
//       "off_days": "5",
//       "hours_per_day": 3,
//       "max_capacity": 10,
//       "price": "100.00",
//       "workshop_id": 22,
//       "teacher_id": 4,
//       "created_at": "2025-09-14T00:05:04.000000Z",
//       "updated_at": "2025-09-14T00:05:04.000000Z",
//       "deleted_at": null
//     },
//     "student": {
//       "id": 11,
//       "name": "ruaaaa",
//       "email": "e1e8e@gmail.com",
//       "email_verified_at": null,
//       "created_at": "2025-09-13T02:25:06.000000Z",
//       "updated_at": "2025-09-13T02:25:06.000000Z",
//       "deleted_at": null
//     }
//   },
//   {
//     "id": 5,
//     "workshop_offering_id": 13,
//     "student_id": 3,
//     "created_at": "2025-09-13T02:39:53.000000Z",
//     "updated_at": "2025-09-13T02:39:53.000000Z",
//     "attended_sessions_count": 1,
//     "total_sessions_count": 13,
//     "attendance_percentage": "7.6923",
//     "class": {
//       "id": 13,
//       "start_date": "2025-09-14T00:00:00.000000Z",
//       "end_date": "2025-09-30T00:00:00.000000Z",
//       "off_days": "5",
//       "hours_per_day": 3,
//       "max_capacity": 10,
//       "price": "100.00",
//       "workshop_id": 22,
//       "teacher_id": 4,
//       "created_at": "2025-09-14T00:05:04.000000Z",
//       "updated_at": "2025-09-14T00:05:04.000000Z",
//       "deleted_at": null
//     },
//     "student": {
//       "id": 3,
//       "name": "stu",
//       "email": "stu@gmail.com",
//       "email_verified_at": null,
//       "created_at": "2025-09-03T23:40:30.000000Z",
//       "updated_at": "2025-09-03T23:40:30.000000Z",
//       "deleted_at": null
//     }
//   }
// ]
