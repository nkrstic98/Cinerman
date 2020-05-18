<!--
    Nikola Krstic 2017/0265
-->
<?php use App\Controllers\Admin; ?>

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

        <title>Cinerman Admin</title>

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
    <body>
        <div class="container-fluid bg-dark">
            <div class="row vh-100">
                <div class="col-sm-2 d-flex justify-content-center">
                    <nav class="navbar text-center">
                        <ul class="navbar-nav">
                            <li class="nav-item mb-3">
                                <a href="<?= site_url("Admin/register") ?>" class="btn btn-light btn-block" role="button">Registracija zaposlenih</a>
                            </li>
                            <li class="nav-item mb-3">
                                <a href="<?= site_url("Admin/delete") ?>" class="btn btn-light btn-block" role="button">Uklanjanje zaposlenih</a>
                            </li>
                            <li class="nav-item mb-3">
                                <a href="<?= site_url("Admin/addMovie") ?>" class="btn btn-light btn-block" role="button">Dodavanje filma</a>
                            </li>
                            <li class="nav-item mb-3">
                                <a href="<?= site_url("Admin/makeSchedule") ?>" class="btn btn-light btn-block" role="button">Pravljenje repertoara</a> 
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-sm-10 d-flex justify-content-center align-items-center bg-white text-center">
                    <div class="shadow-lg p-4 mb-4 bg-ligt">
                        <?php 
                            if(isset($poruka)) { 
                                echo "<div class='alert alert-dismissible alert-danger text-center'>";
                                echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                echo "<strong>$poruka</strong>";
                                echo "</div>";
                            }
                            else {
                                if(isset($uspeh)) {
                                    echo "<div class='alert alert-dismissible alert-success text-center'>";
                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                    echo "<strong>Uspesno ste obrisali zaposlenog</strong>";
                                    echo "</div>";
                                }
                            }
                        ?>
                        <form name="deleteForm" class="form-inline needs-validation" action="<?= site_url("Admin/deleteSubmit") ?>" method="post" novalidate>
                            <?php Admin::listaZaposlenih(); ?>
                            <button type="submit" class="btn btn-danger">Obrisi zaposlenog</button>
                        </form>
                        
                    </div>
                </div>
            </div>      
        </div>
    </body>
</html>