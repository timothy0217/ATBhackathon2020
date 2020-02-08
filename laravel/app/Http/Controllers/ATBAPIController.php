<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use App\Http\Service\ATBAPI;


class ATBAPIController extends Controller
{
    public function fetchAPI(Request $request)
    {

        $ATBAPI = new ATBAPI();
        $login = $ATBAPI->login();
        $token = $login['token'];
        session()->put('key',$token);
        $token = session()->get('key');
        $test=$ATBAPI->createCustomers($token);
        dd($test);


        return view('ATBAPI');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     *
     * @return  string json
     */
    public function getCustomer(Request $request, $id)
    {
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     *
     * @return string json
     */
    public function getSustainabilityScore(Request $request, $id){

    }
}
