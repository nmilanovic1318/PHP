<?php

require_once 'Korisnik.php';
class InternetProvajder
{
    protected $ime;
    protected $listaKorisnika;
    protected $brojUgovora;

    /**
     * InternetProvajder constructor.
     * @param string $ime - naziv internet provajdera
     * @param string $listaKorisnika - lista korisnika internet provajdera
     * @param int $brojUgovora - broj ugovora korisnika ovog ISP-ja
     */
    public function __construct(string $ime, string $listaKorisnika)
    {
        $this->ime = $ime;
        $this->listaKorisnika = $listaKorisnika;
    }
    public function generisiRacune(Korisnik $korisnik){
        if ($korisnik instanceof PostpaidKorisnik){
            print_r("Generisani su sledeći računi za postpaid korisnike: <br> <br>");
            $korisnik->generisiRacun($korisnik); echo "<br>";echo "<br>";
        }
    }

    /**
     * @param Korisnik $korisnik -> prosledjujemo objekat klase Korisnik kako bi identifikovali ko vrsi pretragu radi zapisa
     * @param String $url -> prosledjujemo poseceni URL kao parametar tipa string radi zapisa
     * @param int $mb -> prosledjujemo broj potrosenih mb kao parametar tipa int radi zapisa
     */
    public function zabeleziSaobracaj(Korisnik $korisnik, String $url, int $mb){
                print_r("Broj ugovora korisnika: {$korisnik->getBrojUgovora()}, url koji je posećen: $url.com, broj potrošenih megabajta je $mb, korisnik koji je posetio sajt: {$korisnik->getIme()}<br>");
    }
    public function prikazPrepaidKorisnika(Korisnik $korisnik){
        if ($korisnik instanceof PrepaidKorisnik){
            echo "Prikaz prepaid korisnika preko $this->ime ISP-ja: <br> <br>";

            echo "Broj ugovora: {$korisnik->getBrojUgovora($korisnik)} <br>
                          Ime prepaid korisnika: {$korisnik->getIme($korisnik)} <br>
                          Prezime prepaid korisnika: {$korisnik->getPrezime($korisnik)} <br>
                          Stanje kredita prepaid korisnika: {$korisnik->getKredit()} <br>
                          ";
        }
        print_r("Tarifni dodaci korisnika: ");array_walk_recursive($korisnik->tarifniDodatak,function($item,$key){echo"$item ";});echo "<br>";echo "<br>";
    }

    public function prikazPostpaidKorisnika(Korisnik $korisnik){
        echo "Prikaz Postpaid korisnika preko $this->ime ISP-ja: <br> <br>";
        if ($korisnik instanceof PostpaidKorisnik){
            echo "Postpaid korisnici:";

            echo "Broj ugovora: {$korisnik->getBrojUgovora($korisnik)} <br> 
                          Ime postpaid korisnika:{$korisnik->getIme($korisnik)} <br> 
                          Prezime postpaid korisnika: {$korisnik->getPrezime($korisnik)} <br> 
                          Tarifni paket postpaid korisnika: {$korisnik->tarifniPaket->getCenaPaketa()} <br>";
        }
        print_r("Tarifni dodaci korisnika: ");array_walk_recursive($korisnik->tarifniDodatak,function($item,$key){echo"$item ";});echo "<br>";echo "<br>";
    }
    public function dodajKorisnika(Korisnik $korisnik){
       $this->listaKorisnika = "{$this->listaKorisnika}, {$korisnik->getIme()}, {$korisnik->getBrojUgovora()}<br>";
        if ($this->brojUgovora == $korisnik->getBrojUgovora()){
            echo "Ne možete dodati više korisnika sa istim brojem ugovora!";
            return;
        }
        $this->brojUgovora = $korisnik->getBrojUgovora();
        echo "<br>";
       print_r("$this->ime: Uspešno ste dodali korisnika sa imenom {$korisnik->getIme()} i brojem ugovora {$korisnik->getBrojUgovora()} na listu korisnika! <br><br>");
    }

}