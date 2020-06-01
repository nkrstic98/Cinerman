<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Damir Savic 2017/0240
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele mesto iz baze
 * 
 * @version 1
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
    protected $allowedFields = ['FilmID', 'SalaID', 'Datum', 'PocetakTermina','KrajTermina','Cena'];
    /**
     * Funkcija koja dohvata datume u kojima se prikazuje odredjeni film 
     * @param $film id filma za koji se traze datumi 
     * 
     * @return Array datuma
     */    
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
    /**
     * Funkcija koja dohvata filmove koji se prikazuju odredjenog datuma 
     * @param $datum datum za koji se traze filmovi
     * 
     * @return Array filmova
     */    
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
    /**
     * Funkcija koja dohvata u kojim terminima se prikazuje odredjeni film odredjenog datuma  
     * @param $dan datum za koji se traze filmovi
     * @param $film film za koji se traze filmovi
     * 
     * @return Array termin
     */   
    function getTermine($dan, $film)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT PocetakTermina, TerminID From termin WHERE Datum=\"$dan\" and FilmID=\"$film\";");
        $results= $q->getResultArray();
        return $results;
    }
    /**
     * Funkcija koja dohvata podatke o sali za odredjen termini 
     * @param $termin termin koji se prikazuje u sali  
     * 
     * @return Object Array
     */  
    function getSala($termin)
    {
        $q=$this->db->query("SELECT sala.BrVrsta, sala.BrKolona FROM termin Join sala on sala.SalaID=termin.SalaID WHERE TerminID=\"$termin\"");
        $results= $q->getResultArray();
        return $results;
    }
    
    /**
     * Funkcija koja dohvata stanja sedista u sali za odredjen termini 
     * @param $termin terminID koji se prikazuje u sali  
     * 
     * @return Object Array
     */ 
    function getSedista($termin)
    {
        $q=$this->db->query("SELECT BrojSedista, Stanje FROM mesto where TerminID=\"$termin\" ORDER BY BrojSedista ASC");
        $results= $q->getResultArray();
        return $results;
    }
    
    
    /**
     * Funkcija koja dohvata cenu prikazivanja za odredjen termini 
     * @param $termin terminID koji se prikazuje u sali  
     * 
     * @return Object 
     */ 
    function getCena($termin)
    {
        $q=$this->db->query("SELECT Cena FROM termin where TerminID=\"$termin\"");
        $results= $q->getResultArray();
        return $results[0]['Cena'];
    }
}