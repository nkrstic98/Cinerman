<?php namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model
{
    protected $table = 'loyalitykorisnik';
    protected $primaryKey = 'KorisnikID';
    protected $returnType = 'object';
    protected $allowedFields = ['KorisnikID', 'BrojKartice'];

    public function isLoyality($korisnikID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT * FROM loyalitykorisnik where KorisnikID=$korisnikID");
        $results= $q->getResultArray();
        //print_r(count($results));
         if (count($results)==0)
        {
            return false;
        }
        else
        {
            return true;
        }
        //za sad imam korisnik ID kad se uradi baza stavi po korisnickom imenu
    }

    public function isKorisnik($korisnikID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT * FROM korisnik where KorisnikID=$korisnikID");
        $results= $q->getResultArray();
        //print_r(count($results));
         if (count($results)==0)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
}