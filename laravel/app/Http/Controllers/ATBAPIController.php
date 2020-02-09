<?php

namespace App\Http\Controllers;

use App\Http\Service\ATBAPI;
use App\Http\Service\CategorizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class ATBAPIController
 *
 * @package App\Http\Controllers
 */
class ATBAPIController extends Controller
{
    protected $token;

    protected $atb;

    protected $emails;

    /**
     * ATBAPIController constructor.
     */
    public function __construct(ATBAPI $ATBAPI)
    {
        $this->atb = $ATBAPI;

        if (session()->has('key')) {
            $token = session()->get('key');
        } else {
            $this->authenticate();
        }

        $this->emails = collect([
            [
                'email' => 'martha@hotmail.com',
                'account_id' => '942525966868-5e1328f8-85c',
            ],
            [
                'email' => 'matthew@routeique.com',
                'account_id' => '9043177494179-a30c474d-ced',
            ],
        ]);
    }

    public function authenticate()
    {

        $login = $this->atb->login();
        $token = $login['token'];
        $this->token = $token;

        session()->put('key', $token);
    }

    public function login(Request $request)
    {

        $email = $request->get('email');

        // get account ID for email
        $account = $this->emails->where('email', $email);

        //dd($account);

        if ($account->isEmpty()) {
            return response(json_encode(['error' => 'No account found'], 401));
        } else {

            $account = $account->first();
            $data = $this->getAccountData($account['account_id']);

            return response(json_encode(['data' => $data]), 201);
        }
    }

    /**
     *
     * @param $getAccountID
     * @return array
     */
    private function getAccountData($accountID)
    {
        $allAccounts = collect($this->atb->getAccount($this->token));

        $account = $allAccounts->where('id', $accountID);
        $accountName = $account['label'];
        $accountFullInfo = $this->getCustomer($this->token, $accountID);
        $accountBalance = $accountFullInfo['balance']['amount'];

        $fileName = $accountID.'.json';

        if (! Storage::exists('public/upload/'.$fileName)) {
            $getTransactions = $this->atb->getTransactionsForAccount($this->token, $accountID);
            $getTransactions = json_encode($getTransactions, true);

            //  Save Json as file to storage
            Storage::put('public/upload/'.$fileName, $getTransactions);
        }

        //  Read json file from storage
        $path = storage_path().'/app/public/upload/'.$fileName;
        $oldJason = json_decode(file_get_contents($path), true);

        // Nordigen Formating
        $accountListArray = [
            'account_nr' => $accountID,
            'holder_name' => $accountName,
            'holder_id' => $accountID,
            'bank_name' => 'screaming lemon',
            'currency' => 'CAD',
            'start_balance' => $accountBalance,
            'end_balance' => $accountBalance,
            'debit_turnover' => 101000,
            'credit_turnover' => 1000,
            'period_start' => '2020-01-01',
            'period_end' => '2020-01-01',
            'transaction_list' => [],
        ];

        // Transaction from ATB Finance
        $transactions = $oldJason['transactions'];
        // Unique transaction ID
        $transactionID = 0;

        foreach ($transactions as $transaction) {
            // Unique transaction ID
            $transactionID = $transactionID + 1;
            $date = $transaction['details']['posted'];

            $transactionListArray = [
                'date' => substr($date, 0, 10),
                'partner' => $transaction['details']['type'],
                'info' => $transaction['details']['description'].' '.str_replace($date, 'T', '').' CAD',
                'transaction_id' => 'arbritary-unique-id'.$transactionID,
                'sum' => (float) $transaction['details']['value']['amount'],
            ];

            // push transaction_list data as an object under  transaction_list array
            $transactionListObject = (object) $transactionListArray;
            array_push($accountListArray['transaction_list'], $transactionListObject);
        }

        // push account_list data as an object under account_list array
        $accountListObject = (object) $accountListArray;
        $newJson = ['account_list' => []];
        array_push($newJson['account_list'], $accountListObject);
        $newJson = json_encode($newJson);

        return $newJson;
    }

