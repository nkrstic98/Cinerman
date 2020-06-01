<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * Damir Savic 2017/0240
 * 
 * Klasa koja sluzi za rad sa informacijama iz tabele mesto
 * 
 * @version 1
 */
class MestoModel extends Model
{
    protected $table = 'mesto';
    protected $primaryKey = 'MestoID';
    protected $returnType = 'object';
    protected $allowedFields = ['MestoID', 'TerminID', 'BrojSedista','Stanje'];
/**
     * Funkcija koja dodaje mesto u bazu podataka
     * @param $TerminID id termina u kom je zauzeto mesto 
     * @param $BrojSedista broj sedista koje je zauzeto 
     * @param $Stanje stanje sedista 1-kupljeno 2-rezervisano
     * 
     * @return void
     */    
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
/**
     * Funkcija koja dodaje rezervaciju za korisnika na trazenom mestu 
     * @param $terminID id termina u kom je zauzeto mesto 
     * @param $BrojSedista broj sedista koje je zauzeto 
     * @param $Stanje stanje sedista 1-kupljeno 2-rezervisano
     * 
     * @return void
     */   
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
/**
     * Funkcija koja dohvata niz termina nad kojima korisnik ima rezervaciju 
     * @param $korisnikID id korisnika
     * 
     * @return Array
     */ 
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
    /**
     * Funkcija koja izvrsava potvrdu rezervacije nad odredjenim terminom za odredjenog korisnika  
     * @param $korisnikID id korisnika
     * @param $TerminID id termina;
     * 
     * @return $data vraca koliko je mesta imao korisnik u terminu
     */
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
    /**
     * Funkcija koja izvrsava otkazivanje rezervacije nad odredjenim terminom za odredjenog korisnika  
     * @param $korisnikID id korisnika
     * @param $TerminID id termina;
     * 
     * @return $data vraca koliko je mesta imao korisnik u terminu
     */
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
     /**
     * Funkcija koja izvrsava provereu da li su mesta slobodna u odredjenom terminu   
     * @param $polja niz polja za koje je potrebna provera
     * @param $terminID id termina;
     * 
     * @return true/false 
     */
    public function areFree($TerminID,$polja)
    {
        foreach($polja as $polje)
        {
            $q=$this->db->query("Select * from mesto where BrojSedista=$polje and TerminID=$TerminID");
            $results= $q->getResultArray();
            $data=count($results);
            if ($data==0)
            {
                return false;
            }
        }
        return true;
    }
}
