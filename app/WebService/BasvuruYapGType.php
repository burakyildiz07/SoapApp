<?php

namespace App\WebService;

class BasvuruYapGType extends KisiselSorgulamaGType
{
    public $adi;
    public $soyadi;
    public $aboneNo;
    public $ilceKodu;
    public $mahalleKodu;
    public $sokakCaddeKodu;
    public $disKapiNo;
    public $icKapiNo;
    public $basvuranAciklamaAdres;
    public $basvuranNVIAdresNo;
    public $basvuruTipi;
    public $eposta;
    public $telefonListesi =array();
    public $basvuruDetay;
    public $kordinat;
    public $cevapSekli;
    public $detayListesi;
    public $dosyaListesi;
    public $dosyaBilgisiType;
    public $dosyauzanti;
    public $dosya;
}