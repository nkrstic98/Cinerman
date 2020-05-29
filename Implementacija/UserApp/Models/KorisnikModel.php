<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Nikola Krstic 2017/0265
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele korisnik
 * 
 * @version 1
 */
class KorisnikModel extends Model
{
    /**
     * @var $table - naziv tabele u bazi
     */
    protected $table = 'korisnik';
    /**
     * @var $primarykey - primarni kljuc tabele
     */
    protected $primaryKey = 'KorisnikID';

    /**
     * @var $returntype - povratna vrednost upita
     */
    protected $returnType = 'object';

    /**
     * @var $allowedFields - dozvoljena polja za modifikaciju
     */
    protected $allowedFields = [
        'Ime',
        'Prezime',
        'email',
        'Lozinka'
    ];

    public function isLoyality($korisnikID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT * FROM loyalitykorisnik where KorisnikID=$korisnikID");
        $results= $q->getResultArray();
        //print_r(count($results));
         if (count($results)==0)
        {
            return false;
        }
        else
        {
            return true;
        }
        //za sad imam korisnik ID kad se uradi baza stavi po korisnickom imenu
    }

    public function isKorisnik($korisnikID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT * FROM korisnik where KorisnikID=$korisnikID");
        $results= $q->getResultArray();
        //print_r(count($results));
         if (count($results)==0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    /**
     * Pomocna funkcija za dohvatanje svih zaposlenih
     * 
     * @return Object Array
     */
    public function dohvatiKorisnika() {
        return $this->findAll();
    } 
}