<?php namespace App\Controllers;

use App\Models\ZaposleniModel;
use App\Models\FilmModel;
use App\Models\TerminModel;
use CodeIgniter\I18n\Time;

class FrontPage extends BaseController{
    public function index(){

        $terminModel = new TerminModel();
        $filmoviZaSedamDana = array();
        $terminiZaFilmove = array();

        for($i=0;$i<7;$i++){
            $myTime = new Time('+'.$i.'day','Europe/Belgrade');
            $danasnjiDatum=substr($myTime,0,10); 
            $filmoviZaSedamDana[$i] = $terminModel->dohvatiTerminePoDatumuGroupByFilm($danasnjiDatum);
           
            $brojacFilmova=0;
            $terminiZaFilmove[$i]= array();
           
            foreach($filmoviZaSedamDana[$i] as $film){
                $terminiZaFilmove[$i][$brojacFilmova]=$terminModel->dohvatiSveTermineZaFilm($film->FilmID,$danasnjiDatum);
                $brojacFilmova=$brojacFilmova + 1;
            }
        }
        $_POST['filmoviZaSedamDana'] = $filmoviZaSedamDana;
        $_POST['terminiZaFilmove'] = $terminiZaFilmove;

        
        echo view('pages/frontPage');
        echo view("templates/footer_front");
    }
}