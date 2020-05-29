<!--
    Nikola Krstic 2017/0265
-->
<header class="bg-dark">
    <div class="row">
        <div class="col-sm-2 text-center">
            <a class="display-4 text-white" href="<?= site_url("Korisnik/index") ?>" style="text-decoration: none">Cinerman</a>
        </div>
        <div class="col-sm-8">
            <nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar" style="font-size: 20px">
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Pocetna <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item pl-4">
                            <a class="nav-link" href="#">Repertoar</a>
                        </li>
                        <li class="nav-item pl-4">
                            <a class="nav-link" href="#">Promocije</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-sm-2">
            <form action="<?= site_url("Korisnik/login") ?>" method="post">
                <ul class="nav nav-pills float-right pt-3 mr-3 mb-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="font-size: 20px">
                            <?= $_SESSION['name']; ?>
                        </a>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="<?= site_url("Korisnik/changePass") ?>">Promena lozinke</a>
                            <div class="dropdown-divider"></div>
                            <a class="btn btn-danger btn-block" role="button" href="<?= site_url("Korisnik/logout") ?>">Log out</a>
                        </div>
                    </li>
                </ul>     
            </form>
        </div>
    </div>
</header>

