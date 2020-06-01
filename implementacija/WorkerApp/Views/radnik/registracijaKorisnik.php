<!doctype html>
<html lang="en">
    <head>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Registracija Korisnika</title>
        
    </head>
    <body style="overflow-x: hidden;">
        <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1" style="font-size: 30px;">Cinerman</span>
            <form class="form-inline my-2 my-lg-0" name="backLogoutform" action="<?= site_url("Radnik/vratiIzadji") ?>" method="post">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <input name="vratiSe" type="submit" class="btn btn-outline-secondary my-2 my-sm-0" value="Vrati se" style="width: 100px;">
                        </td>
                        <td width="50%" align="center">
                            <input name="logout" type="submit" class="btn btn-outline-danger my-2 my-sm-0" value="Log out" style="width: 100px;">
                        </td>
                    </tr>
                </table>
            </form>
        </nav>
        <form class="needs-validation" novalidate name="registracijaform" action="<?= site_url("Radnik/unesiKorisnika") ?>" method="post">
        <div class="row mt-3">
            <div class="offset-sm-3 col-sm-6 ">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <input name="name" type="text" class="form-control" placeholder="Ime" id="validationTooltip01" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="lastname" type="text" class="form-control" placeholder="Prezime" id="validationTooltip01" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="email" type="text" class="form-control" placeholder="e-mail" id="validationTooltip01" required>
                        </td>
                    </tr>
                     <tr>
                        <td width="50%" align="center">
                            <input name="username" type="text" class="form-control" placeholder="Korisnicko ime" id="validationTooltip01" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="password" type="password" class="form-control" placeholder="Lozinka" id="validationTooltip01" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="korisnik" type="submit" class="btn btn-dark btn-lg btn-outline-light" value="Unesi Korisnika">
                            <input name="loyality" type="submit" class="btn btn-dark btn-lg btn-outline-light" value="Unesi Loyality">
                        </td> 
                    </tr>
                </table>   
            </div>
        </div>
        </form>
        <footer class="page-footer font-small blue fixed-bottom bg-dark text-white">
            <div class="footer-copyright text-center py-3"> © Cinerman Zaposleni App - Brute Force 2020
            </div>
        </footer>
    
<script>
// Disable form submissions if there are invalid fields    
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
      
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

