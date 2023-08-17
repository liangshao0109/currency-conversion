<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConversion extends Controller
{
    //
    function index(Request $request)
    {   
        
        // import data
        $raw_data = '{
            "currencies": {
                "TWD": {
                    "TWD": 1,
                    "JPY": 3.669,
                    "USD": 0.03281
                },
                "JPY": {
                    "TWD": 0.26956,
                    "JPY": 1,
                    "USD": 0.00885
                },
                "USD": {
                    "TWD": 30.444,
                    "JPY": 111.801,
                    "USD": 1
                }
            }
        }';
    
        $data = json_decode($raw_data);
        $currencies = array_keys((array)$data->currencies);
       
        //get request body
        $requestBody = $request->all();

        // error handling
        if(!array_key_exists('source', $requestBody)){
            return [
                'msg' => 'missing source'
            ];
        }

        if(!array_key_exists('target', $requestBody)){
            return [
                'msg' => 'missing target'
            ];
        }

        if(!array_key_exists('amount', $requestBody)){
            return [
                'msg' => 'missing amount'
            ];
        }

        if(!in_array($requestBody['source'], $currencies) || !in_array($requestBody['target'], $currencies)){
            return [
                'msg' => 'invaild currency'
            ];
        }
        
        //convert amount
        $amount = filter_var( str_replace(",", "", $requestBody['amount']), FILTER_SANITIZE_NUMBER_INT);
        $convert_rate = $data->currencies->{$requestBody['source']}->{$request['target']};
        $converted_amount = '$' . number_format($amount * $convert_rate, 2, ".",",");

        return [
            'msg' => 'success',
            'amount' => $converted_amount
        ];
    }
}
