<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class CategorizationService
{
    public $client;

    public $base_uri = 'https://api.nordigen.com';

    public $token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VUXlRVFJFTWpjeE1UUkVNVFl4TmpjNVJrUTJOVUl5TjBRMU4wSTJNVEEzUlVRNU9UWTRNZyJ9.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTIwMzgyNCwiZXhwIjoxNTgxMjkwMjI0LCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.D7sprqBw-PSsjpCMEwnbhq_wyxATxotYkmXA5fOL3ihAKh2be1HkSE5TSfUgi_u9QhE70zev8w2mVw7DlqgjbdDZ6eIhP0b1mq4XuhDeg12Hyo6XhdRvNMS5eP9DwZpUyy_TRkPI-uQWqgl93dTWLxj9sGMWdnMR1YOweYdisi4k-QrmQRhbLpacuIFtgeU5oU1XjZbfn1MaKFFl2iIWtYps0s9Gclm4yY16cP8yMI4i7HF38z4DqJBNOxCXyARC6GXLAhfrZ3gn-dp_RCOlyBzcQVCoAOp0nt0cf63VQdU8wY3XkbkQIuXR2Gx5OPrjlBN0S9tPX_1fZxTM_EycKQ';

    /**
     * CategorizationService constructor.
     */
    public function __construct()
    {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://auth.nordigen.com/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=RvmBObrYyw2l9F7l17nsn1XXzQAgLQdE&client_secret=yGePqmG81FFe6z6_M_kfNj2KP2rV2MA455swhhxCeZXKylOGCHko56lCnWHwS7vs&audience=https%3A//nordigen/api",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
            ],
        ]);
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        $this->token = $response['access_token'];

        $this->client = new Client([
            'base_uri' => $this->base_uri,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getCategories()
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token,
                'Accept' => 'application/json',
            ],
            'base_uri' => $this->base_uri,
        ]);

        $response = $client->GET('/v2/category-tree/UK', []);

        return $response->getBody()
            ->getContents();
    }

    public function startCategorization($account_id)
    {

        $response = $this->client->request('post', '/v2/report', [
            'multipart' => [['name'=> 'input', 'contents' => \Storage::disk()
                ->readStream('/public/upload/transactions-'.$account_id.'.json') , 'filename' => '/public/upload/transactions-'.$account_id.'.json'],
            ],
        ]);

        $data = json_decode($response->getBody()
            ->getContents());


        $attributes = collect($data->data->attributes);
        $job_id = $attributes->get('request-id');

        $command = "   curl -X PUT  https://api.nordigen.com/v2/report/process/".$job_id. " -H 'Authorization: Bearer " . $this->token. "' -H 'Content-Type: application/json'  -d '{\"operations\": [\"categorisation\"],   \"country\": \"uk\"}'";

        $output = shell_exec($command);

        $response = $this->client->request('get', 'v2/report/'.$job_id);


        \Storage::disk()->put('/public/downloads/statement-'.$account_id.'.json', $response->getBody()
            ->getContents());

        return $account_id;

    }

    public function getCategorization($account_id){


        try {
            $categorization = \Storage::disk()
                ->get('public/downloads/statement-'.$account_id.'.json');
            return \GuzzleHttp\json_decode($categorization);
        } catch (\Exception $e) {
            return false;
        }
    }
}
