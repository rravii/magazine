<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Join = new join();

    // debugger($_POST,true);
    if($_POST){
        $act ="Add";
        $data = array(
            'name' => sanitize($_POST['name']), //sanitize: remove all illegal character
            'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL), 
            'message' => sanitize(htmlentities($_POST['message'])),
            'status' => 'Active',
        );

        $success = $Join->addJoin($data);
        if($success){
            redirect('../index', 'success', 'Join request added successfully.');
        }else{
            redirect('../index', 'error', 'Error while adding join request');
        }
    }else{
        redirect('../index', 'error', 'Unauthorized Access');
    }
?>