<?php

require_once 'Korisnik.php';
class PostpaidKorisnik extends Korisnik
{
    protected $prekoracenje;
    public $tarifniDodatak;
    public $ukupnaCenaTD;
    /**
     * PostpaidKorisnik constructor.
     * @param float $prekoracenje -> ukoliko prekoracenje postoji, u ovom polju cemo cuvati vrednost korisnikovog prekoracenja
     * @param  $ISP -> inherited
     * @param string $ime -> inherited
     * @param string $prezime -> inherited
     * @param string $adresa -> inherited
     * @param int $brojUgovora -> inherited
     * @param TarifniPaket $tarifniPaket -> tarifni paket koji ce korisnik imati prilikom potpisivanja ugovora, tj. inicijalizacije
     */
    public function __construct(float $prekoracenje, InternetProvajder $ISP, string $ime, string $prezime, string $adresa, int $brojUgovora, TarifniPaket $tarifniPaket)
    {
        parent::__construct($ISP, $ime, $prezime, $adresa, $brojUgovora, $tarifniPaket);
        $this->prekoracenje = $prekoracenje;
        $this->tarifniDodatak = array();
    }
    public function getIme() : string {
       return $this->ime;
    }
    public function getPrezime() : string {
        return $this->prezime;
    }
    public function getBrojUgovora() : int {
        return $this->brojUgovora;
    }
    public function getPrekoracenje(){
        return $this->prekoracenje;
    }


    public function ukupnoZaNaplatu(){
        if ($this->tarifniPaket->getNeogranicenSaobracaj() != false){
            $rez = $this->tarifniPaket->getCenaPaketa() + $this->ukupnaCenaTD;
            print_r("Ukupna suma za naplatu na računu #$this->brojUgovora je: $rez <br>");
            return $rez;
        }
        else{
            $rez = $this->tarifniPaket->getCenaPaketa() + $this->ukupnaCenaTD + $this->prekoracenje;
            print_r("Ukupna suma za naplatu na računu #$this->brojUgovora je: $rez <br>");
            return $rez;
        }

    }
    function surfuj(String $url, int $MB): bool
    {
        if ($this->tarifniPaket->getNeogranicenSaobracaj() == true){
                $listingUnos = new ListingUnos($url,  $MB);
                $this->ISP->zabeleziSaobracaj($this, $url, $MB);
                $this->dodajListingUnos($listingUnos);
                return true;
        }
        else if (in_array(strtolower($url), array_map('strtolower', $this->tarifniDodatak))){
            $listingUnos = new ListingUnos($url, $MB);
            $this->ISP->zabeleziSaobracaj($this, $url, $MB);
            $this->dodajListingUnos($listingUnos);
            return true;
        }
            $trenutniMB = $this->tarifniPaket->getMegabajti() - $MB;
            if($trenutniMB >= 0){
                print_r("Za ovu pretragu oduzeto Vam je $MB megabajta. Vaši trenutni megabajti: $trenutniMB <br>");
            }
            if ($trenutniMB < 0){
                print_r("Trenutni MB: 0 <br>");
                $razlika = -$trenutniMB * $this->tarifniPaket->getCenaPoMB();
                $this->prekoracenje = $razlika;
                echo "Trenutno prekoračenje je: {$this->prekoracenje}<br>";
                return true;
            }
        return true;
    }
    public function generisiRacun() : string {
       print_r("Tarifni dodaci korisnika: "); array_walk_recursive($this->tarifniDodatak,function($item,$key){echo"$item ";});echo "<br>";
        return print_r("  Broj ugovora: $this->brojUgovora <br>
                                     Ime: {$this->getIme()} <br> 
                                     Prezime: {$this->getPrezime()} <br>
                                     Cena paketa: {$this->tarifniPaket->getCenaPaketa()}<br>
                                     Prekoracenje: {$this->getPrekoracenje()} <br>
                                    Ukupno za naplatu: {$this->ukupnoZaNaplatu()}<br>");

    }
    function dodajTarifniDodatak(TarifniDodatak $tarifniDodatak)
    {
          if ($this->tarifniPaket->getNeogranicenSaobracaj() == true && ($tarifniDodatak->tipDodatka != "IPTV" && $tarifniDodatak->tipDodatka !="Fiksna_Telefonija")){
                    echo "Ukoliko imate neograničen internet saobraćaj, možete iskoristiti samo tarifne dodatke tipa IPTV ili fiksna telefonija! <br><br>";
          }
          else
          {
              array_push($this->tarifniDodatak,"Cena:", $tarifniDodatak->cena, "Tip dodatka:", $tarifniDodatak->tipDodatka);
              $this->ukupnaCenaTD = $this->ukupnaCenaTD + $tarifniDodatak->cena;
                echo "$this->ime: Uspešno ste dodali {$tarifniDodatak->tipDodatka} na listu tarifnih dodataka korisnika sa računom $this->brojUgovora <br>";
                echo "<br>";
          }
    }
}