<?php

    $headers = getallheaders();
//print_r($headers);die;
    if(isset($headers['x-hello-world']) && $headers['x-hello-world'] != '') {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $clientIp = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $clientIp = $forward;
        }
        else{
            $clientIp = $remote;
        }

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Max-Age: 3600");
        header("x-hello-world: ".$headers['x-hello-world']);

        if(isset($_GET['name'])) {
            echo json_encode(array("ip" => $clientIp, "mesaage" => "Greetings ".$_GET['name']));
        } else {
            echo json_encode(array("ip" => $clientIp));
        }
    } else {
        echo json_encode(array("error" => "header missing"));
    }

    
?>
