<?php

namespace App\Http\Controllers;

use App\WebService\BasvuruYapCType;
use App\WebService\BasvuruYapGType;
use App\WebService\Kullanici;
use soap_server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SoapServiceController extends Controller
{
    public function basvusuYap($basvuruYapGType)
    {
        $result = new BasvuruYapCType();
        $result->belediyeKodu = $basvuruYapGType['belediyeKodu'];
        $result->basvuruTakipNo= rand(1,1000);

        //Belediye Sorgusu
        $kullaniciclar = new Kullanici();
        foreach($kullaniciclar->kullanicilar as $kullanici){
            if( $kullanici['belediyeKodu'] == $basvuruYapGType['belediyeKodu'])
            {
                if($kullanici['kullaniciAdi'] != $basvuruYapGType['kullaniciAdi'] || $kullanici['sifre'] != $basvuruYapGType['sifre']) {
                    //Belediye kullanıcı adı ve şifre Hatalı
                    $result->sonucKodu = 0001; // Kullanıcı adı ve şifre hatalı kodu
                    $result->sonucAciklamasi = "Kullanıcı Adı veya Şifre Hatalı"; // Kullanıcı adı ve şifre hatalı açıklaması
                    //return $result->basvuruTakipNo;
                    return $result->sonucAciklamasi;
                }
                else{ //Belediye doğrulandı
                    return 'ok';
                }
            }
        }
        //Belediye kullanıcı adı ve şifre Hatalı
        $result->sonucKodu = 0001; // Kullanıcı adı ve şifre hatalı kodu
        $result->sonucAciklamasi = "Kullanıcı Adı veya Şifre Hatalı"; // Kullanıcı adı ve şifre hatalı açıklaması
        //return $result->basvuruTakipNo;
        return $result->sonucAciklamasi;
    }

    public function index()
    {
        $server = new soap_server();//soap server oluşturup server değişkenine atıyoruz
        $server->configureWSDL("açıklama","urn:webservisimiz");//WSDL'nin adını ve acıklamasını veriyoruz.rastgele verebilirsiniz

        if(!isset($HTTP_RAW_POST_DATA)){
            $HTTP_RAW_POST_DATA = file_get_contents("php://input");
        }

//webservisimize register yapacağımız fonksiyonun içeriğini burada belirliyoruz.Kullanıcı veritabanımızda neleri görebilsin?
        function getir(){

            $Arrmetodlar = [
                'ok'=>'ok'
            ];

            return json_encode($Arrmetodlar);
        }
//nusoap kütüphanesinin nimetlerinden register fonksiyonu.Burada yukarıda ayarladığımız fonksiyonu alarak web servisimizi oluşturuyoruz.
        $server->register("getir",array(),
            array("return"=>"xsd:string"),
            "urn:webservisimiz",
            "urn:webservisimiz#getir",
            "rpc",
            "encoded",
            "bilgileri getir"
        );

        $server->service($HTTP_RAW_POST_DATA);



    }


}



