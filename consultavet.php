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
    date_default_timezone_set("America/Mexico_City");
    include "funciones.php";
 //if($_POST['alex']=='si'){

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
        $nombre = $_POST['elemento1'];
        
        //echo strlen($nombre);
        
        $data = htmlentities($_COOKIE['consulta'], 3, 'UTF-8');
        $dateme = explode("@", $data);

        //echo nl2br( count($dateme)."\n");
        //echo nl2br($dateme[0]."   ".$dateme[1]."\n");

        

        //updating the Row
        if($nombre =='Piolasa' ){
 
            $txtpeso  = $_POST['txtpeso'];
            $txttalla = $_POST['txttalla'];
            $txtdiag = $_POST['diag'];
            $txtplan = $_POST['plan'];
            $txthistoria = $_POST['txthistoria'];

            $txttemp  = $_POST['txttemp'];
            $txtFC  = $_POST['txtFC'];
            $txtFR  = $_POST['txtFR'];
            $txttllc  = $_POST['txttllc'];
            $txtpiel  = $_POST['txtpiel'];
            $txtsubmax  = $_POST['txtsubmax'];
            $txtretro  = $_POST['txtretro'];
            $txtaxi  = $_POST['txtaxi'];
            $txtingu  = $_POST['txtingu'];


            $savedata = $_POST['txtnombre'];
            $datesave = explode("@", $savedata);

            if(strlen($savedata) > 0){
                $query= "Update consulta 
                        set peso =".$txtpeso." ,histclinica = '".$txthistoria."', talla = ".$txttalla." , diagnostico = '".$txtdiag."' ,cplan = '".$txtplan."', updatedate=NOW() +1
                        ,temp='".$txttemp."', fc='".$txtFC."', fr='".$txtFR."',tllc='".$txttllc."', piel='".$txtpiel."', bubmax='".$txtsubmax."', retro='".$txtretro."', axi='".$txtaxi."'
                        ,ingu='".$txtingu."'   where pacID = ".$datesave[0].  " and fechacons = '" .$datesave[1]."'";

                $data = $savedata;
                $dateme = explode("@", $data);

            }else{
                $query= "Update consulta 
                        set peso =".$txtpeso." ,histclinica = '".$txthistoria."', talla = ".$txttalla." , diagnostico = '".$txtdiag."' ,cplan = '".$txtplan."', updatedate=NOW() +1
                        ,temp='".$txttemp."', fc='".$txtFC."', fr='".$txtFR."',tllc='".$txttllc."', piel='".$txtpiel."', bubmax='".$txtsubmax."', retro='".$txtretro."', axi='".$txtaxi."'
                        ,ingu='".$txtingu."'  where pacID = ".$dateme[0].  " and fechacons = '" .$dateme[1]."'";                
            }

            //echo 'actualizado';
            //echo $query;

            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);

            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                die( ); 
            }
        }
        //Saving a new Row 
        if($nombre == 'guarda'){

            $savedata = $_POST['txtnombre'];
            $datesave = explode("@", $savedata);

            $txtpeso  = $_POST['txtpeso'];
            $txttalla = $_POST['txttalla'];
            $txtdiag = $_POST['diag'];
            $txtplan = $_POST['plan'];

            $txttemp  = $_POST['txttemp'];
            $txtFC  = $_POST['txtFC'];
            $txtFR  = $_POST['txtFR'];
            $txttllc  = $_POST['txttllc'];
            $txtpiel  = $_POST['txtpiel'];
            $txtsubmax  = $_POST['txtsubmax'];
            $txtretro  = $_POST['txtretro'];
            $txtaxi  = $_POST['txtaxi'];
            $txtingu  = $_POST['txtingu'];
            


            $txthistoria = $_POST['txthistoria'];
            $query = " Insert consulta (pacID,fechacons,peso,histclinica,talla,diagnostico,cplan,userID,insertdate,temp,fc,fr,tllc,piel, bubmax,retro,axi,ingu)
                        values (".$datesave[0].",'".$datesave[1]."','".$txtpeso."','".$txthistoria."','".$txttalla."','".$txtdiag."','".$txtplan."',".$cookme[0].",NOW() +1
                        ,'".$txttemp."','".$txtFC."','".$txtFR."','".$txttllc."','".$txtpiel."','".$txtsubmax."','".$txtretro."','".$txtaxi."','".$txtingu."')";
            
            //echo $query;

            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
        
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                 die( ); 
            }else{
                $data = $savedata;
                $dateme = explode("@", $data);
            }

        }

        if($dateme[1]=='sc'){
            $query = "  select null fechacons,null peso,null talla,null histclinica,null diagnostico,null cplan,Nombrepac,null tempfecha
                        FROM pacientes
                        where pacID = ".$dateme[0];
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            //$restme = sqlsrv_has_rows( $stmt );
            //echo nl2br("total rows: ".mysqli_num_rows($stmt)."\n");
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                 die( ); 
            }else{
                if(mysqli_num_rows($stmt)> 0 ){
                    while($rows = mysqli_fetch_assoc($stmt)) {
                        $data_array = array(
                        $rows['fechacons'],
                        $rows['peso'],
                        $rows['talla'],
                        $rows['diagnostico'],
                        $rows['cplan'],
                        $rows['Nombrepac'],
                        $rows['tempfecha'],
                        $rows['histclinica']
                        );
                    }
                }
            }
        }else{
            $query = "  select fechacons,peso,talla,diagnostico,histclinica,cplan,Nombrepac,fechacons as tempfecha,temp,fc,fr,tllc,piel, bubmax,retro,axi,ingu,a.userid
                        from consulta a 
                        JOIN pacientes b on a.pacID = b.pacID
                        where a.pacID = ".$dateme[0].  " and fechacons = '" .$dateme[1]."'";        
            $conn = conectarse();
            $stmt = mysqli_query( $conn, $query);
            if( $stmt === false ) {
                echo nl2br($query."\n");
                echo nl2br("\n");
                echo nl2br("Error:".mysqli_error($conn)."\n");
                 die( ); 
             }
            //$restme = sqlsrv_has_rows( $stmt );
            if(mysqli_num_rows($stmt) >0){
                while($rows = mysqli_fetch_assoc($stmt)) {
                    $data_array = array(
                    $rows['fechacons'],       //0  
                    $rows['peso'],              //1
                    $rows['talla'],             //2
                    $rows['diagnostico'],       //3
                    $rows['cplan'],             //4
                    $rows['Nombrepac'],         //5
                    $rows['tempfecha'],         //6
                    $rows['histclinica'],       //7
                    $rows['temp'],              //8
                    $rows['fc'],                //9
                    $rows['fr'],                //10
                    $rows['tllc'],              //11
                    $rows['piel'],              //12
                    $rows['bubmax'],            //13
                    $rows['retro'],             //14
                    $rows['axi'],               //15
                    $rows['ingu'],               //16
                    $rows['userid']               //17
                    );
                }
            }
        }
        //echo count($data_array);
        //echo nl2br(strlen($data_array[6])."\n");
        //echo $data_array[6];
    }else{
        $nombre = 'regresate';        
    }

    
        //if($nombre == 'regresate'){
        //    echo "<script type='text/javascript'>llama('iniciophp')</script>";
        //}

