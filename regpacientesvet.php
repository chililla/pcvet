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
<form name="principal"  method="post" onsubmit="return false;">
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
            
            $query = "SELECT utypeID FROM users WHERE enabled = 1 and sectionID = ".$cookme[1]." and userID = ".$cookme[0];
            //echo $query;
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            
              while($rows = mysqli_fetch_assoc($stmt)) {
                  $menus = array(
                      $rows['utypeID']
                  );
              }                

        }
      }    




    if( isset($_POST['elemento1']) )
    {   
        $element1 = $_POST['elemento1'];
        $dateme = explode("@",  $element1);

        //echo nl2br("argument: ".$element1."\n");
        //echo nl2br("Total index: ".count($dateme)."\n");
        //echo nl2br($dateme[0]."   ".$dateme[1]."\n");

        if($dateme[0]=="0"){
            $txtnombre = "";        
            $data_array = array("","","","","","","","","","","","","","","","","");
            $nombre = "";
        }elseif($dateme[0]=='insert'){
            $fname = $_POST['fname'];
            $ownername = $_POST['ownername'];
            $email = $_POST['email'];
            $bdate = $_POST['bdate'];
            $edad = $_POST['edad'];
            $especie = $_POST['especie'];
            $raza = $_POST['raza'];
            $sexo = $_POST['sexo'];
            $dir = $_POST['dir'];
            $nointer = $_POST['nointer'];
            $noext = $_POST['noext'];
            $colonia = $_POST['colonia'];
            $cp = $_POST['cp'];
            $telcasa = $_POST['telcasa'];
            $teloff = $_POST['teloff'];
            $cel = $_POST['cel'];

            if($sexo == "Macho"){
                $sexo = 1;
            }else{$sexo = 2;}
            $query = "Insert pacientes(Nombrepac,ownerName,fechaNac,edad,especie,raza,sexo,direccion,nointerior,noexterior,colonia,cp,telcasa,teloficina,celular,email,userID,secID,insertdate)
                     values('".$fname."','".$ownername."','".$bdate."','".$edad."','".$especie."','".$raza."','".$sexo."','".$dir."','".$nointer."','".$noext.
                     "','".$colonia."','".$cp."','".$telcasa."','".$teloff."','".$cel."','".$email."',".$cookme[0].",".$cookme[1].",NOW() +1)";
            //echo nl2br($query."\n");
            $conn = conectarse();            
            $stmt = mysqli_query( $conn, $query);        
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                die( ); 
            }else{
                $query = "Select Nombrepac,ownerName,fechaNac,edad,especie,raza,sexo,direccion,nointerior,noexterior,colonia,cp,telcasa,teloficina,celular,email,pacID, fechaNac fechame
                    from pacientes where Nombrepac='".$fname."' and ownername = '".$ownername."' and email = '".$email."' and fechanac = '".$bdate."'";
                $stmt = mysqli_query( $conn, $query);
                if( $stmt === false ) {
                    echo nl2br($query."\n");
                    echo nl2br("\n");
                    echo nl2br("Error:".mysqli_error($conn)."\n");
                     die( ); 
                }else{
                    //$restme = sqlsrv_has_rows( $stmt );
                    if(mysqli_num_rows($stmt) >0){
                        $txtnombre = "";
                        while($rows = mysqli_fetch_assoc($stmt)) {
                            $data_array = array(
                                $rows['Nombrepac'],         //0
                                $rows['ownerName'],         //1
                                $rows['fechaNac'],          //2
                                $rows['edad'],              //3
                                $rows['raza'],              //4
                                $rows['sexo'],              //5
                                $rows['direccion'],         //6                   
                                $rows['nointerior'],        //7
                                $rows['noexterior'],        //8
                                $rows['colonia'],           //9
                                $rows['cp'],                //10
                                $rows['telcasa'],           //11
                                $rows['teloficina'],        //12
                                $rows['celular'],           //13
                                $rows['email'],             //14
                                $rows['fechame'],           //15
                                $rows['especie'],           //16
                                $rows['pacID']              //17    
                            );
                        }
                    }
                }
                $txtnombre = "";
                $element1 = $data_array[17]."@";
                $nombre = "";
            }            
        }elseif($dateme[0]=='update'){

            $fname = $_POST['fname'];
            $ownername = $_POST['ownername'];
            $email = $_POST['email'];
            $bdate = $_POST['bdate'];
            $edad = $_POST['edad'];
            $especie = $_POST['especie'];
            $raza = $_POST['raza'];
            $sexo = $_POST['sexo'];
            $dir = $_POST['dir'];
            $nointer = $_POST['nointer'];
            $noext = $_POST['noext'];
            $colonia = $_POST['colonia'];
            $cp = $_POST['cp'];
            $telcasa = $_POST['telcasa'];
            $teloff = $_POST['teloff'];
            $cel = $_POST['cel'];

            if($sexo == "Macho"){
                $sexo = 1;
            }else{$sexo = 2;}

            $query = "Update pacientes set Nombrepac = '".$fname."',ownerName='".$ownername."',fechaNac='".$bdate."',edad='".$edad."',especie='".$especie."',raza='".$raza."',sexo='".$sexo."',direccion='".$dir."'
                     ,nointerior='".$nointer."',noexterior='".$noext."',colonia='".$colonia."',cp='".$cp."',telcasa='".$telcasa."',teloficina='".$teloff."',celular='".$cel."',email='".$email."',updatedate=NOW() +1
                     where pacID = ".$dateme[1];
                    //echo $query;
                    
                     $conn = conectarse();
                     $stmt = mysqli_query( $conn, $query);
         
                     if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                     }else{

                        $query = "Select Nombrepac,ownerName,fechaNac,edad,especie,raza,sexo,direccion,nointerior,noexterior,colonia,cp,telcasa,teloficina,celular,email,pacID, 'sin fecha' fechame
                        from pacientes where pacID = ".$dateme[1];
    
                        $stmt = mysqli_query( $conn, $query);
                        if( $stmt === false ) {
                            echo nl2br($query."\n");
                            echo nl2br("\n");
                            echo nl2br("Error:".mysqli_error($conn)."\n");
                            die( ); 
                        }else{
                            //$restme = sqlsrv_has_rows( $stmt );
                            if(mysqli_num_rows($stmt) >0){
                                $txtnombre = "";
                                while($rows = mysqli_fetch_assoc($stmt)) {
                                    $data_array = array(
                                        $rows['Nombrepac'],
                                        $rows['ownerName'],
                                        $rows['fechaNac'],
                                        $rows['edad'],
                                        $rows['raza'],
                                        $rows['sexo'],
                                        $rows['direccion'],                            
                                        $rows['nointerior'],
                                        $rows['noexterior'],
                                        $rows['colonia'],
                                        $rows['cp'],
                                        $rows['telcasa'],
                                        $rows['teloficina'],
                                        $rows['celular'],
                                        $rows['email'],
                                        $rows['fechame'],
                                        $rows['especie'],
                                        $rows['pacID']                      
                                    );
                                }
                            }
                        }
                        $txtnombre = "";
                        $element1 = $dateme[1]."@";
                        $nombre = "";
                     }       
        }else{
            $query = "  select *, fechaNac fechame
                        from pacientes a
                        where a.pacID = ".$dateme[0];
            //echo $query;          
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                die( ); 
            }else{
                //$restme = sqlsrv_has_rows( $stmt );
                if(mysqli_num_rows($stmt) >0){
                    $txtnombre = "";
                    while($rows = mysqli_fetch_assoc($stmt)) {
                        $data_array = array(
                            $rows['nombrepac'],
                            $rows['ownername'],
                            $rows['fechanac'],
                            $rows['edad'],
                            $rows['raza'],
                            $rows['sexo'],
                            $rows['direccion'],                            
                            $rows['nointerior'],
                            $rows['noexterior'],
                            $rows['colonia'],
                            $rows['cp'],
                            $rows['telcasa'],
                            $rows['teloficina'],
                            $rows['celular'],
                            $rows['email'],
                            $rows['fechame'],
                            $rows['especie']                        
                        );
                    }
                }
            }
        }
    }else{
        $nombre = 'regresate';
    }

        //if($nombre == 'regresate'){
        //    echo "<script type='text/javascript'>llama('iniciovet.php')</script>";
        //}

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


    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-6" style="text-align:center">Registro de Pacientes</h1><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="border-style: none;">
                
                    <div class="row">
                        <div class="col-md-2 col-md-offset-2 ">
                            <label>Nombre</label>
                            <input type="text" name="fname"  id="fname" class="form-control" placeholder="Nombre" 
                                value=<?php 
                                    if(strlen($data_array[0])>0){
                                        echo $data_array[0];
                                    }else{
                                        echo $dateme[1];
                                    }
                                ?> 
                            >
                        </div>
                        <div class="col-md-3 col-md-offset-0">
                            <label>Nombre de Propietario</label>
                            <input type="text" name="ownername" id="ownername" class="form-control" placeholder="Nombre de Propietario" value="<?php echo $data_array[1] ?> ">
                        </div>
                        <div class="col-md-3 col-md-offset-0">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Correo Electronico" value=<?php echo $data_array[14] ?> >
                        </div>                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="bdate" id="bdate" class="form-control" placeholder="Fecha de Nacimiento" onkeypress="return false;"  onpaste="return false;" onchange="getage();"
                            value=<?php 
                                        if(strlen($data_array[15])>0){
                                            echo $data_array[2]; 
                                        }else {
                                            echo "";
                                        }
                                        ?>>
                        </div>
                        <div class="col-md-4">
                            <label>Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control" placeholder="Edad"  maxlength="2" 
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                                    value=<?php echo $data_array[3] ?>>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Especie</label>
                            <input type="text" name="especie" id="especie" class="form-control" placeholder="Especie" value=<?php echo $data_array[16] ?>>
                        </div>
                        <div class="col-md-4">
                            <label>Raza</label>
                            <input type="text" name="raza" id="raza" class="form-control" placeholder="Raza" value=<?php echo $data_array[4] ?> >
                        </div>
                        <div class="col-sm-4">
                            <label>Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" >
                                <option <?php if($data_array[5]==1){echo "selected";} ?> > Macho </option>
                                <option <?php if($data_array[5]==2){echo "selected";} ?> > Hembra </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-4">
                            <label>Direccion</label>
                            <input type="text" name="dir" id="dir" class="form-control" placeholder="Direccion" value="<?php echo $data_array[6];?>" >
                        </div>
                        <div class="col-md-4">
                            <label>No Interior</label>
                            <input type="text" name="nointer" id="nointer" class="form-control" placeholder="No Interior" value=<?php echo $data_array[7]; ?>>
                        </div>
                        <div class="col-md-4">
                            <label>No Exterior</label>
                            <input type="text" name="noext" id="noext" class="form-control" placeholder="No Exterior" value=<?php echo $data_array[8] ?>>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-4">
                            <label>Colonia</label>
                            <input type="text" name="colonia" id="colonia" class="form-control" placeholder="Colonia" value=<?php echo $data_array[9] ?>>
                        </div>
                        <div class="col-md-4">
                            <label>Codigo Postal</label>
                            <input type="text" name="cp" id="cp" class="form-control" placeholder="Codigo Postal" value=<?php echo $data_array[10] ?>>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-4">
                            <label>Tel Casa</label>
                            <input type="text" name="telcasa" id="telcasa" class="form-control" placeholder="Tel Casa" value=<?php echo $data_array[11] ?>>
                        </div>
                        <div class="col-md-4">
                            <label>Tel Oficina</label>
                            <input type="text" name="teloff" id="teloff" class="form-control" placeholder="Tel Oficina" value=<?php echo $data_array[12] ?>>
                        </div>
                        <div class="col-md-4">
                            <label>Celular</label>
                            <input type="text" name="cel" id="cel" class="form-control" placeholder="Celular" value=<?php echo $data_array[13] ?>>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-3"></div>
                    
                        <div class="col-md-4">
                            <input type="submit" name="btnsave" class="btn btn-outline-secondary" style="width: 170px;"  value="Save" onclick="registramipac()">
                            <input type="submit" name="btncancel" class="btn btn-outline-danger" style="width: 170px;" value="Cancel" onclick="findme('iniciovet.php')">
                        </div>

                        <div class="col"></div>
                    </div>
                
            </div>
        </div>

            <!-- SIDE CARD -->
            <div class="col-md-3" style="border-style: none;">
                <input type="text" name="txtnombre" id="txtnombre" class="form-control" value=<?php echo '"'.$txtnombre.'"' ?> style="display: none">
                <input type="text" name="elemento1" id="elemento1" class="form-control" value=<?php echo '"'.$element1.'"' ?> style="display: none" placeholder="elemento1">
            </div>

            <br><br>

        <div class="row">
            <br>
            <footer>
                <p>&copy; 2021 - design by Joel Gonzalez</p>
            </footer>
        </div>



    </div>
</form>
<script>
var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("bdate")[0].setAttribute('max', today);
</script>

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