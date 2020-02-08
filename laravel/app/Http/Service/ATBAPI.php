<?php

namespace App\Http\Service;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

class ATBAPI
{
    private  $_baseAPI = "https://api.leapos.ca"; //Helcim Commerce API - URL Location
//curl -XPOST https://api.leapos.ca/my/logins/direct -H "Content-Type: application/json"  -H 'Authorization: DirectLogin username="bb3c98c6a7e3f34a6a9b140", password="dc08d4b3f3f4b3K+", consumer_key="89c7a0d1727b47a1ac18b65fd4a96ae6"'

    public function login(){ // process credit card using new card

        $apiDirectory = "/my/logins/direct";
        $apiFullAddress = $this->_baseAPI . $apiDirectory;

        $header = array(
            "Authorization"=> 'DirectLogin',
            "username"=>"bb3c98c6a7e3f34a6a9b140",
            "password"=>"dc08d4b3f3f4b3K+",
            "consumer_key"=>"89c7a0d1727b47a1ac18b65fd4a96ae6",
        );

        // API call using guzzle
        try
        {
            $client = new Client(['headers' => ['Authorization' =>'DirectLogin username="cb4f94251b14ec41ce84440", password="e713b6dbfba8f2B+", consumer_key="7ee6547745914d328b32320d023d46d6"']]);

            // use post to send data to Helcim api end point.
            $result = $client->request('POST',$apiFullAddress)->getBody()->getContents();

        }
        catch (RequestException $e)
        { //show error
            return response()->setStatusCode(500);
        }
        // return xml
        $json = json_decode($result,TRUE);

        // convert to json
        // decode json to array
        return $json;
    }

}
