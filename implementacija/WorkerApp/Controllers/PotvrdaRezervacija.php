<?php
namespace App\Controllers;

use App\Models\TerminModel;
use App\Models\MestoModel;
use App\Models\KorisnikModel;

/**
 * Damir Savic 2017/0240
 * 
 * Klasa za potvrdu rezervacije
 */
class PotvrdaRezervacija extends BaseController
{
    /**
     * Funkcija koja se poziva da bi se iscrtao odredjeni view
     * @param $page-view koji treba da se pozove
     * @param $data-niz podataka koji se prosledjuje stranici
     * 
     * @return void 
     */
    protected function prikaz($page) {
        echo view($page);
    }
    /**
     * Funkcija koja izvrsava poroveru i rezervaciju izabranih polja u izabranom terminu
     * 
     * @return void 
     */
    public function index()
    {
        $this->prikaz("radnik/prikazRezervacije");
    }
    /**
     * Funkcija koja izvrsava poroveru da li korisnik ima rezervaciju 
     * 
     * @return void 
     */
    public function akcija()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $korIme=$_POST['korIme'];
        
        if ($k->isKorisnik($korIme)==false)
        {
            $data['termini']=array();
        }
        else {
            $korID=$k->getKorID($korIme);
            $data['termini']=$m->getRezervacijePoKorID($korID);}
        $myJSON = json_encode($data);
        print_r( $myJSON);
    }
    /**
     * Funkcija koja izvrsava potvrdu rezervacija 
     * 
     * @return void 
     */
    public function potvrda()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $t= new TerminModel();
        $korIme=$_POST['korIme'];
        $korID=$k->getKorID($korIme);

        $cena=$t->getCena($_POST['termin'])*$m->potvrdaRezervacije($korID,$_POST['termin']);
        if($k->isLoyality($korID)==true)
            $cena=$cena*0.9;
        echo($cena);
    }
    /**
     * Funkcija koja izvrsava otkazivanje aplikacije
     * 
     * @return void 
     */
    public function otkaz()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $korIme=$_POST['korIme'];
        $korID=$k->getKorID($korIme);
        $m->izbrisiRezervacije($korID,$_POST['termin']);
    }
}