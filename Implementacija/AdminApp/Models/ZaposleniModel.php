<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Nikola Krstic 2017/0265
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele zaposleni iz baze
 * 
 * @version 1
 */
class ZaposleniModel extends Model
{
    /**
     * @var $table - naziv tabele u bazi
     */
    protected $table = 'zaposleni';
    /**
     * @var $primarykey - primarni kljuc tabele
     */
    protected $primaryKey = 'ZaposleniID';

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
        'KorisnickoIme', 
        'Lozinka', 
        'Privilegije'
    ];

    /**
     * Pomocna funkcija za dohvatanje svih zaposlenih
     * 
     * @return Object Array
     */
    public function dohvatiZaposlene() {
        return $this->findAll();
    }
}
