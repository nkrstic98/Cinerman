<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cinerman</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <style>
            #logout {
                float: right;
            }
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
            <p>Dobrodosli na stranicu za dodavanje novih filmova</p>
        </div>

        <div>
            <?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>
            <form name="addMovieform" action="<?= site_url("Admin/addMovieSubmit") ?>" method="post">
                <table id="t">
                    <tr>
                        <td>Naziv filma: </td>
                        <td><input type="text" name="naziv" value="<?= set_value('naziv') ?>"></td>
                        <td>
                            <font color='red'>
                                <?php 
                                    if(!empty($errors['naziv']))
                                        echo "Naziv filma ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Originalni naziv filma: </td>
                        <td><input type="text" name="onaziv" value="<?= set_value('onaziv') ?>"></td>
                    </tr>
                    <tr>
                        <td>Zanr: </td>
                        <td><input type="text" name="zanr"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["zanr"]))
                                        echo "Zanr ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Trajanje: </td>
                        <td><input type="number" name="traj"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["traj"]))
                                        echo "Trajanje ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Godina premijere: </td>
                        <td><input type="text" name="prem"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["prem"]))
                                        echo "Godina premijere ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Pocetak prikazivanja: </td>
                        <td><input type="date" name="poc"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["poc"]))
                                        echo "Pocetak prikazivanja ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Kraj prikazivanja: </td>
                        <td><input type="date" name="kraj"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["kraj"]))
                                        echo "Kraj prikazivanja ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Reditelj: </td>
                        <td><textarea name="red" id="red" cols="30" rows="2"></textarea></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["red"]))
                                        echo "Reditelj ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Uloge: </td>
                        <td><textarea name="uloge" id="uloge" cols="30" rows="2"></textarea></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["uloge"]))
                                        echo "Uloge ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Opis filma: </td>
                        <td><textarea name="opis" id="opis" cols="40" rows="10"></textarea></td>
                    </tr>
                    <tr>
                        <td>Slika: </td>
                        <td><input type="text" name="slika"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["slika"]))
                                        echo "Slika ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Dodaj film u bazu</button></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>