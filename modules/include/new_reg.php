<?php 
require "../require/config.php";

$name = $email = $phone = $street = $city = $province = $zip = $newscheck = $news = $other ="";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["name"]) || !empty($_POST["email"]) || !empty($_POST["phone"])){
        echo"<br><strong>Método post hay datos</strong><br>";
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $province = $_POST["province"];
        $zip = $_POST["zip"];
        $newscheck = $_POST["newscheck"];
        $news = $_POST["news"];
        $other = $_POST["other"];

        function limpiar_dato($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
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