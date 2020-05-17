<?php
namespace App\Controllers;

use App\Models\TerminModel;


class IzborTermina extends BaseController
{
    protected function prikaz($page, $data) {
        //echo view("radnik/header");
        echo view($page,$data);
    }

    public function index()
    {
        $t= new TerminModel();
        $datumi=$t->getDatume(NULL);
        $filmovi=$t->getFilmove(NULL);
        $data['datumi']=$datumi;
        $data['filmovi']=$filmovi;
        $this->prikaz('radnik/PrikazFilma',$data);
    }

    public function azurirajDatum()
    {//kao podatak imam film treba da nadjem datume
        $film=$_POST['film'];
        $t= new TerminModel();
        $datumi=$t->getDatume($film);
        $myJSON = json_encode($datumi);
        print_r( $myJSON);
    }

    public function azurirajFilm()
    {//kao podatak imam datum treba da nadjem film
        $t= new TerminModel();
        $datum=$_POST['datum'];
        $film=$t->getFilmove($datum);
        $myJSON = json_encode($film);
        print_r( $myJSON);
    }

    public function azurirajTermin()
    {
        $t= new TerminModel();
        $datum=$_POST['datum'];   
        $film=$_POST['film'];
        $myJSON = json_encode($t->getTermine($datum,$film));
        print_r( $myJSON);
    }
}