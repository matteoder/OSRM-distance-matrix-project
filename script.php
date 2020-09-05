


<?php

session_start();

ini_set('implicit_flush', 1);
ob_implicit_flush(1);
include 'functions.php';
if(isset($_POST['test1']) || isset($_POST['no1'])){
    echo "<body style="."background-color:#FCFAF9;".">";
    my_flush();
    echo "<pre>caricamento...</pre>";
    my_flush();
    
    $link = mysqli_connect("localhost","root","","nomeDB");
    
    
    
   mysqli_query($link,"DELETE FROM distanze_poitemp");
        //tempo massimo di esecuzione aumentato a 15 minuti
        
   set_time_limit(0);
        
      //array necessari per salvare id e coordinate
     
     $id_arr=array();
     $lat_arr=array();
     $lon_arr=array();
     
    
    if($link===FALSE){
        die("ERROR: could not connect.".mysqli_connect_error());
    }
    
   
    //query per recuperare id e coordinate da poi
         $sql1=mysqli_query($link,"SELECT id FROM poi");
         while($row1 = mysqli_fetch_assoc($sql1)){
             foreach($row1 as $id){
                 $id_arr[]=$id;
             }
         }
         $sql2=mysqli_query($link,"SELECT lat FROM poi");
         while($row2 = mysqli_fetch_assoc($sql2)){
             foreach($row2 as $lat){
                 $lat_arr[]=$lat;
             }
         }
         $sql3=mysqli_query($link,"SELECT lon FROM poi");
         while($row3 = mysqli_fetch_assoc($sql3)){
             foreach($row3 as $lon){
                 $lon_arr[]=$lon;
             }
         }
         $_SESSION['dimensione']=sizeof($lat_arr);
         
         
     matrix(0,0,$lon_arr,$lat_arr,$id_arr,"car",$link,1);
     
     //funzione
     
     matrix(0,0,$lon_arr,$lat_arr,$id_arr,"foot",$link,3);
     
     
     
     matrix(0,0,$lon_arr,$lat_arr,$id_arr,"bicycle",$link,2);
     
   
     echo '<script type="text/javascript">';
     echo 'alert("caricamento completato!");';
     echo 'window.location.href = "inserimento.php";';
     echo '</script>';
     
    }
    
 
    ?>
   </body>
    </html>
