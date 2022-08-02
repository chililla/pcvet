<!--<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Control</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/myfunc.js"></script>
</head>

<body>-->
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
<form class="" id="" name="principal" method="post"  onsubmit="return false;">
<?php
        include "funciones.php";

        if (!isset($_COOKIE["pcvet"])) {
          echo '<script type="text/javascript">llama("login.php")</script>';
        } else {

          //echo nl2br("cookie Value is: " . $_COOKIE["pcvet"]."\n");
          
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
                if(mysqli_num_rows( $stmt )>0){
                    while($rows = mysqli_fetch_assoc($stmt)) {
                        $menus = array(
                            $rows['utypeID']
                        );
                    }
                }else{$menus == '3';}

          }
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
            <div class="col">
                <h1 class="display-6" style="text-align:center">Busqueda de Pacientes</h1><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="border-style: none;">                
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1 ">
                            <label>Nombre</label>
                            <input type="text" id="txtname" name="txtname" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="col-md-6 col-md-offset-1" style="padding-top: 2rem;">
                            <input type="submit" name="btnsave" class="btn btn-outline-secondary" style="width: 170px;" onclick="llama('iniciovet.php')" value="Buscar">
                            <input type="submit" name="btncancel" id="btncancel" class="btn btn-outline-danger" style="width: 170px; display: none;" onclick="findme('0@',3)" value="Registrar" >
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1 ">
                            <label>Nombre del Dueño</label>
                            <input type="text" name="txtowner" id="owner" class="form-control" placeholder="Nombre del Dueño">
                        </div>
                    </div><br>
                    <div class="col-md-8 col-md-offset-1" style="border-style: none;" >
                        <h3 id="lblerror" class="alert alert-danger" style="text-align: center; display: none;" >Paciente no encontrado </h3>
                    </div>
                    
                    <br>
                    
                    <div class="col-md-12" style="border-style: none;">
                        <table class="table table-hover" id="thead" style="display: none">
                            <tr >
                              <th>Nombre</th>
                              <th>Nombre del Dueño</th>
                              <th>Fecha Ultima Consulta</th>
                              <th>Celular</th>
                              <th>E-mail</th>
                              <th>MVZ</th>
                              <th>Prox Cons.</th>
                            </tr>
                                <?php
                                    if( isset($_POST['txtname']) )
                                    {

                                        $ori = $_POST['txtname'];
                                        $owner = $_POST['txtowner'];

                                        if(strlen($owner) > 0 ){
                                            $query = "Select IFNULL(cit.fecha,'Sin Prox') fecha, a.pacid,a.nombrepac Nombrecito,ownername,  b.fechacons fechita,a.direccion Direccion,nointerior,noexterior ,a.celular ,a.email, b.fechacons,CONCAT(c.nombre,' ',c.apeidos) mvz
                                            from pacientes a LEFT JOIN consulta b on a.pacID = b.pacID LEFT JOIN users c on b.userID = c.userid 
                                            LEFT JOIN receta rec on b.conID = rec.conID and a.pacID = rec.pacID
                                            LEFT JOIN citas cit on cit.citaID = rec.citaID and a.pacID = cit.pacID
                                            where a.nombrepac like '". $ori ."%' and ownername like '". $owner . "%' order by fechita desc" ;

                                        }else{

                                            $query = "Select IFNULL(cit.fecha,'Sin Prox') fecha,a.pacid,a.nombrepac Nombrecito,ownername, b.fechacons fechita,a.direccion Direccion,nointerior,noexterior ,a.celular ,a.email, b.fechacons,CONCAT(c.nombre,' ',c.apeidos) mvz
                                            ,b.fechacons as tempfecha
                                            from pacientes a LEFT JOIN consulta b on a.pacID = b.pacID LEFT JOIN users c on b.userID = c.userid 
                                            LEFT JOIN receta rec on b.conID = rec.conID and a.pacID = rec.pacID
                                            LEFT JOIN citas cit on cit.citaID = rec.citaID and a.pacID = cit.pacID
                                            where a.nombrepac like '". $ori ."%' order by fechita desc";
                                        }
                                        //echo '<script type="text/javascript">reasignme("' .$ori. '");</script>';

                                        //echo $query;
                                        //echo $owner;

                                        if(strlen($ori) > 0){
                                                $conn = conectarse();
                                                $stmt = mysqli_query( $conn, $query);
                                                if( $stmt == false ) {      
                                                    echo nl2br($query."\n");
                                                    echo nl2br("\n");
                                                    echo nl2br("Error:".mysqli_error($conn)."\n");
                                                    die( ); 
                                                 }else{
                                                    //$restme = mysqli_num_rows($stmt);
                                                    if(mysqli_num_rows($stmt) >0){
                                                        while($rows = mysqli_fetch_assoc($stmt)) {
                                                            echo "<tr>";
                                                            $tosend = "'" . $rows['pacid']."@'";
                                                            echo '<td><a href="#" onclick="findme('.$tosend.',3);">' .$rows["Nombrecito"].'</a></td>';
                                                            echo "<td>" . $rows['ownername'] . "</td>";

                                                            //$more=$rows['fechita'];
                                                            //echo $rows['tempfecha'];

                                                            if(strlen($rows['tempfecha'])> 0 ){

                                                                $more = strval($rows['fechita']);

                                                                if(strlen($more)>0  ){
                                                                    $fechada = $rows['fechita'];
                                                                    $tosend = "'" .$rows['pacid'].'@'.$fechada. "'";
                                                                }
                                                            }else{
                                                                $fechada="Sin Consulta";
                                                                $tosend = "'" .$rows['pacid']."@sc'";
                                                            }

                                                        
                                                            //echo $tosend;
                                                            

                                                            if(strlen($fechada) > 0) {
                                                                if($menus[0] != 3){
                                                                    echo '<td><a href="#" onclick="findme(' .$tosend. ',1);" >' . $fechada . "</a></td>";
                                                                }else{ echo '<td>' . $fechada . "</td>";}
                                                            }else{
                                                                echo "<td> </td>";
                                                            }

                                                            echo "<td>" . $rows['celular'] . "</td>";
                                                            echo "<td>" . $rows['email'] . "</td>";
                                                            echo "<td>" . $rows['mvz'] . "</td>";
                                                            echo "<td>" . $rows['fecha'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo '<script type="text/javascript">document.getElementById("thead").style.display="inline-block";</script>';
                                                    }else{
                                                        echo '<script type="text/javascript">document.getElementById("btncancel").style.display="inline";</script>';
                                                        echo '<script type="text/javascript">document.getElementById("lblerror").style.display="block";</script>';
                                                        echo '<script type="text/javascript">document.getElementById("thead").style.display="none";</script>';
                                                    }
                                                }


                                        }else{
                                            echo '<script type="text/javascript">document.getElementById("thead").style.display="none";</script>';
                                        }
                                        
                                        echo '<script type="text/javascript">document.getElementById("txtname").value="' .$ori. '";</script>';
                                        echo '<script type="text/javascript">document.getElementById("owner").value="' .$owner. '";</script>';
                                    }                                    
                                ?>
                          </table>                        
                    </div>
                    <input type="text" name="elemento1" style="display: none"> 
                </form>
            </div>
        </div>


        <div class="row">
        
            <br>
            <footer>
                <p>&copy; 2021 - design by Joel Gonzalez</p>
            </footer>   
        </div>

    </div>

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