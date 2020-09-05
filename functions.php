<?php


function matrix($k,$k1,array $lon_arr,array $lat_arr,array $id_arr,$type,$link,$id_mezzo){
    
    //sessione iniziata
    $curlSES=curl_init();
    //due cicli for per ciclare le coordinate
    mysqli_query($link,"BEGIN");
    $contatore=0;
    $contatore2=0;
    for($j=$k;$j<sizeof($lat_arr);++$j){
       
        for($i=$j+1+$k1;$i<sizeof($lat_arr);++$i){
            
            mysqli_query($link,"SAVEPOINT s1");
            ++$contatore;
            
            //costruzione della richiesta GET al server OSRM
            $url="http://###########/table/v1/".$type."/".$lon_arr[$j].",".$lat_arr[$j].";".$lon_arr[$i].",".$lat_arr[$i]."?annotations=distance,duration";
            //indici utili per tenere traccia delle coppie calcolate
          
          
     
            curl_setopt($curlSES,CURLOPT_URL,$url);
            curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curlSES,CURLOPT_HEADER, false);
            $result=curl_exec($curlSES);
           
            
            
            //il risultato json viene convertito in array
            $car=json_decode($result,true);
            
            if($contatore==10){
                mysqli_query($link,"SAVEPOINT s1");
                $contatore=0;
                ++$contatore2;
            }
            
            //in caso di errore:
           
            if($car==NULL){
                curl_close($curlSES);
                mysqli_query($link,"ROLLBACK TO SAVEPOINT s1");
                mysqli_query($link,"COMMIT");
             
                
                //$_SESSION['contatore']=$contatore2;
                echo '<script type="text/javascript">';
                echo 'alert("errore di connessione");';
                echo 'window.location.href = "inserimento.php";';
                echo '</script>';
               
                exit("errore");
            } elseif($result === false){
            
                echo 'Curl error: ' . curl_error($result);
                my_flush();
                curl_close($curlSES);
                mysqli_query($link,"ROLLBACK TO SAVEPOINT s1");
                mysqli_query($link,"COMMIT");
        
               
                //$_SESSION['contatore']=$contatore2;
                echo '<script type="text/javascript">';
                echo 'alert("errore");';
                echo 'window.location.href = "inserimento.php";';
                echo '</script>';
              
                exit("errore");
            }
            
           
            $durata1=ceil(($car['durations'][0][1]/600));
            $durata2=ceil(($car['durations'][1][0]/600));
            
            //inserimento nel db--1a insert
            $sql="INSERT INTO distanze_poitemp (idpoi_da,idpoi_a,idmezzo,distanza_minuti,distanza_metri)
     VALUES('".$id_arr[$j]."','".$id_arr[$i]."','".$id_mezzo."','".$durata1."','".$car['distances'][0][1]."') ON DUPLICATE KEY UPDATE idpoi_da=idpoi_da";
            if(!mysqli_query($link,$sql)){
                echo "<td>error:could not able to execute $sql</td>".mysqli_error($link);
                my_flush();
                curl_close($curlSES);
                mysqli_query($link,"ROLLBACK TO SAVEPOINT s1");
                mysqli_query($link,"COMMIT");
              
                
                //$_SESSION['contatore']=$contatore2;
                echo '<script type="text/javascript">';
                echo 'alert("errore");';
                echo 'window.location.href = "inserimento.php";';
                echo '</script>';
             
                exit("errore");
                
            }
            
           //inserimento nel db--2a insert
            $sql2="INSERT INTO distanze_poitemp (idpoi_da,idpoi_a,idmezzo,distanza_minuti,distanza_metri)
        VALUES( '".$id_arr[$i]."','".$id_arr[$j]."','".$id_mezzo."','".$durata2."','".$car['distances'][1][0]."') ON DUPLICATE KEY UPDATE idpoi_da=idpoi_da";
            if(!mysqli_query($link,$sql2)){
                echo "<td>error:could not able to execute $sql2</td>".mysqli_error($link);
                my_flush();
                curl_close($curlSES);
                mysqli_query($link,"ROLLBACK TO SAVEPOINT s1");
                mysqli_query($link,"COMMIT");
                
               // $_SESSION['i']=$i;

                //$_SESSION['contatore']=$contatore2;
                echo '<script type="text/javascript">';
                echo 'alert("errore");';
                echo 'window.location.href = "inserimento.php";';
                echo '</script>';
               
                exit("errore");
                
                                    }
      
          
     }
    }
    mysqli_query($link,"COMMIT");
        //sessione chiusa
        curl_close($curlSES);
      
       echo "procedura ".$type." completata"."<br>";
       my_flush();
                                                                                     

           
   
    
    
}


//funzione per il calcolo dei minuti

    
    /// minuti
    
   

//funzione utile per la percentuale di completamento
function firstnnum($value){
    $k=0;
    for($i=0;$i<$value;$i++){
        $k+=$i;
    }
    return $k;
}
function my_flush() {
    // following matt at hevanet's lead
    for ($i=0;$i<10000;$i++) echo ' ';
    ob_flush();
    flush();
}

    



?>