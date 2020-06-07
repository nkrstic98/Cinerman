<?php 
    function iscrtajRepertoar($idTaba){
        $brojacFilmova=0;
        $termini = $_POST['terminiZaFilmove'][$idTaba];
        foreach($_POST['filmoviZaSedamDana'][$idTaba] as $film){
         

                echo "<div class=\"col-sm-12 col-md-12 row text-center\">";

                    echo "<div class=\"col-sm-0 col-md-2 text-center \"></div>";
                
                    echo "<div class=\"col-sm-12 col-md-3 text-center \">";
                    $slikaLink=base_url($film->Slika);
                    echo "<img src=$slikaLink width=\"90%\" height=450>";
                    echo "</div>";

                    echo "<div class=\"col-sm-6 col-md-3 text-left\">";
                            echo "<h3 style=\"text-align:center;\" class=mb-3><b>$film->Naziv</b></h3>";
                            echo "<p>Reditelj: $film->Reditelj</p>";
                            echo "<p>Zanr: $film->Zanr</p>";
                            echo "Uloge:";
                            echo "<p>$film->Uloge</p>";
                            echo "<p>Trajanje filma: $film->Trajanje min</p>";
                            echo "<p>Godina premijere: $film->GodinaPremijere.</p>";
                            echo "Opis:";
                            echo "<p>$film->Opis</p>";
                    echo "</div>";


                    echo "<div class=\"col-sm-12 col-md-2 mt-5\">";
                    foreach($termini[$brojacFilmova] as $termin){
                        $vremePocetka=substr($termin->PocetakTermina,0,5);
                        echo "<div class=\"col-sm-12 mt-3\">";
                        echo "<form action='http://localhost:8080/index.php/Prodaja' method='post'>";
                        echo "<button type=submit name='terminID' class=\"btn btn-dark btn-lg dugmeTermin\" value=\"$film->TerminID\" onclick='http://localhost:8080/index.php/Prodaja'>$vremePocetka h<br>$termin->Cena RSD</butoon>";
                        echo "<input type='hidden' name='terminID' value='$film->TerminID' />";
                        echo "</form>";
                        echo "</div>";
                    }
                    echo "</div>";
                    $brojacFilmova++;

                    echo "<div class=\"col-sm-0 col-md-2 text-center \"></div>";

                echo "</div>";
          
            echo "<hr>";
        }
    };
    function getImage($id){
        echo base_url($_POST['filmoviZaSedamDana'][0][$id]->Slika);
    }
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

        <title>Cinerman bioskop</title>

        <script>
            /*
            *setujem imena tabova u zavisnosti koji je dan u nedelji realno
            *prvi tab uvek ima vrednost danasnjeg dana
            *prvi tab je aktivan po ucitavanju stranice
            */
            function openTabOnLoad() {

                    var days = ['Nedelja', 'Ponedeljak', 'Utorak', 'Sreda', 'Cetvrtak', 'Petak', 'Subota'];
                    var dateString = new Date();
                    console.log(dateString);
                    var d = new Date(dateString);
                    var indexDana = d.getDay();

                    
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                        tablinks[i].innerText=days[indexDana];
                        indexDana=(indexDana+1)%7;
                    }

                    document.getElementById("Dan1").style.display = "block";
                    document.getElementById("Dan1").className += " active";
                    tablinks[0].className += " active";

            }

            function getTodayDayName(){
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var dateString = new Date();
                var d = new Date(dateString);
                console.log(d);
                var dayName = days[d.getDay()];
                console.log(dayName);
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

        <style>
            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: white;
            }

            /* Style the buttons inside the tab */
            .tab button {
                background-color: #e1e1d0;
                float: center;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #4d4d4d;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #4d4d4d;
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

            .tabcontent img{
                padding:10px;
            }

            .carousel-inner img {
                width: 100%;
                height: 100vh;
            }

            .dugmeTermin{
                width:100%;
            }

        </style>

    </head>
    <body onload="openTabOnLoad()">

            <div id="demo" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="http://localhost:8080/public/upload/KingKong.jpeg" alt="Chicago" width="1100" height="500">
                    </div>
                    <div class="carousel-item">
                    <img src="http://localhost:8080/public/upload/starWars.jpg" alt="Los Angeles" width="1100" height="500">
                    </div>
                    <div class="carousel-item">
                    <img src="http://localhost:8080/public/upload/inception.jpg" alt="New York" width="1100" height="500">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
                </a>
            </div>
            
            <div class="container-fluid">
               <div class="row">
                        <div class="col-md-3 col-sm-0"></div>
                        <div class="col-md-6 col-sm-12 text-center pt-5 pb-2"><h2>REPERTOAR</h2><hr></div>
                        <div class="col-md-3 col-sm-0"></div>

                        <div class="col-sm-12 bg-white">
                                
                                    <div class="tab text-center">
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan1')" type="button">Dan 1</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan2')"  type="button">Dan 2</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan3')"  type="button">Dan 3</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan4')" type="button">Dan 4</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan5')"  type="button">Dan 5</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan6')"  type="button">Dan 6</button>
                                        <button class="tablinks col-sm-1" onclick="openTab(event, 'Dan7')"  type="button">Dan 7</button>
                                    </div>

                                    <div id="Dan1" class="tabcontent">
                                        <?php iscrtajRepertoar(0); ?>
                                    </div>

                                    <div id="Dan2" class="tabcontent">
                                        <?php iscrtajRepertoar(1);?>
                                    </div>

                                    <div id="Dan3" class="tabcontent">
                                        <?php iscrtajRepertoar(2);?>
                                    </div>

                                    <div id="Dan4" class="tabcontent">
                                        <?php iscrtajRepertoar(3);?>
                                    </div>

                                    <div id="Dan5" class="tabcontent">
                                        <?php iscrtajRepertoar(4);?>
                                    </div>

                                    <div id="Dan6" class="tabcontent">
                                        <?php iscrtajRepertoar(5);?>
                                    </div>

                                    <div id="Dan7" class="tabcontent">
                                        <?php iscrtajRepertoar(6);?>
                                    </div>
                        </div>
               </div>   
        </div>
    </body>
</html>