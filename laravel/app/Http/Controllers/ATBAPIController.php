<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Service\CategorizationService;
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

     //$getAllAccounts = $ATBAPI->getAccount($token);
     //dd($getAllAccounts);
        $test=$ATBAPI->getTransactionsForAccount($token,'2524119902112-a6b71584-74f');



        $types = [];

        foreach($test['transactions'] as $t){

            $type = $t['details']['type'];
            array_push($types, $type);
        }

        return $types;


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
        $cat = new CategorizationService();
        dd($cat->categorize('test'));

        $cat = new CategorizationService();

        dd($cat->categorize('test'));



    }
}
