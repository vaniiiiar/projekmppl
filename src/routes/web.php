<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Livewire\ShowHomePage;
use App\Livewire\ShowAbout;
use App\Livewire\ShowProduct;
use App\Livewire\ShowProfile;
use App\Exports\MonthlyIncomeExport;
use App\Exports\PaymentReportExport;
use Maatwebsite\Excel\Facades\Excel;


/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', ShowHomePage::class)->name('home');
Route::get('/about', ShowAbout::class)->name('about');
Route::get('/profile', ShowProfile::class)->name('profile');
Route::get('/product', ShowProduct::class)->name('product');



// Route::get('/export-payments', function () {
//     $startDate = request('start_date');
//     $endDate = request('end_date');
    
//     // Convert string dates to Carbon instances if they exist
//     $startDate = $startDate ? \Carbon\Carbon::parse($startDate) : null;
//     $endDate = $endDate ? \Carbon\Carbon::parse($endDate) : null;
    
//     return Excel::download(
//         new PaymentReportExport($startDate, $endDate),
//         'payment-report-' . now()->format('Y-m-d') . '.xlsx'
//     );
// })->name('export-payments');