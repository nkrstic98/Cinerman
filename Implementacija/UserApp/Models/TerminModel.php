<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Ivan Rakonjac 2017/0656
 * Damir Savic 2017/0240
 * 
 * Klasa koja sluzi za rad sa tabelom termin baze podataka
 * 
 * @version 27
 */
class TerminModel extends Model
{
    /**
     * @var $table - naziv tabele u bazi
     */
    protected $table = 'termin';
    /**
     * @var $primarykey - primarni kljuc tabele
     */
    protected $primaryKey = 'TerminID';

    /**
     * @var $returntype - povratna vrednost upita
     */
    protected $returnType = 'object';

    /**
     * @var $allowedFields - dozvoljena polja za modifikaciju
     */
    protected $allowedFields = [
        'TerminID',
        'FilmID',
        'SalaID',
        'Datum',
        'PocetakTermina',
        'KrajTermina',
        'Cena'
    ];

    /**
     
    * dohvatam sve termine za zadati datum
    *joinujem sa filmom da bi dobio podatke za prikaz
    *sortujem po vremenu pocetka filma

    * @param $datum - datum za koji se dohvata termin

    * @return ObjectArray
    
    */
    public function dohvatiTerminePoDatumu($datum){
        
        $db      = \Config\Database::connect();
        $builder = $db->table('termin');
        $builder->select('*');
        $builder->where('Datum', $datum);
        $builder->join('film', 'termin.FilmID = film.FilmID');
        $builder->orderBy('termin.PocetakTermina', 'ASC');
        $query = $builder->get();
        $results = $query->getResult();

        return $results;
    }

    /**
     *dohvatam sve termine za zadati datum
     *joinujem sa filmom da bi dobio podatke za prikaz
     *grupisem po filmu
     *sluzi mi da bi prikazao filmove na frontPageu

     * @param $datum - datum za koji se dohvata termin

     * @return ObjectArray
     
     */
    public function dohvatiTerminePoDatumuGroupByFilm($datum){
        
        $db      = \Config\Database::connect();
        $builder = $db->table('termin');
        $builder->select('*');
        $builder->where('Datum', $datum);
        $builder->join('film', 'termin.FilmID = film.FilmID');
        $builder->groupBy("film.Naziv");
        $query = $builder->get();
        $results = $query->getResult();

        return $results;
    }

    /**
     *dohvatam sve termine za zadati film, za zadati datum
     *sluzi mi da bi prikazao termine za filmove na frontPageu

     * @param $filmID - film 
     * @param $datum - datum

     * @return ObjectArray
     
     */
    public function dohvatiSveTermineZaFilm($filmID,$datum){
        
        $db      = \Config\Database::connect();
        $builder = $db->table('termin');
        $builder->select('termin.PocetakTermina,termin.Cena');
        $builder->where('FilmID', $filmID);
        $builder->where('Datum', $datum);
        $query = $builder->get();
        $results = $query->getResult();

        return $results;
    }

    /**
     *provaravam da li postoji termin
     *vraca 0 ako nema termina sa zadatim param
     *vraca -1 ako takav termin vec postoji

     * @param $datum - datum
     * @param $salaId - film 
     * @param $pocetakTermina - pocetak termina

     * @return int
     
     */
    public function proveriValidnostTermina($datum,$salaId,$pocetakTermina){
       
        $db      = \Config\Database::connect();
        $builder = $db->table('termin');
        $builder->select('*');
        $builder->where('Datum', $datum);
        $builder->where('SalaID', $salaId);
        $builder->where('PocetakTermina', $pocetakTermina);
        $query = $builder->get();
        $results = $query->getResult();

        if($results==NULL) return 0;
        else return -1;
    }


    /**
     *dohvata salu za termin

     * @param $termin - termin za koji se dohvata sala

     * @return Object (sala.BrVrsta, sala.BrKolona)
     
     */
    function getSala($termin)
    {
        $q=$this->db->query("SELECT sala.BrVrsta, sala.BrKolona FROM termin Join sala on sala.SalaID=termin.SalaID WHERE TerminID=\"$termin\"");
        $results= $q->getRow();
        return $results;
    }

    /**
     *dohvata broj sedista i stanje za termin

     * @param $termin - termin za koji se dohvata sala

     * @return Object (BrojSedista, Stanje)
     
     */
    function getSedista($termin)
    {
        $q=$this->db->query("SELECT BrojSedista, Stanje FROM mesto where TerminID=\"$termin\" ORDER BY BrojSedista ASC");
        $results= $q->getResultArray();
        return $results;
    }

    /**
     *dohvata cenu za termin

     * @param $termin - termin za koji se dohvata sala

     * @return Object
     
     */
    function getCena($termin)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT Cena FROM termin where TerminID=\"$termin\"");
        $results= $q->getResultArray();
        return $results[0]['Cena'];
    }

    /**
     *dohvata film za termin

     * @param $termin - termin za koji se dohvata sala

     * @return Object
     
     */
    function getFilm($terminID)
    {
        $q=$this->db->query("SELECT * FROM film Join termin on film.FilmID=termin.FilmID WHERE termin.TerminID=\"$terminID\"");
        $results= $q->getRow();
        return $results;
    }
}
