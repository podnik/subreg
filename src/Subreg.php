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
     * @throws \Exception
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
            throw new \Exception($response->error->errormsg,$response->error->errorcode->major);
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
    public function Info_Domain_CZ($domain) {
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Set_Autorenew($domain, $autorenew) {
        return $this->base(__FUNCTION__,["domain" => $domain, "autorenew" => $autorenew]);
    }
    public function In_Subreg($domain) {
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Get_Redirects($domain) {
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Info_Contact($id) {
        return $this->base(__FUNCTION__,["contact" => ["id" => $id] ]);
    }
    public function Contacts_List() {
        return $this->base(__FUNCTION__);
    }
    public function Check_Object($object, $id) {
        return $this->base(__FUNCTION__,["object" => $object, "id" => $id]);
    }
    public function Info_Object($object, $id) {
        return $this->base(__FUNCTION__,["object" => $object, "id" => $id]);
    }
    public function Make_Order($order){
        return $this->base(__FUNCTION__,["order" => $order]);
    }
    public function Info_Order($order_id){
        return $this->base(__FUNCTION__,["order" => $order_id]);
    }
    public function Get_Credit(){
        return $this->base(__FUNCTION__);
    }

    /**
     * @param $from - string in YYYY-mm-dd format
     * @param $to - string in YYYY-mm-dd format
     * @return mixed
     * @throws \Exception
     */
    public function Get_Accountings($from, $to){
        return $this->base(__FUNCTION__,["from" => $from, "to" => $to]);
    }
    public function Credit_Correction($username, $amount, $reason){
        return $this->base(__FUNCTION__,["username" => $username, "amount" => $amount, "reason" => $reason]);
    }
    public function Pricelist(){
        return $this->base(__FUNCTION__);
    }
    public function Special_PriceList(){
        return $this->base(__FUNCTION__);
    }
    public function Prices($tld){
        return $this->base(__FUNCTION__,["tld" => $tld]);
    }
    public function Get_Pricelist($pricelist){
        return $this->base(__FUNCTION__,["pricelist" => $pricelist]);
    }
    public function Get_TLD_Info($tld){
        return $this->base(__FUNCTION__,["tld" => $tld]);
    }
    public function Download_Document($id){
        return $this->base(__FUNCTION__,["id" => $id]);
    }
    public function List_Documents(){
        return $this->base(__FUNCTION__);
    }

    /**
     * @param $name
     * @param $document
     * @param array $optional optional array with these optional parameters - format:
     *                  ["type" => Type of the document (optional), "filetype" => MIME type of the file (optional)]
     * @return mixed
     * @throws \Exception
     */
    public function Upload_Document($name, $document, $optional = []){
        $data = ["name" => $name, "document" => $document];
        $data = (!empty($optional)) ? array_merge($data, $optional) : $data;
        return $this->base(__FUNCTION__,$data);
    }
    public function Users_List(){
        return $this->base(__FUNCTION__);
    }
    public function Get_DNS_Info($domain, $dnstype){
        return $this->base(__FUNCTION__,["domain" => $domain, "dnstype" => $dnstype]);
    }
    public function Sign_DNS_Zone($domain){
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Unsign_DNS_Zone($domain){
        return $this->base(__FUNCTION__,["domain" => $domain]);
    }
    public function Anycast_List_Domains($ip){
        return $this->base(__FUNCTION__,["ip" => $ip]);
    }
    /**
     * @param $zone
     * @param array $fromto optional array with these optional parameters - format:
     *                  ["from" => Start date (YYYY-MM-DD) in UTC (optional) , "to" => End date (YYYY-MM-DD) in UTC (optionally)]
     * @return mixed
     * @throws \Exception
     */
    public function Anycast_Domain_Statistics($zone, $fromto = []){
        $data = ["zone" => $zone];
        $data = (!empty($optional)) ? array_merge($data, $fromto) : $data;
        return $this->base(__FUNCTION__,$data);
    }
    public function Get_Certificate($orderid){
        return $this->base(__FUNCTION__,["orderid" => $orderid]);
    }
    public function POLL_Get(){
        return $this->base(__FUNCTION__);
    }
    public function POLL_Ack($id){
        return $this->base(__FUNCTION__,["id" => $id]);
    }
}