<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use App\Http\Service\ATBAPI;


class ATBAPIController extends Controller
{
    public function fetchAPI()
    {

        $ATBAPI = new ATBAPI();

        return view('ATBAPI');
    }
}
