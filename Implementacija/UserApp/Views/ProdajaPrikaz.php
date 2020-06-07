<html>
<head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Cinerman bioskop</title>
</head>
<style>

.btn  {width: 250px;}
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
body {
 
 overflow-x: hidden; /* Hide horizontal scrollbar */
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
var obj ={"polja":[],
    "terminID":"<?php echo $termin?>"
};
var korID;
function ucitavanje()
{

   if("<?php if(isset($korID)) echo $korID; else echo "";?>"=="")
   {
        document.getElementById("d1").disabled=true;
        document.getElementById("d2").disabled=true;
        string="<div class='alert alert-danger' role='alert'>Da bi izvrsili kupovinu/rezervaciju potrebno je da se ulogujete</div>";
        document.getElementById("alert").innerHTML = string;
       
        return;
   }
      korID="<?php print_r ($korID);?>";
}
function izaberi(ele)
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
    
    if (obj.polja.length==4)
        return;
    
    let ukupno = (obj.polja.length + 1) * <?php echo $cena; ?>;
    
    if(<?php if(isset($_SESSION["userLoyalty"])) echo $_SESSION["userLoyalty"]; else echo 2;?> == 1) {
        ukupno = ukupno * 0.9;
    }

    document.getElementById("cena").innerHTML = "Cena vasih karata iznosi: " + ukupno + " RSD";

    obj.polja[obj.polja.length]=ele.id;
    ele.className='izabrano';

    
    
}
function kupi()
        {   
        if (obj.polja.length==0)
        {
            string="<div class='alert alert-danger' role='alert'>Niste izabrali mesta!</div>";
            document.getElementById("alert").innerHTML = string;
            return;
        }
        //ovde treba da uzima korisnicko ime iz sesije
        console.log("Ovde sam");
        obj["korisnickoIme"]=korID;
        var baseUrl = '<?php echo site_url() ?>';
            $.post(baseUrl + "/Prodaja/Placanje", obj,function(data, status)
            {
                console.log(data);
                var myObj = JSON.parse(data);
                    string="<div class='alert alert-success text-center' role='alert'>Uspesno ste kupili karte za film. Cena karte iznosi: " + myObj.cena + " RSD</div>";
                    document.getElementById("alert").innerHTML = string;
                    for (var i=0;i<obj.polja.length;i++)
                    {
                        document.getElementById(obj.polja[i]).className='zauzeto';
                    }
                    obj.polja=[];
            });
        }

function rezervisi(){

            console.log("Usao sam ovde");
            if (obj.polja.length==0)
        {
            string="<div class='alert alert-danger' role='alert'>Niste izabrali mesta!</div>";
            document.getElementById("alert").innerHTML = string;
            return;
        }
        //isto uzima id od sesije 
        obj["korisnickoIme"]=korID;
        var baseUrl = '<?php echo site_url() ?>';
            $.post(baseUrl + "/Prodaja/Rezervisi", obj,function(data, status)
            {
                console.log(data);
                var myObj = JSON.parse(data);
                string="<div class='alert alert-success text-center' role='alert'>Uspesno ste rezervisali karte za film</div>";
                document.getElementById("alert").innerHTML = string;
                for (var i=0;i<obj.polja.length;i++)
                {
                    document.getElementById(obj.polja[i]).className='zauzeto';
                }
                obj.polja=[];    
            })
        }
</script>
<body onLoad="ucitavanje()" >
<div id="alert">   
</div>
<div class="row mt-3 pt-4" >

   
    <?php
   echo "<div class=\"col-sm-12 col-md-12 row text-center p-5\">";

   echo "<div class=\"col-sm-12 col-md-3 text-center \">";
   $slikaLink=base_url($film->Slika);
   echo "<img src=$slikaLink width=\"90%\" height=450>";
   echo "</div>";

   echo "<div class=\"col-sm-6 col-md-3 text-left\">";
           echo "<h3 style=\"text-align:center;\" class=mb-3><b>$film->Naziv</b></h3>";
           echo "<p><b>Reditelj</b>: $film->Reditelj</p>";
           echo "<p><b>Zanr</b>: $film->Zanr</p>";
           echo "<b>Uloge</b>:";
           echo "<p>$film->Uloge</p>";
           echo "<p><b>Trajanje filma</b>: $film->Trajanje min</p>";
           echo "<p><b>Godina premijere</b>: $film->GodinaPremijere.</p>";
           echo "<p><b>Cena</b>: $cena RSD</p>";
           echo "<p><b>Opis</b>: $film->Opis</p>";
           
   echo "</div>";
    ?>
 <div  class="col-md-3 col-sm-12">
<?php
$brVrsta=$sala->BrVrsta;
$brKolona=$sala->BrKolona;
$stSed=$sedista;

echo "<table class='table table-borderless' width='100%' height=450>";
$k=0;
for ($i=0;$i<$brVrsta;$i++)
{
    echo "<tr>";                                
    for ($j=0;$j<=$brKolona;$j++)
    {
        if ($j==0)
        {
            $pomocna=$i+1;
            echo "<td width='10%'>$pomocna</td>";
            continue;
        }   
        if($k==count($stSed)) 
        {//ovo je resavalo neku gresku nmg sad da se setim koju
            $pom=$i*$brKolona+$j;
            echo "<td class='slobodno' onclick='izaberi(this)' id='$pom' ></td>";
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
            echo "<td class='slobodno' id='$pom' onclick='izaberi(this)'></td>";
        }
    }
    echo "</tr>";
}
echo "</table>";
?></div>

<div class="col-md-3 col-sm-12" >
 <div>
 <input type="button" onclick='kupi()' class="btn btn-dark btn-lg mt-5 mb-5" value="Kupi" id='d1'></input>
 </div>
 <div>
 <input  type="button" onclick='rezervisi()' class="btn btn-dark btn-lg " value="Rezervisi" id='d2'></input>
 </div>
 <div class="mt-5" id="cena" style="font-size:20px">

 </div>
 </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</body>
</html>