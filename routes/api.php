<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
route::middleware('ApiRequest')->group(function () {
    Route::get('currency', [AjaxController::class, 'currency']);
    Route::get('caselist/{id}', [AjaxController::class, 'caselist']);
    Route::get('insurance/{id}', [AjaxController::class, 'insurance']);
    Route::get('autocomplete', [AjaxController::class, 'TheAutoCompleteFunc']);
    Route::get('autocomplete/interim', [AjaxController::class, 'TheAutoCompleteFuncIterim']);
    Route::get('/chart/caselist', [AjaxController::class, 'ChartCaseList']);
    Route::get('/chart/line/caselist/{id}', [AjaxController::class, 'ChartLineCaseList']);
    Route::get('/count/{id}', [AjaxController::class, 'count']);
    Route::post('/invoice/post', [AjaxController::class, 'invoice']);
    Route::post('/update/kurs', [AjaxController::class, 'kurs']);
    Route::get('/caselist/file_no/last', [AjaxController::class, 'CaseListFileNoLast']);
    Route::get('/caselist/file_no/edit/{id}', [AjaxController::class, 'CaseListFileNoEdit']);
    Route::get('/interim/{id}', [AjaxController::class, 'GetInterimResource']);
    Route::get('/count/all/policy', [AjaxController::class, 'CountAllPolicy']);
    Route::get('/admin/expense/log/{id}', [AjaxController::class, 'ExpenseLog']);
    Route::get('/admin/expense/show/{id}', [AjaxController::class, 'ExpenseShow']);
    Route::get('/getfee/{id}', [AjaxController::class, 'getFee']);
});
