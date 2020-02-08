<?php

namespace App\Services;

use Guzzle;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
class CategorizationService
{


    private $base_uri = 'https://api.nordigen.com/';

    // todo: put these in env
    private $client_id = '';
    private $client_secret = '5n75tqsegshum2i9o0bgavmmuf';
    private




    private function authorize(){
        // Check for bearer token
        $token = Storage::get('nordigen_key.json');
        $token = json_decode($token);



        // if no bearer token, re authorize

        // store bearer token


    }

    public function categorize(){


    }



}