    public function fetchAPI(Request $request)
    {
// fetch all accounts and it's ID

        $getAllAccounts = $this->atb->getAccount($this->token);
        $getAccountID = $getAllAccounts[20]['id']; // Change the number to choose between accounts;
        $getTransactions = $this->atb->getTransactionsForAccount($this->token, $getAccountID);
        $getTransactions = json_encode($getTransactions, true);
        $accountID = $getAccountID;
        $fileName = $accountID.'.json';

//Get Account Info
        $accountName = $getAllAccounts[20]['label'];
        $accountFullInfo = $this->getCustomer($this->token, $accountID);
        $accountBalance = $accountFullInfo['balance']['amount'];

//  Save Json as file to storage
        Storage::put('public/upload/'.$fileName, $getTransactions);

//  Read json file from storage
        $path = storage_path().'/app/public/upload/'.$fileName;
        $oldJason = json_decode(file_get_contents($path), true);

// Nordigen Formating
        $accountListArray = [
            'account_nr' => $accountID,
            'holder_name' => 'Mike Allan',
            'holder_id' => $accountID,
            'bank_name' => 'screaming lemon',
            'currency' => 'CAD',
            'start_balance' => 500000,
            'end_balance' => 400000,
            'debit_turnover' => 101000,
            'credit_turnover' => 1000,
            'period_start' => '',
            'period_end' => '',
            'transaction_list' => [],
        ];

        // Transaction from ATB Finance
        $transactions = $oldJason['transactions'];
        // Unique transaction ID
        $transactionID = 0;
        $startDate = "9999-12-30";
        $endDate = "0001-01-01";

        foreach ($transactions as $transaction) {
            $getDate = $transaction['details']['posted'];
            $date = substr($getDate, 0, 10);
            $dateAndTime = str_replace($getDate, 'T', '');

            if ($date < $startDate) {
                $startDate = $date;
            }

            if ($date > $endDate) {
                $endDate = $date;
            }

            // Unique transaction ID
            $transactionID = $transactionID + 1;

            $transactionListArray = [
                'date' => $date,
                'partner' => $transaction['details']['type'],
                'info' => $transaction['details']['description'].' '.$dateAndTime.' CAD',
                'transaction_id' => 'arbritary-unique-id'.$transactionID,
                'sum' => (float) $transaction['details']['value']['amount'],
            ];
            // push transaction_list data as an object under  transaction_list array
            $transactionListObject = (object) $transactionListArray;
            array_push($accountListArray['transaction_list'], $transactionListObject);
        }
        $accountListArray['period_start'] = $startDate;
        $accountListArray['period_end'] = $endDate;

        // push account_list data as an object under account_list array
        $accountListObject = (object) $accountListArray;
        $newJson = ['account_list' => []];
        array_push($newJson['account_list'], $accountListObject);
        $newJson = json_encode($newJson);

//Nordigen json format --->  $newJason

        Storage::disk()
            ->put('public/upload/transactions-'.$accountID.'.json', $newJson);

        return $accountID;
    }

    public function getCustomer($token, $accountID)
    {
        $ATBAPI = new ATBAPI();
        $getAccountInfo = $ATBAPI->getAccountByID($token, $accountID);

        return $getAccountInfo;
    }


    ///**
    // * @param  \Illuminate\Http\Request  $request
    // * @param $id
    // *
    // * @return  string json
    // */
    //public function getAccount(Request $request, $id)
    //{
    //    $account = $this->atb->getAccount($this->token, $id);
    //    return json_encode(['data'=> $account]);
    //}

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */

    public function getAccounts(Request $request)
    {
        $accounts = $this->atb->getAccounts($this->token);

        return response(json_encode(['data' => $accounts]), 200);
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

        $categorized = $cat->getCategorizationFromFile($account_id);

        if ($categorized) {
            $accounts = $categorized->data->attributes->categorisation->accounts;

            // need to accomodate multiple accounts/ transactions later
            $account = array_shift($accounts);

            $currency = array_shift($account->currencies);
            $transactions = collect($currency->transactions);

            // Sum dollar value for selected categories
            $selected = [
                29 => [
                    'id' => 29,
                    'title' => 'Utility services',
                    'carbon_multiplier' => 2.19,
                ],
                //
                30 => [
                    'id' => 30,
                    'title' => 'Heating',
                    'carbon_multiplier' => 5.77,
                ],
                //
                32 => [
                    'id' => 32,
                    'title' => 'Electricity',
                    'carbon_multiplier' => 0.634,
                ],
                //
                33 => [
                    'id' => 33,
                    'title' => 'Natural gas',
                    'carbon_multiplier' => 5.77,
                ],
                //
                //    35 => ['title' =>  'Telephone, internet, TV, computer'],
                //
                36 => [
                    'id' => 36,
                    'title' => 'Water',
                    'carbon_multiplier' => 0.173,
                ],
                //
                37 => [
                    'id' => 37,
                    'title' => 'Other utility expenses',
                    'carbon_multiplier' => 2.19,
                ],
                //
                42 => [
                    'id' => 42,
                    'title' => 'Transportation',
                    'carbon_multiplier' => 0.92,
                ],
                //
                44 => [
                    'id' => 44,
                    'title' => 'Fuel',
                    'carbon_multiplier' => 2.49,
                ],
                46 => [
                    'id' => 46,
                    'title' => 'Vehicle purchase, maintenance',
                    'carbon_multiplier' => 4.999,
                ],
                //	Vehicle purchase, maintenance
                55 => [
                    'id' => 55,
                    'title' => 'Accommodation, travel expenses',
                    'carbon_multiplier' => 0.323,
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
                $carbon = -1 * $value * $category['carbon_multiplier'];
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
                'categories' => $stats,
            ];

            return response(json_encode(['data' => $result]), 200);
        } else {
            // try to find file
            if (! Storage::exists('public/upload/transactions-'.$account_id.'.json')) {
                // generate file
                $this->createCategorizationUploadFile($account_id);
            };

            // start categorization
            $cat->startCategorization($account_id);

            return response('Locked', 423);
        }

        // retrieve job
        $categorized = $cat->getCategorization($account_id);
    }

    /**
     * @param $getAccountID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function createCategorizationUploadFile($accountID)
    {
        $newJson = $this->getAccountData($accountID);
        //Nordigen json format --->  $newJason
        Storage::disk()
            ->put('public/upload/transactions-'.$accountID.'.json', $newJson);

        return $newJson;
    }
}
