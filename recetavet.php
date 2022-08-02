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
        $txtnombre = $_POST['txtnombre'];
        $element1 = $_POST['elemento1'];
        $nombre = '';

        //echo nl2br($txtnombre."\n");
        //echo nl2br($element1."\n");

        if(strlen($element1)>0){
            $dateme = explode("@", $element1);
            //echo nl2br( count($dateme)."\n");
            
            if(count($dateme)==2){
                $query = "Select nombrepac,b.conID,fechacons, recID, receta, IFNULL(d.fecha, cast(now() as date) ) proxcons, c.citaID 
                          from pacientes a 
                          JOIN consulta b on a.pacID = b.pacID  and b.fechacons = '".$dateme[1]."' 
                          LEFT JOIN receta c on b.conID = c.conID
                          LEFT JOIN citas d on c.citaID = d.citaID 
                          where a.pacID = ".$dateme[0];
                $conn = conectarse();
                $stmt = mysqli_query( $conn, $query);
                //echo $query;
                if( $stmt === false ) {
                    echo nl2br($query."\n");
                    echo nl2br("\n");
                    echo nl2br("Error:".mysqli_error($conn)."\n");
                    die( ); 
                }else{
                    if(mysqli_num_rows( $stmt )>0){
                        while($rows = mysqli_fetch_assoc($stmt)) {
                            $data_array = array(
                            $rows['nombrepac'],     //0
                            $rows['conID'],         //1
                            $rows['fechacons'],     //2
                            $rows['recID'],         //3
                            $rows['receta'],        //4
                            $rows['proxcons'],      //5
                            $rows['citaID']         //6
                            );
                        }
                        $element1 = $element1."@".$data_array[1]."@".$data_array[6];
                        //echo strlen($data_array[4]);
                        if(strlen($data_array[4])>0){
                            $txtnombre = 'Guardada';
                        }
                        
                    }else{
                        $data_array = array("","","","","","","","","","","","","","","");
                    }                    
                }
            }else{
               $txtreceta = $_POST['txtreceta'];
               $txtproxd = $_POST['txtproxd'];

                if($dateme[0] == 'update'){
                    $query= "update citas set fecha = '".$txtproxd."' where citaID = ".$dateme[4];
                    //echo nl2br($query."\n");
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                    }

                    $query= " Update receta set receta='".$txtreceta."',proxconsulta ='".$txtproxd."', updatedate=NOW() +1
                              where pacID = ".$dateme[1].  " and conID = '" .$dateme[3]."'";
                    //echo nl2br($query."\n");
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                  
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( ); 
                    }else{
                        $query = "Select nombrepac,b.conID,fechacons, recID, receta,proxconsulta from pacientes a 
                        JOIN consulta b on a.pacID = b.pacID 
                        LEFT JOIN receta c on a.pacID = c.pacID AND b.conID = c.conID
                        where a.pacID = ".$dateme[1]." and b.conID=".$dateme[3] ;
                        //echo nl2br($query."\n");
                        $conn = conectarse();
                        $stmt = mysqli_query( $conn, $query);
                        //echo $query;
                        if( $stmt === false ) {
                            echo nl2br($query."\n");
                            echo nl2br("\n");
                            echo nl2br("Error:".mysqli_error($conn)."\n");
                            die( ); 
                        }else{
                            while($rows = mysqli_fetch_assoc($stmt)) {
                                $data_array = array(
                                $rows['nombrepac'],
                                $rows['conID'],
                                $rows['fechacons'],
                                $rows['recID'],
                                $rows['receta'],
                                $rows['proxconsulta'] 
                                );
                            }
                            $element1 = $dateme[1]."@".$dateme[2]."@".$dateme[3]."@".$dateme[4];
                            $txtnombre = 'Guardada';
                            //echo $element1;
                        }
                    }
                }
                if($dateme[0] == 'guarda'){

                    $query = "Insert citas (pacID,fecha,hora,enabled,insertdate) 
                            values(".$dateme[1].",'".$txtproxd."','10:00:00',1,now()+1)";

                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( );
                    }else{
                        $query = "SELECT citaID FROM citas where pacID =".$dateme[1]." and fecha = '".$txtproxd."'";

                        $conn = conectarse();
                        $stmt = mysqli_query( $conn, $query);
                        if( $stmt === false ) {
                            echo nl2br($query."\n");
                            echo nl2br("\n");
                            echo nl2br("Error:".mysqli_error($conn)."\n");
                            die( );
                        }else{
                            while($rows = mysqli_fetch_assoc($stmt)) {
                                $conidarr = array(
                                $rows['citaID']
                                );
                            }                            
                        }
                    }

                    $query = "  Insert receta(pacID,conID,fecha,receta,userID,proxconsulta,citaID,insertdate)
                                values(".$dateme[1].",'".$dateme[3]."','".$dateme[2]."','".$txtreceta."',".$cookme[0].",'".$txtproxd."',".$conidarr[0].",NOW() +1)";
                    
                    $conn = conectarse();
                    $stmt = mysqli_query( $conn, $query);
                    if( $stmt === false ) {
                        echo nl2br($query."\n");
                        echo nl2br("\n");
                        echo nl2br("Error:".mysqli_error($conn)."\n");
                        die( );
                    }else{

                        $query = "Select nombrepac,b.conID,fechacons, recID, receta, proxconsulta,citaID  from pacientes a 
                        JOIN consulta b on a.pacID = b.pacID 
                        LEFT JOIN receta c on a.pacID = c.pacID
                        where a.pacID = ".$dateme[1]." and b.conID=".$dateme[3] ;
                        $conn = conectarse();
                        $stmt = mysqli_query( $conn, $query);
                        //echo $query;
                        if( $stmt === false ) {
                            echo nl2br($query."\n");
                            echo nl2br("\n");
                            echo nl2br("Error:".mysqli_error($conn)."\n");
                            die( );
                        }else{
                            while($rows = mysqli_fetch_assoc($stmt)) {
                                $data_array = array(
                                $rows['nombrepac'],         //0
                                $rows['conID'],         //1
                                $rows['fechacons'],     //2
                                $rows['recID'],         //3
                                $rows['receta'],        //4
                                $rows['proxconsulta'],        //5
                                $rows['citaID']        //6
                                );
                            }
                            $txtnombre = 'Guardada';
                            $element1 = $dateme[1]."@".$dateme[2]."@".$dateme[3]."@".$data_array[6];
                            //echo $element1;
                        }
                    }
                }
            }
        }
    }else{   
        $nombre = 'regresate';
    }

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
                <h1>Receta</h1>
            </div>   
        </div>
        <div class="row">    
            <div class="col-md-9" style="border-radius: 10px; border-style: none; border-width: 1px;">
            <br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-3 col-md-offset-0 ">
                            <table style="width:100%">
                                <tr><th style="text-align: center;" ><label id="lblcons"> Fecha:</label> </th> </tr>
                                <tr><td style="text-align: center;"><label id="lblultcons">
                                    <?php
                                        if(strlen($data_array[3])==0){
                                            $currenttime = date('Y-m-d H:i:s');
                                            echo $currenttime;
                                        }else{
                                            echo $data_array[2];
                                        }
                                    ?>
                                </label></td></tr>
                            </table>
                        </div>
                        <div class="col-md-5 col-md-offset-0">
                            <table style="width:100%" style="border-style: solid;">
                                <tr><th style="text-align: center;">Paciente</th> </tr>
                                <tr><td style="text-align: center;"><label id="lblultcons">
                                    <?php
                                     if(strlen($data_array[0])==0){
                                         echo "No Patient Name";
                                     }else{
                                        echo $data_array[0];
                                    }
                                    ?>
                                </label></td></tr>
                            </table>
                        </div>
                        <div class="col-md-4 col-md-offset-0" style="padding-top: 2rem;">
                            <input type="submit" name="btnback" id="btnback" class="btn btn-outline-primary" value="Back" onclick="llama('consultavet.php')" style="width: 170px;">                            
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-7" >
                            <label>Receta:</label>
                        </div>
                        <div class="col-3" >
                            <label>Prox Consulta</label>
                            <?php $dates = explode("-", $data_array[5]); $today =  $dates[0]."-".$dates[1]."-".$dates[2];   ?>
                            <input type="date" name="txtproxd" id="txtproxd" class="form-control"  onkeypress="return false;"  onpaste="return false;" 
                            value="<?php echo $today;?>" >
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="border-style: none;">
                            <textarea onkeyup="checkme(this);" onkeypress="checkme(this);" name="txtreceta" COLS=100 ROWS=10 id="txtreceta"
                                maxlenght="300" runat="server" ><?php if(strlen($data_array[3])>0){echo $data_array[4];}else{echo "";}?></TEXTAREA>
                        </div>
                    </div><br>
                    <div class="row" style="border-style: none;">
                        <div class="col-md-2 col-md-offset-1 "></div>
                        <div class="col-md-6 col-md-offset-0 ">
                            <input type="submit" name="btnupdate" id="btnupdate" class="btn btn-outline-warning" value="Update" onclick="updaterec(2)" <?php if(strlen($data_array[3])==0){echo 'style="width: 170px;display: none;"';}else{echo 'style="width: 170px;';} ?>>
                            <input type="submit" name="btnsave" id="btnsave" value="Guardar"    class="btn btn-outline-primary" onclick="updaterec(1)" <?php if(strlen($data_array[3])==0){echo 'style="width: 170px;display: inline;"';}else{echo 'style="width: 170px;display: none;"';}?>>
                            <input type="submit" name="btnprint" id="btnprint" value="Print" class="btn btn-outline-secondary"  onclick="printTextArea()"  <?php if(strlen($data_array[0])==0){echo 'style="width: 170px;display: none;"';}else{echo 'style="width: 170px;display: inline;"';}?> >
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

<script>

var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("txtproxd")[0].setAttribute('min', today);
    //document.getElementsByName("txtproxd").value = '04/16/2021';

    //alert(today);
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