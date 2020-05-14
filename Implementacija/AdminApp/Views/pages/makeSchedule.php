<?php
    use App\Models\FilmModel;
?>

<?php if($_POST['SalaID']!=null){ $salaID=$_POST['SalaID'];} ?>

<?php 
    function iscrtajTabelu($termini,$sala){

        if($termini!=NULL){
            $brojac=0;
            foreach ($termini as $row)
            {
                if($row->SalaID==$sala){
                    $brojac=$brojac+1;
                    echo "<tr>";
                    echo "<th scope=row>$brojac</th>";
                    echo "<td>$row->PocetakTermina</td>";
                    echo "<td>$row->KrajTermina</td>";
                    echo "<td>$row->Naziv</td>";
                    echo "<td>$row->Datum</td>";
                    echo "<td><button class=\"btn btn-danger\" name=deleteTermin type=submit value=$row->TerminID formaction=deleteTermin>&times;</button></td>";
                    echo "</tr>";
                }
            }
        }
        else{
            echo "<tr><td colspan=3>Admine napravi mi raspored za danas!</tr></tr>";
        }
    };
?>


<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">

            <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
            <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


            <title>Cinerman</title>
            
            <style>
                #logout {
                    float: right;
                }

                .container .box {
                    display:table; 
                }

                .container .box .box-row { 
                    display:table-row; 
                } 

                .container .box .box-cell { 
                    display:table-cell; 
                    width:50%; 
                    padding:10px; 
                }

                table.sch {
                    width: 600px;
                    border: 1px solid black;
                }

                td.sch, th.sch {
                    height: 20px;
                    border: 1px solid black;
                }

                #table2 {
                    border-collapse: collapse;
                }

                body {font-family: Arial;}

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
        <div class="header">
            <h1>Cinerman</h1>
            <a href="<?= site_url("Admin/logout") ?>" id="logout">Log out</a>
        </div>

        <div class="topnav">
            <a href="<?= site_url("Admin/register") ?>">Registracija novog korisninka</a>
            <a href="<?= site_url("Admin/delete") ?>">Uklanjanje zaposlenog iz sistema</a>
            <a href="<?= site_url("Admin/addMovie") ?>">Dodavanje novog filma u bazu</a>
            <a href="<?= site_url("Admin/makeSchedule") ?>">Pravljenje repertoara</a>
        </div>

        <div>
            <p>Dobrodosli na stranicu za pravljenje repertoara</p>
        </div>

        <div>
            <?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>

            <form name="makeSchedform" action="<?= site_url("Admin/makeScheduleSubmit") ?>" method="post">
                <div class="container" align="center"> 
                    <div class="box"> 
                        <div class="box-row"> 
                            <div class="box-cell box1"> 
                                <table class="setup">
                                    <tr>
                                        <td>Izaberite datum</td>
                                        <td><input type="date" name="datum" value="<?= set_value('datum')?>" oninput="dateDugme()"></td>
                                        <td>
                                            <font color='red'>
                                                <?php 
                                                    if(!empty($errors['datum']))
                                                        echo "Datum ne sme biti prazno polje";
                                                ?>
                                            </font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Izaberite vreme pocetka prikazivanja filmova</td>
                                        <td><input type="text" name="vreme" value="<?php set_value('vreme'); ?>"></td>
                                        <td>
                                            <font color='red'>
                                                <?php 
                                                    if(!empty($errors['vreme']))
                                                        echo "Pocetno vreme ne sme biti prazno polje";
                                                ?>
                                            </font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Izaberite film</td>
                                        <td>
                                            <?php
                                                echo "<select name='mov' id='movies'>";
                                                echo "<option></option>";
                                                $filmModel = new FilmModel();
                                                $filmovi = $filmModel->dohvatiFilmove();
                                                foreach($filmovi as $film) {
                                                    echo "<option value='{$film->FilmID}'>{$film->Naziv} - {$film->Trajanje}</option>";
                                                }
                                                echo "</select>";
                                            ?>
                                        </td>
                                        <td>
                                            <font color='red'>
                                                <?php 
                                                    if(!empty($errors['mov']))
                                                        echo "Film ne sme biti prazno polje";
                                                ?>
                                            </font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Sala </td>
                                        <td>
                                            <select name="sala" id="salaId">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <font color='red'>
                                                <?php 
                                                    if(!empty($errors['sala']))
                                                        echo "Sala ne sme biti prazno polje";
                                                ?>
                                            </font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><input type="submit" name="dodaj" value="Dodaj film" formaction="insertMovieSubmit"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" name="osveziTabelu" value="Osvezi tabelu" formaction="dovuciTermineZaDatum"></td>
                                    </tr>
                                </table>
                            </div>
                        </div> 

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
                    </div> 
                </div>
            </form>
        </div>


        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>


<!-- Za biranje vremena
        <label for="appt-time">Choose an appointment time: </label>
        <input id="appt-time" type="time" name="appt-time" value="13:30">
-->

<!-- Da ne zaboravimo

srediti ispis gresaka
srediti input polja
napraviti fju za formiranje cene

razmisliti o dodavanju u vuse sala
razmisliti o dodavanju u vise termina

-->