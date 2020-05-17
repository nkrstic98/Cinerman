<?php
namespace App\Controllers;

use App\Models\TerminModel;
use App\Models\MestoModel;
use App\Models\KorisnikModel;


class IzborSedista extends BaseController
{
    protected function prikaz($view,$data)
    {
        //echo view("radnik/header");
        echo view($view,$data);
    }
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
    public function Placanje()
    {
        //trebam da uvedem proveru da li postoje polja
        $m= new MestoModel();
        $k= new KorisnikModel();
        $t= new TerminModel();
        $polja=$_POST['polja'];
        $termin=$_POST['terminID'];
        $korIme=$_POST['korisnickoIme'];
        $data;
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
    
        
    
        // print_r( $k->isLoyality($korIme));
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
        else
        {
            $data["status"]='nijeok';
            $myJSON = json_encode($data);
            print_r( $myJSON);

        }
       // echo "success";
    }

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