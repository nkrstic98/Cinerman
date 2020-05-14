<?php namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\FilmModel;
use App\Models\TerminModel;

class Admin extends BaseController
{
    protected function prikaz($page, $data)
    {
        $data['controller'] = 'Admin';
        echo view("/pages/$page", $data);
    }
   
    public function index($poruka = null) {
        $this->prikaz('index', ['poruka'=>$poruka]);
    }

    public function welcome() {
        return view("pages/welcome.php");
    }

    public function register($poruka = null) {
        $this->prikaz('register', ['poruka'=>$poruka]);
    }

    public function delete($poruka = null) {
        $this->prikaz('delete', ['poruka'=>$poruka]);
    }

    public function addMovie($poruka = null) {
        $this->prikaz('addMovie', ['poruka'=>$poruka]);
    }

    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    public function makeSchedule($poruka = null) {
        $this->prikaz('makeSchedule', ['poruka'=>$poruka]);
    }
    
    public function loginSubmit() {
        if(!$this->validate(['KorisnickoIme'=>'required', 'Lozinka'=>'required'])) {
            return $this->prikaz('index', ['errors'=>$this->validator->getErrors()]);
        }
        $adminModel = new AdminModel();
        $admin = $adminModel->where('KorisnickoIme', $_POST['KorisnickoIme'])->findAll();
        if($admin == null) {
            return $this->index("Korisnik ne postoji");
        }
        if($admin[0]->Lozinka != $this->request->getVar('Lozinka')) {
            return $this->index("Pogresna lozinka");
        }
        
        if($admin[0]->Privilegije == 0) {
            return $this->index("Ne mozete se ulogovati, nemate privilegije admina");
        }
        
        $this->session->set('adminUser', $admin[0]->KorisnickoIme);
        $this->session->set('adminPass', $admin[0]->Lozinka);
        return redirect()->to(site_url('Admin/welcome'));
    }

    public function registerSubmit() {
        if(!$this->validate(['ime'=>'required', 'prez'=>'required', 'user'=>'required', 'pass'=>'required'])) {
            return $this->prikaz('register', ['errors'=>$this->validator->getErrors()]);
        }

        $noviKorisnik = new AdminModel();
        
        if(($noviKorisnik->where('KorisnickoIme', $_POST['user'])->findAll()) != null) {
            return $this->register("U bazi postoji korisnik sa unetim korisnickim imenom");
        }

        if(isset($_POST["priv"])) {
            $priv = 1;
        }
        else {
            $priv = 0;
        }


        $data = [
            'Ime' => $_POST["ime"],
            'Prezime' => $_POST["prez"],
            'KorisnickoIme' => $_POST["user"],
            'Lozinka' => $_POST["pass"],
            'Privilegije' => $priv
        ];

        $noviKorisnik->insert($data);

        return redirect()->to(site_url("Admin/register"));
    }

    public function deleteSubmit() {
        if(!$this->validate(['user'=>'required'])) {
            return $this->prikaz('delete', ['errors'=>$this->validator->getErrors()]);
        }
        $adminModel = new AdminModel();
        $korisnik = $adminModel->where('KorisnickoIme', $_POST['user'])->findAll();
        if($korisnik == null) {
            return $this->delete("Korisnik koga pokusavate da obrisete, ne postoji");
        }

        if($_POST['user'] == $this->session->get('adminUser')) {
            return $this->delete("Ne mozete obrisati sebe iz baze");
        }

        $adminModel->where('ZaposleniID', $korisnik[0]->ZaposleniID)->delete();

        return redirect()->to(site_url('Admin/delete'));
    }

    public function addMovieSubmit() {
        if(!$this->validate([
            'naziv' => 'required',
            'zanr' => 'required',
            'traj' => 'required',
            'prem' => 'required',
            'poc' => 'required',
            'kraj' => 'required',
            'red' => 'required',
            'uloge' => 'required',
            'slika' => 'required',
        ])) {
            return $this->prikaz('addMovie', ['errors'=>$this->validator->getErrors()]);
        }

        $film = new FilmModel();

        if(($film->where('Naziv', $_POST['naziv'])->findAll()) != null) {
            return $this->addMovie("U bazi postoji film sa unetim imenom");
        }
        
        if($_POST['traj'] <= 0) {
            return $this->addMovie("Trajanje filma mora biti vece od 0");
        }

        if($_POST['poc'] > $_POST['kraj']) {
            return $this->addMovie("Pogresno uneseno vreme pocetka i/ili trajanja");
        }

        $slika = '<img src="' . $_POST['slika'] . '" alt="' . $_POST['naziv'] . '">'; 

        $maxId = $film->orderBy('FilmID', 'desc')->first();
        $id = $maxId->FilmID;

        $data = [
            'FilmID' => $id + 1,
            'Naziv' => $_POST['naziv'],
            'OriginalniNaziv' => $_POST['onaziv'],
            'Zanr' => $_POST['zanr'],
            'Trajanje' => $_POST['traj'],
            'GodinaPremijere' => $_POST['prem'],
            'PocetakPrikazivanja' => $_POST['poc'],
            'KrajPrikazivanja' => $_POST['kraj'],
            'Reditelj' => $_POST['red'],
            'Uloge' => $_POST['uloge'],
            'Opis' => $_POST['opis'],
            'Slika' => $slika
        ];

        $film->insert($data);

        return redirect()->to(site_url("Admin/addMovie"));
    }

    public function insertMovieSubmit() {
        if(!$this->validate([
            'datum' => 'required',
            'vreme' => 'required',
            'mov' => 'required',
            'sala' => 'required',
        ])) {
            return $this->prikaz('makeSchedule', ['errors'=>$this->validator->getErrors()]);
        }

        $time = $_POST['vreme'];

        $time = strtotime($time);
        $start_time = date("H:i:s", $time);

        $filmM = new FilmModel();
        $film = $filmM->dohvatiFilm($_POST['mov']);

        $trajanje = $film[0]->Trajanje;

        $plus = "+" . $trajanje . " minutes";

        $time = strtotime("$plus", $time);
        $end_time = date("H:i:s", $time);

        $time = strtotime("+10 minutes", $time);

        $terminModel = new TerminModel();

        $maxId = $terminModel->orderBy('TerminID', 'desc')->findAll();

        $id = $maxId[0]->TerminID;

        $cena = 0;

        if(strtotime($start_time) < strtotime("17:00:00")) {
            $cena = 300;
        }
        else {
            $cena = 350;
        }
        
        if($trajanje >= 120 && $trajanje < 180) {
            $cena += 30;
        }
        else if($trajanje >= 180) {
            $cena += 50;
        }

        $dt1 = strtotime($_POST['datum']);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);

        if($dt3 == "saturday" || $dt3 == "sunday") {
            $cena += 50;
        }
        else if ($dt3 == "tuesday" && strtotime($start_time) > strtotime("17:00:00")) {
            $cena -= 50;
        }
        else if($dt3 == "tuesday" && strtotime($start_time) < strtotime("17:00:00")) {
            $cena -= 30;
        }

        $data = [
            'TerminID' => $id + 1,
            'FilmID' => $_POST['mov'],
            'SalaID' => $_POST['sala'],
            'Datum' => $_POST['datum'],
            'PocetakTermina' => $start_time,
            'KrajTermina' => $end_time,
            'Cena' => $cena
        ];

        $terminModel->insert($data);

        return redirect()->to(site_url("Admin/makeSchedule"));
    }
	//--------------------------------------------------------------------
}