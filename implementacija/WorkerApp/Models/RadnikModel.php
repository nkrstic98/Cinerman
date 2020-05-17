<?php namespace App\Models;

use CodeIgniter\Model;

class RadnikModel extends Model {
    
        protected $table      = 'zaposleni';
        protected $primaryKey = 'KorisnickoIme';
        protected $returnType = 'object';
       
}