<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Service\CategorizationService;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use App\Http\Service\ATBAPI;
use Illuminate\Support\Facades\Storage;





class ATBAPIController extends Controller
{
    public function fetchAPI(Request $request)
    {

        $ATBAPI = new ATBAPI();
        $login = $ATBAPI->login();
        $token = $login['token'];
        session()->put('key',$token);
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
    public function getSustainabilityScore(Request $request, $id){
        $cat = new CategorizationService();
        dd($cat->startCategorization('test'));





    }
}
