<?php

use Illuminate\Support\Facades\Route;
use Modules\Classroom\Http\Controllers\AgeController;
use Modules\Classroom\Http\Controllers\ClassroomController;
use Modules\Classroom\Http\Controllers\SubjectController;
use Modules\Classroom\Http\Controllers\TeacherController;
use Modules\Classroom\Http\Controllers\ClassroomAcademicYearController;
use Modules\Classroom\Http\Controllers\ClassroomExerciseController;
use Modules\Classroom\Http\Controllers\ClassroomExerciseSessionController;
use Modules\Classroom\Http\Controllers\ClassroomSubjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authenthicated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('classroom')->group(function () {
        Route::get('ages', [AgeController::class, 'index'])->name('classroom.ages.index');
        Route::get('/ages/{id}', [AgeController::class, 'show'])->name('classroom.ages.show');
        Route::post('/ages', [AgeController::class, 'store'])->name('classroom.ages.store');
        Route::put('/ages/{id}', [AgeController::class, 'update'])->name('classroom.ages.update');
        Route::delete('/ages/{id}', [AgeController::class, 'destroy'])->name('classroom.ages.destroy');

        Route::get('/subjects', [SubjectController::class, 'index'])->name('classroom.subjects.index');
        Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('classroom.subjects.show');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('classroom.subjects.store');
        Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('classroom.subjects.update');
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('classroom.subjects.destroy');

        Route::get('/{club_id}/teachers', [TeacherController::class, 'index'])->name('classroom.teachers.index');
        Route::get('/{club_id}/teachers/{id}', [TeacherController::class, 'show'])->name('classroom.teachers.show');
        Route::post('/{club_id}/teachers', [TeacherController::class, 'store'])->name('classroom.teachers.store');
        Route::put('/{club_id}/teachers/{id}', [TeacherController::class, 'update'])->name('classroom.teachers.update');
        Route::delete('/{club_id}/teachers/{id}',
            [TeacherController::class, 'destroy'])->name('classroom.teachers.destroy');
        Route::get('/{club_id}/teacher-areas', [TeacherController::class, 'areas'])->name('classroom.teachers.areas');

        Route::get('/classrooms-by-user/{user_id}',
            [ClassroomController::class, 'indexByUser'])->name('classroom.classrooms.indexByUser');
        Route::get('/{club_id}/classrooms', [ClassroomController::class, 'index'])->name('classroom.classrooms.index');
        Route::get('/{club}/classrooms/{classroom}',
            [ClassroomController::class, 'show'])->name('classroom.classrooms.show');
        Route::post('/{club_id}/classrooms', [ClassroomController::class, 'store'])->name('classroom.classrooms.store');
        Route::put('/{club_id}/classrooms/{id}',
            [ClassroomController::class, 'update'])->name('classroom.classrooms.update');
        Route::delete('/{club_id}/classrooms/{id}',
            [ClassroomController::class, 'destroy'])->name('classroom.classrooms.destroy');

        Route::prefix('/{classroom}/exercises')->group(function () {
            Route::get('/', [ClassroomExerciseController::class, 'index']);
            Route::post('/', [ClassroomExerciseController::class, 'store']);
            Route::get('/{code}', [ClassroomExerciseController::class, 'show']);
            Route::put('/{code}', [ClassroomExerciseController::class, 'update']);
            Route::delete('/{code}', [ClassroomExerciseController::class, 'destroy']);
        });

        Route::post('/{classroom_academic_year}/teachers/assign',
            [ClassroomAcademicYearController::class, 'assignTeachers']);

        Route::prefix('/{classroom}')->group(function () {
            Route::prefix('/academic-years')->group(function () {
                Route::get('/', [ClassroomAcademicYearController::class, 'index']);
                Route::post('/assign', [ClassroomAcademicYearController::class, 'assignYears']);
                Route::post('/{academicYear}/assign-alumns', [ClassroomAcademicYearController::class, 'assignAlumns']);
            });
        });

        Route::prefix('/{classroom}/exercise-sessions')->group(function () {
            Route::get('/', [ClassroomExerciseSessionController::class, 'index']);
            Route::post('/', [ClassroomExerciseSessionController::class, 'store']);
            Route::get('/{code}', [ClassroomExerciseSessionController::class, 'show']);
            Route::put('/{code}', [ClassroomExerciseSessionController::class, 'update']);
            Route::delete('/{code}', [ClassroomExerciseSessionController::class, 'destroy']);
        });
    });

    Route::prefix('school-center/')->group(function () {
        Route::prefix('{club_id}/classroom/{classroom_id}')->group(function () {
            Route::get('/teachers-subjects',
                [ClassroomSubjectController::class, 'index'])->name('classroom.teachers-subjects.index');
            Route::post('/teachers-subjects',
                [ClassroomSubjectController::class, 'store'])->name('classroom.teachers-subjects.store');
            Route::post('/remove/teachers-subjects',
                [ClassroomSubjectController::class, 'remove'])->name('classroom.teachers-subjects.remove');
        });
    });
    
});
