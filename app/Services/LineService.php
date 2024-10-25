<?php

namespace App\Services;

use GuzzleHttp\Client;

class LineService
{
    public function getLoginBaseUrl()
    {
        // 組成 Line Login Url
        $url = config('line.authorize_base_url') . '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' . config('line.channel_id');
//        $url .= '&client_id=1657565787';
//        $url .= '&redirect_uri=http://35.234.27.81/callback/login';
        $url .= '&redirect_uri='.url('callback/login');
        $url .= '&state=test'; // 暫時固定方便測試
        $url .= '&scope=openid%20profile%20email';

        return $url;
    }

    public function getLineToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', config('line.get_token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
//                'redirect_uri' => 'http://35.234.27.81/callback/login',
                'redirect_uri' => url('callback/login'),
                'client_id' => config('line.channel_id'),
                'client_secret' => config('line.secret')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUserProfile($token)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $client->request('GET', config('line.get_user_profile_url'), [
            'headers' => $headers
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}