<?php


class Client
{

    private $soapClient;
    public function __construct($location, $uri, $login, $pass)
    {
        $this->soapClient = new \SoapClient(
            null,
            array(
                "location" => $location,
                "uri" => $uri
            )
        );

        $params = array (
            "data" => array (
                "login" => $login,
                "password" => $pass,
            )
        );

        $response = $this->soapClient->__call("Login",$params);

        dump($response);die();
    }

}