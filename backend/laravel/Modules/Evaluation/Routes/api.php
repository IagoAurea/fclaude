<?php

use Modules\Evaluation\Http\Controllers\RubricController;
use Modules\Evaluation\Http\Controllers\RubricPdfController;
use Modules\Evaluation\Http\Controllers\IndicatorController;
use Modules\Evaluation\Http\Controllers\CompetenceController;
use Modules\Evaluation\Http\Controllers\EvaluationController;
use Modules\Evaluation\Http\Controllers\RubricExportController;
use Modules\Evaluation\Http\Controllers\RubricImportController;
use Modules\Evaluation\Http\Controllers\EvaluationGradeController;
use Modules\Evaluation\Http\Controllers\EvaluationResultController;

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

Route::middleware('auth:api')->group(function () {
    Route::prefix('evaluation')->group(function () {
        Route::get('/competences', [CompetenceController::class, 'index'])->name('evaluation.competences.index');
        Route::get('/competences/{id}', [CompetenceController::class, 'show'])->name('evaluation.competences.show');
        Route::post('/competences', [CompetenceController::class, 'store'])->name('evaluation.competences.store');
        Route::put('/competences/{id}', [CompetenceController::class, 'update'])->name('evaluation.competences.update');
        Route::delete('/competences/{id}',
            [CompetenceController::class, 'destroy'])->name('evaluation.competences.destroy');

        Route::get('/indicators', [IndicatorController::class, 'index'])->name('evaluation.indicators.index');
        Route::get('/indicators/{id}', [IndicatorController::class, 'show'])->name('evaluation.indicators.show');
        Route::post('/indicators', [IndicatorController::class, 'store'])->name('evaluation.indicators.store');
        Route::put('/indicators/{id}', [IndicatorController::class, 'update'])->name('evaluation.indicators.update');
        Route::delete('/indicators/{id}',
            [IndicatorController::class, 'destroy'])->name('evaluation.indicators.destroy');

        Route::get('/rubrics', [RubricController::class, 'index'])->name('evaluation.rubrics.index');
        Route::get('/rubrics-by-classroom/{id}',
            [RubricController::class, 'indexByClassroom'])->name('evaluation.rubrics.indexByClassroom');
        Route::get('/rubrics-by-user/{id}',
            [RubricController::class, 'indexByUser'])->name('evaluation.rubrics.indexByUser');
        Route::get('/rubrics-by-alumn/{id}/classroom/{classroom_academic_year_id}',
            [RubricController::class, 'indexByAlumn'])->name('evaluation.rubrics.indexByAlumn');
        Route::get('/rubrics/{id}', [RubricController::class, 'show'])->name('evaluation.rubrics.show');
        Route::post('/rubrics', [RubricController::class, 'store'])->name('evaluation.rubrics.store');
        Route::put('/rubrics/{id}', [RubricController::class, 'update'])->name('evaluation.rubrics.update');
        Route::delete('/rubrics/{id}', [RubricController::class, 'destroy'])->name('evaluation.rubrics.destroy');
        Route::post('/rubrics/{id}/attach-classroom-academic-year',
            [RubricController::class, 'attachClassroomAcademicYear'])
            ->name('evaluation.rubrics.attachClassroomAcademicYear');
        Route::post('/rubrics/{id}/detach-classroom-academic-year',
            [RubricController::class, 'detachClassroomAcademicYear'])
            ->name('evaluation.rubrics.detachClassroomAcademicYear');
        Route::post('/rubrics/{rubric_id}/classroom-academic-year/{id}/evaluation-date',
            [RubricController::class, 'evaluationDate'])->name('evaluation.rubrics.evaluationDate');
        Route::get('/rubrics/list/user',
            [RubricController::class, 'getAllRubricsUser'])->name('evaluation.rubrics.list.user');

        Route::get('/rubrics-export/{id}',
            [RubricExportController::class, 'export'])->name('evaluation.rubrics.export');
        Route::get('/rubrics-pdf/{id}/alumn/{alumn_id}/classroom/{classroom_academic_year_id}',
            [RubricPdfController::class, 'generate'])->name('evaluation.rubrics.generate');
        Route::post('/rubrics-import', [RubricImportController::class, 'import'])->name('evaluation.rubrics.import');

        Route::post('/grade', [EvaluationGradeController::class, 'store'])->name('evaluation.grades.store');
        Route::post('/result', [EvaluationResultController::class, 'getResult'])->name('evaluation.results.getResult');
        Route::post('/competences-result',
            [EvaluationResultController::class, 'getCompetenceResult'])->name('evaluation.results.getCompetenceResult');
        Route::post('/finish', [EvaluationResultController::class, 'finish'])->name('evaluation.results.finish');
        Route::get('/grade/list/user', [EvaluationGradeController::class, 'getAllEvaluationsUser'])
            ->name('evaluation.grade.list.user');

        Route::get('/students-evaluation-by-classroom/{id}',
            [EvaluationController::class, 'indexByClassroom'])->name('evaluation.students.indexByClassroom');
        Route::get('/students-evaluation-by-rubric/{id}',
            [EvaluationController::class, 'indexByRubric'])->name('evaluation.students.indexByRubric');
        Route::get('/last-evaluations-by-classroom/{classroom_academic_year_id}',
            [EvaluationController::class, 'lastEvaluationsByClassroom'])
            ->name('evaluation.students.lastEvaluationsByClassroom');
    });
});
