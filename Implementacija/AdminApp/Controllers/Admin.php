<?php namespace App\Controllers;

use App\Models\ZaposleniModel;
use App\Models\FilmModel;
use App\Models\TerminModel;

/**
 * Nikola Krstic 2017/0265
 * Ivan Rakonjac 2017/0656
 * 
 * Admin - klasa za rad ulogovanog korisnika
 * 
 * @version 3
 */
class Admin extends BaseController
{
    /**
     * @var string $date Datum za prikazivanje stanja sala na stranici Pravljenje repertoara
     */
    public $date;

    /**
     * Funkcija koja se poziva da bi se iscratao odredjeni View
     * 
     * @param $page - View koji treba da se pozove
     * @param $data - niz podataka koji se prosledjuju View-u
     * 
     * @return void
     */
    protected function prikaz($page, $data) {
        $data['controller'] = 'Admin';
        if(strcmp($page, 'index') != 0) echo view ("templates/header.php");
        echo view("/pages/$page", $data);
        echo view ("templates/footer.php");
    }

    /**
     * Funkcija koja sluzi za prikaz View-a welcome
     * 
     * @return void
     */
    public function welcome() {
        $this->prikaz('welcome', []);
    }

    /**
     * Funkcija koja sluzi za prikaz View-a register
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * 
     * @return void
     */
    public function register($poruka = null, $uspeh = null) {
        $this->prikaz('register', ['poruka'=>$poruka, 'uspeh'=>$uspeh]);
    }

     /**
     * Funkcija koja sluzi za prikaz View-a delete
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * 
     * @return void
     */
    public function delete($poruka = null, $uspeh = null) {
        $this->prikaz('delete', ['poruka'=>$poruka, 'uspeh'=>$uspeh]);
    }

     /**
     * Funkcija koja sluzi za prikaz View-a addMovie
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * 
     * @return void
     */
    public function addMovie($poruka = null, $uspeh = null) {
        $this->prikaz('addMovie', ['poruka'=>$poruka, 'uspeh'=>$uspeh]);
    }

     /**
     * Funkcija koja sluzi za prikaz View-a makeSchedule
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * @param $termini - niz termina za odredjeni datum
     * 
     * @return void
     */
    public function makeSchedule($poruka = null,$termini=null) {
        $_POST['SalaID'] = 0;
        $this->prikaz('makeSchedule', ['poruka'=>$poruka,'termini'=>$termini]);
    }

     /**
     * Funkcija koja se poziva kada korisnik zeli da se izloguje
     * 
     * @return Response
     */
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    //--------------------------------------------------------------------

    /**
     * Funkcija koja se poziva kada korisnik submituje podatke novog korisnika
     * 
     * @return Response
     */
    public function registerSubmit() {
        $novi = new ZaposleniModel();

        if(($novi->where('KorisnickoIme', $this->request->getVar('uname'))->first()) != null) {
            return $this->register("Korisnicko ime vec postoji");
        }

        if(isset($_POST["priv"])) {
            $priv = 1;
        }
        else {
            $priv = 0;
        }

        $data = [
            'Ime' => $_POST["name"],
            'Prezime' => $_POST["lname"],
            'KorisnickoIme' => $_POST["uname"],
            'Lozinka' => $_POST["pswd"],
            'Privilegije' => $priv
        ];

        $novi->insert($data);

        return $this->register(null, 1);
    }

    /**
     * Funkcija koja se poziva kada admin brise korisnika iz sistema
     * 
     * @return Response
     */
    public function deleteSubmit() {
        if($this->request->getVar('zaposleni') == -1) {
            return $this->delete("Odaberite zaposlenog pre pokusaja brisanja");
        }

        $zModel = new ZaposleniModel();

        $zaposleni = $zModel->where('ZaposleniID', $this->request->getVar('zaposleni'))->first();

        if($zaposleni->KorisnickoIme == $this->session->get('adminUser')) {
            return $this->delete("Ne mozete obrisati sebe iz baze");
        }

        $zModel->where('ZaposleniID', $zaposleni->ZaposleniID)->delete();

        return $this->delete(null, 1);
    }

