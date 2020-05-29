<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Nikola Krstic 2017/0265
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele loyalitykorisnik
 * 
 * @version 1
 */
class LoyaltyModel extends Model
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
    protected $allowedFields = [
        'KorisnikID',
        'BrojKartice'
    ];

    /**
     * Pomocna funkcija za dohvatanje svih korisnika
     * 
     * @return Object Array
     */
    public function dohvatiKorisnika($id) {
        return $this->findAll();
    }
}