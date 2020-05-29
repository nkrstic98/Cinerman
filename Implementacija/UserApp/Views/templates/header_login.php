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
                    <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Pocetna <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item pl-4">
                        <a class="nav-link" href="#">Repertoar</a>
                    </li>
                    <li class="nav-item pl-4 ">
                        <a class="nav-link" href="#">Promocije</a>
                    </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-sm-2 text-center">
            <form action="<?= site_url("Korisnik/login") ?>" method="post">
                <button type="submit" class="btn btn-primary float-right mt-3 mr-3 p-2 mb-3">Log In</button>
            </form>
        </div>
        
    </div>
</header>