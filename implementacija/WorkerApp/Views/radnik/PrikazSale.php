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
<style>
    .zauzeto
{
      
    border-radius:5px;
    background-color: #4d4d4d;
}
.slobodno
{
       
    border-radius:5px;
    background-color:#e1e1d0;
}
.izabrano
{
    
    border-radius:5px;
    background-color: #990000;

}
</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type='text/javascript'>
    var obj ={"polja":[],
    "terminID":"<?php echo $termin?>"
    }
        function pritisnut(ele)
        {
            if(ele.className=='izabrano')
            {
                ele.className='slobodno';
                for (var i=0; i<obj.polja.length;i++)
                {
                    if (obj.polja[i]==ele.id)
                    {
                        obj.polja.splice(i,1);
                        break;
                    }
                }
                return;
            }
            if (ele.className=='zauzeto')
                return;
            //if (obj.polja.length==5) return;
            
            obj.polja[obj.polja.length]=ele.id;
            ele.className='izabrano';
        }
        function kupi()
        {   
        if (obj.polja.length==0)
        {
            string="<div class='alert alert-danger alert-dismissible' role='alert'>Niste izabrali mesta!</div>";
            document.getElementById("alert").innerHTML = string;
            return;
        }
        if (document.getElementById('korisnickoIme').value=="")
        obj["korisnickoIme"]="";
        else
        obj["korisnickoIme"]=document.getElementById('korisnickoIme').value;
        var baseUrl = '<?php echo site_url() ?>';
            $.post(baseUrl + "/IzborSedista/Placanje", obj,function(data, status)
            {
                console.log(data);
                var myObj = JSON.parse(data);
                if (myObj.status=='ok')
                {
                    string="<div class='alert alert-success alert-dismissible' role='alert'>Cena je: " +myObj.cena+ "</div>";
                    document.getElementById("alert").innerHTML = string;
                    //alert("cena je "+myObj.cena);
                    for (var i=0;i<obj.polja.length;i++)
                    {
                        document.getElementById(obj.polja[i]).className='zauzeto';
                    }
                    obj.polja=[];
                }
                else
                {
                    string="<div class='alert alert-danger alert-dismissible' role='alert'>Doslo je do greske pokusajte opet</div>";
                    document.getElementById("alert").innerHTML = string;
                    //alert('niste uneli korisnicko ime loyaliti korisnika');
                    for (var i=0;i<obj.polja.length;i++)
                    {
                        document.getElementById(obj.polja[i]).className='slobodno';
                    }
                    obj.polja=[];
                }

            })
        }
        function rezervisi()
        {
            if (obj.polja.length==0)
        {
            string="<div class='alert alert-danger alert-dismissible' role='alert'>Niste izabrali mesta!</div>";
            document.getElementById("alert").innerHTML = string;
            //alert ("niste izabrali polja");
            return;
        }
        if (document.getElementById('korisnickoIme').value=="")
        {
            string="<div class='alert alert-danger alert-dismissible' role='alert'>Niste uneli korisnicko ime!</div>";
            document.getElementById("alert").innerHTML = string;
            //alert('niste uneli korisnicko ime');
            for (var i=0;i<obj.polja.length;i++)
            {
                document.getElementById(obj.polja[i]).className='slobodno';
            }
            obj.polja=[];
            return;
        }
        obj["korisnickoIme"]=document.getElementById('korisnickoIme').value;
        var baseUrl = '<?php echo site_url() ?>';
            $.post(baseUrl + "/IzborSedista/Rezervisi", obj,function(data, status)
            {
                console.log(data);
                var myObj = JSON.parse(data);
                if (myObj.status=='ok')
                {
                    string="<div class='alert alert-success alert-dismissible' role='alert'>Rezervisano je!</div>";
                    document.getElementById("alert").innerHTML = string;
                    //alert("rezervisano je");
                    for (var i=0;i<obj.polja.length;i++)
                    {
                        document.getElementById(obj.polja[i]).className='zauzeto';
                    }
                    obj.polja=[];
                }
                else
                {
                    string="<div class='alert alert-danger alert-dismissible' role='alert'>Doslo je do greske pokusajte opet</div>";
                    document.getElementById("alert").innerHTML = string;
                    //alert('niste uneli validno korisnicko ime');
                    for (var i=0;i<obj.polja.length;i++)
                    {
                        document.getElementById(obj.polja[i]).className='slobodno';
                    }
                    obj.polja=[];
                }

            })
        }
</script>
<style>
.polje{
    border-radius: 5px;
   padding: 3px;
  width: 5px;
  height: 5px;
}
</style>
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
                    <tr width='10px' height='10px'>
                        <td width="50%" align="center" rowspan=3 >
                           <?php
                            $brVrsta=$brSed[0]['BrVrsta'];
                            $brKolona=$brSed[0]['BrKolona'];
                            
                          
                            echo "<table>";
                        
                            $k=0;
                            for ($i=0;$i<$brVrsta;$i++)
                            {
                                echo "<tr>";
                                
                                for ($j=0;$j<=$brKolona;$j++)
                                {
                                    if ($j==0)
                                    {
                                    $pomocna=$i+1;
                                    echo "<td >$pomocna</td>";
                                    continue;
                                    } 
                                   if($k==count($stSed)) {
                                      $pom=$i*$brKolona+$j;
                                        echo "<td class='slobodno'  onclick='pritisnut(this)' id='$pom'></td>";
                                       continue;   
                                   }
                                    if ($i*$brKolona+$j==$stSed[$k]['BrojSedista'])
                                    {   
                                        $k++;
                                        echo "<td class='zauzeto' ></td>";
                                    }   
                                    else
                                    {
                                        $pom=$i*$brKolona+$j;
                                        echo "<td class='slobodno' onclick='pritisnut(this)' id='$pom'></td>";
                                    }
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                           ?> 
                        </td>
                        
                        <td width="50%" align="center">
                            <br>
                            <br>
                            <input type='text' class="form-control" placeholder="Unesite korisnicko ime" name='korisnickoIme' id='korisnickoIme'>
                            <br>
                        
                        <button type="button" onclick="kupi()" class="btn btn-dark btn-lg btn-outline-light">Kupi</button>
                        <br>
                        
                       
                         <br>
                        <button type="button" onclick="rezervisi()" class="btn btn-dark btn-lg btn-outline-light">Rezervisi</button>
                       
                        </td>
                        
                    </tr>
                </table>   
            </div>
        </div>
        <footer class="page-footer font-small blue fixed-bottom  bg-dark text-white">
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
    <!--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    -->    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
