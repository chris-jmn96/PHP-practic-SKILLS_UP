<?php
require"../require/config.php";

//define y inicializa las variables que se van a usar del formulario.
$name = $email = $phone = $address = $city = $province = $zip = $other = $news = $newscheck="";
$name_err = $email_err = $phone_err = false;
$newsLettercheck;
/**
 * Función para limpiar un dato procedente de un formulario.
 * 
 * @param $data
 * @return $data
 */

function limpiar_dato($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//nombre, email y nº de telefono.
/**
 * Función para validar nombre que solo contenga letras min y MAY, y espacio en blanco.
 *
 * @param $name
 * @return boolean
 */

    function validar_name($name){
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
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
        
        //TODO:documentar función.
        /**
         * Validar un número de telefono.
         * @param $phone
         * @return Boolean
        */

        function validar_phone($phone){
            if (!preg_match("/^[0-9]{9}+$/",$phone)) { 
                return false;
            } else {
                return true;
            }
        }

//Si (llega datos)Entonces

if($_SERVER["REQUEST_METHOD"] == "POST"){
    print_r ($_POST);
    
    if(!empty($_POST["name"]) || !empty($_POST["email"]) || !empty($_POST["phone"])){
        echo "<br><strong>name post hay datos</strong><br>";
        //Variables requeridas para enviar a BBDD:name,email y phone.
        $name = limpiar_dato($_POST["name"]);

        $email = limpiar_dato($_POST["email"]);

        $phone = limpiar_dato($_POST["phone"]);


        if (validar_name($name)){
            
            }else{
                $name_err=true;
        }

        if (validar_email($email)){
        
            }else{
                $email_err=true;
        }

        if (validar_phone($phone)){
        
            }else{
                $phone_err=true;
        }

        if(validar_name($name) && validar_email($email) && validar_phone($phone)){
        
            
            if(isset($_POST["address"])){
                $address = limpiar_dato ($_POST["address"]);
            }else{
                $address = NULL;
            }

            if(isset($_POST["city"])){
                $city = limpiar_dato ($_POST["city"]);
            }else{
                $city = NULL;
            }

            if(isset($_POST["province"])){
                $province = limpiar_dato ($_POST["province"]);
            }else{
                $province = NULL;
            }

            if(isset($_POST["zip"])){
                $zip = limpiar_dato ($_POST["zip"]);
            }else{
                $zip = NULL;
            }
            
            // if(isset($_POST["newscheck"])){
            //     $newscheck = limpiar_dato ($_POST["newscheck"]);
            // }else{
            //     $newscheck = NULL;
            // }
            
            if(isset($_POST["news"])){
                $news = limpiar_dato ($_POST["news"]);
            }else{
                $news = NULL;
            }
            
            if(isset($_POST["other"])){
                $other = limpiar_dato ($_POST["other"]);
            }else{
                $other = NULL;
            }
            
            echo "<br><strong>Name:</strong>" . $name . "<br>";
            echo "<br><strong>Telefono:</strong>" . $phone . "<br>";
            echo "<br><strong>Email:</strong>" . $email . "<br>";
            echo "<br><strong>Address:</strong>" . $address . "<br>";
            echo "<br><strong>City:</strong>" . $city . "<br>";
            echo "<br><strong>Province:</strong>" . $province . "<br>";
            echo "<br><strong>Zip:</strong>" . $zip . "<br>";
            echo "<br><strong>other:</strong>" . $other . "<br>";
           // echo "<br><strong>News:</strong>" . $news . "<br>";
            echo "<br><strong>Newscheck:</strong>" . $newscheck . "<br>";
            
            //echo "</br>";
            $newscheck = filter_input(
                INPUT_POST,
                'newscheck',
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_REQUIRE_ARRAY
            );
            var_dump($newscheck);
            echo "<br>Longitud de newsletter: " . count($newscheck) .".";

            $lengArray = count($newscheck);
            switch ($lengArray){
                case 1:
                    if ($newscheck [0] == "HTML"){
                        $newsLettercheck = bindec('100');
                    } elseif ($newscheck [0] == "CSS"){
                        $newsLettercheck = bindec('010');
                    } else {
                        $newsLettercheck = bindec('001');
                    }
                    break;
                case 2: 
                    if (newscheck[0] != "HTML"){
                        $newsLettercheck = bindec('011');
                    } elseif (newscheck[0] != "CSS") {
                        $newsLettercheck = bindec('101');
                    } else {
                        $newsLettercheck = bindec('110');
                    }
                    break;
                case 3:
                    $newscheck == bindec('111');
                    break;
                default:
                    $newscheck == bindec('100');
            }

            echo "Valor a devolver" . $newsLettercheck;
            echo "<br>";

            $string=implode(", ",$newscheck);
            echo $string;
            echo "</br>"; 
            // === FIN MOSTRAR valores array.
        
            $other = limpiar_dato($_POST["other"]);
            // echo "<strong>Noticias que quiere recibir: $newscheck";
            var_dump($name);
            
            echo "<br><strong>Name:</strong> $name <br>";
            echo "<strong>Telefono:</strong> $phone <br>";
            echo "<strong>Email: </strong> $email <br>";

        try{
            $sql = "SELECT * from news_reg WHERE fullname = :fullname OR email = :email OR phone = :phone";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":fullname", $name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);

            $stmt->execute();
            $resultado = $stmt->fetchAll();
            echo "resultado es: " . var_dump($resultado) . "<br>";
            if($resultado){
                echo "La información existe.<br>";
            } else {
                try{
                    $sql = "INSERT INTO news_reg (fullname, email, phone, address, city, state, zipcode, newsletters, format_news, suggestion) VALUES (:fullname, :email, :phone, :address, :city, :state, :zipcode, :newsletters, :format_news, :suggestion)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':fullname', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                    $stmt->bindParam(':state', $province, PDO::PARAM_STR);
                    $stmt->bindParam(':zipcode', $zip, PDO::PARAM_STR);
                    $stmt->bindParam(':newsletters', $newsLettercheck, PDO::PARAM_INT);
                    $stmt->bindParam(':format_news', $news, PDO::PARAM_INT);
                    $stmt->bindParam(':suggestion', $other, PDO::PARAM_STR);

                    $stmt->execute();
                    echo "New record created successfully. <br>";
                    echo "Valor a ingresado decimal de 3bit: " . $newsLettercheck . "<br>";
                } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
                $conn = null;
            }
        }   catch (PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }
         
        }else{
        
            // var_dump($phone);
            // var_dump($phone_err);
            if ($name_err==true){
                echo "la validación de name ha fallado";
            }elseif($email_err==true){
                echo "La validación de email ha fallado";
            }elseif($phone_err==true){
                echo "La validación de phone ha fallado";
            } 
        }
    
    }else{
        echo "No han llegado las variables requeridas";
    }   
}else{
        echo "fallo el metodo post";
}


//si los datos llegan se  limpia la informacion

/*Inicialización de las variables 
Si (llega datos) Entonces
tratamos datos
Si si hay información Entonces
Si no llegan variables?**
                limpiar la información. check!!
                validar la informacinon.
                Si datos necesarios Entonces
                    asegurar de que están bien escrito.
                SiNo
                    mandamos dato tal cual.
                Fin Si
                Mostrar que todos los datos son correctos para enviar a BBDD.
        SiNo
            enviar datos necesarios
        Fin Si
SiNo
    avisar no han llegado.
Fin Si */
?>