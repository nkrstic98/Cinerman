<?php
namespace App\Controllers;

use App\Models\TerminModel;
use App\Models\MestoModel;
use App\Models\KorisnikModel;

/**
 * Damir Savic 2017/0240
 * 
 * Klasa za kontrolu izbora sedista u bisokopu
 */
class IzborSedista extends BaseController
{
  
  
    /**
     * Funkcija koja se poziva da bi se iscrtao odredjeni view
     * @param $page-view koji treba da se pozove
     * @param $data-niz podataka koji se prosledjuje stranici
     * 
     * @return void 
     */
    protected function prikaz($view,$data)
    {
        echo view($view,$data);
    }
    /**
     * Funkcija koja sluzi za prikaz Viewa index
     * 
     * @return void 
     */
    public function index()
    {

        $t= new TerminModel();
        if ($this->request->getVar('termin')!=NULL)
        {
            $brSed=$t->getSala($this->request->getVar('termin'));
            $stSed=$t->getSedista($this->request->getVar('termin'));
            $data['termin']=$this->request->getVar('termin');
            $data['brSed']=$brSed;
            $data['stSed']=$stSed;
            $this->prikaz('radnik/PrikazSale',$data);
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
        $data;

        if ($m->slobodnaMesta($polja,$termin)==false)
        {
            $data["status"]='nijeok';
            $myJSON = json_encode($data);
            print_r( $myJSON);
            return;
        }        


        if ($korIme=="")
        {
            foreach($polja as $polje)
                $m->dodajMesto($termin,$polje,1);
            $cena=$t->getCena($termin)*count($polja);
            $data["status"]='ok';
            $data["cena"]=$cena;
            $myJSON = json_encode($data);
            print_r( $myJSON);
        return;
        }
    
        
        $korID=$k->getKorID($_POST['korisnickoIme']);
        foreach($polja as $polje)
            $m->dodajMesto($termin,$polje,1);
        $cena=$t->getCena($termin)*count($polja);
        if ($k->isLoyality($korID)==true)
        {
            $cena=$cena*90/100;
        }
        $data["status"]='ok';
        $data["cena"]=$cena;
        $myJSON = json_encode($data);
        print_r( $myJSON);
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
       // print_r($_POST);
        $polja=$_POST['polja'];
        $termin=$_POST['terminID'];
        $korIme=$_POST['korisnickoIme'];
        
        $data;
        
        if ($m->slobodnaMesta($polja,$termin)==false)
        {
            $data["status"]='nijeok';
            $myJSON = json_encode($data);
            print_r( $myJSON);
            return;
        }   

        if ($k->isKorisnik($korIme)==true)
        {
            $korID=$k->getKorID($_POST['korisnickoIme']);
            foreach($polja as $polje)
            {
            $m->dodajMesto($termin,$polje,2);
            $m->dodajRezervaciju($polje, $korID,$termin);
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