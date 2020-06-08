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
                        <?php 
                            if(isset($poruka)) { 
                                echo "<div class='alert alert-dismissible alert-danger text-center'>";
                                echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                echo "<strong>$poruka</strong>";
                                echo "</div>";
                            }
                        ?>
                        <form name="registerForm" action="<?= site_url("Korisnik/registerSubmit") ?>" method="post" class="needs-validation" novalidate style="width:400px">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Ime" name="name" required value="<?= set_value('name') ?>">
                                <div class="invalid-feedback text-sm-left">Ime ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="lname" placeholder="Prezime" name="lname" required value="<?= set_value('lname') ?>">
                                <div class="invalid-feedback text-sm-left">Prezime ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="uname" placeholder="E-mail" name="uname" required>
                                <div class="invalid-feedback text-sm-left">E-mail ne sme biti prazno polje</div>
                            </div>
							<div class="form-group">
                                <input type="text" class="form-control" id="user" placeholder="Korisnicko ime" name="user" required>
                                <div class="invalid-feedback text-sm-left">Korisnicko ime ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="pswd" placeholder="Loznika" name="pswd" required>
                                <div class="invalid-feedback text-sm-left">Lozinka ne sme biti prazno polje</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="pswd" placeholder="Potvrda lozinke" name="pswdC" required>
                                <div class="invalid-feedback text-sm-left">Potvrda lozinke ne sme biti prazno polje</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Registruj se</button>
                        </form>
                    </div>
                </div>
            </div>      
        </div>
    </body>
</html>