<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Archive = new archive();

    // debugger($_POST);
    if($_POST){
        $data = array(
            'date' => sanitize($_POST['date']), //sanitize: remove all illegal character
            'status' => 'Active',
            'added_by' => $_SESSION['user_id']
        );

        // debugger($data);
        if(isset($_POST['id']) && !empty($_POST['id'])){
            //update
            $act = 'updat';
            $archive_id = (int)$_POST['id']; // type casting
        }else{
            //add
            $act = 'add';
            $archive_id = false;
        }

        // adding in database:
        if ($archive_id){
            $archive_info = $Archive->getArchivebyId($archive_id);
            // debugger($archive_info,true);
            if ($archive_info){
                if ($_SESSION['user_id'] == $archive_info[0]->added_by){
                    $success = $Archive->updateArchiveById($data, $archive_id);
                }else{
                    redirect('../archive', 'error', 'You are not allowed to access this Archive.');
                }
            }else{
                redirect('../archive', 'error', 'Archive not Found');
            }
        }else{
            $success = $Archive->addArchive($data);
        }
        if ($success){
            redirect('../archive', 'success', 'Archive '.$act.'ed Successfully');
        }else{
            redirect('../archive', 'error', 'Problem while '.$act.'ing Archive');
        }
    }else if($_GET){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $archive_id = (int)$_GET['id'];
            if($archive_id){
                $act = substr(md5("Delete-Archive-".$archive_id.$_SESSION['token']), 3, 15);
                if(isset($act) && !empty($act)){
                    if ($act == $_GET['act']){
                        $archive_info = $Archive->getArchivebyId($archive_id);
                        if($archive_info){
                            $data = array(
                                'status'=>'Passive'
                            );
                            $success = $Archive->updateArchiveById($data, $archive_id);
                            if($success){
                                redirect('../archive', 'success', 'Archive Deleted Successfully');
                            }else{
                                redirect('../archive', 'error', 'Error while Deleting Data');
                            }
                        }else{
                            redirect('../archive', 'error', 'Archive not Found');
                        }
                    }else{
                        redirect('../archive', 'error', 'Invalid Action');
                    }
                }else{
                    redirect('../archive', 'error', 'Action is required');
                }
            }else{
                redirect('../archive', 'error', 'ID is invalid');
            }
        }else{
            redirect('../archive', 'error', 'ID is required');
        }
    }else{
        redirect('../archive', 'error', 'Unauthorized Access');
    }
?>