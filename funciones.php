<?php


function conectarse(){
   #$con = mysqli_connect("localhost","root","joel8207","pacvet");
   $con = mysqli_connect("162.241.224.35","mitrende_pacvet","joel8207","mitrende_pacvet");
   
 
    
   if (!$con){
    echo "Fallo la conneccion :(";
     die('Could not connect: ' . mysqli_error($con));
   }
   //echo $con; 
   return $con;
 }

/*
// SQL server Connection
function conectarse(){

    $serverName = ".";
    $connectionInfo = array( "Database"=>"pacientes", "UID"=>"sa", "PWD"=>"Alex1982@");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    
    if (!$conn){die('Could not connect: ' . mysql_error());}

    return $conn;
}
*/


/* Connect to the local server using Windows Authentication and
specify the AdventureWorks database as the database in use. 

$serverName = ".";
$connectionInfo = array( "Database"=>"pacientes", "UID"=>"sa", "PWD"=>"Alex1982@");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ){
	 echo "Fallo la conneccion :(";
     //echo "Could not connect.\n";
     //die( print_r( sqlsrv_errors(), true));
}else{
	
		$stmt = sqlsrv_query( $conn, "SELECT * FROM ofta.pacientes");
		if ( $stmt ){
			echo "1";	
		}else{
		die( print_r( sqlsrv_errors(), true));
			//echo "Fallo el insert ".$dato;
		}

}
*/
/* Free statement and connection resources. 
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
*/

function buscavacdes($value1, $value2){
   $query = "  select b.Nombrepac,a.pacID,fecha,peso,temp,producto,fechaProx,observaciones,tipoID,a.enabled,c.Nombre,c.apeidos
         from vac_desp a
         JOIN pacientes b on a.pacID = b.pacID
         JOIN users c ON a.userID = c.userID
         where a.pacID = ".$value1.  " and fecha = '" .$value2."'";
         //echo nl2br($query."\n");

      $conn = conectarse();
      $stmt = mysqli_query( $conn, $query);
      if( $stmt === false ) {
         echo nl2br($query."\n");
         echo nl2br("\n");
         echo nl2br("Error:".mysqli_error($conn)."\n");
      }else{
            //$restme = sqlsrv_has_rows( $stmt );
            if(mysqli_num_rows($stmt) >0){
                  while($rows = mysqli_fetch_assoc($stmt)) {
                        $data_array = array(
                              $rows['Nombrepac'],        //0
                              $rows['pacID'],            //1
                              $rows['fecha'],            //2
                              $rows['peso'],             //3
                              $rows['temp'],             //4
                              $rows['producto'],         //5
                              $rows['fechaProx'],        //6
                              $rows['observaciones'],    //7
                              $rows['tipoID'],           //8
                              $rows['enabled'],          //9
                              $rows['Nombre'],           //10
                              $rows['apeidos']           //11
                     );
                  }    
            }else{
               $data_array = array("","","2020-11-01 15:16:06","","","","","","","");
            }
      }      
      return  $data_array;
}
function encontrar($n_mes){
   $meses = array("January","February","March","April","May","June","July","August","September","October","November","December");
   for($i=0; $i < 12 ; $i++){
     if ($meses[$i] == $n_mes){
	$estas = $i + 1;
	 return $estas;
	break;
     }
   }

}
function encuentra($n_mes){
   if($n_mes ='Junary'){
      return("bien");
   }

}
function encryptme($value){
   // Store a string into the variable which
   // need to be Encrypted
   $simple_string = "Welcome to GeeksforGeeks\n";
   
   // Display the original string
   //echo "Original String: " . $simple_string;
   
   // Store the cipher method
   $ciphering = "AES-128-CTR";
   
   // Use OpenSSl Encryption method
   $iv_length = openssl_cipher_iv_length($ciphering);
   $options = 0;
   
   // Non-NULL Initialization Vector for encryption
   $encryption_iv = '1234567891011121';
   
   // Store the encryption key
   $encryption_key = "GeeksforGeeks";
   
   // Use openssl_encrypt() function to encrypt the data
   $encryption = openssl_encrypt($value, $ciphering,
               $encryption_key, $options, $encryption_iv);
   
   // Display the encrypted string
   //echo "Encrypted String: " . $encryption . "\n";

   return $encryption;
}
function decryptme($value){
   echo nl2br($value."\n");
   // Store the cipher method
   $ciphering = "AES-128-CTR";
   
   // Use OpenSSl Encryption method
   $iv_length = openssl_cipher_iv_length($ciphering);
   $options = 0;

 // Non-NULL Initialization Vector for decryption
 $decryption_iv = '1234567891011121';
   
 // Store the decryption key
 $decryption_key = "GeeksforGeeks";
 
 // Use openssl_decrypt() function to decrypt the data
 $decryption=openssl_decrypt ($value, $ciphering, 
       $decryption_key, $options, $decryption_iv);
 
 // Display the decrypted string
 //echo "Decrypted String: " . $decryption;
 return $decryption;
}



?>