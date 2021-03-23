<?php
require_once '../Klase/InternetProvajder.php';
require_once '../Klase/Korisnik.php';
require_once '../Klase/ListingUnos.php';
require_once '../Klase/PostpaidKorisnik.php';
require_once '../Klase/PrepaidKorisnik.php';
require_once '../Klase/TarifniDodatak.php';
require_once '../Klase/TarifniPaket.php';


$SBB = new InternetProvajder("SBB", "");
$tarifniPaket = new TarifniPaket(1000,350, false, 300, 10);
$tarifniPaketDva = new TarifniPaket(1000,250, false, 300, 10);
$tarifniDodatakDva = new TarifniDodatak(150, "Instagram");
$tarifniDodatak = new TarifniDodatak(250, "IPTV");
$tarifniDodatakTri = new TarifniDodatak(250, "Fiksna_Telefonija");
$tarifniFacebook = new TarifniDodatak(200, "Facebook");
$url = "facebook";


$prepaidKorisnik = new PrepaidKorisnik(0, $SBB, "Pera", "Peric", "Adresa", 2299, $tarifniPaket);
$postPaidKorisnik = new PostpaidKorisnik(0, $SBB, "Mika", "Mikic", "Adresica", 9922, $tarifniPaket);
$kredit = 400;
$prepaidKorisnik->dodajTarifniDodatak($tarifniFacebook);
$SBB->prikazPrepaidKorisnika($prepaidKorisnik);
$SBB->prikazPostpaidKorisnika($postPaidKorisnik);
$postPaidKorisnik->dodajTarifniDodatak($tarifniDodatakTri);

$postPaidKorisnik->dodajTarifniDodatak($tarifniDodatak);

$SBB->generisiRacune($postPaidKorisnik);
$postPaidKorisnik->generisiRacun();


$SBB->dodajKorisnika($postPaidKorisnik);

$prepaidKorisnik->dopuniKredit($kredit);
$prepaidKorisnik->dodajTarifniDodatak($tarifniFacebook);
$prepaidKorisnik->surfuj($url, 30);
$prepaidKorisnik->surfuj($url, 30);
$prepaidKorisnik->surfuj($url, 90);


$postPaidKorisnik->surfuj($url, 310);
$SBB->generisiRacune($postPaidKorisnik);

