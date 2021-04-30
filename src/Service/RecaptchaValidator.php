<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaValidator
{
    private $privateKey;
    private $captchaResponse;
    public $error;
    /**
     * @var string
     */
    private $ip;
    
    public function __construct(RequestStack $requestStack, string $recaptchaPrivateKey)
    {
        $this->privateKey = $recaptchaPrivateKey;
        /** @var Request $request */
        $request               = $requestStack->getCurrentRequest();
        $this->ip              = $request->server->get('REMOTE_ADDR');
        $this->captchaResponse = $request->request->get('g-recaptcha-response');
    }
    
    public function isValid(): bool
    {
        if (!$this->captchaResponse) {
            return false;
        }
        $data = $this->sendRequest();
        if (!$data) {
            return false;
        }
        $data = json_decode($data, true);
        
        return $data && $data['success'];
    }
    
    private function sendRequest()
    {
        $url    = 'https://www.google.com/recaptcha/api/siteverify';
        $fields = [
            'secret'   => $this->privateKey,
            'response' => $this->captchaResponse,
            'remoteip' => $this->ip,
        ];
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $data = curl_exec($ch);
        //$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->error = curl_error($ch);
        curl_close($ch);
        
        return $data;
    }
    
}