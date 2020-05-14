<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'zaposleni';
    protected $primaryKey = 'ZaposleniID';

    protected $returnType = 'object';

    protected $allowedFields = [
        'Ime', 
        'Prezime', 
        'KorisnickoIme', 
        'Lozinka', 
        'Privilegije'
    ];
}
