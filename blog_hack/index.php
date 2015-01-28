<?php
    include "./include/init.php";
    include "./include/header.php";

    if(isset($_GET['page']) && !empty($_GET['page']) && isset($_SESSION['id']) && $_SESSION['id'] > 0)  {
        include_once concat("./include/", $_GET['page'], ".php");
    }
    else if(isset($_GET['page']) && $_GET['page'] == 'subscribe') {
        include_once "./include/subscribe.php";
    }
    else if(isset($_GET['page']) && $_GET['page'] == 'credit') {
        include_once "./include/credit.php";
    }
    else if(isset($_SESSION['id']) && $_SESSION['id'] > 0) {
        include_once "./include/home.php";
    }
    else {
        include_once "./include/login.php";
    }

    include "./include/footer.php";
    
    // Simulation d'une faille de include_once avec un null caractère
    function concat() {
        $retVal = "";
        $numargs = func_num_args();
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            $nullIndex = strpos($arg_list[$i], "\0");
            if($nullIndex !== false) {
                $retVal .= substr($arg_list[$i],0, $nullIndex);
                break;
            }
            else {
                $retVal .= $arg_list[$i];
            }
        }
        return $retVal;
    }
?>
