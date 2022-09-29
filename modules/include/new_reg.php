<?php 
require "../require/config.php";

$name = $email = $phone = $street = $city = $province = $zip = $newscheck = $news = $other ="";

function limpiar_datos($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
    
if($_SERVER["REQUEST_METHOD"] == "POST"){
    print_r($_POST);
    if(!empty($_POST["name"]) || !empty($_POST["email"]) || !empty($_POST["phone"])){
        echo"<br><strong>Método post hay datos</strong><br>";
        $name = limpiar_datos($_POST["name"]);
        echo " $name ";
        $email = limpiar_datos($_POST["email"]);
        echo "$email";
        $phone = limpiar_datos ($_POST["phone"]);
        echo "$phone";
        $address = limpiar_datos ($_POST["address"]);
        $city = limpiar_datos ($_POST["city"]);
        $province = limpiar_datos ($_POST["province"]);
        $zip = limpiar_datos ($_POST["zip"]);
        $newscheck = limpiar_datos ($_POST["newscheck"]);
        $news = limpiar_datos ($_POST["news"]);
        $other = limpiar_datos ($_POST["other"]);
        var_dump($name);
    
    //no funciona
    if(validar_name($name)){
        echo"validada";
    }else{
        echo"no validada";
    }
        
        function validar_name($name){
            if(!preg_match("/^[a-zA-Z-' ]$/",$name)){
                return false;
            }else{
                return true;
            }
        }
        function validar_email($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }else{
                return true;
            }
        }
        function validar_movil($phone){
            if (!preg_match("(+34|0034|34)?[ -](6|7)[ -]([0-9][ -]*){8}",$phone)) {
                return false;
            }
            else {
                return true;
            }
        }
    } 
}
?>