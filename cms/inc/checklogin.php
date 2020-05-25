<?php
    $user = new user();
    if(isset($_SESSION['token']) && !empty($_SESSION['token'])){ //if SESSION_TOKEN exists
        $user_info=$user->getUserbySessionToken($_SESSION['token']);//database bata $_SESSION['token'] ko adhar ma user lai tanxa
        if (!isset($user_info[0]->session_token) || empty($user_info[0]->session_token)){
            redirect('logout');
        }else{
            if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)=='login'){ // yadi yo line bhayena bhanae we will be contionusly redirected to index page with infinite loop(ie index.php ma gayo include le checlogin.php mai pathai dinxa ani pheri index ma janxa.. infinite loop)
                redirect('index'.'success','You are already logged in.');
            }
        }
    }else{
        // session token not available
        if(isset($_COOKIE['_auth_user']) && !empty($_COOKIE['_auth_user'])){
            // no session but yes cookie
            $token = $_COOKIE['_auth_user'];
            $user_info =$user->getUserbySessionToken($token);
            if (isset($user_info[0]->session_token) && !empty($user_info[0]->session_token)){//session_token ra $token ko match bhayo bhanae
                $_SESSION['user_id'] = $user_info[0]->id;
                $_SESSION['user_name'] = $user_info[0]->username;
                $_SESSION['user_email'] = $user_info[0]->email;
                $_SESSION['user_role'] = $user_info[0]->role;
                $_SESSION['user_status'] = $user_info[0]->status;
                $token = tokenize();
                $_SESSION['token'] = $token;

                $datas = array(
                    'session_token' => $token
                );
                $user->updateUserByEmail($datas,$_SESSION['user_email']);
                setcookie('_auth_user',$token,time()+(60*60*24*7),'/'); //_auth_user name matra set garya ho

                if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)=='login'){
                    redirect('../index','success','Welcome to Dashboard.');
                }
            }else{// no session but yes cookie but not matching with session so we delete the cokiee
                setcookie('_auth_user','',time()-100,'/');
                if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)!='login'){
                    redirect('login','error','You must logged in first.');
                }
            }
        }

        if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)!='login'){ //pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) gives hami kun file ma xau bhanera
            // no session and no cookie
            redirect('login','error','You must logged in first.'); // yaha ../login garnu parena kinaki index.php le yo file lai call gari ra xa ra index.php ra login.php autai directory ma xan
        }
    }
?>