    /**
     * Funkcija koja se poziva kada korisnik dodaje novi film u sistem
     * 
     * @return Response
     */
    public function movieSubmit() {
        $fModel = new FilmModel();

        if(($fModel->where('Naziv', $this->request->getVar('naziv'))->findAll()) != null) {
            return $this->addMovie("Postoji film sa unetim imenom");
        }

        if($this->request->getVar('traj') <= 0) {
            return $this->addMovie("Trajanje filma mora biti vece od 0");
        }

        if($this->request->getVar('poc') > $this->request->getVar('kraj')) {
            return $this->addMovie("Pogresno uneseno vreme pocetka i/ili kraja prikazivanja");
        }

        $putanjaDoSLike=$this->uploadImage();

        $data = [
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
            'Slika' => $putanjaDoSLike
        ];

        $fModel->insert($data);

        return $this->addMovie(null, 1);
    }

    /**
     * Funkcija koja se poziva kada korisnik pravi novi termin filma
     * 
     * @return Response
     */
    public function scheduleSubmit() {
        if($this->request->getVar('mov') == -1) {
            return $this->makeSchedule("Odaberite film koji zelite da stavite u repertoar");
        }

        if($this->request->getVar('sala') == -1) {
            return $this->makeSchedule("Izaberite salu u kojoj zelite da prikazujete film");
        }

        $time = $_POST['sat'] . ":" . $_POST['min'];

        $time = strtotime($time);
        $start_time = date("H:i:s", $time);

        $filmM = new FilmModel();
        $film = $filmM->dohvatiFilm($_POST['mov']);

        $trajanje = $film[0]->Trajanje;

        $plus = "+" . $trajanje . " minutes";

        $time = strtotime("$plus", $time);
        $end_time = date("H:i:s", $time);

        $time = strtotime("+10 minutes", $time);
        
        $cena = $this->formirajCenu($start_time, $end_time, $trajanje);

        $data = [
            'FilmID' => $_POST['mov'],
            'SalaID' => $_POST['sala'],
            'Datum' => $_POST['datum'],
            'PocetakTermina' => $start_time,
            'KrajTermina' => $end_time,
            'Cena' => $cena
        ];

        $terminModel = new TerminModel();

        //ovo sluzi da bi prikazao tab sale u koji je film dodat
        $_POST['SalaID']=$data['SalaID'];

        $this->date = $_POST['datum'];

        if($terminModel->proveriValidnostTermina($data['Datum'],$data['SalaID'],$data['PocetakTermina'])==0){
            $terminModel->insert($data);
            $this->prikazMakeSchedule("Termin je uspesno dodat.", 1);
        }else{
            $this->prikazMakeSchedule("Termin je zauzet!", null);
        }
    }

    /**
     * fja koja treba na osnovu datum da dovuce postojece termine
     * koristim je da bi cim korisnik unese datum mogao da vidi 
     * do sada napravljeni raspored po salama
     * 
     * @return Response
     */
    public function dovuciTermineZaDatum(){
        $this->date = $_POST['datum'];
        $_POST['SalaID'] = 0;
        $terminModel = new TerminModel();
        $datum=$_POST['datum'];
        $podaci['termini']=$terminModel->dohvatiTerminePoDatumu($datum);
        return $this->prikaz('makeSchedule', ['poruka'=>null,'termini'=>$podaci['termini'],'datum'=>$_POST['datum'], 'uspeh'=>null]);
    }

