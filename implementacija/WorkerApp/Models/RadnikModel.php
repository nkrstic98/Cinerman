<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Lara Vukovic 2017/0319
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele zaposleni iz baze
 * 
 * @version 1
 */

class RadnikModel extends Model {
    
        /**
        * @var $table - naziv tabele u bazi
        */
        protected $table      = 'zaposleni';
        
        /**
        * @var $primarykey - primarni kljuc tabele
        */
        protected $primaryKey = 'KorisnickoIme';
        
        /**
        * @var $returntype - povratna vrednost upita
        */
        protected $returnType = 'object';
       
}