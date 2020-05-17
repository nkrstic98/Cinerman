<?php namespace App\Models;

use CodeIgniter\Model;

class KorisnikInsertModel extends Model {
    
        protected $table      = 'korisnik';
        protected $primaryKey = 'KorisnikID';
        protected $returnType = 'object';
        protected $allowedFields = ['KorisikID', 'Ime', 'Prezime', 'e-mail', 'Lozinka'];
        
        public function dodajKorisnika($data) {
            $builder = $this->db->table('korisnik');
            return $builder->insert($data);
            //echo '<pre>'; print_r($data); echo '</pre>';
        }
       
}