    /**
     * Funkcija koja sluzi za brisanje odredjenjog termina
     * 
     * @return void
     */
    public function deleteTermin(){
        $idTermina=$_POST['deleteTermin'];
        $terminModel = new TerminModel();

        $termin=$terminModel->find($idTermina);
        $_POST['SalaID'] = $termin->SalaID;

        //brisem termin
        $terminModel->where('TerminID', $idTermina)->delete();

        $this->prikazMakeSchedule("Termin je uspesno obrisan.", 1);
    }

    /**
     * Funkcija koja sluzi za ispis View-a repertoara
     * 
     * @return void
     */
    protected function prikazMakeSchedule($poruka=null, $uspeh)
    {
        $terminModel = new TerminModel();

        //dohvata termine za datum
        $data['termini']=$terminModel->dohvatiTerminePoDatumu($this->date);
        $data['poruka']=$poruka;
        $data['SalaID']=$_POST['SalaID'];
        $data['datum']=$this->date;
        $data['uspeh']=$uspeh;

        $data['controller'] = 'Admin';
        echo view ("templates/header.php");
        echo view("/pages/makeSchedule", $data);
        echo view ("templates/footer.php");
    }

    //------------------------------------------------------------------------------
    //Pomocne funkcije

    /**
     * Pomocna funkcija za iscrtavanje HTML select komponente
     * Sluzi za prikaz svih zaposlenih
     * Koristi se kada se zaposleni brise iz baze
     */
    public static function listaZaposlenih() {

        echo "<select name='zaposleni' class='custom-select mr-sm-2'>";
        echo "<option value='-1'>Izaberite zaposlenog kog zelite da izbrisete</option>";
                                    
        $zModel = new ZaposleniModel();
        $zaposleni = $zModel->dohvatiZaposlene();
        foreach($zaposleni as $zap) {
            echo "<option value='{$zap->ZaposleniID}'>{$zap->Ime} {$zap->Prezime} - {$zap->KorisnickoIme}</option>";
        }
        echo "</select>";
    }

    /**
     * Funkcija koja ispisuje listu scih filmova na HTML stranici
     */
    public static function listaFilmova() {

        echo "<select name='mov' id='movies' class='custom-select mr-sm-2' value='<?= set_value('mov')?>'>";
        echo "<option value='-1'>Izaberite film</option>";
                                    
        $fModel = new FilmModel();
        $filmovi = $fModel->dohvatiFilmove();
        foreach($filmovi as $film) {
            echo "<option value='{$film->FilmID}'>{$film->Naziv} - {$film->Trajanje}</option>";
        }
        echo "</select>";
    }

    /**
     * Kada se novi film dodaje na repertoar, formira mu se cena
     * Pomocna funkcija za formiranje cene filma
     * 
     * @param $start_time - vreme pocetka filma
     * @param $end_time - vreme zavrsetka filma
     * 
     * @return int
     */
    public function formirajCenu($start_time, $end_time, $trajanje) {
        $dt1 = strtotime($_POST['datum']);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);

        if($dt3 == "saturday" || $dt3 == "sunday") {
            if(strtotime($start_time) >= strtotime("11:00:00") && strtotime($start_time) < strtotime("12:00:00")) {
                return 270;
            }
        }

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

        if($dt3 == "saturday" || $dt3 == "sunday") {
            $cena += 50;
        }
        else if ($dt3 == "tuesday" && strtotime($start_time) > strtotime("17:00:00")) {
            $cena -= 50;
        }
        else if($dt3 == "tuesday" && strtotime($start_time) < strtotime("17:00:00")) {
            $cena -= 30;
        }

        return $cena;
    }

    /**
     * Funkcija za upload slike
     * 
     * @return string
     */
    public function uploadImage(){
        $file = $this->request->getFile('slika');

        if($file->getSize()>0){
            $file->move('C:\wamp64\www\prodaja\public\public\upload',$file->getName());
        }

        return './public/upload/'.$file->getName();
    }

    //---------------------------------------------------------------------------
    /**
     * Skript funkcije koje se aktiviraju kada se korisnik uloguje na sistem
     * Sluze za odrzavanje baze
     */
}