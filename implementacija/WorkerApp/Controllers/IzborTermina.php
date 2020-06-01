<?php
namespace App\Controllers;

use App\Models\TerminModel;

/**
 * Damir Savic 2017/0240
 * 
 * Klasa za izbor termina
 */
class IzborTermina extends BaseController
{
    /**
     * Funkcija koja se poziva da bi se iscrtao odredjeni view
     * @param $page-view koji treba da se pozove
     * @param $data-niz podataka koji se prosledjuje stranici
     * 
     * @return void 
     */
    protected function prikaz($page, $data) {
        echo view($page,$data);
    }

    /**
     * Funkcija koja sluzi za prikaz Viewa index
     * 
     * @return void 
     */
    public function index()
    {

        $t= new TerminModel();
        $datumi=$t->getDatume(NULL);
        $filmovi=$t->getFilmove(NULL);
        $data['datumi']=$datumi;
        $data['filmovi']=$filmovi;
        $this->prikaz('radnik/PrikazFilma',$data);
    }
    /**
     * Funkcija koja sluzi da vrati datume za odredjeni film 
     * @return void 
     */

    public function azurirajDatum()
    {//kao podatak imam film treba da nadjem datume
        $film=$_POST['film'];
        $t= new TerminModel();
        $datumi=$t->getDatume($film);
        $myJSON = json_encode($datumi);
        print_r( $myJSON);
    }
      /**
     * Funkcija koja sluzi da vrati filmove za odredjeni datum 
     * @return void 
     */

    public function azurirajFilm()
    {
        $t= new TerminModel();
        $datum=$_POST['datum'];
        $film=$t->getFilmove($datum);
        $myJSON = json_encode($film);
        print_r( $myJSON);
    }

      /**
     * Funkcija koja sluzi da vrati termine za odredjeni film i datum 
     * @return void 
     */

    public function azurirajTermin()
    {
        $t= new TerminModel();
        $datum=$_POST['datum'];   
        $film=$_POST['film'];
        $myJSON = json_encode($t->getTermine($datum,$film));
        print_r($myJSON);
    }
}