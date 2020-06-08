<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\LoyaltyModel;

/**
 * Nikola Krstic 2017/0265
 * 
 * Korisnik - klasa za prijavu i registraciju korisnika
 * 
 * @version 1
 */
class Korisnik extends BaseController
{
    /**
     * Funkcija koja se poziva da bi se iscratao odredjeni View
     * 
     * @param $page - View koji treba da se pozove
     * @param $data - niz podataka koji se prosledjuju View-u
     * 
     * @return void
     */
    protected function prikaz($page, $data) {
        $data['controller'] = 'Korisnik';
        if($this->session->get('userName') == null) echo view ("templates/header_login.php");
        else echo view ("templates/header.php");
        echo view("/pages/$page", $data);
        echo view ("templates/footer.php");
    }

    /**
     * Funkcija koja sluzi za prikaz View-a login
     * 
     * @param $poruka - porukaa koja se prikazuje (opcioni parametar)
     * @param $f - bool parametar za pomoc prilikom ispisa greske (opcioni parametar)
     * 
     * @return void
     */
    public function login($poruka = null, $f = null) {
        $this->prikaz('login', ['poruka'=>$poruka, 'f'=>$f]);
    }

    /**
     * Funkcija koja sluzi za prikaz View-a changePass
     * 
     * @param $poruka - poruka koja se prikazuje (opcioni parametar)
     * @param $uspeh - bool parametar za pomoc prilikom ispisa greske (opcioni parametar)
     * 
     * @return void
     */
    public function changePass($poruka = null, $uspeh = null) {
        $this->prikaz('changePass', ['poruka'=>$poruka, 'uspeh'=>$uspeh]);
    }

    /**
     * Funkcija koja sluzi za prikaz View-a recoverPass
     * 
     * @param $poruka - porukaa koja se prikazuje (opcioni parametar)
     * @param $uspeh - bool parametar za pomoc prilikom ispisa greske (opcioni parametar)
     * 
     * @return void
     */
    public function recoverPass($poruka = null, $uspeh = null) {
        $this->prikaz('recoverPass', ['poruka'=>$poruka, 'uspeh'=>$uspeh]);
    }

    /**
     * Funkcija koja sluzi za prikaz View-a register
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * 
     * @return void
     */
    public function register($poruka = null) {
        $this->prikaz('register', ['poruka'=>$poruka]);
    }

    /**
     * Funkcija koja se poziva kada se korisnik odjavi iz aplikacije
     * 
     * 
     * @return void
     */
    public function logout() {
        $this->session->destroy();
        return redirect()->to("http://localhost:8080/index.php/FrontPage");
    }

    //--------------------------------------------------------------------

    /**
     * Login funkcija koja koristi korisnicko ime i lozinku
     * Logovanje korisnika na sistem
     * 
     * @return Response
     */
    public function loginSubmit() {
        $kModel = new KorisnikModel();

        $korisnik = $kModel->where('KorIme', $this->request->getVar('uname'))->first();

        if($korisnik == null) {
            return $this->login("Korisnik ne postoji", 1);
        }

        if($korisnik->Lozinka != $this->request->getVar('pswd')) {
            return $this->login("Pogresna lozinka", 2);
        }
		
		$this->session->set('KorIme', $korisnik->KorIme);
        $this->session->set('userName', $korisnik->email);
        $this->session->set('userPass', $korisnik->Lozinka);
        $this->session->set('userID', $korisnik->KorisnikID);
        $this->session->set('name', $korisnik->Ime);

        $lModel = new LoyaltyModel();

        $lkorisnik = $lModel->where('KorisnikID', $korisnik->KorisnikID)->first();

        if($lkorisnik == null) {
            $this->session->set('userLoyalty', 0);
        }
        else {
            $this->session->set('userLoyalty', 1);
        }
        
        if($this->session->get("terminID") != null) {
            return redirect()->to(site_url('Prodaja'));
        }
        return redirect()->to(site_url('FrontPage/index'));
    }

    /**
     * Promena lozinke korisnika
     * 
     * @return Response
     */
    public function changePassword() {
        $kModel = new KorisnikModel();

        if($this->session->get("ulogovan") == 1) {
            $korisnik = $kModel->where('KorisnikID', $this->session->get("kId"))->first();
        }
        else {
            $korisnik = $kModel->where('email', $this->session->get('userName'))->first();
        }

        if($this->request->getVar('pswd') != $this->request->getVar('pswdC')) {
            if($this->session->get("ulogovan") == 1) return $this->recoverPass("Lozinka i potvrda lozinke nisu iste", null);
            else return $this->changePass("Lozinka i potvrda lozinke nisu iste", null);
        }

        $data = [
            'Ime' => $korisnik->Ime,
            'Prezime' => $korisnik->Prezime,
            'email' => $korisnik->email,
            'Lozinka' => $this->request->getVar('pswd')
        ];

        $kModel->update($korisnik->KorisnikID, $data);

        if($this->session->get("ulogovan") == 1) {
            unset($_SESSION["ulogovan"]);
            unset($_SESSION["kId"]);
            return $this->login("Uspesno ste resetovali lozinku");
        }
        return $this->changePass("Uspesno ste postavili novu lozinku", 1);
    }

    /**
     * Funkcija koja se koristi za resetovanje lozinke
     * Kada korisnik izgubi sifru, resetuje mu se lozinka
     */
    public function recoverPassword() {
        $kModel = new KorisnikModel();

        $korisnik = $kModel->where("Ime", $_POST["name"])->where("Prezime", $_POST["lname"])->where("email", $_POST["email"])->first();

        if($korisnik == null) {
            return $this->recoverPass("Pogresno uneti podaci");
        }

        $this->session->set('ulogovan', 1);
        $this->session->set('kId', $korisnik->KorisnikID);

        return $this->changePass();
    }

    /**
     * Registracija korisnika
     * Upis podataka u bazu
     */
    public function registerSubmit() {
        $novi = new KorisnikModel();

        if(($novi->where('email', $this->request->getVar('uname'))->first()) != null) {
            return $this->register("Postoji nalog sa ovom e-mail adresom");
        }
		
		if(($novi->where('KorIme', $this->request->getvar('user'))->first()) != null) {
            return $this->register("Korisnicko ime je zauzeto");
        }

        if($this->request->getVar('pswd') != $this->request->getVar('pswdC')) {
            return $this->register("Lozinka i potvrda lozinke nisu iste");
        }

        $name = $this->test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            return $this->register("Ime moze sadrzati samo slova");
        }

        $lname = $this->test_input($_POST["lname"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
            return $this->register("Prezime moze sadrzati samo slova");
        }

        $email = $this->test_input($_POST["uname"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->register("Pogresan format e-mail adrese");
        }

        $data = [
            'Ime' => $_POST["name"],
            'Prezime' => $_POST["lname"],
            'email' => $_POST["uname"],
            'Lozinka' => $_POST["pswd"],
			'KorIme' => $_POST["user"]
        ];

        $novi->insert($data);

        $this->loginSubmit();

        return redirect()->to(site_url('FrontPage/index'));
    }

    /**
     * Funkcija koja sluzi za testiranje unetih podataka
     * 
     * @return string
     */
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}