<?php

use App\Http\Controllers\{
    BankController,
    BrokerController,
    CaseListController,
    CategoryExpenseController,
    ClaimDocumentController,
    ExpenseController,
    FeeBasedController,
    FileSurveyController,
    GmailController,
    IncidentController,
    InsuranceController,
    InvoiceController,
    PermissionController,
    PolicyController,
    ReportDuaController,
    ReportEmpatController,
    ReportLimaController,
    ReportSatuController,
    ReportTigaController,
    RoleController,
    UserController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes([
    'register' => false,
    'reset' => false,
]);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::get('/report/{rp}', [App\Http\Controllers\HomeController::class, 'report'])->name('report');
    Route::patch('/update/{user:id}', [App\Http\Controllers\HomeController::class, 'update'])->name('profile.update');

    Route::post('/case-list/invoice/{id}', [CaseListController::class, 'invoice'])->name('case-list.invoice');
    Route::post('/case-list/status', [CaseListController::class, 'status'])->name('caselist.status');
    Route::post('/case-list/ir-status', [CaseListController::class, 'irstatus']);
    Route::post('/case-list/getcase', [CaseListController::class, 'getcase']);
    Route::post('/case-list/laporan', [CaseListController::class, 'laporan'])->name('caselist.laporan');
    Route::post('/case-list/excel', [CaseListController::class, 'excel'])->name('caselist.excel');
    Route::post('/case-list/closeCase', [CaseListController::class, 'closeCase'])->name('caselist.closecase');
    Route::get('/case-list/{caseList:id}/penunjukan', [CaseListController::class, 'penunjukan'])->name('caselist.penunjukan');
    Route::get('/case-list/{caseList:id}/copyPolice', [CaseListController::class, 'copyPolice'])->name('caselist.copyPolice');
    Route::get('/case-list/{caseList:id}/expense', [CaseListController::class, 'expense'])->name('caselist.expense');
    Route::get('/case-list/{caseList:id}/transcript', [CaseListController::class, 'transcript'])->name('caselist.transcript');
    Route::get('/case-list/restore', [CaseListController::class, 'restore'])->name('caselist.restore');
    Route::get('/case-list/{caseList:id}/assignment', [CaseListController::class, 'assigment'])->name('caselist.assignment');
    Route::post('/case-list/instruction', [CaseListController::class, 'instruction'])->name('caselist.instruction');
    Route::post('expense/laporan', [ExpenseController::class, 'laporan'])->name('expense.laporan');
    Route::delete('expenses/{expense:id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expense.index');
    Route::put('/expense/edit/', [ExpenseController::class, 'update'])->name('expense.update');
    Route::resource('/category-expense', CategoryExpenseController::class);
    Route::resource('/case-list', CaseListController::class);
    Route::resource('/cause-of-loss', IncidentController::class);
    Route::resource('/type-of-business', PolicyController::class);
    Route::resource('/broker', BrokerController::class);
    Route::resource('/fee-based', FeeBasedController::class);
    Route::resource('/bank', BankController::class);
    Route::post('/insurance/laporan/{id}', [InsuranceController::class, 'laporan'])->name('insurance.laporan');
    Route::resource('/insurance', InsuranceController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permission', PermissionController::class);
    Route::post('/invoice/laporan', [InvoiceController::class, 'laporan'])->name('invoice.laporan');
    Route::post('/invoice/excel', [InvoiceController::class, 'excel'])->name('invoice.excel');
    Route::get('invoice/pdf/{id}', [InvoiceController::class, 'pdf'])->name('invoice.pdf');
    Route::get('invoice/{id}/final', [InvoiceController::class, 'final'])->name('invoice.final');
    Route::post('invoice/store-interim', [InvoiceController::class, 'storeInterim'])->name('invoice.storeInterim');
    Route::resource('invoice', InvoiceController::class);
    Route::get('expense/download', [ExpenseController::class, 'download'])->name('expense.download');
    Route::post('expense/store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::post('expense/import', [ExpenseController::class, 'import'])->name('expense.import');
    Route::resource('file-survey', FileSurveyController::class);
    Route::resource('claim-document', ClaimDocumentController::class);
    Route::resource('report-satu', ReportSatuController::class);
    Route::resource('report-dua', ReportDuaController::class);
    Route::resource('report-tiga', ReportTigaController::class);
    Route::resource('report-empat', ReportEmpatController::class);
    Route::resource('report-lima', ReportLimaController::class);
    Route::get('/gmails/{id}/attachment', [GmailController::class, 'download'])->name('gmails.attachment');
    Route::get('/gmails/{id}/show/{caseList:id}', [GmailController::class, 'show'])->name('gmails.show');
    Route::resource('gmails', GmailController::class);
});

Route::get('/oauth/gmail', function () {
    return LaravelGmail::redirect();
});
Route::get('/oauth/gmail/callback', [GmailController::class, 'makeToken']);
Route::get('/oauth/gmail/logout', [GmailController::class, 'logout']);

// Route::get('/oauth/gmail/callback', function () {
//     LaravelGmail::makeToken();
//     return redirect()->to('/case-list');
// });

// Route::get('/oauth/gmail/logout', function () {
//     LaravelGmail::logout(); //It returns exception if fails
//     return back();
// });
