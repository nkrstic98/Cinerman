<?php namespace App\Models;

use CodeIgniter\Model;

class TerminModel extends Model
{
    protected $table = 'termin';
    protected $primaryKey = 'TerminID';

    protected $returnType = 'object';

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
