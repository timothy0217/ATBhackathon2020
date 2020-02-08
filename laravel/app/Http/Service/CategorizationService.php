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
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token,
                'Accept' => 'application/json',
            ],
            'base_uri' => $this->base_uri,
        ]);

        $authClient = new Client(['base_uri' => 'https://auth.nordigen.com']);
        $token = $authClient->request('POST', 'oauth/token'
        [
            'grant_type' => 'client_credentials',
'client_id' =>'RvmBObrYyw2l9F7l17nsn1XXzQAgLQdE',
'client_secret' => 'yGePqmG81FFe6z6_M_kfNj2KP2rV2MA455swhhxCeZXKylOGCHko56lCnWHwS7vs',
'audience' => 'https://nordigen/api'
            ]
        );

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

//        curl -H 'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VUXlRVFJFTWpjeE1UUkVNVFl4TmpjNVJrUTJOVUl5TjBRMU4wSTJNVEEzUlVRNU9UWTRNZyJ9.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTIwMjE4MSwiZXhwIjoxNTgxMjg4NTgxLCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.plzcSs9OEs_Pm9ngFoUZ9zVJVmdEfCqWVaX69c8hPrjAt10eg8_VZiBSZSTi6pIBeQgY4QFlv0c1-QwTf0yM2jgFD-APzZ9VTDRrAy8KyYrEtl-5I67Qb9vgrtHpxyqjmAHrm1iBtu7T2Lqdwl2Vqik85eWPL7w2iaCVSyem8SCdbUcNEpvOjxzy9BjIhpeMJJyL4UnrLHq0DxwlQRk6SQVMQGW5C7owsJQwDAOUUDglB980WZSv1JuSjJoWjUVdPysnKE6dbatoot3JWQJID1aBuclYAWN7XOUmewiHFRBMA-FzFwPUdhwLrpCwZp4umyXDdp6Wgk8crj6YsKf3yQ' \
//        -F input=@example.json \
//            https://api.nordigen.com/v2/report
//
//
//        >             https://api.nordigen.com/v2/report
//{"data":{"attributes":{"available-operations":["categorisation","income","features","risk","observations","kyc","credit-scores","loans"],"request-id":"9250be63-83cd-4e96-86fc-67990f632f5a","status":"completed"},"relationships":{"operations":{"links":{"related":"https://api.nordigen.com/v2/report/process/9250be63-83cd-4e96-86fc-67990f632f5a","self":"https://api.nordigen.com/v2/report"}}},"type":"report pre-processing record"}}
//
//
//        curl -X PUT \
//        https://api.nordigen.com/v2/report/process/9250be63-83cd-4e96-86fc-67990f632f5a \
//-H 'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VUXlRVFJFTWpjeE1UUkVNVFl4TmpjNVJrUTJOVUl5TjBRMU4wSTJNVEEzUlVRNU9UWTRNZyJ9.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTIwMjE4MSwiZXhwIjoxNTgxMjg4NTgxLCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.plzcSs9OEs_Pm9ngFoUZ9zVJVmdEfCqWVaX69c8hPrjAt10eg8_VZiBSZSTi6pIBeQgY4QFlv0c1-QwTf0yM2jgFD-APzZ9VTDRrAy8KyYrEtl-5I67Qb9vgrtHpxyqjmAHrm1iBtu7T2Lqdwl2Vqik85eWPL7w2iaCVSyem8SCdbUcNEpvOjxzy9BjIhpeMJJyL4UnrLHq0DxwlQRk6SQVMQGW5C7owsJQwDAOUUDglB980WZSv1JuSjJoWjUVdPysnKE6dbatoot3JWQJID1aBuclYAWN7XOUmewiHFRBMA-FzFwPUdhwLrpCwZp4umyXDdp6Wgk8crj6YsKf3yQ' \
//        -H 'Content-Type: application/json' \
//        -d '{
//  "operations": ["categorisation"],
//  "country": "uk"
//}'
//
//        {"data":{"attributes":{"request-id":"9250be63-83cd-4e96-86fc-67990f632f5a","status":"queued"},"relationships":{"result":{"links":{"related":"https://api.nordigen.com/v2/report/9250be63-83cd-4e96-86fc-67990f632f5a","self":"https://api.nordigen.com/v2/report/process/9250be63-83cd-4e96-86fc-67990f632f5a"}}},"type":"report processing record"}}
//
//        curl -X GET \
//        https://api.nordigen.com/v2/report/9250be63-83cd-4e96-86fc-67990f632f5a \
//-H 'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VUXlRVFJFTWpjeE1UUkVNVFl4TmpjNVJrUTJOVUl5TjBRMU4wSTJNVEEzUlVRNU9UWTRNZyJ9.eyJpc3MiOiJodHRwczovL2F1dGgubm9yZGlnZW4uY29tLyIsInN1YiI6IlJ2bUJPYnJZeXcybDlGN2wxN25zbjFYWHpRQWdMUWRFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL25vcmRpZ2VuL2FwaSIsImlhdCI6MTU4MTIwMjE4MSwiZXhwIjoxNTgxMjg4NTgxLCJhenAiOiJSdm1CT2JyWXl3Mmw5RjdsMTduc24xWFh6UUFnTFFkRSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.plzcSs9OEs_Pm9ngFoUZ9zVJVmdEfCqWVaX69c8hPrjAt10eg8_VZiBSZSTi6pIBeQgY4QFlv0c1-QwTf0yM2jgFD-APzZ9VTDRrAy8KyYrEtl-5I67Qb9vgrtHpxyqjmAHrm1iBtu7T2Lqdwl2Vqik85eWPL7w2iaCVSyem8SCdbUcNEpvOjxzy9BjIhpeMJJyL4UnrLHq0DxwlQRk6SQVMQGW5C7owsJQwDAOUUDglB980WZSv1JuSjJoWjUVdPysnKE6dbatoot3JWQJID1aBuclYAWN7XOUmewiHFRBMA-FzFwPUdhwLrpCwZp4umyXDdp6Wgk8crj6YsKf3yQ'
//
//
//        "data":{"attributes":{"categorisation":{"accounts":[{"account_number":"GB29IBAN20160604201923","bank":"Some Bank","country":"uk","currencies":[{"code":"GBP","credit_turnover":1100.8,"debit_turnover":366.4,"end_balance":2750.86,"start_balance":2016.46,"transactions":[{"amount":-15.45,"category_id":84,"date":"2019-08-01","info":"PURCHASE 201620190406111 15.45GBP","partner":"Local Groceries","transaction_id":"arbritary-unique-id1"},{"amount":900.8,"category_id":85,"date":"2019-08-05","info":"SALARY 201620190406222 900.80GBP","partner":"Job Ltd","transaction_id":"arbritary-unique-id2"},{"amount":200.0,"category_id":23,"date":"2019-08-07","info":"ROYALTIES 201620190406333 200.00GBP","partner":"Freelance Agency Ltd","transaction_id":"arbritary-unique-id3"},{"amount":-50.45,"category_id":44,"date":"2019-08-11","info":"PURCHASE 201620190406444 50.45GBP","partner":"Gas Station","transaction_id":"arbritary-unique-id4"},{"amount":-300.5,"category_id":97,"date":"2019-08-15","info":"MORTGAGE PAYMENT, AGREEMENT A201664 300.50GBP","partner":"Loan Bank","transaction_id":"arbritary-unique-id5"}]}],"holders":[{"name":"Alex Watson"}],"is_joint_ownership":false,"is_shared_ownership":false,"period_end":"2019-08-15","period_start":"2019-08-01"}],"category_tree_version":"uk_202001311420"},"status":"completed"},"type":"report processing status"}}

        $response = $this->client->POST('/v2/report', ['multipart' => ['input' => $file]]);
    }
}
