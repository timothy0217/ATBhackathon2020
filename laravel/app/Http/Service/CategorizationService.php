<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class CategorizationService
{
    public $client;

    public $base_uri = 'https://api.nordigen.com';

    public $token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VUXlRVFJFTWpjeE1UUkVNVFl4TmpjNVJrUTJOVUl5TjBRMU4wSTJNVEEzUlVRNU9UWTRNZyJ9.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTIwMjE4MSwiZXhwIjoxNTgxMjg4NTgxLCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.plzcSs9OEs_Pm9ngFoUZ9zVJVmdEfCqWVaX69c8hPrjAt10eg8_VZiBSZSTi6pIBeQgY4QFlv0c1-QwTf0yM2jgFD-APzZ9VTDRrAy8KyYrEtl-5I67Qb9vgrtHpxyqjmAHrm1iBtu7T2Lqdwl2Vqik85eWPL7w2iaCVSyem8SCdbUcNEpvOjxzy9BjIhpeMJJyL4UnrLHq0DxwlQRk6SQVMQGW5C7owsJQwDAOUUDglB980WZSv1JuSjJoWjUVdPysnKE6dbatoot3JWQJID1aBuclYAWN7XOUmewiHFRBMA-FzFwPUdhwLrpCwZp4umyXDdp6Wgk8crj6YsKf3yQ.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTE4ODkwNiwiZXhwIjoxNTgxMjc1MzA2LCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.QjjAXxjw4kW6ltkXfyUvdWuSbIWi71N4WMTmthZN-C2tQQg8kOf59ga8B6HpcACP4lt_qEil3PSoPF5Fh-3dl-gpdaX-hNhV4oB2K4-eLK_gEHdetFAhkpK5IIB1IBiDttQWYpOnsV89n-8e_LB9IWE1FMc9PUtnAnSrXy2sqMp4RAf8j-t4MTOGsH_3YaQLXVmtv3d0l19z34mI8FHQ_f4cQLsuXnepJiNiE2LDKvDTn5ZiJVdOT-_BszPDEMQR01sseMkSnIKlWGEzM5199esZtICzDnQowxoZrA2Ei0ZcQLLZ-q0FbffUOeOqSVFONpEaQpgqG1eR8yZPQQFL1g';

    /**
     * CategorizationService constructor.
     */
    public function __construct()
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://auth.nordigen.com/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=RvmBObrYyw2l9F7l17nsn1XXzQAgLQdE&client_secret=yGePqmG81FFe6z6_M_kfNj2KP2rV2MA455swhhxCeZXKylOGCHko56lCnWHwS7vs&audience=https%3A//nordigen/api",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        $response = json_decode(curl_exec($curl),TRUE);
        curl_close($curl);

        $token = $response['access_token'];
        dd($token);


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

    public function categorize($transactions)
    {

        $file = Storage::disk()
            ->get('example.json');
        dd();
        $response = $this->client->POST('/v2/report', ['multipart' => ['input' => $file]]);
    }
}
