<?php

use Illuminate\Http\Request;

Route::post('/deposit', function (Request $request) {
    \Illuminate\Support\Facades\Log::info(
        json_encode($request->toArray())
    );
});
