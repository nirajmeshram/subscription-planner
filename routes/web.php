<?php

use App\Http\Controllers\ComboPlanController;
use App\Http\Controllers\EligibilityCriteriaController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('plan.index');
});
// Resource route for managing Plans 
Route::resource('plan', PlanController::class);

// Resource route for managing Combo  Plans 
Route::resource('combo_plan', ComboPlanController::class);

// Resource route for managing Eligibility Criteria 
Route::resource('eligibility_criteria', EligibilityCriteriaController::class);
