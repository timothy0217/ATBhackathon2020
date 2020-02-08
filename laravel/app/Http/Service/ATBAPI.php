<?php

namespace App\Http\Service;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

class ATBAPI
{
    private  $_baseAPI = "https://api.leapos.ca"; //Helcim Commerce API - URL Location
    private  $_userName = "bb3c98c6a7e3f34a6a9b140"; //Helcim Commerce API - URL Location
    private  $_password = "dc08d4b3f3f4b3K+"; //Helcim Commerce API - URL Location
    private  $_consumer_key = "89c7a0d1727b47a1ac18b65fd4a96ae6"; //Helcim Commerce API - URL Location
    private  $_bankID = "bb3c98c6a7e3f34a6a9b1405e8a8d74"; //Helcim Commerce API - URL Location

    public function login(){ // process credit card using new card

        $apiDirectory = "/my/logins/direct";
        $apiFullAddress = $this->_baseAPI . $apiDirectory;

        // API call using guzzle
        try
        {
            $client = new Client(['headers' => ['Authorization' =>'DirectLogin username="'.$this->_userName.'", password="'.$this->_password.'", consumer_key="'. $this->_consumer_key .'"']]);

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

    public function getBank($token){ // process credit card using new card
        $apiDirectory = "/obp/v4.0.0/banks/".$this->_bankID;
        $apiFullAddress = $this->_baseAPI . $apiDirectory;
//
//        $body = array(
//            "username"=> 'DirectLogin',
//            "password"=>"bb3c98c6a7e3f34a6a9b140",
//            "first_name"=>"dc08d4b3f3f4b3K+",
//            "last_name"=>"dc08d4b3f3f4b3K+",
//            "email"=>"dc08d4b3f3f4b3K+",
//        );

        // API call using guzzle
        try
        {
            $client = new Client(['headers' => ['Authorization' =>'DirectLogin token="'.$token.'"']]);
            // use post to send data to Helcim api end point.
            $result = $client->request('GET',$apiFullAddress)->getBody()->getContents();

        }
        catch (RequestException $e)
        { //show error
            dd($e);
        }
        // return xml
        $json = json_decode($result,TRUE);
dd($json);
        // convert to json
        // decode json to array
        return $json;
    }


    public function createUser($token){ // process credit card using new card

        $apiDirectory = "/obp/v4.0.0/users";
        $apiFullAddress = $this->_baseAPI . $apiDirectory;

        $body = array(
            "username"=> 'DirectLogin',
            "password"=>"bb3c98c6a7e3f34a6a9b140",
            "first_name"=>"dc08d4b3f3f4b3K+",
            "last_name"=>"dc08d4b3f3f4b3K+",
            "email"=>"dc08d4b3f3f4b3K+",
        );

        // API call using guzzle
        try
        {
            $client = new Client();
            // use post to send data to Helcim api end point.
            $result = $client->request('POST',$apiFullAddress,$body)->getBody()->getContents();

        }
        catch (RequestException $e)
        { //show error
            dd($e);
        }
        // return xml
        $json = json_decode($result,TRUE);
        dd($json);
        // convert to json
        // decode json to array
        return $json;
    }




}
