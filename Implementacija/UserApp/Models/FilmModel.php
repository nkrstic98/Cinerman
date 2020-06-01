<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Nikola Krstic 2017/0265
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele Film iz baze
 * 
 * @version 1
 */
class FilmModel extends Model
{
    /**
     * @var $table - naziv tabele u bazi
     */
    protected $table = 'film';
    /**
     * @var $primarykey - primarni kljuc tabele
     */
    
    protected $primaryKey = 'FilmID';
    /**
     * @var $returntype - povratna vrednost upita
     */
    protected $returnType = 'object';

    /**
     * @var $allowedFields - dozvoljena polja za modifikaciju
     */
    protected $allowedFields = [
        'FilmID',
        'Naziv', 
        'OriginalniNaziv', 
        'Zanr', 
        'Trajanje', 
        'GodinaPremijere', 
        'PocetakPrikazivanja', 
        'KrajPrikazivanja', 
        'Reditelj', 
        'Uloge', 
        'Opis', 
        'Slika'
    ];

    /**
     * Pomocna funkcija za dohvatanje filmova
     * 
     * @return Object Array
     */
    public function dohvatiFilmove() {
        return $this->findAll();
    }

    /**
     * Pomocna funkcija za dohvatanje filma sa odredjenim ID-jem
     * 
     * @return ObjectArray
     */
    public function dohvatiFilm($id) {
        return $this->where('FilmID', $id)->findAll();
    }
}