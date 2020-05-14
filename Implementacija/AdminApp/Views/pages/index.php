<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cinerman</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="header">
            <h1>Cinerman</h1>
        </div>
        <div>
            <?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>
            <form name="loginform" action="<?= site_url("Admin/loginSubmit") ?>" method="post">
                <table id="t">
                    <tr>
                        <td>Username: </td>
                        <td><input type="text" name="KorisnickoIme" value="<?= set_value('KorisnickoIme') ?>"></td>
                        <td>
                            <font color='red'>
                                <?php 
                                    if(!empty($errors['KorisnickoIme']))
                                        echo $errors['KorisnickoIme'];
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="Lozinka"></td>
                        <td>
                            <font color="red">
                                <?php
                                    if(!empty($errors["Lozinka"]))
                                        echo $errors["Lozinka"];
                                ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Log In</button></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>