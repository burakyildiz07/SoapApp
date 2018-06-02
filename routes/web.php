<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::any('server',['uses'=>'SoapServiceController@index']);
Route::get('client',['uses'=>'SoapClientController@index']);


Route::any('api', function() {

    $$server = new soap_server();//soap server oluşturup server değişkenine atıyoruz
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

});

Route::get('apiTest', function() {
    $client = new nusoap_client("http://localhost:8000/api?wsdl");//bir client oluşturup wsdl adresimizi yazıyoruz.(oluşturduğumuz webservisine giderek wsdl  linkine tıklayıp alın)
    $metodlar = $client->call("getir");//web servisimizde oluşturduğumuz fonksiyonu clientimize çağırıyoruz.
    $metodlar = json_decode($metodlar);

    var_dump($metodlar);
});
