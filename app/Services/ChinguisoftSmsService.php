<?php
namespace App\Services;

use GuzzleHttp\Client;

class ChinguisoftSmsService
{
    protected $client;
    protected $validationKey;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->validationKey = config('services.chinguisoft.key');
        $this->token = config('services.chinguisoft.token');
    }

    // public function sendValidationSms($phone, $lang )
    // {
    //     $url = "https://chinguisoft.com/api/sms/validation/{$this->validationKey}";

    //     $response = $this->client->post($url, [
    //         'headers' => [
    //             'Validation-token' => $this->token,
    //             'Content-Type' => 'application/json',
    //         ],
    //         'json' => [
    //             'phone' => $phone,
    //             'lang' => $lang,
                
    //         ],
    //     ]);

    //     return json_decode($response->getBody(), true);
    // }
   public function sendValidationSms($phone, $lang)
{
    $url = "https://chinguisoft.com/api/sms/validation/{$this->validationKey}";

    try {
        $response = $this->client->post($url, [
            'headers' => [
                'Validation-token' => $this->token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'phone' => $phone,
                'lang' => $lang,
            ],
        ]);

        $body = $response->getBody()->getContents();
        \Log::info('Réponse API SMS brute : ' . $body);
        return json_decode($body, true);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        \Log::error('Erreur API SMS : ' . $e->getMessage());
        if ($e->hasResponse()) {
            \Log::error('Réponse erreur API : ' . $e->getResponse()->getBody()->getContents());
        }
        return null;
    }
}

}
