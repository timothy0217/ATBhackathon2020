<?php

namespace App\Http\Controllers;

use App\Http\Service\ATBAPI;
use App\Http\Service\CategorizationService;
use Illuminate\Http\Request;

class ATBAPIController extends Controller
{
    public function fetchAPI(Request $request)
    {

        $ATBAPI = new ATBAPI();
        $login = $ATBAPI->login();
        $token = $login['token'];
        session()->put('key', $token);
        $token = session()->get('key');

        //$getAllAccounts = $ATBAPI->getAccount($token);
        //dd($getAllAccounts);
        $test = $ATBAPI->getTransactionsForAccount($token, '2524119902112-a6b71584-74f');

        $types = [];

        foreach ($test['transactions'] as $t) {

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

        }


        // get transactions

        // start categorization
        $cat->startCategorization('test', $account_id);

        // retrieve job
        $categorized = $cat->getCategorization($account_id);


    }
}
