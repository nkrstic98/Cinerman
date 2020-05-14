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
        <p>Dobrodosli na pocetnu stranicu Admin aplikacije</p>
        <div class="footer">
            <p>&copy; Cinerman Adimin App</p>
        </div>
    </body>
</html>

