<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/menustyle.css">

    <script type="text/javascript" src="js/myfunc.js"></script>
    <!--<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>-->


    <title>Patient Control</title>
  </head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
            <form name="principal" method="post"  onsubmit="return false;" class="box">
<?php
                    include "funciones.php";


                    if( isset($_POST['txtuname']) ){      
                        if( isset($_REQUEST['txtuname']) )
                        {  
                            $txtuname = $_REQUEST['txtuname'];
                            $txtpass = $_REQUEST['txtpass'];
                           
                            echo nl2br("user ". $txtuname."\n");
                            echo nl2br("pass ".$txtpass."\n");
                            echo nl2br("total ".strlen($txtuname)."\n");
                        
                            if(strlen($txtuname)>0){                            
                                    $txtpass = encryptme($txtpass);
                                    $query = "  SELECT userID,sectionID,utypeID FROM users where username = '".$txtuname."' and pass ='".$txtpass."'";
                                    echo $query;                                
                                    $conn = conectarse();
                                    //echo nl2br("accessing".$conn."\n");
                                    $stmt = mysqli_query( $conn, $query);                                
                                    if (mysqli_num_rows($stmt) > 0) {
                                        while($rows = mysqli_fetch_assoc($stmt)) {
                                            $data_array = array(
                                                $rows['userID'],           //0
                                                $rows['sectionID'],
                                                $rows['utypeID']
                                            );                
                                        }
                                        $txtnombre = "";
                                        $element1 = $data_array[0]."@".$data_array[1]."@".$data_array[2];
                                        //mycookie($data_array[0]."@".$data_array[1]."@".$data_array[2]);
                                                                
                                        //echo nl2br("userID: ". $data_array[0]."\n");
                                        //echo nl2br("sectionID: ". $data_array[1]."\n");
                                        //echo nl2br("Moving to the next page: \n");

                                        //echo '<script type="text/javascript">llama("inicio.php")</script>';
                                    }else{
                                        $txtnombre = "";
                                        $element1 = "novalue";
                                    }
                            }else{
                                    //mycookie("novalue");
                                    //echo "killed matadote ";
                                    $txtnombre = "";
                                    $element1 = "novalue";

                                }
                        }else{
                            //echo '<script type="text/javascript">llama("login.php")</script>'; 
                            //mycookie("");
                            //echo "killed";
                            $txtnombre = "";
                            $element1 = "novalue";                            
                        }
                    }else{
                        //echo "puta madre";
                        //mycookie("novalue");
                        $txtnombre = "";
                        $element1 = "novalue";                    
                    }

                ?>  



              
                    <h1>Login</h1>
                    <p class="text-muted"> Please enter your login and password!</p> 
                        <input type="text"  name="txtuname" placeholder="Username"> 
                        <input type="password"  name="txtpass" placeholder="Password"> 
                        <br>
                        <!--<a class="forgot text-muted" href="#">Forgot password?</a> -->
                        <input type="submit" name="" value="Login" href="#" onclick="login()" >
                        
                    <div class="col-md-12">
                        <ul class="social-network social-circle">
                            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-3" style="border-style: none;">
                        <input type="text" name="elemento1" id="elemento1" class="form-control" value=<?php echo '"'.$element1.'"' ?> style="display: none" placeholder="elemento1">
                    </div>
                        <?php
                            
                            if(strlen($element1) == 7){                                
                                //echo '<script type="text/javascript">alert(accessCookie())</script>';
                                echo '<script type="text/javascript">setCookie("pcvet","'.$element1.'",-10)</script>';
                                //echo '<script type="text/javascript">llama("login.php")</script>';
                            }else{
                                if (mysqli_num_rows($stmt) > 0) {
                                    echo '<script type="text/javascript">setCookie("pcvet","'.$element1.'",1)</script>';
                                    echo '<script type="text/javascript">llama("iniciovet.php")</script>';
                                }
                            }
                        ?>
                </form>
            </div>
        </div>
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