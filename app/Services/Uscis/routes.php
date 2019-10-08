<?php

use Illuminate\Support\Facades\Route;

Route::get('uscis/cases/{caseNumber?}', ApiController::class);
