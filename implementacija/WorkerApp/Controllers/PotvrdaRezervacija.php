<?php
namespace App\Controllers;

use App\Models\TerminModel;
use App\Models\MestoModel;
use App\Models\KorisnikModel;


class PotvrdaRezervacija extends BaseController
{
    protected function prikaz($page) {
        //echo view("radnik/header");
        echo view($page);
    }

    public function index()
    {
       // echo view ("prikazRezervacije");
        $this->prikaz("radnik/prikazRezervacije");
    }
    public function akcija()
    {
        $m= new MestoModel();
        //print_r($_POST);
        $data['termini']=$m->getRezervacijePoKorID($_POST['korIme']);
        $myJSON = json_encode($data);
        print_r( $myJSON);
    }
    public function potvrda()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $t= new TerminModel();
        $cena=$t->getCena($_POST['termin'])*$m->potvrdaRezervacije($_POST['korIme'],$_POST['termin']);
        if($k->isLoyality($_POST['korIme'])==true)
            $cena=$cena*0.9;
        echo($cena);
        //print_r($_POST);
    }
    public function otkaz()
    {
        $m= new MestoModel();
        $m->izbrisiRezervacije($_POST['korIme'],$_POST['termin']);
        //print_r();
    }
}