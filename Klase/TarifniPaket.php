<?php


class TarifniPaket
{
    protected $maxSpeed;
    protected $cenaPaketa;
    public $neogranicenSaobracaj;
    protected $megabajti;
    protected $cenaPoMB;

    public function getCenaPaketa(){
        return $this->cenaPaketa;
    }
    public function getNeogranicenSaobracaj(){
        return $this->neogranicenSaobracaj;
    }
    public function getCenaPoMB(){
        return $this->cenaPoMB;
    }
    public function getMegabajti(){
        return $this->megabajti;
    }
    /**
     * TarifniPaket constructor.
     * @param int $maxSpeed -> Maksimalna brzina paketa
     * @param float $cenaPaketa -> Cena paketa
     * @param bool $neogranicenSaobracaj -> Vraca true ili false u zavisnosti od toga da li korisnik ima pristup neogranicenom netu
     * @param int $megabajti -> Broj dostupnih megabajta
     * @param float $cenaPoMB -> Cena / MB
     */
    public function __construct(int $maxSpeed, float $cenaPaketa, bool $neogranicenSaobracaj, int $megabajti, float $cenaPoMB)
    {
        $this->maxSpeed = $maxSpeed;
        $this->cenaPaketa = $cenaPaketa;
        $this->neogranicenSaobracaj = $neogranicenSaobracaj;
        $this->megabajti = $megabajti;
        $this->cenaPoMB = $cenaPoMB;
    }


}