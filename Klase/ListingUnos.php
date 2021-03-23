<?php


class ListingUnos
{
    public $url;
    public $mb;

    /**
     * ListingUnos constructor.
     * @param string $url -> poseceni URL cuvamo u ovoj promenljivoj
     * @param int $mb -> broj potrosenih MB cuvamo u ovoj promenljivoj
     */
    public function __construct(string $url, int $mb)
    {
        $this->url = $url;
        $this->mb = $mb;

    }

    /**
     * @param int $megabajti -> prosledjujemo f-ji parametar megabajti tipa int
     */
    public function dodajMegabajte(int $megabajti){
            $this->mb += $megabajti;

    }

}