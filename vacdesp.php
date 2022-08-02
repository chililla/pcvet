<!DOCTYPE html>
<html lang="en">

<!--<head>
    <title>Patient Control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/myfunc.js"></script>
</head>-->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script type="text/javascript" src="js/myfunc.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>

    <title>Patient Control</title>
</head>
<body>
<form name="principal"  method="post" onsubmit="return false;" >
<?php
    include "funciones.php";

    if (!isset($_COOKIE["pcvet"])) {
        echo '<script type="text/javascript">llama("login.php")</script>';
      } else {

        //echo nl2br("Value is: " . $_COOKIE["pcvet"]."\n");
        
        $cookme = $_COOKIE["pcvet"];
        //echo '<script type="text/javascript">alert("cookie value: '.$cookme.'")</script>';

        if($cookme == 'novalue'){
            echo '<script type="text/javascript">llama("login.php")</script>';
        }else{
            $cookme = explode("@",$_COOKIE["pcvet"]);
            //echo nl2br("userID: ". $cookme[0]."\n");
            //echo nl2br("sectionID: ". $cookme[1]."\n");
            
            $query = "SELECT utypeID,nombre, apeidos FROM users WHERE enabled = 1 and sectionID = ".$cookme[1]." and userID = ".$cookme[0];
            //echo $query;
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            
              while($rows = mysqli_fetch_assoc($stmt)) {
                  $menus = array(
                      $rows['utypeID'],
                      $rows['nombre'],
                      $rows['apeidos']
                  );
              }                

        }
      }  


    if( isset($_POST['elemento1']) )
    {   
        $txtnombre = $_POST['txtnombre'];
        $element1 = $_POST['elemento1'];
        $nombre = 'sigues';

        //echo $txtnombre;
        //echo $element1;

        if(strlen($element1)>0){
            $dateme = explode("@", $element1);
            //echo nl2br( count($dateme)."\n");
            if(count($dateme)==2){
                $data_array = buscavacdes($dateme[0],$dateme[1]);
                if($data_array[8] == 2){
                    echo '<script type="text/javascript">document.getElementById("despa").checkedy=true;</script>';
                 }else{
                    echo '<script type="text/javascript">document.getElementById("vac").checkedy=true;</script>';
                 }  
            }else{
               $txtpeso = $_POST['txtpeso'];
               $txttemp = $_POST['txttemp'];
               $txtprod = $_POST['txtprod'];
               $txtprox = $_POST['txtprox'];
               $txtplan = $_POST['txtplan'];
               if($dateme[1]=='true'){$type=2;}else{$type=1;}
                //echo  nl2br($dateme[0]."   ".$dateme[1]."    ".$dateme[2]."    ".$dateme[3]."\n");
                if($dateme[0] == 'Piolasa'){
                    $query= " Update vac_desp set peso='".$txtpeso."', temp='".$txttemp."', producto='".$txtprod."', fechaProx='".$txtprox."', observaciones='".$txtplan."', tipoID=".$type.", updatedate=NOW() 
                              where pacID = ".$dateme[2].  " and fecha = '" .$dateme[3]."'";
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                  
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                    }else{
                        $data_array = buscavacdes($dateme[2],$dateme[3]);
                    }
                    $element1 = $dateme[2]."@".$dateme[3];
                }
                if($dateme[0] == 'delete'){

                    $query= " Update vac_desp set enabled = 0,updatedate=NOW() 
                              where pacID = ".$dateme[2].  " and fecha = '" .$dateme[3]."'";
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                  
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                    }else{
                        $element1 = $dateme[2]."@".$dateme[3];
                        $data_array = buscavacdes($dateme[2],$dateme[3]);

                        echo '<script type="text/javascript">document.getElementById("elemento1").value="'.$txtnombre.'";</script>';
                        #echo '<script type="text/javascript">findme("consultaphp")</script>';

                    }
                }                  
                if($dateme[0] == 'guarda'){
                    $query = "  Insert vac_desp(pacID,fecha,peso,temp,producto,fechaprox,observaciones,tipoID,enabled,userID,insertdate)
                                values(".$dateme[3].",'".$dateme[2]."','".$txtpeso."','".$txttemp."','".$txtprod."','".$txtprox."','".$txtplan."',".$type.",1,".$cookme[0].",NOW()+1)";
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);                                
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                    }else{
                        $data_array = buscavacdes($dateme[3],$dateme[2]);
                    }

                    $element1 = $dateme[3]."@".$dateme[2];

                }
            }
        }else{
            $dateme = explode("@", $txtnombre);
            $query = "  select Nombrepac,pacID,NOW() fecha,'' peso,null temp,null producto,null fechaProx,null observaciones,null tipoID,null enabled
                    from pacientes 
                    where pacID = ".$dateme[0];
            //echo nl2br($query."\n");
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                die( ); 
            }else{
                if(mysqli_num_rows($stmt) >0){
                    while($rows = mysqli_fetch_assoc($stmt)) {
                        $data_array = array(
                        $rows['Nombrepac'],
                        $rows['pacID'],
                        $rows['fecha'],
                        $rows['peso'],
                        $rows['temp'],
                        $rows['producto'],
                        $rows['fechaProx'],
                        $rows['observaciones'],
                        $rows['tipoID'],
                        $rows['enabled']
                        );
                    }
                }
            }
            $nombre ='iniciando';
        }
    }else{
        $nombre = 'regresate';
    }
?>




<?php
        if($nombre == 'regresate'){
            echo "<script type='text/javascript'>llama('iniciophp')</script>";
        }
