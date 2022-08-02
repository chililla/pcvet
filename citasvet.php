<!doctype html>
<html lang="en">
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
<form class="needs-validation" novalidate name="principal" method="post"  onsubmit="return false;" >
    <?php
        include "funciones.php";
        date_default_timezone_set("America/Mexico_City");

        if(!isset($_COOKIE["pcvet"])) {
            echo '<script type="text/javascript">llama("login.php")</script>';  
          } else {
            //echo nl2br("Value is: " . $_COOKIE["pcvet"]."\n");
            
            $cookme = $_COOKIE["pcvet"];
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

        if( isset($_POST['elemento1'])){   
            $element1 = $_POST['elemento1'];
            $dateme = explode("@",  $element1);
            
            //echo nl2br($element1."\n");
            //echo nl2br( count($dateme)."\n");
            //echo nl2br($dateme[0]."   ".$dateme[1]."\n");
      
            if($dateme[0]=="0"){
                  $txtnombre = "";        
                  $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
                  $nombre = '';
            }elseif($dateme[0]=='insert'){

               $txtfechacita = $_POST['txtfechacita'];
               $txtnombrepac = $_POST['txtnombrepac'];
               $txthora = $_POST['txthora'];
               $txtnaci = $_POST['txtnaci'];
               $txtcel = $_POST['txtcel'];
               $txtemail = $_POST['txtemail'];
                
                $query = "SELECT pacID FROM pacientes where nombre like '".$txtnombrepac."%' and fechanac='".$txtnaci."' and celular=".$txtcel;
                $conn = conectarse();
                $stmt = mysqli_query( $conn, $query);
                $rows = mysqli_num_rows($stmt);

                if( $stmt === false ) {
                    echo $query;
                    die(print_r( mysqli_error(true)));
                }else{
                    if($rows==0){  //si el paciente no existe Lo Registramos
                        $query = "INSERT pacientes(nombre,fechanac,celular,email,userID,sectionID) values ('".$txtnombrepac."','".$txtnaci."',".$txtcel.",'".$txtemail."',".$cookme[0].",".$cookme[1].")";
                        $conn = conectarse();
                        $stmt = mysqli_query( $conn, $query);
                        if( $stmt === false ) {
                            echo $query;
                            die(print_r( mysqli_error(true)));
                        }else{// una vez registrado recuperamos el pacID para el registro de la Cita
                            $query = "SELECT pacID FROM pacientes where nombre like '".$txtnombrepac."%' and fechanac='".$txtnaci."' and celular=".$txtcel;
                            $conn = conectarse();
                            $stmt = mysqli_query( $conn, $query);
                            $rows = mysqli_num_rows($stmt);                            
                            if( $stmt === false ) {
                                echo $query;
                                die(print_r( mysqli_error(true)));
                            }else{
                                while($rows = mysqli_fetch_assoc($stmt)) {
                                    $data_array = array(
                                       $rows['pacID']
                                    );
                                 }
                                // Registramos la Cita ya con el pacID
                                $query = "INSERT citas(pacID,fecha,hora,enabled,insertdate) values(".$data_array[0].",'".$txtfechacita."','".$txthora."',1,NOW()+1)";
                                $conn = conectarse();
                                $stmt = mysqli_query( $conn, $query);
                                if( $stmt === false ) {
                                    echo $query;
                                    die(print_r( mysqli_error(true)));
                                }else{
                                    $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
                                    $txtnombre = "";
                                    $element1 = "";
                        
                                    $curdate = $txtfechacita;
                                    $curtime = date('GG:i:s');                                    
                                }
                            }
                        }
                    }else{//Si el paciente Existe entonces registramos la cita 
                        while($rows = mysqli_fetch_assoc($stmt)) {
                            $data_array = array(
                               $rows['pacID']  // Tomando el ID del paciente
                            );
                         }
                        // Registramos la Cita ya con el pacID
                        $query = "INSERT citas(pacID,fecha,hora,enabled,insertdate) values(".$data_array[0].",'".$txtfechacita."','".$txthora."',1,NOW()+1)";
                        $conn = conectarse();
                        $stmt = mysqli_query( $conn, $query);

                        if( $stmt === false ) {
                            echo $query;
                            die(print_r( mysqli_error(true)));
                        }else{
                            $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
                            $txtnombre = "";
                            $element1 = "";
                
                            $curdate = $txtfechacita;
                            $curtime = date('GG:i:s');                                    
                        }
                    }                
                }


            }elseif($dateme[0]=='update'){      
                $txtfechacita = $_POST['txtfechacita'];
                $txtnombrepac = $_POST['txtnombrepac'];
                $txthora = $_POST['txthora'];
                $txtnaci = $_POST['txtnaci'];
                $txtcel = $_POST['txtcel'];
                $txtemail = $_POST['txtemail'];

        
                $query = "UPDATE citas SET fecha='".$txtfechacita."',hora='".$txthora."',updatedate=NOW() + 1
                            WHERE citaID = " .$dateme[1];
        
                //echo $query;
                $conn = conectarse();
                $stmt = mysqli_query( $conn, $query);         
                if( $stmt === false ) {
                    echo $query;
                    die(print_r( mysqli_error(true)));
                }else{    
                   //$query = "SELECT a.*, b.nombrepac,b.fechanac,b.celular,b.email
                   //          FROM citas a
                   //          JOIN pacientes b ON a.pacID = b.pacID
                   //          where citaID=".$dateme[1];
                   //$conn = conectarse();
                   //$stmt = mysqli_query( $conn, $query);
                   //$rows = mysqli_num_rows($stmt);
    
                   //if( $stmt === false ) {
                   //    echo $query;
                   //    die(print_r( mysqli_error(true)));
                   //}else{
                        //while($rows = mysqli_fetch_assoc($stmt)) {
                        //    $data_array = array(
                        //       $rows['citaID'],
                        //       $rows['nombrepac'],
                        //       $rows['pacID'],          //2
                        //       $rows['fecha'],
                        //       $rows['hora'],           //4
                        //       $rows['fechanac'],
                        //       $rows['celular'],
                        //       $rows['email']
                        //    );
                        //}

                        $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
                        $curdate = $txtfechacita;
                        $curtime = $txthora;
                        $element1 = "";
                        $txtnombre = "";
                    //}
                }
            }elseif($dateme[0]=='delete'){      

                $query = "UPDATE users SET enabled= 0,updatedate=NOW() + 1
                            WHERE userID = " .$dateme[1]. " and sectionID = ".$cookme[1];
                //echo $query;
                $conn = conectarse();
                $stmt = mysqli_query( $conn, $query);         
                if( $stmt === false ) {
                    echo $query;
                    die(print_r( mysqli_error(true)));
                }else{    
                    $data_array = array("","","","","");
                    $txtnombre = $data_array[0];
                    $element1 = "";
                    $nombre = '';
                }                
            }elseif($dateme[0]=='find'){
                $txtnombre = $_POST['txtnombre'];
                $txtfechacita = $_POST['txtfechacita'];
                $txtnombrepac = $_POST['txtnombrepac'];
                $txthora = $_POST['txthora'];
                $txtnaci = $_POST['txtnaci'];
                $txtcel = $_POST['txtcel'];
                $txtemail = $_POST['txtemail'];

                if($dateme[1]=='me'){
                    $txthora = $_POST['txthora'];
                    $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
                    $txtnombre = "";
                    $element1 = "";

                    $curdate = $txtfechacita;
                    $curtime = $txthora;

                }else{
                    $query = "SELECT a.*, b.nombrepac,b.fechanac,b.celular,b.email
                              FROM citas a
                              JOIN pacientes b ON a.pacID = b.pacID
                              LEFT JOIN receta c on b.pacID = c.pacID and a.fecha = c.proxconsulta
                              where a.citaID=".$dateme[1];
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                    $rows = mysqli_num_rows($stmt);
                    //echo $query;
                    if( $stmt === false ) {
                        echo $query;
                        die(print_r( mysqli_error(true)));
                    }else{
                        while($rows = mysqli_fetch_assoc($stmt)) {
                            $data_array = array(
                               $rows['citaID'],
                               $rows['nombrepac'],
                               $rows['pacID'],          //2
                               $rows['fecha'],
                               $rows['hora'],           //4
                               $rows['fechanac'],
                               $rows['celular'],
                               $rows['email']
                            );
                        }

                        if($txtnombre =='new'){
                            $curdate = $txtfechacita;
                            $curtime = $txthora;
                        }else{
                            $curdate =  $data_array[3];
                            $curtime =  $data_array[4];
                        }
                        $txtnombre = "";
                    }                    
                }
            }
        }else{
            //echo "empezamos ";
            $data_array = array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
            $txtnombre = "";
            $element1 = "";

            $curdate = date('Y-m-d');
            $curtime = date('G:i:s');
        }
        //if($nombre == 'regresate'){echo "<script type='text/javascript'>llama('inicio.php')</script>";}
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

    <div class="container"><br>
        <div id="accordion">
            <div class="container" style="border-radius: 10px; border-style: none; border-width: 1px; height:100%">
                <div class="card" >
                    <h5 class="card-header">Control de Citas Medicas</h5>
                    <br>
                    <div class="form-row">
                        <div class="col-1" ></div>
                        <div class="col-2" >
                            <label for="txtfechacita">Fecha de Cita</label>
                            <input type="date" class="form-control" id="txtfechacita" name="txtfechacita"  required value="<?php echo $curdate ?>" onkeypress="return false;"  onpaste="return false;" onchange="citaadmin('find','me');">
                            <div class="invalid-feedback">Campo Requerido</div>
                        </div>
                        <div class="col-1" ></div>
                        <div class="col-5" style="border-style: none;">
                                <label for="txtnombrepac">Nombre del Paciente: </label>
                                <input type="text" class="form-control" id="txtnombrepac" name="txtnombrepac" placeholder="Nombre"  required value="<?php echo  $data_array[1] ?>" >
                                    <div class="invalid-feedback">Campo Requerido</div>
                                    <!--<div class="valid-feedback">Looks good!</div>-->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-1" ></div>
                        <div class="col-2">
                                <label for="txthora">Hora</label>
                                <input type="time" class="form-control" id="txthora" name="txthora"  required value="<?php echo  $curtime ?>">
                                    <div class="invalid-feedback">Campo Requerido</div>
                                    <!--<div class="valid-feedback">Looks good!</div>-->
                        </div>
                        <div class="col-1" ></div>
                        <div class="col-3">
                            
                            <label for="txtnaci">Fecha de Nac</label>
                            <input type="date" class="form-control" id="txtnaci" name="txtnaci"  required value=<?php echo  $data_array[5] ?>>
                            <div class="invalid-feedback">Campo Requerido</div>
                        </div>
                        <div class="col-2">
                            <label for="txtcel">Telefono</label>
                            <input type="number" class="form-control" id="txtcel" name="txtcel" placeholder="Celular"  required maxlength="10" 
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            value=<?php echo  $data_array[6] ?>>
                            <div class="invalid-feedback">Campo Requerido</div>                        
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-4" style="border-style: none;"></div>
                        <div class="col-4">
                                <label for="txtemail">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    </div>
                                    <input type="text" class="form-control" id="txtemail" name="txtemail" placeholder="Correo electronico" aria-describedby="inputGroupPrepend" value=<?php echo  $data_array[7] ?>>
                                    <div class="invalid-feedback">Campo Requerido</div>
                                    <!--<div class="valid-feedback">Looks good!</div>-->
                                </div>
                        </div>
                    </div><br><br>

                    <div class="form-row">
                        <div class="col-md-3 col-md-offset-10"></div>
                        <div class="col-md-6">
                            <button id="btnupdate" class="btn btn-outline-warning"  style="width: 170px;" type="submit" onclick="citaadmin('update','#')">Update</button>
                            <button id="btnsave" class="btn btn-outline-secondary"  style="width: 170px;" type="submit" onclick="citaadmin('insert','me')">Save</button>
                            <button id="btncancel" class="btn btn-outline-danger"  style="width: 170px;" type="submit" onclick="citaadmin('cancel','me')">Cancel</button>
                        </div>
                    </div> <br>                   
                </div>
                <?php
                   
                    if(strlen($element1)==0){                        
                        echo '<script language="javascript">
                                hideme("btnupdate");
                            </script>';
                    }else{
                        echo '<script language="javascript">
                                hideme("btnsave");
                            </script>';                            
                    }
                ?>
                <br>
                <div class="card" >
                    <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">Citas Agendadas</h5>
                    </div><br>
                    <div class="form-row">
                        <div class="col-2" style="border-style: none;"></div>
                        <div class="col-8" style="border-style: none;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nombre Paciente</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">hora de cita</th>
                                        <th scope="col">Email</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        $query = "SELECT  a.*,b.nombrepac,b.celular,b.email, NOW() today 
                                                    FROM citas a
                                                    LEFT JOIN pacientes b on a.pacID = b.pacID
                                                    WHERE a.fecha >= '".$curdate."' and a.fecha <= '".$curdate."'";
                                        //echo $query;
                                        $conn = conectarse();
                                        $stmt = mysqli_query( $conn, $query);
                                        $rows = mysqli_num_rows($stmt);
                                        if( $stmt == false ) {
                                            echo nl2br($query."\n");
                                            echo mysqli_connect_error();
                                        }else{
                                            if($rows>0){
                                                while($rows = mysqli_fetch_assoc($stmt)) {
                                                    echo "<tr>";
                                                    echo '<td><button  class="btn btn-outline-danger" type="submit" onclick=citaadmin("delete","'.$rows['citaID'].'")>Delete</button></td>';
                                                    echo '<td><a href="#" onclick=citaadmin("find","'.$rows['citaID'].'");>' .$rows['nombrepac'].'</a></td>';
                                                    echo '<td>'.$rows['celular'].'</td>';
                                                    echo '<td>'.$rows['hora'].'</td>';
                                                    echo '<td>'.$rows['email'].'</td>';
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div><br><br>                  
                </div>
            </div>
        </div>
    </div>



            <!-- SIDE CARD -->
            <div class="col-md-3" style="border-style: none;">
                
                <input type="text" name="txtnombre" id="txtnombre" class="form-control" value=<?php echo '"'.$txtnombre.'"' ?> style="display: none">
                <input type="text" name="elemento1" id="elemento1" class="form-control" value=<?php echo '"'.$element1.'"' ?> style="display: none" placeholder="elemento1">
            </div>
</form>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
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