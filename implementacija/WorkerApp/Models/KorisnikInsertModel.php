<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Lara Vukovic 2017/0319
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele korisnik iz baze
 * 
 * @version 1
 */


class KorisnikInsertModel extends Model {
    
        /**
        * @var $table - naziv tabele u bazi
        */
        protected $table      = 'korisnik';
        
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
        protected $allowedFields = ['KorisikID', 'Ime', 'Prezime', 'email', 'Lozinka'];
        
        /**
        * Funkcija koja dodaje korisnika u bazu podataka
        * @param $data polja koja ce se dodati u tabelu korisnik u bazi
        * 
        * @return boolean
        */ 
        public function dodajKorisnika($data) {
            $builder = $this->db->table('korisnik');
            return $builder->insert($data);
            //echo '<pre>'; print_r($data); echo '</pre>';
        }
       
}