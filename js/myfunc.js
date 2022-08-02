

function findme(value, type){
    switch (type){
        case 1:
            setCookie('consulta',value,1);
            llama('consultavet.php');
            break;
        case 2:
            document.principal.elemento1.value = value;
            llama('vacdesp.php');
            break;
        case 3:
            if(value=='0@'){document.principal.elemento1.value = value+document.principal.txtname.value}
            else{document.principal.elemento1.value = value}
            llama('regpacientesvet.php');
            break;
        case 4:
            document.principal.elemento1.value = document.principal.txtnombre.value;
            llama('recetavet.php');
            break;                
        default:
            llama(value);
    }
}
function login(){
    // To create a cipher
    const myCipher = cipher('mySecretSalt')

    //alert(accessCookie("pcontrol"));
    //Then cipher any text:
    //var joel = myCipher(document.principal.txtpass.value)   // --> "7c606d287b6d6b7a6d7c287b7c7a61666f"

    //To decipher, you need to create a decipher and use it:
    //const myDecipher = decipher('mySecretSalt')
    //myDecipher("7c606d287b6d6b7a6d7c287b7c7a61666f")    // --> 'the secret string'

    llama('login.php');

}
function geninfo(){
    consulta=sessionStorage.getItem("consulta");        
    //var res = consulta.split("@");
    //alert(res[0]);
    //alert("desde:" + consulta);    
    document.write('<input type="text" name="elemento1">');
    document.principal.elemento1.value = consulta;

    findme(consulta,1);
}
function getage(){
    var edad =Math.round( ( ( Date.parse(getcurrenttime(3)) - Date.parse(document.principal.bdate.value) ) / (1000*60*60*24) ) /365) ;
    document.principal.edad.value =  edad;
}
function reasignme(value)
{

    //alert(value);
    //document.getElementById("txtname").value=value;

    switch (value){
        case 1: clearform(1);

    }    
}
function registramipac(value){
    var osito = document.principal.elemento1.value;
    var ositosplit = osito.split("@");

    

        if(ositosplit[0]==0){
            document.principal.elemento1.value = "insert@"+ositosplit[0];
        }else{
            document.principal.elemento1.value = "update@"+ositosplit[0];
        }
        
    
    llama("regpacientesvet.php");
}
function updaterec(value){
    var prox = document.principal.txtproxd.value;


    if(prox.length >0 ){
        var osito = document.principal.elemento1.value;
        var ositosplit = osito.split("@");
        document.principal.txtnombre.value = 'Guardada';
        switch (value){
            case 1:
                document.principal.elemento1.value = "guarda@"+ositosplit[0]+"@"+getcurrenttime(1)+"@"+ositosplit[2];
                break;
            case 2:
                document.principal.elemento1.value = "update@"+ositosplit[0]+"@"+ositosplit[1]+"@"+ositosplit[2]+"@"+ositosplit[3];
                break;
        }
        llama("recetavet.php");
    }else{
        alert("Proxima consulta esta Faltante");
        document.principal.txtproxd.focus();
    }
    
}
function updatevac(value){
//console.log(value);

        switch (value){
            case 1: 
                var osito = document.principal.txtnombre.value;
                var ositosplit = osito.split("@");

                document.principal.elemento1.value = "guarda@"+document.principal.despa.checked+"@"+getcurrenttime(1)+"@"+ositosplit[0];
                break;
            case 2: 
                document.principal.elemento1.value = "Piolasa@"+document.principal.despa.checked+"@"+document.principal.elemento1.value;
                break;
            case 3: 
                document.principal.elemento1.value = "delete@"+document.principal.despa.checked+"@"+document.principal.elemento1.value;
                break;                
        }
        llama("vacdesp.php");
}
function updatecons(value){
//console.log(value);
//alert(value);
    var tmp = document.principal.diag.value;
    switch (value){
        case 1: 
            document.principal.elemento1.value = "guarda";
            break;
        case 2: 
            document.principal.elemento1.value = "Piolasa";
            break;        
    }

    llama("consultavet.php");
}
function printTextArea() {
    if(document.principal.txtnombre.value != 'Guardada'){alert("La receta todavia no a sido Guardada necesita guardarla despues de la imprecion...");}
    childWindow = window.open('','childWindow','location=yes, menubar=yes, toolbar=yes');
    childWindow.document.open();
    childWindow.document.write('<html><head></head><body><br><br><br><br><br><br>');
    childWindow.document.write(document.getElementById('txtreceta').value.replace(/\n/gi,'<br>'));
    childWindow.document.write('</body></html>');
    childWindow.print();
    childWindow.document.close();
    childWindow.close();
}
function clearform(value){
    
    document.getElementById("txtpeso").value="";
    document.getElementById("txttalla").value="";
    document.getElementById("txtdiag").value="";
    document.getElementById("txtplan").value="";
    document.getElementById("txthistoria").value="";

    document.getElementById("txttemp").value="";
    document.getElementById("txtFC").value="";
    document.getElementById("txtFR").value="";
    document.getElementById("txttllc").value="";
    document.getElementById("txtpiel").value="";
    document.getElementById("txtsubmax").value="";
    document.getElementById("txtretro").value="";
    document.getElementById("txtaxi").value="";
    document.getElementById("txtingu").value="";

    if(value == 1 ){
        var actual = document.principal.txtnombre.value;

        var currentme = actual.split("@")


        var currentdate = new Date();
        
        var d = currentdate.getDate();
        var m = currentdate.getMonth() + 1;
        var y = currentdate.getFullYear();
        var dateStringeng = y+ '-' + (m <= 9 ? '0' + m : m)+ '-' +(d <= 9 ? '0' + d : d);
        var dateString = (d <= 9 ? '0' + d : d) + '-' + (m <= 9 ? '0' + m : m) + '-' + y;

        var h = currentdate.getHours();
        var mm = currentdate.getMinutes();
        var ss = currentdate.getSeconds();

        var timetostring = (h <= 9 ? '0' + h : h) + ':' + (mm <= 9 ? '0' + mm : mm) + ':' +  (ss <= 9 ? '0' + ss : ss);
        document.getElementById("lblcons").innerHTML = "Fecha Actual: ";

        //document.getElementById("lblultcons").innerHTML= "Fecha Actual: " + dateString + " " +  timetostring;
        document.getElementById("lblultcons").innerHTML=  dateString + " " +  timetostring;

        document.principal.txtnombre.value = currentme[0] + "@" + dateStringeng + " " +  timetostring;
    
        document.getElementById("btnsave").style.display="inline";
        document.getElementById("btncancel").style.display="inline";

        document.getElementById("btnnew").style.display="none";
        document.getElementById("btnupdate").style.display="none";
        document.getElementById("btnreceta").style.display="none";
    }

    if(value == 2 ){
        llama('iniciovet.php');
    }

}
function getcurrenttime(type){
    var currentdate = new Date();
        
    var d = currentdate.getDate();
    var m = currentdate.getMonth() + 1;
    var y = currentdate.getFullYear();
        var dateStringeng = y+ '-' + (m <= 9 ? '0' + m : m)+ '-' +(d <= 9 ? '0' + d : d);
        var dateStringeng2 = (m <= 9 ? '0' + m : m)+ '-' +(d <= 9 ? '0' + d : d)+ '-' + y;
        var dateString = (d <= 9 ? '0' + d : d) + '-' + (m <= 9 ? '0' + m : m) + '-' + y;
    var h = currentdate.getHours();
    var mm = currentdate.getMinutes();
    var ss = currentdate.getSeconds();

    var timetostring = (h <= 9 ? '0' + h : h) + ':' + (mm <= 9 ? '0' + mm : mm) + ':' +  (ss <= 9 ? '0' + ss : ss);

    if(type == 1){
        return dateStringeng// + " " + timetostring;
    }else if(type == 3){
        return dateStringeng;
    }else if(type == 4){
        return dateStringeng2;
    }else{
        return dateString + " " + timetostring;
    }


}
function llama(aquien){
    //alert(aquien);    
    document.principal.method = "POST";
    document.principal.action = aquien;
    document.principal.submit();
}
function max1(txarea){ 
    total = 300; 
    strtam = txarea.value.length; 
    str=""; 
    str=strtam; 
    Digitado.innerHTML = str; 
    Restante.innerHTML = total - str; 

    if (strtam > total){ 
        aux = txarea.value; 
        txarea.value = aux.substring(0,total); 
        Digitado.innerHTML = total 
        Restante.innerHTML = 0 
    } 
} 
function checkme(txarea){ 

    total = 300; 
    strtam = txarea.value.length; 
    str=""; 
    str=strtam;
    
    if (strtam > total){ 
            aux = txarea.value; 
            txarea.value = aux.substring(0,total);
        alert("You are now in end of the file");
    }
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function accessCookie(cookieName){
      return document.cookie;
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "; expires="+ d.toUTCString();
    
    
    //var exdate = new Date();
    //exdate.setDate(exdate.getDate() + exdays);
    //var cvalue = escape(cvalue) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString())

    //alert("seting the cookie " + expires);
    document.cookie = cname + "=" + cvalue  + expires + ";path=/";
    //document.cookie = cname + "=" + cvalue;
} 
const cipher = salt => {
      const textToChars = text => text.split('').map(c => c.charCodeAt(0));
      const byteHex = n => ("0" + Number(n).toString(16)).substr(-2);
      const applySaltToChar = code => textToChars(salt).reduce((a,b) => a ^ b, code);
  
      return text => text.split('')
          .map(textToChars)
          .map(applySaltToChar)
          .map(byteHex)
          .join('');
}
const decipher = salt => {
      const textToChars = text => text.split('').map(c => c.charCodeAt(0));
      const applySaltToChar = code => textToChars(salt).reduce((a,b) => a ^ b, code);
      return encoded => encoded.match(/.{1,2}/g)
          .map(hex => parseInt(hex, 16))
          .map(applySaltToChar)
          .map(charCode => String.fromCharCode(charCode))
          .join('');
}
function useradmin(type, value){
    
    var nombre = document.principal.validationCustom01.value
    var Apeidos = document.principal.validationCustom02.value
    var utype = document.principal.validationCustomUtype.value
    var username = document.principal.validationCustomUsername.value
    var pass = document.principal.validationCustompass.value

    

    var sigues = true;

    if(nombre.length == 0 ){sigues = false;}
    if(Apeidos.length == 0 ){sigues = false;}
    if(utype.length == 0 ){sigues = false;}
    if(nombre.length == 0 ){sigues = false;}
    if(username.length == 0 ){sigues = false;}
    if(pass.length == 0 ){sigues = false;}

    
    if(type =='find'){
        document.principal.elemento1.value = type + "@" + value;
        llama("useradmin.php");
    }else if(type =='delete'){
        document.principal.elemento1.value =  "delete@" + value;
        llama("useradmin.php");
    }else if(type =='cancel'){
        llama("inicio.php");
    }else if(sigues){
        switch (type){
            case 'insert':
                document.principal.elemento1.value = type + "@" + value;
                llama("useradmin.php");
                break;                
            case 'update':
                var osito = document.principal.txtnombre.value;
                document.principal.elemento1.value =  "update@" + osito;
                llama("useradmin.php");
                break;              
        }
    }
}
function citaadmin(type, value){
    
    var fechacita = document.principal.txtfechacita.value
    var nombrepac = document.principal.txtnombrepac.value
    var hora = document.principal.txthora.value
    var naci = document.principal.txtnaci.value
    var cel = document.principal.txtcel.value
    var email = document.principal.txtemail.value

    var sigues = true;

    if(fechacita.length == 0 ){sigues = false;}
    if(nombrepac.length == 0 ){sigues = false;}
    if(hora.length == 0 ){sigues = false;}
    if(hora.length == 0 ){sigues = false;}
    if(naci.length == 0 ){sigues = false;}
    if(cel.length == 0 ){sigues = false;}
    //if(email.length == 0 ){sigues = false;}


    if(type =='find'){
        var more = document.principal.elemento1.value
        if(value == 'me'){
            document.principal.txtnombre.value = "new"
            if(more.length == 0){
                document.principal.elemento1.value = type + "@" + value;     
            }
        }else{
            document.principal.elemento1.value = type + "@" + value; 
        }
        
        
        llama("citasvet.php");

    }else if(type =='delete'){
        document.principal.elemento1.value =  "delete@" + value;
        llama("citasvet.php");
    }else if(type =='cancel'){
        llama("inicio.php");
    }else if(sigues){
        switch (type){
            case 'insert':
                document.principal.elemento1.value = type + "@" + value;
                llama("citasvet.php");
                break;                
            case 'update':
                var osito = document.principal.elemento1.value;
                var ositos = osito.split("@")
                
                document.principal.elemento1.value =  "update@" + ositos[1];
                llama("citasvet.php");
                break;              
        }
    }
}
function hideme(value){
    document.getElementById(value).style.display="none";
}