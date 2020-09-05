
<!doctype html>
<html>
<head><title>HTML1</title>
<link rel="stylesheet" type="text/css" href="styled.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>INSERIMENTO</h1>
<p>questa semplice interfaccia e' pensata con lo scopo 
di fornire un semplice input al fine di inserire distanze e durate 
all'interno della tabella <strong>distanze_poi</strong> tramite le api di OSRM.</p>
<blockquote>


<cite>(per maggiori informazioni visita <a href="http://project-osrm.org/">OSRM)</a></cite>
</blockquote>
<h2>procedura</h2>
<ul>

<li>composizione di un array di id e di coppie latitudine-longitudine dalla tabella <strong>poi</strong> tramite le coordinate</li>
<li>utilizzo delle coordinate per fare richieste in coppia al <strong>server OSRM</strong> di tipo "table"<br>
ottenendo una risposta in formato <strong>json</strong> che presenta due sottocampi <strong>distances</strong> e <strong>duration</strong> <br>
il quale verra' successivamente convertita in array, dacui si potranno ricavare i valori dei sottocampi gia' citati 
  </li>
<li>dalle mini-matrici 2x2 vengono prelevati i valori di interesse</li>
<li>i valori vengono immediatamente posti dentro la tabella temporanea <strong>distanze_poitemp</strong></li>
<li>a seconda della scelta fatta nella pagina finale,si possono inserire i dati nella tabella ufficiale <br>
oppure, in caso di errori nello svolgimento dell'operazione, si puo' svuotare la tabella temporanea e ricominciare da capo <br>
oppure ripartire </li>
</ul>

 <form action="script.php" method="post"> 


<button name="test1" class="button1" >trasferisci</button>

  </form> 


<form action="provaHTML.php" method="post">
<button name="delete" class="button1">ripulisci tabella</button>

</form>
</body>
<?php
session_start();

if(isset($_POST['delete'])){
    $link = mysqli_connect("localhost","root","","collegali");
    $sql = "DELETE FROM distanze_poi";
    mysqli_query($link,$sql);
}

?>