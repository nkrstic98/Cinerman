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
            <p>Dobrodosli na stranicu za registraciju</p>
        </div>

        <div>
            <?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>
            <form name="registerForm" action="<?= site_url("Admin/registerSubmit") ?>" method="post">
                <table id="t">
                    <tr>
                        <td>Ime: </td>
                        <td><input type="text" name="ime" value="<?= set_value('ime') ?>"></td>
                        <td>
                            <font color='red'>
                                <?php 
                                    if(!empty($errors['ime']))
                                        echo "Ime ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Prezime: </td>
                        <td><input type="text" name="prez" value="<?= set_value('prez') ?>"></td>
                        <td>
                            <font color='red'>
                                <?php 
                                    if(!empty($errors['prez']))
                                        echo "Prezime ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Korisnicko ime: </td>
                        <td><input type="text" name="user"></td>
                        <td>
                            <font color='red'>
                                <?php 
                                    if(!empty($errors['user']))
                                        echo "Koriscnicko ime ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="pass"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["pass"]))
                                        echo "Lozinka ne sme biti prazno polje";
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Privilegija</td>
                        <td>
                            <input type="checkbox" id="priv" name="priv" value="1">
                            <label for="priv">Admin</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Register</button></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>