<?php namespace App\Models;

use CodeIgniter\Model;

class TerminModel extends Model
{
    protected $table = 'termin';
    protected $primaryKey = 'TerminID';
    protected $returnType = 'object';
    protected $allowedFields = ['FilmID', 'SalaID', 'Datum', 'PocetakTermina','KrajTermina','Cena'];

    function getDatume($film)
    {//funkcija koja uzima sve datume u koji postoje u terminu
     
        //$db=\Config\Database::connect();
        if ($film!=NULL)
        $q=$this->db->query("SELECT DISTINCT Datum from termin where FilmID=\"$film\";");
        else
        $q=$this->db->query("SELECT DISTINCT Datum From termin;");
        $results= $q->getResultArray();
        return $results;
    }

    function getFilmove($datum)
    {
        //$db=\Config\Database::connect();
        if($datum!=NULL)
        $q=$this->db->query("SELECT DISTINCT termin.FilmID, film.Naziv From termin Join film on film.FilmID=termin.FilmID WHERE Datum=\"$datum\";");
        else
        $q=$this->db->query("SELECT DISTINCT termin.FilmID, film.Naziv From termin Join film on film.FilmID=termin.FilmID");
        $results= $q->getResultArray();
        return $results;
    }

    function getTermine($dan, $film)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT PocetakTermina, TerminID From termin WHERE Datum=\"$dan\" and FilmID=\"$film\";");
        $results= $q->getResultArray();
        return $results;
    }

    function getSala($termin)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT sala.BrVrsta, sala.BrKolona FROM termin Join sala on sala.SalaID=termin.SalaID WHERE TerminID=\"$termin\"");
        $results= $q->getResultArray();
        return $results;
    }
    function getSedista($termin)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT BrojSedista, Stanje FROM mesto where TerminID=\"$termin\" ORDER BY BrojSedista ASC");
        $results= $q->getResultArray();
        return $results;
    }
    function getCena($termin)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT Cena FROM termin where TerminID=\"$termin\"");
        $results= $q->getResultArray();
        return $results[0]['Cena'];
    }
}