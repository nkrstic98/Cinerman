<!doctype html>
<html lang="en">
    <head>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Navigacija</title>
    
    </head>
    <body style="overflow-x: hidden;">
    <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1" style="font-size: 30px;">Cinerman</span>
            <form class="form-inline my-2 my-lg-0" name="backLogoutform" action="<?= site_url("Radnik/vratiIzadji") ?>" method="post">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                        </td>
                        <td width="50%" align="center">
                            <input name="logout" type="submit" class="btn btn-outline-danger my-2 my-sm-0" value="Log out" style="width: 100px;">
                        </td>
                    </tr>
                </table>
            </form>
    </nav>
    <?php if(isset($poruka)) {
        if($poruka=="Uspesno ste uneli korisnika!") {
        echo"<div class='alert alert-success' role='alert'>"; 
        echo"$poruka";
        echo"</div>";
        } else {
        echo"<div class='alert alert-danger' role='alert'>"; 
        echo"$poruka";
        echo"</div>"; 
        }
    }?>
        <div class="row mt-3">
            <div class="offset-sm-3 col-sm-6 ">
                <form name="navigationform" action="<?= site_url("IzborTermina") ?>" method="post">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <input name="prodajaRezervacija" type="submit" class="btn btn-dark btn-lg  btn-outline-light" value="Prodaj/Rezervisi"></input>
                        </td>
                    </tr>
                </form>
                <form name="navigationform" action="<?= site_url("PotvrdaRezervacija") ?>" method="post">
                    <tr>
                        <td width="50%" align="center">
                            <input name="potvrdiRezervaciju" type="submit" class="btn btn-dark btn-lg  btn-outline-light" value="Potvrdi Rezervaciju"></input>
                        </td>    
                    </tr>
                </form>
                    <form name="navigationform" action="<?= site_url("Radnik/navigacijaIzbor") ?>" method="post">
                    <tr>
                        <td width="50%" align="center">
                            <input name="registracijaKorisnik" type="submit" class="btn btn-dark btn-lg  btn-outline-light" value="Registruj"></input>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="postaniLoyality" type="submit" class="btn btn-dark btn-lg  btn-outline-light" value="Postani Loyality"></input>
                        </td>    
                    </tr> 
                    </form>
                </table>    
            </div>
        </div>
        <footer class="page-footer font-small blue fixed-bottom bg-dark text-white">
            <div class="footer-copyright text-center py-3"> © Cinerman Zaposleni App - Brute Force 2020
            </div>
        </footer>
        
        <!-- My CSS Style --> 
        <style>
        .btn  {width: 250px;}
        </style>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>