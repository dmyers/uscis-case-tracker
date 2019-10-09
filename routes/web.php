<?php

use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
    $case_ids = $request->input('cid');
    if (!empty($case_ids)) {
        $case_ids = explode(',', $case_ids);
    }

    $asset_url = asset('/');
    return view('app', compact('asset_url', 'case_ids'));
});
