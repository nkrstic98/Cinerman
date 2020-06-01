<?php namespace App\Controllers;

use App\Models\RadnikModel;
use App\Models\KorisnikInsertModel;
use App\Models\LoyalityInsertModel;

/**
 * Lara Vukovic 2017/0319
 * 
 * Klasa za upravljanje radnikom
 */
class Radnik extends BaseController {
    
    
        /**
        * Funkcija koja se poziva da bi se iscrtao odredjeni view
        * @param $page-view koji treba da se pozove
        * @param $data-niz podataka koji se prosledjuje stranici
        * 
        * @return void 
        */
        protected function prikaz($page, $data) {
            $data['controller']='Radnik';   
            echo view("radnik/$page", $data);
        }
    
        /**
        * Login  funkcija koja prikazuje login stranu
        * @param $poruka - poruka koja se ispisuje ako je doslo do greske prilikom login-a
        * 
        * @return void 
        */
	public function login($poruka=null){
            $this->prikaz('login',['poruka'=>$poruka]);
	}
        
        /**
        * Login  funkcija koja omogucava login pomocu korisnickog imena i lozinke
        * 
        * @return void 
        */
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
        
        /**
        * Funkcija koja prikazuje stranu za izbor radnje radnika; na ovoj strani se prikazuju i greske prilikom tih radnji
        * @param $poruka - poruka koja se ispisuje ako je doslo do greske prilikom radnji
        * 
        * @return void 
        */
        public function navigacija($poruka=null) {
           $this->prikaz('navigacija',['poruka'=>$poruka]);
        }
        
        
        /**
        * Funkcija koja radnika prebacuje na stranice registracijaKorisnik i postanyLoyality u zavisnosti od izbora
        * 
        * @return void 
        */
        public function navigacijaIzbor() {
            if (isset($_POST['registracijaKorisnik'])) {
                $this->prikaz('registracijaKorisnik',[]);
            }
            elseif (isset($_POST['postaniLoyality'])) {
                $this->prikaz('postaniLoyality',[]);
            }
        } 
        
        /**
        * Funkcija koja vrsi logout ili vracanje na stranu navigacija
        * @param $poruka - poruka koja se ispisuje ako je doslo do neke greske
        * 
        * @return void 
        */
        public function vratiIzadji($poruka=null) {
            if (isset($_POST['vratiSe'])) {
                $this->prikaz('navigacija',['poruka'=>$poruka]);
            }
            elseif (isset($_POST['logout'])) {
                $this->session->destroy();
                $this->login();
            }
        }
        
        /**
        * Funkcija koja unosi obicnog ili loyality korisnika u bazu
        * i prosledjuje nas na stranicu navigacija uz odredjenu poruku uspeha
        * @return void 
        */
        public function unesiKorisnika() {
            $korisnik = new KorisnikInsertModel();
            
            //echo '<pre>'; print_r($id); echo '</pre>';
            
            $data = array(
              "Ime"=>$_POST['name'],
              "Prezime"=>$_POST['lastname'],
              "email"=>$_POST['email'],
              "Lozinka"=>$_POST['password'],
              "KorIme"=>$_POST['username'],
            );
            $korIme = $_POST['username'];
            $sql="SELECT KorisnikID as id FROM korisnik WHERE KorIme='$korIme'";
            $query = $korisnik->db->query($sql);
            $idRow = $query->getRowArray();
            if(empty($idRow)) {
            
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
                
                $sql="SELECT KorisnikID AS id FROM korisnik WHERE KorIme='$korIme'";
                $query = $korisnik->db->query($sql);
                $idRow = $query->getRowArray();
                $id = $idRow['id'];
                
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
            
            } else $this->navigacija("Korisnicko ime vec postoji!");
                
        }
        
        /**
        * Funkcija koja obicnog korisnika u bazi postavlja i kao loyality korisnika
        * i prosledjuje nas na stranicu navigacija uz odredjenu poruku uspeha
        * @return void 
        */
        public function postaniLoyality() {
            $korisnik = new KorisnikInsertModel();
            $loyality = new LoyalityInsertModel();
            
            $sql="SELECT MAX(BrojKartice) AS max FROM loyalitykorisnik";
            $query = $loyality->db->query($sql);
            $brRow = $query->getRowArray();
            $br = $brRow['max'];
            $br = $br + 1;
            
            $username=$_POST['username'];
            $sql="SELECT KorisnikID AS id FROM korisnik WHERE KorIme='$username'";
            $query = $korisnik->db->query($sql);
            $idRow = $query->getRowArray();
            if(empty($idRow))
                return $this->navigacija("Korisnik ne postoji u sistemu!");
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