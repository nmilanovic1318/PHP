<?php
require_once 'IzradaListinga.php';

abstract class Korisnik implements IzradaListinga
{
    protected $ISP;
    protected $ime;
    protected $prezime;
    protected $adresa;
    protected $brojUgovora;
    public $tarifniPaket;
    protected $listaListingUnosa;

    /**
     * Korisnik constructor.
     * @param string $ISP -> ISP korisnika
     * @param string $ime -> ime korisnika
     * @param string $prezime -> prezime korisnika
     * @param string $adresa -> adresa korisnika
     * @param int $brojUgovora -> korisnikov broj ugovora
     * @param $tarifniDodatak -> tarifni dodatak koji korisnik poseduje; moze imati 0 ili vise (inicijalizovan kao prazan array)
     * @return int
     */

    public function getBrojUgovora(){
        return $this->brojUgovora;
    }
    public function getISP(){
        return $this->ISP;
    }
    public function getIme(){
        return $this->ime;
    }
    public function __construct(InternetProvajder $ISP, string $ime, string $prezime, string $adresa, int $brojUgovora, TarifniPaket $tarifniPaket)
    {
        $this->ISP = $ISP;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->adresa = $adresa;
        $this->brojUgovora = $brojUgovora;
        $this->tarifniPaket = $tarifniPaket;
        $this->listaListingUnosa = array();
    }

    public function dodajListingUnos(ListingUnos $listingUnos){
        $provera = false;
        foreach($this->listaListingUnosa as $item){
            if ($item->url == $listingUnos->url){
                $provera = true;
                $item->dodajMegabajte($listingUnos->mb);
                echo "Ponovo ste posetili isti sajt! Dodato je $listingUnos->mb megabajta. Ukupno potrošeno: {$item->mb}<br>";
            }
        }
        if ($provera == false){
            echo "Uspešno ste dodali listing unos sa $listingUnos->mb megabajta i $listingUnos->url URL-om!<br>";
            array_push($this->listaListingUnosa, $listingUnos);
        }

    }
    public function napraviListing(): string{
        if ($this->listaListingUnosa != null){
            sort($this->listaListingUnosa, SORT_NUMERIC, array_reverse());
            print_r("Lista listing unosa sortirana prema broju potrošenih MB (opadajuće): <br>");
            for ($i = 0; $i < count($this->listaListingUnosa); ++$i){
                echo $this->listaListingUnosa[$i] . " ";
                if ($i % 2){
                    echo "<br>";
                }
            }
        }
        else{
            print_r("Trenutno ne postoji listing za ovog korisnika!");
        }

    }
    abstract function surfuj(String $url, int $MB):bool;
    abstract function dodajTarifniDodatak(TarifniDodatak $tarifniDodatak);
}