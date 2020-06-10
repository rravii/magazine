<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Subscribe = new subscribe();

    // debugger($_POST,true);
    if($_POST){
        $data = array(
            'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL), 
            'status' => 'Active',
        );
        $subscribe = $Subscribe->searchSubscribeByEmail($data['email']);
        if ($subscribe){
                redirect('../index', 'error', 'You have already subscribed.');
        }else{
            $success = $Subscribe->addSubscribe($data);
        }
        if($success){
            redirect('../index', 'success', 'Successfully subscribed');
        }else{
            redirect('../index', 'error', 'Error while subscribing. Please subscribe once more.');
        }
    }else{
        redirect('../index', 'error', 'Unauthorized Access');
    }
?>