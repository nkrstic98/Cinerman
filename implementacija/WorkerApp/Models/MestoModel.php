<?php namespace App\Models;

use CodeIgniter\Model;

class MestoModel extends Model
{
    protected $table = 'mesto';
    protected $primaryKey = 'MestoID';
    protected $returnType = 'object';
    protected $allowedFields = ['MestoID', 'TerminID', 'BrojSedista','Stanje'];

    public function dodajMesto($TerminID,$BrojSedista, $Stanje)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT max(MestoID) FROM mesto");
        $results= $q->getResultArray();
        $mestoID=$results[0]['max(MestoID)']+1;
        $data=array (
                "MestoID"=>$mestoID,
                "TerminID"=> $TerminID,
                "BrojSedista"=>$BrojSedista,
                "Stanje"=>$Stanje
        );
        $builder=$this->db->table('mesto');
        $builder->insert($data);
    }

    public function dodajRezervaciju($BrojSedista,$korisnikID)
    {
    //$db=\Config\Database::connect();
    $q=$this->db->query("SELECT MestoID FROM mesto WHERE BrojSedista=$BrojSedista");
    $results= $q->getResultArray();
    $data=array (
        "KorisnikID"=>$korisnikID,
        "MestoID"=>$results[0]['MestoID']
    );
    $builder=$this->db->table('rezervacija');
    $builder->insert($data);
    }

    public function getRezervacijePoKorID($korisnikID)
    { 
    //$db=\Config\Database::connect();
    $q=$this->db->query("SELECT DISTINCT termin.TerminID AS 'TerminID', film.Naziv AS 'Naziv', termin.Datum 
    AS 'Datum', termin.PocetakTermina AS 'Pocetak', termin.SalaID AS 'Sala' FROM termin 
    INNER JOIN mesto ON mesto.TerminID = termin.TerminID 
    INNER JOIN film ON termin.FilmID = film.FIlmID 
    INNER JOIN rezervacija ON rezervacija.MestoID = mesto.MestoID 
    WHERE rezervacija.KorisnikID = $korisnikID");
    $results= $q->getResultArray();
    return($results);
    }
    
    public function potvrdaRezervacije($korisnikID, $TerminID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT
        rezervacija.MestoID AS 'MestoID'
        FROM
        rezervacija
        INNER JOIN mesto ON mesto.MestoID = rezervacija.MestoID
        INNER JOIN termin ON termin.TerminID = mesto.TerminID
        WHERE rezervacija.KorisnikID=$korisnikID AND termin.TerminID=$TerminID");
        $results= $q->getResultArray();
        $data=count($results);
        //print_r($results);
        foreach($results as $row)
        {
            $mID=$row['MestoID'];
            $this->db->query("UPDATE mesto SET Stanje='1' WHERE MestoID='$mID'");
            $this->db->query("DELETE FROM rezervacija WHERE MestoID=$mID");
        }
        return $data;
    }
    public function izbrisiRezervacije($korisnikID, $TerminID)
    {
        //$db=\Config\Database::connect();
        $q=$this->db->query("SELECT
        rezervacija.MestoID AS 'MestoID'
        FROM
        rezervacija
        INNER JOIN mesto ON mesto.MestoID = rezervacija.MestoID
        INNER JOIN termin ON termin.TerminID = mesto.TerminID
        WHERE rezervacija.KorisnikID=$korisnikID AND termin.TerminID=$TerminID");
        $results= $q->getResultArray();
        $data=count($results);
        //print_r($results);
        //$this->db->query("DELETE FROM `mesto` WHERE `mesto`.`MestoID` = 2;");
        foreach($results as $row)
       {
            $mID=$row['MestoID'];
            $builder=$this->db->table('mesto');
            print_r($builder->delete(['MestoID'=>$mID]));
           // $builder->delete(['MestoID'=>$mID]);
            //$this->db->query("DELETE FROM mesto WHERE MestoID=$mID");
        }
        return $data;
    }
}
