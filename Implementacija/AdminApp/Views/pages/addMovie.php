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
                <div class="col-sm-10 bg-white d-flex justify-content-center align-items-center">
                    <div class="shadow-lg p-4 mb-4 mt-5 bg-ligt">
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
                                    echo "<strong>Uspesno ste dodali film</strong>";
                                    echo "</div>";
                                }
                            }
                        ?>
                        <form name="addMovieForm" enctype="multipart/form-data" action="<?= site_url("Admin/movieSubmit") ?>" method="post" class="needs-validation" novalidate style="width: 800px">
                            <div class="form-group row">
                                <div class="col-sm-6">  
                                    <input type="text" class="form-control" id="naziv" placeholder="Naziv filma" name="naziv" required>
                                    <div class="invalid-feedback text-sm-left">Naziv filma ne sme biti prazno polje</div>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="onaziv" placeholder="Originalni naziv filma" name="onaziv">
                                    <div class="valid-feedback">Originalni naziv filma nije obavezno polje</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="Zanr" class="form-control" id="zanr" placeholder="Zanr" name="zanr" required>
                                    <div class="invalid-feedback text-sm-left">Zanr ne sme biti prazno polje</div>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="traj" placeholder="Trajanje filma (min)" name="traj" required>
                                    <div class="invalid-feedback text-sm-left">Trajanje ne sme biti prazno polje</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="prem" placeholder="Godina premijere" name="prem" required>
                                    <div class="invalid-feedback text-sm-left">Godina premijere ne sme biti prazno polje</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="slika" name="slika" required>
                                        <label class="custom-file-label" for="slika">Ucitajte sliku</label>
                                        <div class="invalid-feedback text-sm-left">Morate dodati sliku filma</div>
                                    </div>
                                    <script>
                                        // Add the following code if you want the name of the file appear on select
                                        $(".custom-file-input").on("change", function() {
                                            var fileName = $(this).val().split("\\").pop();
                                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="poc" placeholder="Pocetak prikazivanja" name="poc" required onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <div class="invalid-feedback text-sm-left">Pocetak prikazivanja ne sme biti prazno polje</div>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="kraj" placeholder="Kraj prikazivanja" name="kraj" required onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <div class="invalid-feedback text-sm-left">Kraj prikazivanja ne sme biti prazno polje</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <textarea class="form-control" rows="2" id="red" name="red" placeholder="Reditelj" required></textarea>
                                    <div class="invalid-feedback text-sm-left">Reditelj ne sme biti prazno polje</div>
                                </div>
                                <div class="col-sm-6">
                                    <textarea class="form-control" rows="2" id="uloge" name="uloge" placeholder="Uloge" required></textarea>
                                    <div class="invalid-feedback text-sm-left">Uloge ne sme biti prazno polje</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" id="opis" name="opis" placeholder="Opis filma" required></textarea>
                                    <div class="invalid-feedback text-sm-left">Opis filma ne sme biti prazno polje</div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 float-right">Dodaj film</button>
                        </form>
                    </div>
                </div>  
            </div>   
        </div>
    </body>
</html>