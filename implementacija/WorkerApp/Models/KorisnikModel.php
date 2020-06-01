<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Damir Savic 2017/0240
 */
class KorisnikModel extends Model
{
    /**
     * @var $table - naziv tabele u bazi
     */
    protected $table = 'loyalitykorisnik';
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
    protected $allowedFields = ['KorisnikID', 'BrojKartice'];

    /**
     * Funkcija koja izvrsava poroveru da li korisnik ima pravo na popust 
     * @param $korisnikID id korisnika za kog se zahteva provera
     *  
     * 
     * @return true/false 
     */
    public function isLoyality($korisnikID)
    {
        $q=$this->db->query("SELECT * FROM loyalitykorisnik where KorisnikID=$korisnikID");
        $results= $q->getResultArray();
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
     * Funkcija koja izvrsava poroveru da li korisnik postoji u bazi
     * @param $korisnikID id korisnika za kog se zahteva provera
     * 
     * @return true/false 
     */
    public function isKorisnik($korIme)
    {
        $q=$this->db->query("SELECT * FROM korisnik where KorIme='$korIme'");
        $results= $q->getResultArray();
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
     * Funkcija koja dohvati korisnikID na osnovu korIme
     * @param $korIme ime korisnika 
     * 
     * @return true/false 
     */
    public function getKorID($korIme)
    {
        $q=$this->db->query("SELECT KorisnikID FROM korisnik where KorIme='$korIme'");
        $results=$q->getRowArray();
        return $results['KorisnikID'];
    }
}