<?php namespace App\Controllers;

use App\Models\ZaposleniModel;
use App\Models\FilmModel;
use App\Models\TerminModel;

/**
 * Nikola Krstic 2017/0265
 * 
 * GostController - klasa za logovanje registrovanog korisnika
 * 
 * @version 1
 */
class Gost extends BaseController
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
        $data['controller'] = 'Gost';
        if(strcmp($page, 'index') != 0) echo view ("templates/header.php");
        echo view("/pages/$page", $data);
        echo view ("templates/footer.php");
    }

    /**
     * Funkcija koja sluzi za prikaz View-a index
     * 
     * @param $poruka - poruka greske koja se prikazuje (opcioni parametar)
     * @param $f - bool parametar za pomoc prilikom ispisa greske (opcioni parametar)
     * 
     * @return void
     */
    public function index($poruka = null, $f = null) {
        $this->prikaz('index', ['poruka'=>$poruka, 'f'=>$f]);
    }

    //--------------------------------------------------------------------

    /**
     * Login funkcija koja koristi korisnicko ime i lozinku
     * 
     * @return Response
     */
    public function loginSubmit() {
        $zModel = new ZaposleniModel();

        $zaposleni = $zModel->where('KorisnickoIme', $this->request->getVar('uname'))->first();

        if($zaposleni == null) {
            return $this->index("Korisnik ne postoji", 1);
        }

        if($zaposleni->Lozinka != $this->request->getVar('pswd')) {
            return $this->index("Pogresna lozinka", 2);
        }

        if($zaposleni->Privilegije == 0) {
            return $this->index("Ne mozete se ulogovati, nemate privilegija admina");
        }

        $this->session->set('adminUser', $zaposleni->KorisnickoIme);
        $this->session->set('adminPass', $zaposleni->Lozinka);

        $fModel = new FilmModel();

        $filmovi = $fModel->dohvatiFilmove();

        foreach ($filmovi as $film) {
            $date = $film->KrajPrikazivanja;
            $today = date("Y-m-d");
            if($date < $today) {
                $fModel->where("FilmID", $film->FilmID)->delete();
            }
        }

        return redirect()->to(site_url('Admin/welcome'));
    }

    public function deleteMovies() {
        
    }
}