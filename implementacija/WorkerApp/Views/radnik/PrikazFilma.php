<!doctype html>
<html lang="en">
    <head>
      
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Registracija Korisnika</title>
        
    </head>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type='text/javascript'>

var datum;
var film;
function azurirajDatum()
{
    var data={
        'film':document.getElementById('film').value
    };
    var baseUrl = '<?php echo site_url() ?>';
    $.post(baseUrl+'/IzborTermina/azurirajDatum',data,function (data)
    {
        var obj=JSON.parse(data);
        var x=document.getElementById('datum');
        x.innerHTML="<select name='datum' onChange='azurirajFilm()' id='datum'>";

        for (var i=0;i<obj.length;i++)
        {
            x.innerHTML+="<option value="+obj[i].Datum+">"+obj[i].Datum+"</option>"
        }
        x.innerHTML+="</select>";
        pogledajTermine();
    });
}

function azurirajFilm()
{
   var data={
        'datum':document.getElementById('datum').value
    };
    var baseUrl = '<?php echo site_url() ?>';
    $.post(baseUrl+'/IzborTermina/azurirajFilm',data,function (data)
    {
        var obj=JSON.parse(data);
        var x=document.getElementById('film');
        x.innerHTML="<select name='film' onChange='azurirajDatum()' id='film'>";
        //x.innerHTML+="<option value='NULL'>Izaberite jedan</option>";
        for (var i=0;i<obj.length;i++)
        {
            x.innerHTML+="<option value="+obj[i].FilmID+">"+obj[i].Naziv+"</option>"
            //console.log(obj[i]);
        }
        x.innerHTML+="</select>";
     //   if (document.getElementById('datum').value!=NULL && document.getElementById('film').value!=NULL)
        pogledajTermine();
    });
}

function pogledajTermine()
{
    //if (document.getElementById('datum').value!=NULL && document.getElementById('film').value!=NULL)
    //{
        var data={
        'datum':document.getElementById('datum').value,
        'film':document.getElementById('film').value
    };
    var baseUrl = '<?php echo site_url() ?>';
    $.post(baseUrl+'/IzborTermina/azurirajTermin',data,function (data)
    {
        var obj=JSON.parse(data);
        var x=document.getElementById('termin');
        x.innerHTML="<select name='termin' id='termin'>";
        //x.innerHTML+="<option value='NULL'>Izaberite jedan</option>";
       for (var i=0;i<obj.length;i++)
        {
            x.innerHTML+="<option value="+obj[i].TerminID+">"+obj[i].PocetakTermina+"</option>"
            //console.log(obj[i]);
        }
        x.innerHTML+="</select>";
        document.getElementById('submit').disabled=false;
    });

    //}
}

function reset()
{
    location.reload();
}
</script>    


    <body onload='pogledajTermine()' style="overflow-x: hidden;">
        <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1" style="font-size: 30px;">Cinerman</span>
            <form class="form-inline my-2 my-lg-0" name="backLogoutform" action="<?= site_url("Radnik/vratiIzadji") ?>" method="post">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <input name="vratiSe" type="submit" class="btn btn-outline-secondary my-2 my-sm-0" value="Vrati se" style="width: 100px;">
                        </td>
                        <td width="50%" align="center">
                            <input name="logout" type="submit" class="btn btn-outline-danger my-2 my-sm-0" value="Log out" style="width: 100px;">
                        </td>
                    </tr>
                </table>
            </form>
        </nav>
        <div class="row mt-3">
            <div class="offset-sm-3 col-sm-6 ">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center" >
                        <p>Izaberite datum</p>
                        <select class="btn btn-light btn-outline-dark dropdown-toggle" name='datum' onChange='azurirajFilm()' id='datum'>
                        
                        <?php foreach ($datumi as $row)
                            {
                            $pom=$row['Datum'];
                            echo "<option value=$pom>$pom</option>";
                            }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                        <p>Izaberite film</p>
                        <select class="btn btn-light btn-outline-dark dropdown-toggle" name='film' onChange='azurirajDatum()' id='film'>
                        
                        <?php
                        foreach ($filmovi as $row)
                        {
                            $pom=$row['FilmID'];
                            $p2=$row['Naziv'];
                            echo "<option value=$pom>$p2</option>";
                        }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <?php
                                 echo form_open("IzborSedista","method=post");
                                 echo "<select class='btn btn-light btn-outline-dark dropdown-toggle' name='termin' id='termin'>";
                                 echo "</select></br>";
                           
                        echo '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td width="50%" align="center">';
                            echo '<input type="submit" id="submit" name="submit" class="btn btn-dark btn-lg btn-outline-light" value="Predji na kupovinu" disabled="true" />';
                            echo form_close();
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                        <input type="button" onclick="reset()" class="btn btn-dark btn-lg btn-outline-light" value="Resetuj"/>
                        </td> 
                    </tr>
                </table>   
            </div>
        </div>
        <footer class="page-footer font-small blue fixed-bottom bg-dark text-white">
            <div class="footer-copyright text-center py-3"> © Cinerman Zaposleni App - Brute Force 2020
            </div>
        </footer>
    
<script>
// Disable form submissions if there are invalid fields    
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
      
        <!-- My CSS Style --> 
        <style>
        .btn  {width: 250px;}
        </style>
       
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <!--  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        --><script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
