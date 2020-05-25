<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php'; // DOCUMENT_ROOT samma chai magazine/ samma ko part dinxa
    // 'config/init.php' le config bhitra ko sabai file load hunxa

    debugger($_POST);
    $data = array();
    if ($_POST) {
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $data['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            if($data['email']){
                if(isset($_POST['password']) && !empty($_POST['password'])){
                    $data['password'] = sha1($_POST['email'].$_POST['password']);
                    $user = new user(); //yo user.php ma bha ko user ko object banako for getUserbyEmail
                    $user_info = $user->getUserbyEmail($data['email']);
                    debugger($user_info);

                    if(isset($user_info[0]->email) && !empty($user_info[0]->email)){ //Array ma 0 index ma database ma user xa ki xaina bhanera
                        if($user_info[0]->password==$data['password']){//database ra user le pathako password milyo ki nai bhanaera
                            if($user_info[0]->role=='Admin'){// database ma check garxa ra Admin ho ki hoina bhanxa
                                if($user_info[0]->status=='Active'){//database ma user ko status active xa ki xaina
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
                                    if(isset($_POST['rememberme']) && !empty($_POST['rememberme']) && $_POST['rememberme']=='on'){
                                        setcookie('_auth_user',$token,time()+(60*60*24*7),'/'); //_auth_user name matra set garya ho
                                    }

                                    redirect('../index','success','Welcome to Dashboard.');

                                }else{
                                    redirect('../login','error','Your account is not active.');
                                }
                            }else{
                                redirect('../login','error','You cannot logged in here.');
                            }
                        }else{
                            redirect('../login','error',"Password doesn't Match.");
                        }
                    }else{// 0 index ma bhako user hamro database ma xaina bhanae 
                        redirect('../login', 'error', 'Email not Found. Please Register or contact magazine.com Administration');
                    }
                }else{
                    redirect('../login','error','Password is required.');
                }
            }else{
                redirect('../login','error','Email type is not correct.');
            }
        }else{
            redirect('../login','error','Email is required.');
        }        
    }else{
        redirect('../login','error','Unauthorized Access..');
    }
?>