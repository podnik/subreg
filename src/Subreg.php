<?php

namespace Podnik;


final class Subreg
{

    public $soapClient;
    private $token;

    public function __construct($login, $pass)
    {
        $this->soapClient = new \SoapClient("https://subreg.cz/wsdl");

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

    /**
     * @param $f
     * @param mixed ...$params
     * @return mixed
     * @throws Exception
     */
    public function base($f, ...$params) {
        $request = [
            "ssid" => $this->token
        ];
        foreach ($params as $p) {
            $request = array_merge($request,$p);
        }
        $response = $this->soapClient->$f($request)->response;
        if ($response->status == "error") {
            throw new Exception($response->error->errormsg,$response->error->errorcode->major);
        }
        return $response->data;
    }

    public function Domains_List() {
        return $this->base(__FUNCTION__);
    }
    public function Check_Domain($domain) {
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Info_Domain($domain) {
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }

}