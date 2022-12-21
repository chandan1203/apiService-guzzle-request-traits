<?php

namespace App\Traits;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use GuzzleHttp\Client;
use Exception;

trait ApiService {

        public static function postCall($path='', $form_params=[], $token='') {

            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', config('app.api_link').$path, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$token,
                ],
                'form_params' => $form_params
            ]);
            
            $data =  json_decode(\json_encode(json_decode(($response->getBody())->getContents(), true)));
            return $data;
        }

        public static function getCall($path='', $query_params=[], $token='') {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', config('app.base_api_url').$path, [
                'query' => $query_params
            ]);
            $data =  json_decode(\json_encode(json_decode(($response->getBody())->getContents(), true)));
            return $data;
        }

}

