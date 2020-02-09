<?php

namespace App\Http\Controllers;

use App\Http\Service\ATBAPI;
use App\Http\Service\CategorizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ATBAPIController extends Controller
{
    public function fetchAPI(Request $request)
    {

        $ATBAPI = new ATBAPI();
        $login = $ATBAPI->login();
        $token = $login['token'];
        session()->put('key', $token);
        $token = session()->get('key');


// fetch all accounts and it's ID
        $getAllAccounts = $ATBAPI->getAccount($token);
        $getAccountID =$getAllAccounts[1]['id']; // Change the number to choose between accounts
        $getTransactions = $ATBAPI->getTransactionsForAccount($token,$getAccountID);
        $getTransactions = json_encode($getTransactions,true);
        $accountID= $getAccountID;
        $fileName = $accountID.'.json';

//  Save Json as file to storage
        Storage::put('public/upload/' . $fileName, $getTransactions);

//  Read json file from storage
        $path = storage_path().'/app/public/upload/'.$fileName;
        $oldJason = json_decode(file_get_contents($path),true);

// Nordigen Formating
        $accountListArray = array('account_nr'=>$accountID,
            'holder_name'=>'first_name last_name',
            'holder_id'=>$accountID,
            'bank_name'=>'screaming lemon',
            'currency'=>'CAD',
            'start_balance'=>500000,
            'end_balance'=>400000,
            'debit_turnover'=>101000,
            'credit_turnover'=>1000,
            'period_start'=>'2020-01-01',
            'period_end'=>'2020-01-01',
            'transaction_list'=>[]
        );

        // Transaction from ATB Finance
        $transactions = $oldJason['transactions'];
        // Unique transaction ID
        $transactionID = 0;

        foreach($transactions as $transaction)
        {
            // Unique transaction ID
            $transactionID = $transactionID+1;
            $date = $transaction['details']['posted'];

            $transactionListArray = array(
                'date'=>substr($date,0,10),
                'partner'=>$transaction['details']['type'],
                'info'=>$transaction['details']['description'] . ' '. str_replace($date,'T','') . ' CAD',
                'transaction_id'=>'arbritary-unique-id'.$transactionID,
                'sum' => (float)$transaction['details']['value']['amount']
            );

            // push transaction_list data as an object under  transaction_list array
            $transactionListObject = (object)$transactionListArray;
            array_push($accountListArray['transaction_list'],$transactionListObject);
        }


        // push account_list data as an object under account_list array
        $accountListObject = (object)$accountListArray;
        $newJson = array('account_list'=>[]);
        array_push($newJson['account_list'],$accountListObject);
        $newJson = json_encode($newJson);
//Nordigen json format --->  $newJason


        Storage::disk()->put('public/upload/transactions-'.$accountID.'.json', $newJson);
        dd($newJson);

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
    public function getSustainabilityScore(Request $request, $account_id)
    {
        $cat = new CategorizationService();

        // try to get categorization file

        $categorized = $cat->getCategorization($account_id);

        if($categorized) {
            $accounts = $categorized->data->attributes->categorisation->accounts;

            // need to accomodate multiple accounts/ transactions later
            $account = array_shift($accounts);

            $currency = array_shift($account->currencies);
            $transactions = collect($currency->transactions);

            // Sum dollar value for selected categories
            $selected = [
                29 => [
                    'id' => 29,
                    'title' =>'Utility services',
                    'carbon_mulitplier'=> 0.1,
                ],
                //
                30 => [
                    'id'=> 30,
                    'title' => 'Heating',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                32 => [
                    'id' => 32,
                    'title' => 'Electricity',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                33 => [
                    'id'=> 33,
                    'title' => 'Natural gas',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                //    35 => ['title' =>  'Telephone, internet, TV, computer'],
                //
                36 => [
                    'id'=> 36,
                    'title' => 'Water',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                37 => [
                    'id'=> 37,
                    'title' => 'Other utility expenses',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                42 => [
                    'id'=>42,
                    'title' => 'Transportation',
                    'carbon_mulitplier' => 0.1,
                ],
                //
                44 => [
                    'id'=> 44,
                    'title' => 'Fuel',
                    'carbon_mulitplier' => 0.1,
                ],
                46 => [
                    'id'=> 46,
                    'title' => 'Vehicle purchase, maintenance',
                    'carbon_mulitplier' => 0.1,
                ],
                //	Vehicle purchase, maintenance
                55 => [
                    'id'=> 55,
                    'title' => 'Accommodation, travel expenses',
                    'carbon_mulitplier' => 0.1,
                ],
                //
            ];

            // get transactions for selected categories
            $ids = array_keys($selected);

            $value_total = 0;
            $carbon_total = 0;
            $stats = [];

            foreach ($selected as $id => $category) {

                $cat_transactions = $transactions->where('category_id', $id);
                $value = $cat_transactions->sum('amount');
                $carbon =  -1 * $value * $category['carbon_mulitplier'];
                $value_total += $value;
                $carbon_total += $carbon;

                $category['value'] = $value;
                $category['carbon'] = $carbon;

                $stats[$id] = $category;

            }

            $result = [
                'value_total' => $value_total,
                'carbon_total' => $carbon_total,
                'sustainability_score' => mt_rand(200, 700),
                'categories'=> $stats,
            ];

            return json_encode(['data' => $result]);

        } else {
            // start the job for this account

            // start categorization
            $cat->startCategorization($account_id);


        }


        // get transactions


        // retrieve job
        $categorized = $cat->getCategorization($account_id);


    }
}