?>

    <!--This is the Main Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand" href="#">Patient Control</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-h6="Toggle navigation">
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
                    <div class="dropdown-menu" aria-h6ledby="navbarDropdown">
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

        <div class="row"><div class="col-md-4 col-md-offset-0 "><h1>Consulta</h1></div></div>
        <div class="row">
            <div class="col-md-8" style="border-radius: 10px; border-style: none; border-width: 1px;">
                <br>
                <div class="row" >
                    <div class="col-md-3 col-md-offset-0 " style="border-radius: 10px; border-style: none; border-width: 1px;">
                        <table style="width:100%">
                            <tr><th style="text-align: center;" ><h6 id="lblcons"> ultima consulta</h6> </th> </tr>
                            <tr><td style="text-align: center;"><h6 id="lblultcons">
                                <?php
                                    if(strlen($data_array[6])> 0 ){
                                        $more=$data_array[0];
                                        $more = strval($more);
                                        echo $more;
                                    }else{                                        
                                        $currenttime = date('Y-m-d H:i:s');
                                        echo $currenttime;
                                    }
                                ?>
                            </h6></td></tr>
                        </table>
                    </div>
                    <div class="col-md-5 col-md-offset-0 ">
                        <table style="width:100%">
                            <tr><th style="text-align: center;">Paciente</th> </tr>
                            <tr><td style="text-align: center;"><h6 id="lblultcons"><?php echo $data_array[5] ?></h6></td></tr>
                        </table>
                    </div>
                    <div class="col-md-4 col-md-offset-0" style="padding-top: 2rem;">
                        <input type="submit" name="btnvacu" id="btnvacu" class="btn btn-outline-warning" value="Vacuna / Desp" onclick="findme('',2)" >
                        <input type="submit" name="btnreceta" id="btnreceta" class="btn btn-outline-info" value="Receta" onclick="findme('',4)">
                    </div>
                </div><br>
                <div class="row" style="border-style: none;">
                    <div class="col-md-4 col-md-offset-0 "></div>
                    <div class="col-md-4 col-md-offset-0 "></div>
                    <div class="col-md-4 col-md-offset-0 ">
                        <input type="submit" name="btnnew"    id="btnnew"    class="btn btn-outline-primary" value="Nueva" onclick="return clearform(1)"    <?php if(strlen($data_array[6])== 0 ){ echo 'style="display: none"'; } ?>               >
                        <input type="submit" name="btnupdate" id="btnupdate" class="btn btn-outline-dark" value="Update" onclick="return updatecons(2);" <?php if(strlen($data_array[6])== 0 ){ echo 'style="display: none"'; } ?>                   >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-2 ">
                        <h6>Peso</h6>
                        <input type="text" name="txtpeso" id="txtpeso" class="form-control" placeholder="Peso" value=<?php echo '"'.$data_array[1].'"' ?>
                            style="max-width:60%">
                    </div>
                    <div class="col-md-4 col-md-offset-0 ">
                        <h6>Talla</h6>
                        <input type="text" name="txttalla" id="txttalla" class="form-control" placeholder="Peso" value=<?php echo '"'.$data_array[2].'"' ?>
                            style="max-width:60%">
                    </div>
                </div>
                <br>


                <div class="row" style="border-style: none;">
                    <div class="col" >
                        <h6>Anamnesis / Hist. Clinica</h6>
                        <textarea onkeyup="checkme(this);" onkeypress="checkme(this);" name="txthistoria" COLS=95 ROWS=5 id="txthistoria"
                            maxlenght="300" runat="server" ><?php echo $data_array[7]?></TEXTAREA>                        
                    </div>
                </div>
                              
                <div class="row">
                    <div class="col-2 offset-1">
                        <label for="txttemp"> Temperatura </label>
                        <input type="text" id="txttemp" name="txttemp" class="form-control" onchange="calcac(2);" value="<?php echo $data_array[8]?>">
                    </div>
                    <div class="col-2">
                        <label for="txtFC"> FC </label>
                        <input type="text" id="txtFC" name="txtFC" class="form-control"  onchange="calcac(2);" value="<?php echo $data_array[9]?>">
                    </div>
                    <div class="col-2">
                        <label for="txtFR"> FR </label>
                        <input type="text" id="txtFR" name="txtFR" class="form-control"    value="<?php echo $data_array[10]?>">
                    </div>
                    <div class="col-2">
                        <label for="txttllc"> TLLC </label>
                        <input type="text" id="txttllc" name="txttllc" class="form-control"   value="<?php echo $data_array[11]?>">    
                    </div>
                    <div class="col-3">
                        <label for="txtpiel"> Turgencia Piel </label>
                        <input type="text" id="txtpiel" name="txtpiel" class="form-control"   value="<?php echo $data_array[12]?>"> 
                    </div>
                </div><br>
                <div class="row">
                    <div class="col"> 
                        <h6>Linfonodos:</h6>
                    </div>
                    <div class="col">
                        <label for="txtsubmax"> SubMaxilares </label>
                        <input type="text" id="txtsubmax" name="txtsubmax" class="form-control" value="<?php echo $data_array[13]?>">
                    </div>
                    <div class="col">
                        <label for="txtretro"> Retrofaringeos </label>
                        <input type="text" id="txtretro" name="txtretro" class="form-control" value="<?php echo $data_array[14]?>">
                    </div>
                    <div class="col">
                        <label for="txtaxi"> Axilares </label>
                        <input type="text" id="txtaxi" name="txtaxi" class="form-control"    value="<?php echo $data_array[15]?>"> 
                    </div>
                    <div class="col">
                        <label for="txtingu"> Inguinales </label>
                        <input type="text" id="txtingu" name="txtingu" class="form-control"   value="<?php echo $data_array[16]?>">  
                    </div>
                    
                </div>
                <div class="row" style="border-style: none;">
                    <div class="col" style="border-style: none;">
                        <h6>Diagnostico</h6>
                        <textarea onkeyup="checkme(this);" onkeypress="checkme(this);" name="diag" COLS=95 ROWS=5 id="txtdiag"
                            maxlenght="300" runat="server" ><?php echo $data_array[3]?></TEXTAREA>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="border-style: none;">
                        <h6>Tratamiento Interno</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="border-style: none;">
                        <textarea onkeyup="checkme(this);" onkeypress="checkme(this);" name="plan" COLS=95 ROWS=10 id="txtplan"
                            maxlenght="300" runat="server" ><?php echo $data_array[4]?></TEXTAREA>
                    </div>
                </div><br>
                <div class="row" style="border-style: none;">
                    <div class="col-md-3 col-md-offset-1 "></div>
                    <div class="col-md-6 col-md-offset-0 ">
                        <input type="submit" name="btnsave" id="btnsave" class="btn btn-outline-secondary" value="Guardar" style="width: 170px;" onclick="updatecons(1)"               >
                        <input type="submit" name="btncancel" id="btncancel" class="btn btn-outline-danger" value="Cancel" style="width: 170px;"  onclick="clearform(2)"             >
                    </div>
                    <div class="col-md-2 col-md-offset-0 ">
                        <?php
                                //echo nl2br(strlen($data_array[6])."\n");
                                //echo $data_array[6];

                                //if($nombre == 'regresate'){
                                //    echo "<script type='text/javascript'>llama('iniciophp')</script>";
                                //}
                                if($dateme[1]=='sc'){
                                    echo '<script language="javascript">
                                            document.getElementById("btnreceta").style.display="none"
                                            document.getElementById("btnvacu").style.display="none"                                            
                                            </script>';
                                }
                                 if(strlen($data_array[6])> 0){
                                    
                                    echo '<script language="javascript">
                                        document.getElementById("btnsave").style.display="none";
                                        document.getElementById("btncancel").style.display="none";
                			        </script>';                                          
                                 }else{
                                    $nombre = $dateme[0]."@".$currenttime;
                                    $data = $nombre;
                                 }

                                 if($data_array[17] != $cookme[1]){
                                    echo '<script language="javascript">
                                            document.getElementById("btnreceta").style.display="none"
                                            document.getElementById("btnupdate").style.display="none"                                            
                                            </script>';                                     
                                 }


                        ?>
                    </div>
                </div> 
            </div>

            <div class="col-md-4" style="border-style: none;">
                <div class="row" style="border-radius: 10px; border-style: none; border-width: 1px;" >
                    <div class="col">
                        <div class="card">
                            <h5 class="card-header">Vacunas aplicadas</h5>                            
                            <table class="table table-hover" id="thead">
                                <tr >
                                    <th >Fecha</th>
                                    <th style="font-size: X-Small;">Peso</th>
                                    <th style="font-size: X-Small;">Producto</th>
                                    <th >Prox</th>
                                </tr>
                                <?php
                                    if(strlen($data) > 0  ){
                                        $query = "select vacdesID, pacID, fecha fechita,peso,temp,producto prod,fechaprox 
                                                    from vac_desp 
                                                    where pacID = ".$dateme[0].  " and enabled = 1  and tipoID = 1 order by fecha desc";
                                    }
                                    //echo $query;
                                    $conn = conectarse();
                                    $stmt = mysqli_query( $conn, $query);
                                    if($stmt === false ) {
                                        echo nl2br($query."\n");
                                        echo nl2br("\n");
                                        echo nl2br("Error:".mysqli_error($conn)."\n");
                                        die( ); 
                                    }else{
                                        if(mysqli_num_rows($stmt) >0){
                                            while($rows = mysqli_fetch_assoc($stmt)) {                                                    
                                                $fechada = $rows['fechita'];
                                                $tosend = "'" . $rows['pacID'].'@'.$fechada. "'";
                                                echo "<tr style='font-size:x-small'> ";
                                                if(strlen($fechada) > 0) {echo '<td ><a href="#" onclick="findme(' .$tosend. ',2);" >' . $fechada . "</a></td>";}else{echo "<td> </td>";}
                                                echo "<td>" . $rows['peso'] . "</td>";
                                                echo "<td>" . $rows['prod'] . "</td>";
                                                echo "<td style='font-size:x-small'>" . $rows['fechaprox'] . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                ?>                   
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <br>
                    <div class="col">
                        <div class="card">                    
                            <h5 class="card-header">Desparacitaciones</h5>
                            <table class="table table-hover" id="thead">
                                <tr >
                                    <th >Fecha</th>
                                    <th style="font-size: X-Small;">Peso</th>
                                    <th style="font-size: X-Small;">Producto</th>
                                    <th >Prox</th>
                                </tr>
                                <?php
                                    if(strlen($data) > 0  )
                                    {
                                            $query = "select vacdesID, pacID, fecha fechita,peso,temp,producto prod,fechaprox 
                                                    from vac_desp 
                                                    where pacID = ".$dateme[0].  " and enabled = 1  and tipoID = 2 order by fecha desc";
                                        }

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
                                                    while($rows = mysqli_fetch_assoc($stmt)) {
                                                    
                                                        $fechada = $rows['fechita'];
                                                        $tosend = "'" . $rows['pacID'].'@'.$fechada. "'";
                                                    
                                                        echo "<tr style='font-size:x-small'> ";
                                                        if(strlen($fechada) > 0) {
                                                            echo '<td ><a href="#" onclick="findme(' .$tosend. ',2);" >' . $fechada . "</a></td>";
                                                        }else{
                                                            echo "<td> </td>";
                                                        }
                                                    
                                                        echo "<td>" . $rows['peso'] . "</td>";
                                                        echo "<td>" . $rows['prod'] . "</td>";
                                                        echo "<td>" . $rows['fechaprox'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                
                                            }
                                    }                                    
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <br> <br> <br>
                
                <input type="text" name="txtnombre" id="txtnombre" class="form-control" value=<?php echo '"'.$data.'"' ?> style="display: none">
                <input type="text" name="elemento1" id="elemento1" class="form-control" value=<?php echo '"'.$nombre.'"' ?> style="display: none" placeholder="elemento1">
                          
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