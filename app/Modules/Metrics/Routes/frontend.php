<?php

use Illuminate\Support\Facades\Route;

Route::get('metrics/clicked/navigation/{menu}', 'ClickableController@navigation');