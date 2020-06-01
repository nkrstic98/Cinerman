<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Lara Vukovic 2017/0319
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele loyalitykorisnik iz baze
 * 
 * @version 1
 */


class LoyalityInsertModel extends Model {
    
        /**
        * @var $table - naziv tabele u bazi
        */
        protected $table      = 'loyalitykorisnik';
        
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
        protected $allowedFields = ['KorisikID', 'BrojKartice'];
        
        /**
        * Funkcija koja dodaje loyality korisnika u bazu podataka
        * @param $data polja koja ce se dodati u tabelu loyalitykorisnik u bazi
        * 
        * @return boolean
        */ 
        public function dodajKorisnika($data) {
            $builder = $this->db->table('loyalitykorisnik');
            return $builder->insert($data);
            //echo '<pre>'; print_r($data); echo '</pre>';
        }
       
}