<?php


class TarifniDodatak
{
    public $cena;
    public $tipDodatka;

    /**
     * TarifniDodatak constructor.
     * @param int $cena -> cena tarifnog dodatka
     * @param string $tipDodatka -> tip dodatka; sme biti samo Facebook, Instagram, IPTV, Twitter, Viber i Fiksna_Telefonija, u suprotnom vraca null
     * @return null
     */

    public function __construct(int $cena, string $tipDodatka)
    {
        $this->cena = $cena;

       $this->tipDodatka = $tipDodatka;
       if ($tipDodatka != "Facebook" && ($tipDodatka !="Instagram") && ($tipDodatka != "IPTV") && ($tipDodatka != "Twitter") && ($tipDodatka != "Viber") && ($tipDodatka!= "Fiksna_Telefonija")){
              $this->tipDodatka = null;
       }
    }


}