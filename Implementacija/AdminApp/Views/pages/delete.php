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
            <p>Dobrodosli na stranicu za brisanje korisnika</p>
        </div>

        <div>
            <?php if(isset($poruka)) echo "<font color='red'>$poruka</font><br>"; ?>
            <form name="deleteform" action="<?= site_url("Admin/deleteSubmit") ?>" method="post">
                <table id="t">
                    <tr>
                        <td>Korisnicko ime radnika koji se brise: </td>
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
                        <td colspan="2"><button type="submit">Delete</button></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>

