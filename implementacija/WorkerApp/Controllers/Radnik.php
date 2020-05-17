<?php namespace App\Controllers;

use App\Models\RadnikModel;
use App\Models\KorisnikInsertModel;
use App\Models\LoyalityInsertModel;

class Radnik extends BaseController {
    
        protected function prikaz($page, $data) {
            $data['controller']='Radnik';   
            echo view("radnik/$page", $data);
        }
    
	public function login($poruka=null){
            $this->prikaz('login',['poruka'=>$poruka]);
	}
        
        public function loginSubmit() {
            if(!$this->validate(['korime'=>'required', 'lozinka'=>'required'])){
                 return $this->prikaz('login', ['errors'=>$this->validator->getErrors()]);
            }
            
            $radnikModel = new RadnikModel();
            $radnik = $radnikModel->find($this->request->getVar('korime'));
            
            if($radnik==null)
                return $this->login('Radnik ne postoji');
            if($radnik->Lozinka!= $this->request->getVar('lozinka'))
                return $this->login ('Pogesna lozinka');
            
            $this->session->set('radnik',$radnik);
            return redirect()->to(site_url("Radnik/navigacija"));     
        }
        
        public function navigacija($poruka=null) {
           $this->prikaz('navigacija',['poruka'=>$poruka]);
        }
        
        public function navigacijaIzbor() {
            if (isset($_POST['registracijaKorisnik'])) {
                $this->prikaz('registracijaKorisnik',[]);
            }
            elseif (isset($_POST['postaniLoyality'])) {
                $this->prikaz('postaniLoyality',[]);
            }
        } 
        
        public function vratiIzadji($poruka=null) {
            if (isset($_POST['vratiSe'])) {
                $this->prikaz('navigacija',['poruka'=>$poruka]);
            }
            elseif (isset($_POST['logout'])) {
                $this->session->destroy();
                $this->login();
            }
        }
        
        public function unesiKorisnika() {
            $korisnik = new KorisnikInsertModel();
            $sql="SELECT MAX(KorisnikID) AS max FROM korisnik";
            $query = $korisnik->db->query($sql);
            $idRow = $query->getRowArray();
            $id = $idRow['max'];
            $id = $id + 1;
            //echo '<pre>'; print_r($id); echo '</pre>';
            
            $data = array(
              "KorisnikID"=>$id,
              "Ime"=>$_POST['name'],
              "Prezime"=>$_POST['lastname'],
              "email"=>$_POST['email'],
              "Lozinka"=>$_POST['password'],
            );
            
            $res=$korisnik->dodajKorisnika($data);
            if($res==false) {
                return $this->navigacija("Dogodila se greska prilikom unosa korisnika!");
            }
            
            if (isset($_POST['loyality'])){
                $loyality = new LoyalityInsertModel();
                $sql="SELECT MAX(BrojKartice) AS max FROM loyalitykorisnik";
                $query = $loyality->db->query($sql);
                $brRow = $query->getRowArray();
                $br = $brRow['max'];
                $br = $br + 1;
                $dataL = array(
                 "KorisnikID"=>$id,
                 "BrojKartice"=>$br
                );
                $res=$loyality->dodajKorisnika($dataL);
            }
            
            if($res==true) 
                return $this->navigacija("Uspesno ste uneli korisnika!");
            else 
                return $this->navigacija("Dogodila se greska prilikom unosa korisnika!");   
        }
        
        public function postaniLoyality() {
            $korisnik = new KorisnikInsertModel();
            $loyality = new LoyalityInsertModel();
            
            $sql="SELECT MAX(BrojKartice) AS max FROM loyalitykorisnik";
            $query = $loyality->db->query($sql);
            $brRow = $query->getRowArray();
            $br = $brRow['max'];
            $br = $br + 1;
            
            $email=$_POST['email'];
            $sql="SELECT KorisnikID AS id FROM korisnik WHERE email='$email'";
            $query = $korisnik->db->query($sql);
            $idRow = $query->getRowArray();
            $id = $idRow['id'];
            
            $data = array(
             "KorisnikID"=>$id,
             "BrojKartice"=>$br
            );
            
            $res=$loyality->dodajKorisnika($data);
            if($res==true) 
                return $this->navigacija("Uspesno ste uneli korisnika!");
            else 
                return $this->navigacija("Dogodila se greska prilikom unosa korisnika!");
        }
        

	//--------------------------------------------------------------------

}