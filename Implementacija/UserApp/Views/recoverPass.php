<!--
    Nikola Krstic 2017/0265
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

        <title>Cinerman bioskop</title>

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
    </head>
    <body style="overflow-x: hidden;">
        <div class="container-fluid bg-dark">
            <div class="row vh-100">
                <div class="col-sm-12 d-flex justify-content-center align-items-center bg-white text-center">
                    <div class="shadow-lg p-4 mb-4 bg-ligt">
                        <div>
                            <img src="<?php echo base_url('password-img.png'); ?>" alt="Lozinka" style="width:400px"> 
                        </div>
                        <?php
                            if(!isset($uspeh) && isset($poruka)) { 
                                echo "<div class='alert alert-dismissible alert-danger text-center'>";
                                echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                echo "<strong>$poruka</strong>";
                                echo "</div>";
                            }
                            else if(isset($poruka)) {
                                echo "<div class='alert alert-dismissible alert-success text-center'>";
                                echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                echo "<strong>$poruka</strong>";
                                echo "</div>";
                            }
                        ?>
                        <form name="changePassForm" action="<?= site_url("Korisnik/recoverPassword") ?>" method="post" class="needs-validation" novalidate style="width:400px">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Ime" name="name" required>
                                <div class="invalid-feedback text-sm-left">Korisnicko ime ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="lname" placeholder="Prezime" name="lname" required>
                                <div class="invalid-feedback text-sm-left">Korisnicko ime ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="Email" name="email" required>
                                <div class="invalid-feedback text-sm-left">Korisnicko ime ne sme biti prazno polje</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Resetovanje lozinke</button>
                        </form>
                    </div>
                </div>
            </div>      
        </div>
    </body>
</html>