<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\Api\MatchingApiController;

//Auth::routes();


//Route::middleware(['auth'])->prefix('matchings')->group(function () {
Route::prefix('matchings')->group(function () {

    Route::get('/', [MatchingController::class, 'index'])->name('matchings.index');
    Route::get('/create', [MatchingController::class, 'create'])->name('matchings.create');
    Route::post('/', [MatchingController::class, 'store'])->name('matchings.store');
    Route::get('/{id}/edit', [MatchingController::class, 'edit'])->name('matchings.edit');
    Route::put('/{id}', [MatchingController::class, 'update'])->name('matchings.update');
    Route::delete('/{id}', [MatchingController::class, 'destroy'])->name('matchings.destroy');
    Route::post('/import', [MatchingController::class, 'import'])->name('matchings.import');
    Route::get('/export', [MatchingController::class, 'export'])->name('matchings.export'); 
		
});

//--Route API pour fournir le id DHIS2 à partir du code SIDAInfo
Route::get('/matching/by-code/{sidainfo_code}', [MatchingApiController::class, 'getDhis2Id']);

Route::get('/', function () {
    return view('welcome');
});


?>