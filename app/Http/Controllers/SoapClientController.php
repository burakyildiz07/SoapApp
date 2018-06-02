<?php

namespace App\Http\Controllers;

use App\WebService\BasvuruYapGType;
use nusoap_client;
use Illuminate\Http\Request;

class SoapClientController extends Controller
{
    public function index()
    {
        $client = new nusoap_client("http://localhost:8000/server?wsdl");//bir client oluşturup wsdl adresimizi yazıyoruz.(oluşturduğumuz webservisine giderek wsdl  linkine tıklayıp alın)
        $metodlar = $client->call("getir");//web servisimizde oluşturduğumuz fonksiyonu clientimize çağırıyoruz.
        $metodlar = json_decode($metodlar);

        var_dump($metodlar);
    }
}
