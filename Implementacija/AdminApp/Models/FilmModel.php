<?php namespace App\Models;

use CodeIgniter\Model;

class FilmModel extends Model
{
    protected $table = 'film';
    protected $primaryKey = 'FilmID';

    protected $returnType = 'object';

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

    public function dohvatiFilmove() {
        return $this->findAll();
    }

    public function dohvatiFilm($id) {
        return $this->where('FilmID', $id)->findAll();
    }
}
