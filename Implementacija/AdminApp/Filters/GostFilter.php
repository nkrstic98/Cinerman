<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Ivan Rakonjac 2017/0656
 * 
 * Filter klasa koja obezbedjuje pravilno ponasanje neulogovanog korisnika
 * 
 * @version 1
 */
class GostFilter implements FilterInterface
{
    /**
     * Funkcija koja sluzi za modifikaciju Requesta
     * 
     * @param RequestInterface $request Request
     * 
     * @return Response
     */
    public function before(RequestInterface $request)
    {
        $session = session();
        if($session->has('adminUser')) {
            return redirect()->to(site_url('Admin/welcome'));
        }
    }

    //--------------------------------------------------------------------

    /**
     * Modifikacija Responsa pre slanja klijentu
     */
    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}