?>

    <!--This is the Main Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand" href="#">Patient Control</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ">
                <li class="nav-item active">
                    <a class="nav-link" href="iniciovet.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="citasvet.php">Agenda / Citas</a>
                </li>
                <li class="nav-item">
                    <?php if($menus[0] == 1){echo '<a class="nav-link" href="useradmin.php">User Management</a>';} ?>                    
                </li>
               <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>-->
            </ul>
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link " href="login.php" ><span class="glyphicon glyphicon-log-in"></span>Logout</a>
                 </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-9" style="border-style: none;">                
                <h1>Vacunas / Desparacitaciones</h1>
            </div>   
        </div>
        <div class="row">    
            <div class="col-md-9" style="border-radius: 10px; border-style: none; border-width: 1px;">
            <br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-3 col-md-offset-0 ">
                            <h6><?php echo $data_array[2]; ?> </h6>
                        </div>
                        <div class="col-md-4 col-md-offset-0 ">
                            <h5>Paciente: <?php echo $data_array[0] ?></h5>
                        </div>
                        <div class="col-md-5 col-md-offset-0" >
                            <table>
                                <tr><th>MVZ: <?php if( $nombre !='iniciando'){ echo $data_array[10]." ".$data_array[11];}else{echo $menus[1]." ".$menus[2];} ?>  </th></tr>
                                <tr><td>&nbsp</tr></td>
                                <tr>
                                    <td>
                                        <input type="submit" name="btnupdate" id="btnupdate" class="btn btn-outline-warning" value="Update" onclick="updatevac(2)" <?php if(strlen($data_array[3])==0){echo 'style="display: none;"';}?>>
                                        <input type="submit" name="btndelete" id="btndelete" class="btn btn-outline-danger" value="Delete" onclick="updatevac(3)"<?php if(strlen($data_array[3])==0){echo 'style="display: none;"';}?>  >
                                        <input type="submit" name="btnback" id="btnback" class="btn btn-outline-primary" value="Back" style="width: 100px;" onclick="findme('consultavet.php')" >
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-md-offset-1" style="border-radius: 10px; border-style: none; border-width: 1px;">
                            <label>Tipo</label>
                        </div>                     
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-md-offset-1" style="border-radius: 10px; border-style: none; border-width: 1px;"></div>
                        <div class="col-md-3 col-md-offset-0" style="border-radius: 10px; border-style: none; border-width: 1px;">
                                <input type="radio" id="despa" name="gender" value="2" <?php  if($data_array[8] == 2){echo 'Checked';}?> >
                                <label for="despa">Desparacitacion</label>
                        </div>
                        <div class="col-md-4 col-md-offset-0" style="border-radius: 10px; border-style: none; border-width: 1px;">
                                <input type="radio" id="vac" name="gender" value="1" <?php  if($data_array[8] == 1){echo 'Checked';}?> >
                                <label for="vac">Vacuna</label>
                        </div>                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2" style="border-style: none;">
                            <label>Peso</label>
                            <input type="text" name="txtpeso" id="txtpeso" class="form-control" placeholder="Peso" style="text-align:center;" value=<?php echo '"'.$data_array[3].'"' ?> >
                        </div>
                        <div class="col-md-2" style="border-style: none;">
                            <label>Temperatura</label>
                            <input type="text" name="txttemp" id="txttemp" class="form-control" placeholder="Temperatura" style="text-align:center;" value=<?php echo '"'.$data_array[4].'"' ?> >
                        </div>
                        <div class="col-md-4" style="border-style: none;">
                            <label>Producto Utilizado</label>
                            <input type="text" name="txtprod" id="txtprod" class="form-control" placeholder="Producto Utilizado" style="text-align:center;" value=<?php echo '"'.$data_array[5].'"' ?> >
                        </div>
                        <div class="col-md-3" style="border-style: none;">
                            <label>Proxima</label>
                            <input type="date" name="txtprox" id="txtprox" class="form-control" placeholder="Proxima" style="text-align:center;" value=<?php echo '"'.$data_array[6].'"' ?>  >
                        </div>                                                                        
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12" style="border-style: none;">
                            <label>Observaciones</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="border-style: none;">
                            <textarea onkeyup="checkme(this);" onkeypress="checkme(this);" name="txtplan" COLS=100 ROWS=10 id="txtplan"
                                maxlenght="300" runat="server" ><?php echo $data_array[7]?></TEXTAREA>
                        </div>
                    </div><br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-2 col-md-offset-1 "></div>
                        <div class="col-md-6 col-md-offset-0 ">
                            <input type="submit" name="btnsave" id="btnsave" value="Guardar"    class="btn btn-outline-secondary" onclick="updatevac(1)" <?php if(strlen($data_array[3])==0){echo 'style="width: 170px;display: inline;"';}else{echo 'style="width: 170px;display: none;"';}?>>
                            <input type="submit" name="btncancel" id="btncancel" value="Cancel" class="btn btn-outline-danger"  onclick="clearform()"  <?php if(strlen($data_array[3])==0){echo 'style="width: 170px;display: inline;"';}else{echo 'style="width: 170px;display: none;"';}?> >
                        </div>
                        <div class="col-md-2 col-md-offset-0 "></div>
                    </div>
            </div>
            <!-- SIDE CARD -->
            <div class="col-md-3" style="border-style: none;">
                <input type="text" name="txtnombre" id="txtnombre" class="form-control" value=<?php echo '"'.$txtnombre.'"' ?> style="display: none">
                <input type="text" name="elemento1" id="elemento1" class="form-control" value=<?php echo '"'.$element1.'"' ?> style="display: none" placeholder="elemento1">
            </div>
        </div>
                
        <br><br>
        <div class="row">
            <br>
            <footer>
                <p>&copy; 2021 - design by Joel Gonzalez</p>
            </footer>
        </div>

    </div>
    <?php 

        if($dateme[0] == 'delete'){
            echo '<script type="text/javascript">findme("consultaphp")</script>';
        }
    ?>
</form>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>