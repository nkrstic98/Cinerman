<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Ivan Rakonjac 2017/0656
 * 
 * Klasa koja sluzi za rad sa tabelom termin baze podataka
 * 
 * @version 2
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

    /*
        *dohvatam sve termine za zadati datum
        *joinujem sa filmom da bi dobio podatke za prikaz
        *sortujem po vremenu pocetka filma
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

    /*
        *provaravam da li postoji termin
        *u zadatom datumu => $datum
        *u zadatoj sali => $salaId
        *sa istim vremenom pocetka => $pocetakTermina
        *vraca 0 ako nema termina sa zadatim param
        *vraca -1 ako takav termin vec postoji
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
}
