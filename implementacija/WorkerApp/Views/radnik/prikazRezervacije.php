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
var korisnikID;
function proveriIme()
{
    
    if (document.getElementById('korIme').value=='')
        return;
        document.getElementById("alert").innerHTML = "";
    var data={
        'korIme':document.getElementById('korIme').value
    };
    korisnikID=document.getElementById('korIme').value;
    $.post("PotvrdaRezervacija/akcija",data, function (data)
    {
        var obj= JSON.parse(data);
        console.log(obj);
        if(obj.termini.length==0)
        {
            //ovde boot
            string="<div class='alert alert-danger' role='alert'>Korisnik nema rezervaciju!</div>";
            document.getElementById("alert").innerHTML = string;
        }
        else
        {
            var x=document.getElementById('termini');
            document.getElementById('otkazi').disabled=false;
            document.getElementById('podigni').disabled=false;
            x.disabled=false;
            x.innerHTML="";
            x.innerHTML="<select id='termini' name='ddliste'>";
            for (var i=0;i<obj.termini.length;i++)
            {
                x.innerHTML+="<option value="+obj.termini[i].TerminID+">"+
                obj.termini[i].Naziv+" "+
                obj.termini[i].Datum+" "+
                obj.termini[i].Pocetak+" "+
                obj.termini[i].Sala
                +"</option>";
                console.log(document.getElementById('termini').innerHTML);
            }
            x.innerHTML+="</select>";

        }
    });
}
function otkazi()
{
    var data={
        'korIme':korisnikID,
        'termin':document.getElementById('termini').value
    };
    $.post("/PotvrdaRezervacija/otkaz",data,function(data)
    {
        document.getElementById('termini').disabled=true;
        document.getElementById('otkazi').disabled=true;
        document.getElementById('podigni').disabled=true;
    });
}
function podigni()
{
    var data={
        'korIme':korisnikID,
        'termin':document.getElementById('termini').value
    };
    $.post("/PotvrdaRezervacija/potvrda",data, function(data)
    {
        //ovde bott        alert("cena iznosi: "+data);
        string="<div class='alert alert-success' role='alert'>Cena karata je "+data+"</div>";
        document.getElementById("alert").innerHTML = string;
        document.getElementById('termini').disabled=true;
        document.getElementById('otkazi').disabled=true;
        document.getElementById('podigni').disabled=true;
    });
}
</script> 
    <body style="overflow-x: hidden;">
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
        <div id="alert">
      </div>
        <div class="row mt-3">
            <div class="offset-sm-3 col-sm-6 ">
                <table class="table table-borderless" width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <input name="korIme" type="text" class="form-control" placeholder="Korisnicko ime" id="korIme" required>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <input name="korisnik" type="button" class="btn btn-dark btn-lg btn-outline-light" onClick='proveriIme()' value="Unesi korisnicko ime">
                        </td> 
                    </tr>
                    <tr >
                    <td width="50%" align="center">
                    <select class='btn btn-light btn-outline-dark dropdown-toggle' id='termini' disabled='true' name='ddliste'>
                    </select>
                   
                    </br>
                    </td>
                    </tr>
                    <tr >
                    <td width="50%" align="center">
                    <input id="podigni" type="button" class="btn btn-dark btn-lg btn-outline-light" onClick='podigni()' value="Izvrsi kupovinu" disabled='true'>
                    </td>
                    </tr>
                    <tr>
                    <td width="50%" align="center">
                    <input id="otkazi" type="button" class="btn btn-dark btn-lg btn-outline-light" onClick='otkazi()' value="Otkazi rezervaciju" disabled='true'>                   
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
         </body>
</html>
