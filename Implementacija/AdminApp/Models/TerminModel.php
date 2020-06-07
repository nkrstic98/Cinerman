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
        *koji se preklapa sa zeljenim terminom
        *vraca 0 ako nema termina sa zadatim param
        *vraca -1 ako takav termin vec postoji
    */
    public function proveriValidnostTermina($datum,$salaId,$pocetakTermina){
       
        $db      = \Config\Database::connect();
        $builder = $db->table('termin');
        $builder->select('*');
        $builder->where('Datum', $datum);
        $builder->where('SalaID', $salaId);
        $query = $builder->get();
        $results = $query->getResult();

        if($results == null) return 0;

        $fModel = new FilmModel();
        foreach($results as $res) {
            if($res->PocetakTermina >= $pocetakTermina) return -1;
            $film = $fModel->where("FilmID", $res->FilmID)->first();
            if($film == null) return -1;

            $time = explode(":", $res->PocetakTermina);
            $hour = $time[0] * 60 * 60 * 1000;
            $minute = $time[1] * 60 * 1000;
            $second = $time[2] * 1000;
            $startTime = $hour + $minute + $second;
            $endTime = $startTime + $film->Trajanje * 60 * 1000;

            $time2 = explode(":", $pocetakTermina);
            $hour2 = $time2[0] * 60 * 60 * 1000;
            $minute2 = $time2[1] * 60 * 1000;
            $second2 = $time2[2] * 1000;
            $startTime2 = $hour2 + $minute2 + $second2;

            if($endTime >= $startTime2) return -1;
        }

        return 0;
    }
}
