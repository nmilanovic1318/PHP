<?php

require_once 'Korisnik.php';
class PrepaidKorisnik extends Korisnik
{
    protected $kredit;
    public $tarifniDodatak;

    /**
     * PrepaidKorisnik constructor.
     * @param float $kredit -> kredit Prepaid korisnika
     * @param InternetProvajder $ISP -> inherited
     * @param string $ime -> inherited
     * @param string $prezime -> inherited
     * @param string $adresa -> inherited
     * @param int $brojUgovora -> inherited
     * @param TarifniPaket $tarifniPaket -> tarifni paket koji ce korisnik imati prilikom potpisivanja ugovora, tj. inicijalizacije
     */
    public function __construct(float $kredit, InternetProvajder $ISP, string $ime, string $prezime, string $adresa, int $brojUgovora, TarifniPaket $tarifniPaket)
    {
        parent::__construct($ISP, $ime, $prezime, $adresa, $brojUgovora, $tarifniPaket);
        $this->kredit = $kredit;
        $this->tarifniDodatak = array();
    }
    public function getIme() : string {
       return $this->ime;
    }
    public function getPrezime() : string {
        return $this->prezime;
    }
    public function getBrojUgovora(){
        return $this->brojUgovora;
    }
    public function getKredit(){
        return $this->kredit;
    }

    public function dopuniKredit (float $kredit){
        $this->kredit = $kredit;
        print_r("Dodato je $kredit kredita na racun $this->brojUgovora<br><br>");
    }
    function surfuj(String $url, int $MB): bool
    {
            $listingUnos = new ListingUnos($url, $MB);
            if (in_array(strtolower($url), array_map('strtolower', $this->tarifniDodatak))){
                    $this->ISP->zabeleziSaobracaj($this, $url, $MB);
                    $this->dodajListingUnos($listingUnos);
                    return true;
                }
            else{
                $rez = $MB * $this->tarifniPaket->getCenaPoMB();
                if ($rez > $this->kredit){
                    print_r("Nemate dovoljno kredita!");
                    return false;
                }
               $this->kredit = $this->kredit - $rez;
                print_r("Za pristup internetu bez dodatka za besplatni surf oduzeto vam je $rez kredita. Vaš trenutni kredit je: $this->kredit <br>");
                $this->ISP->zabeleziSaobracaj($this, $url, 0);
                $listingUnosDva = new ListingUnos($url, 0);
                $this->dodajListingUnos($listingUnosDva);
                return true;
            }
    }

    function dodajTarifniDodatak(TarifniDodatak $tarifniDodatak)
    {
        if ($this->kredit > $tarifniDodatak->cena){
            array_push($this->tarifniDodatak,"Cena:", $tarifniDodatak->cena, "Tip dodatka:", $tarifniDodatak->tipDodatka);
            $this->kredit = $this->kredit - $tarifniDodatak->cena;
            echo "$this->ime: Uspešno ste dodali {$tarifniDodatak->tipDodatka} na listu tarifnih dodataka korisnika sa racunom $this->brojUgovora <br><br>";
        }
        else {
            echo "Nemate dovoljno kredita da biste dodali tarifni dodatak! <br><br>";
        }

    }
}