<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;

Route::prefix('inquiries')->group(function () {
    Route::post('/', [InquiryController::class, 'store']);
    Route::get('/', [InquiryController::class, 'index']);
    Route::get('/{id}', [InquiryController::class, 'show']);
});
