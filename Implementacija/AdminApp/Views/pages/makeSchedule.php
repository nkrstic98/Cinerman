<?php
    use App\Models\FilmModel;
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Cinerman</title>

            <style>
                <?php include 'style.css'; ?>
            </style>

    </head>
    <body>
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
                                        <td><input type="date" name="datum" value="<?= set_value('datum') ?>"></td>
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
                                        <td><input type="text" name="vreme" value="<?= set_value('vreme') ?>"></td>
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
                                </table>
                            </div> 
                            <div class="box-cell box2"> 
                                <table id="table2" class="sch">
                                    <tr>
                                        <th class="sch">Sala 1</th>
                                        <th class="sch">Sala 2</th>
                                        <th class="sch">Sala 3</th>
                                    </tr>
                                    <?php
                                        $row = 0;
                                        for($i = 0; $i < 10; $i++) {
                                            $row1 = "1" . $row;
                                            $row2 = "2" . $row;
                                            $row3 = "3" . $row;
                                            $row++;
                                            echo "<tr>";
                                            echo "<td class='sch' id='$row1'></td>";
                                            echo "<td class='sch' id='$row2'></td>";
                                            echo "<td class='sch' id='$row3'></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </table>  
                            </div> 
                        </div> 
                    </div> 
                </div>
            </form>
        </div>

        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>

