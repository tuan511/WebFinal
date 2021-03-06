<?php
    require_once ("config.php");
    require_once ("functions.php");

    $support_controller = array(
        "login" => array("index", "login"),
        "home" => array("index", "shared", "error", "create_dir", "up_load_files", "remove", "like", "note"),
        "register" => array("index", "register"),
        "logout" => array("logout"),
        "profile" => array("index", "change_info", "change_password"),
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["type"]) {
            case "login_form":
                if (isset($_COOKIE[TOKEN_HEADER])) {
                    $controller = "home";
                    $action = "index";
                    break;
                }
                $controller = "login";
                $action = "login";
                break;

            case "remove":
                if (isset($_COOKIE[TOKEN_HEADER])) {
                    $controller = "home";
                    $action = "remove";
                    break;
                }
                $controller = "login";
                $action = "login";
                break;

            case "like":
                if (isset($_COOKIE[TOKEN_HEADER])) {
                    $controller = "home";
                    $action = "like";
                    break;
                }
                $controller = "login";
                $action = "login";
                break;

            case "register_form":
                if (isset($_COOKIE[TOKEN_HEADER])) {
                    $controller = "home";
                    $action = "index";
                    break;
                }
                $controller = "register";
                $action = "register";
                break;
            case "upload_files":
                $controller = "home";
                $action = "up_load_files";
                break;
            case "change-profile":
                $controller = "profile";
                $action = "change_info";
                break;
            case "change-password":
                $controller = "profile";
                $action = "change_password";
                break;
        }
    }
    else if (isset($_GET['controller'])) {
        $controller = $_GET['controller'];
        if (isset($_COOKIE[TOKEN_HEADER]))
        {
            if ($controller == "login" || $controller == "register"){
                $controller = "home";
                $action = "index";
            }
        }
        if (isset($_GET['action'])) {
            $action = $_GET["action"];
        }
    }
    else {
        $controller = "home";
        $action = "index";
    }

    if (!array_key_exists($controller, $support_controller) || !in_array($action, $support_controller[$controller])) {
        $controller = "home";
        $action = "error";
    }

    include_once("controllers/" . $controller . "_controller.php");
    $className = ucfirst($controller)."Controller";

    $obj = new $className();
    $obj->$action();