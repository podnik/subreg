<?php


class Client
{

    public $soapClient;
    private $token;

    public function __construct($login, $pass)
    {
        $this->soapClient = new SoapClient("https://subreg.cz/wsdl");

        $loginParams = array (
            "data" => array (
                "login" => $login,
                "password" => $pass,
            )
        );

        $response = $this->soapClient->__call("Login",$loginParams);
        $this->token = $response->response->data->ssid;
        bdump($response);
    }

    public function checkDomain($domain) {
        $params = [
            "ssid" => $this->token,
            "domain" => $domain
        ];
        bdump($params);
        return $this->soapClient->Check_Domain($params);
    }

}