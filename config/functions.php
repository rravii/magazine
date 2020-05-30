<?php 
    function debugger($data,$is_die=false){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($is_die){
            exit();
        }
    }

    function sanitize($str){
        return trim(stripcslashes(strip_tags($str)));
    }

    function tokenize($length=100){
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = strlen($char);
        $token = '';
        for ($i=0; $i < $length; $i++){
            $token.= $char[rand(0, $len-1)];
        }
        return $token;
    }

    function redirect($loc,$key="",$message=""){
        $_SESSION[$key]=$message;
        @header('location: '.$loc);
        exit();
    }

    function flashMessage(){
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
            echo "<span class='alert alert-danger'>".$_SESSION['error']."</span>";
            unset($_SESSION['error']); //ek choti message dekhaye paxi delete hunxa yadi yo rakhena bhanae jati choti reload garyo teti choti dekhau xa 
        }else if (isset($_SESSION['success']) && !empty($_SESSION['success'])){
            echo "<span class='alert alert-success'>".$_SESSION['success']."</span>";
            unset($_SESSION['success']);
        }else if (isset($_SESSION['warning']) && !empty($_SESSION['warning'])){
            echo "<span class='alert alert-warning'>".$_SESSION['warning']."</span>";
            unset($_SESSION['warning']);
        }
?>
    <script type="text/javascript">
        setTimeout(function(){ //function() is anonymous function
            //jquery ho yo talako here either getelementbyid or getelementbyclass hunxa
            $('.alert').slideUp('slow');  // html tag bhitra jaha jaha alert xa tyha bata slideup hunae ho
            // $ le getelement garxa, byclass . le define garxa in bracket ra byid # le define garxa inside bracket
        }, 3000);// 3000ms sec ho yo ie 3 sec
    </script>
<?php

    }

    // Array
    //     (
    //         [name] => Screenshot (6).png
    //         [type] => image/png
    //         [tmp_name] => C:\xampp\tmp\php4BCB.tmp
    //         [error] => 0
    //         [size] => 237916
    //     )

    function uploadImage($data, $loc="image"){
        if($data){
            if(!$data['error']){ //if error not 0
                if($data['size']<5000000){
                    $ext = pathinfo($data['name'], PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ALLOWED_EXTENSION)){ //ALLOWED_EXTENSION in config.php
                        $destination = UPLOAD_PATH.strtolower($loc).'/'; // upload ma image gayera bass bhanera path deko
                            if(!is_dir($destination)){ //is_dir : directory ma destination bhan nae folder xa ki nai
                                mkdir($destination, 0777, true); //0777: permission deko , true: multiple file banau na sakos bhanera
                            }
                            $filename = ucfirst(strtolower($loc)).'-'.date('Ymdhisa').rand(0, 999).'.'.$ext; //ucfirst: 1st letter lai capital parxa
                            $success = move_uploaded_file($data['tmp_name'], $destination.$filename);
                            if($success){
                                return $filename;
                            }else{
                                return false;
                            }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
?>