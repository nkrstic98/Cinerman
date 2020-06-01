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
            <header class="bg-dark fixed-top">
                <div class="row">
                    <div class="col-sm-2 text-center">
                        <h1 class="display-4 text-white">Cinerman</h1>
                    </div>
                </div>
            </header>
            <div class="row vh-100">
                <div class="col-sm-12 d-flex justify-content-center align-items-center bg-white text-center">
                    <div class="shadow-lg p-4 mb-4 bg-ligt">
                        <?php if(isset($poruka) && !isset($f)) { echo "<p><font color='red'>$poruka</font></p>"; } ?>
                        <form name="loginForm" action="<?= site_url("Gost/loginSubmit") ?>" method="post" class="needs-validation" novalidate style="width:400px">
                            <div class="form-group">
                                <input type="text" class="form-control" id="uname" placeholder="Korisnicko ime" name="uname" required value="<?= set_value('uname') ?>">
                                <div class="invalid-feedback text-sm-left">Korisnicko ime ne sme biti prazno polje</div>
                                <?php if(isset($poruka) && $f == 1) { echo "<p class='text-sm-left' style='font-size: 80%; color: #dc3545'>$poruka</p>"; } ?>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="pwd" placeholder="Lozinka" name="pswd" required>
                                <div class="invalid-feedback text-sm-left">Lozinka ne sme biti prazno polje</div>
                                <?php if(isset($poruka) && $f == 2) { echo "<p class='text-sm-left' style='font-size: 80%; color: #dc3545'>$poruka</p>"; } ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Uloguj se</button>
                        </form>
                    </div>
                </div>
            </div>      
        </div>
    </body>
</html>