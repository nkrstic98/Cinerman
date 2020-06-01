<?php
namespace App\Controllers;

use App\Models\TerminModel;
use App\Models\MestoModel;
use App\Models\KorisnikModel;

class Prodaja extends BaseController
{
    /**
     * Funkcija koja se poziva da bi se iscrtao odredjeni view
     * @param $page-view koji treba da se pozove
     * @param $data-niz podataka koji se prosledjuje stranici
     * 
     * @return void 
     */
    protected function prikaz($page,$data)
    {
        echo view($page,$data);
    }
    /**
     * Funkcija koja sluzi za prikaz Viewa index
     * 
     * @return void 
     */
    public function index()
    {
        if (isset($_POST['terminID']))
        {
            $tID=$_POST['terminID'];
            //print_r($_SESSION); 
            $data['korID']="";
           
            if (isset($_SESSION['userID']))
            {
                $data['korID']=$_SESSION['userID'];
                echo view("templates/header");
            }
            else
            {
                echo view("templates/header_login");
            }
            //print_r($data['korID']);
            $t=new TerminModel();
            $data['termin']=$tID;
            $data['sala']=$t->getSala($tID);
            $data['sedista']=$t->getSedista($tID);
            $data['film']=$t->getFilm($tID);
            $data['cena']=$t->getCena($tID);
            $this->prikaz('ProdajaPrikaz',$data); 
            
            echo view("templates/footer");
            $this->session->set('terminID', $tID);
            //print_r($_SESSION);

        }
        else
        {
            if ($this->session->get('terminID')!=NULL)
            {
                $tID=$this->session->get('terminID');
            //print_r($_SESSION); 
            $data['korID']="";
           
            if (isset($_SESSION['userID']))
            {
                $data['korID']=$_SESSION['userID'];
                echo view("templates/header");
            }
            else
            {
                echo view("templates/header_login");
            }   

            $t=new TerminModel();
            $data['termin']=$tID;
            $data['sala']=$t->getSala($tID);
            $data['sedista']=$t->getSedista($tID);
            $data['film']=$t->getFilm($tID);
            $data['cena']=$t->getCena($tID);
            $this->prikaz('ProdajaPrikaz',$data);
            
            echo view("templates/footer");
            }
            else
            echo 'error';
        }
    }
    /**
     * Funkcija koja izvrsava poroveru i kupovinu izabranih polja u izabranom terminu
     * 
     * @return void 
     */
    public function Placanje()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $t= new TerminModel();
        $polja=$_POST['polja'];
        $termin=$_POST['terminID'];
        $korIme=$_POST['korisnickoIme'];
        //ovo sve sredi kad bude sesija proverila da li je korisnik



        if ($k->isLoyality($korIme)==true)
        {
        foreach($polja as $polje)
            $m->dodajMesto($termin,$polje,1);
        $cena=$t->getCena($termin)*count($polja);
        $cena=$cena*90/100;
        $data["status"]='ok';
        $data["cena"]=$cena;
        $myJSON = json_encode($data);
        print_r( $myJSON);
        }
        elseif ($k->isKorisnik($korIme)==true)
        {
            foreach($polja as $polje)
            $m->dodajMesto($termin,$polje,1);
            $cena=$t->getCena($termin)*count($polja);
            $data["status"]='ok';
            $data["cena"]=$cena;
            $myJSON = json_encode($data);
            print_r( $myJSON);
        }
        else
        {
            $data["status"]='nijeok';
            $myJSON = json_encode($data);
            print_r( $myJSON);

        }
    }
     /**
     * Funkcija koja izvrsava poroveru i rezervaciju izabranih polja u izabranom terminu
     * 
     * @return void 
     */
    public function Rezervisi()
    {
        $m= new MestoModel();
        $k= new KorisnikModel();
        $t= new TerminModel();
        $polja=$_POST['polja'];
        $termin=$_POST['terminID'];
        $korIme=$_POST['korisnickoIme'];
        $data;

       
        if ($k->isKorisnik($korIme)==true)
        {
            foreach($polja as $polje)
            {
            $m->dodajMesto($termin,$polje,2);
            $m->dodajRezervaciju($polje, $korIme);
            }
            $data["status"]='ok';
            $myJSON = json_encode($data);
            print_r( $myJSON);
        }
        else
        {
            $data["status"]='nijeok';
            $myJSON = json_encode($data);
            print_r( $myJSON);
        }
    }

    
}