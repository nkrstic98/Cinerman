<?php namespace App\Models;

use CodeIgniter\Model;

class LoyalityInsertModel extends Model {
    
        protected $table      = 'loyalitykorisnik';
        protected $primaryKey = 'KorisnikID';
        protected $returnType = 'object';
        protected $allowedFields = ['KorisikID', 'BrojKartice'];
        
        public function dodajKorisnika($data) {
            $builder = $this->db->table('loyalitykorisnik');
            return $builder->insert($data);
            //echo '<pre>'; print_r($data); echo '</pre>';
        }
       
}