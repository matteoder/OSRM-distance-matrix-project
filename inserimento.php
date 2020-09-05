<?php 
session_start();
include 'functions.php';
$dimensione=$_SESSION['dimensione'];
//echo firstnnum($dimensione);
$link = mysqli_connect("localhost","root","","collegali");
$conta=0;
$count=mysqli_query($link,"SELECT count(*) FROM distanze_poitemp");
while($count1 = mysqli_fetch_assoc($count)){
    foreach($count1 as $c){
        $conta=$c;
    }
}


$totale= firstnnum($dimensione);
$percentage = (($conta) / ($totale*6)) * 100;
$_SESSION['percentuale']=$percentage;
?>
<html>
<head><title>HTML1</title>
<link rel="stylesheet" type="text/css" href="styled.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<pre >la tabella temporanea e' stata riempita <?php 
if($percentage==100){
    echo "completamente (".$percentage."%).";
}else{
    echo "non completamente  (".$percentage."%)-- errore nella procedura.";
} ?> <br>
inserire tutti i valori ottenuti?</pre>

<form action="script.php" method="post">

<button name="no1" class="button1">no e correggi</button>
</form>


<form action="finalpage.php" method="post">

<button name="si" class="button1">si</button>

</form>


</body>
</html>

