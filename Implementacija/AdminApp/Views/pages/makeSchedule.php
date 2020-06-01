<!--
    Ivan Rakonjac 2017/0656
-->
<?php 
    use App\Models\FilmModel; 
    use App\Controllers\Admin;
?>

<?php 
    function iscrtajTabelu($termini,$sala){

        if($termini!=NULL){
            $brojac=0;
            foreach ($termini as $row)
            {
                if($row->SalaID==$sala){
                    $brojac=$brojac+1;
                    echo "<tr>";
                    echo "<th scope=row class='align-middle'>$brojac</th>";
                    echo "<td class='align-middle'>$row->PocetakTermina</td>";
                    echo "<td class='align-middle'>$row->KrajTermina</td>";
                    echo "<td class='align-middle'>$row->Naziv</td>";
                    echo "<td class='align-middle'>$row->Datum</td>";
                    echo "<td><button class=\"btn btn-danger\" name=deleteTermin type=submit value=$row->TerminID formaction=deleteTermin>&times;</button></td>";
                    echo "</tr>";
                }
            }
        }
    };
?>

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

        <style>
            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }

            /* Style the buttons inside the tab */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #ddd;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #ccc;
            }

            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }

            .xDugme{
                color:red;
            }
        </style>

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

            function openTabOnLoad(idSale) {
                var brSale=0;
                var brSale = "<?php if($_POST['SalaID']!=null){ echo $_POST['SalaID'];} ?>";

                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                if(brSale=="1"){
                     document.getElementById("Sala1").style.display = "block";
                    document.getElementById("Sala1").className += " active";
                    tablinks[0].className += " active";
                }
                else if(brSale=="2"){
                    document.getElementById("Sala2").style.display = "block";
                    document.getElementById("Sala2").className += " active";
                    tablinks[1].className += " active";
                }
                else if(brSale=="3"){
                    document.getElementById("Sala3").style.display = "block";
                    document.getElementById("Sala3").className += " active";
                    tablinks[2].className += " active";
                }
                else{
                    document.getElementById("Sala1").style.display = "block";
                    tablinks[0].className += " active";
                }
            }

            function openTab(evt, tabId) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(tabId).style.display = "block";
                evt.currentTarget.className += " active";
            }
        </script>

    </head>
    <body onload="openTabOnLoad('Sala1')">
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

                <div class="col-sm-4 bg-white d-flex justify-content-center align-items-center">
                    <div class="shadow-lg p-4 mb-4 bg-ligt">
                        <form name="makeSchedform" class="needs-validation text-center" action="<?= site_url("Admin/scheduleSubmit") ?>" method="post" style="width:400px">
                            <div class="form-group text-left">
                                <table>
                                    <tr>
                                        <td class="p-4">Datum repertoara</td>
                                        <td><input type="date" class="form-control" id="datum" placeholder="" name="datum" value="<?= set_value('datum')?>" oninput="dateDugme()" required></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" formaction="dovuciTermineZaDatum">Prikazi repertoar</button>
                            </div>
                            <hr>
                            <?php 
                                if(isset($poruka) && !isset($uspeh)) {
                                    echo "<div class='alert alert-dismissible alert-danger text-center'>";
                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                    echo "<strong>$poruka</strong>";
                                    echo "</div>";
                                }
                                else {
                                    if(isset($uspeh) && isset($uspeh)) {
                                        echo "<div class='alert alert-dismissible alert-success text-center'>";
                                        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                        echo "<strong>$poruka</strong>";
                                        echo "</div>";
                                    }
                                }
                            ?>
                            <hr>
                            <div class="form-group">
                                <table >
                                    <tr>
                                        <td class="p-4">Vreme pocetka filma</td>
                                        <td>
                                        <?php
                                            echo '<select name="sat" id="sat" class="custom-select">';
                                            for($i = 0; $i < 24; $i++) {
                                                if($i < 10) $val = "0" . $i;
                                                else $val = $i;
                                                echo "<option value='$val'>$val</option>";
                                            }
                                            echo '</select>';
                                        ?>
                                        </td>
                                        <td class="p-2">:</td>
                                        <td>
                                        <?php
                                            echo '<select name="min" id="min" class="custom-select">';
                                            for($i = 0; $i < 60; $i++) {
                                                if($i < 10) $val = "0" . $i;
                                                else $val = $i;
                                                echo "<option value='$val'>$val</option>";
                                            }
                                            echo '</select>';
                                        ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <?php Admin::listaFilmova(); ?>
                            </div>
                            <div class="form-group">
                                <select name="sala" id="salaId" class="custom-select" value="<?= set_value('sala')?>">
                                    <option value="-1">Izaberite salu</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Dodaj film</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-6 bg-white mt-5 p-5">
                    <form name="makeSchedform" class="needs-validation text-center" action="<?= site_url("Admin/deleteTermin") ?>" method="post">
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'Sala1')" type="button">Sala 1</button>
                            <button class="tablinks" onclick="openTab(event, 'Sala2')"  type="button">Sala 2</button>
                            <button class="tablinks" onclick="openTab(event, 'Sala3')"  type="button">Sala 3</button>
                        </div>

                        <div id="Sala1" class="tabcontent">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Pocetak Filma</th>
                                        <th scope="col">Kraj Filma</th>
                                        <th scope="col">Film</th>
                                        <th scope="col">Datum</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php iscrtajTabelu($termini,1);?>
                                </tbody>
                            </table>
                        </div>

                        <div id="Sala2" class="tabcontent">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Pocetak Filma</th>
                                        <th scope="col">Kraj Filma</th>
                                        <th scope="col">Film</th>
                                        <th scope="col">Datum</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php iscrtajTabelu($termini,2);?>
                                </tbody>
                            </table>
                        </div>

                        <div id="Sala3" class="tabcontent">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Pocetak Filma</th>
                                        <th scope="col">Kraj Filma</th>
                                        <th scope="col">Film</th>
                                        <th scope="col">Datum</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php iscrtajTabelu($termini,3);?>
                                </tbody>
                            </table>
                        </div> <!--poslednji tab-->
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>