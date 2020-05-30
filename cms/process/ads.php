<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Ads = new ads();

    // debugger($_POST);
    // debugger($_FILES,true);
    if($_POST){
        $data = array(
            'url' => sanitize($_POST['url']), //sanitize: remove all illegal character
            'adType' => sanitize($_POST['adType']),
            'status' => 'Active',
            'added_by' => $_SESSION['user_id']
        );

        // debugger($data);

        if(isset($_FILES) && !empty($_FILES) && !empty($_FILES['image']) && !empty($_FILES['image']['error'] == 0)){
            $success = uploadImage($_FILES['image'], 'ads');
        
            if ($success){
                $data['image'] = $success;
                if (isset($_POST['old_image']) && !empty($_POST['old_image']) && file_exists(UPLOAD_PATH.'ads/'.$_POST['old_image'])){
                    unlink(UPLOAD_PATH.'ads/'.$_POST['old_image']);
                }
            }else{
                redirect('../ads', 'error', 'Error while uploading Image');
            }
        }

        if(isset($_POST['id']) && !empty($_POST['id'])){
            //update
            $act = 'updat';
            $ads_id = (int)$_POST['id']; // type casting
        }else{
            //add
            $act = 'add';
            $ads_id = false;
        }

        // adding in database:
        if ($ads_id){
            $ads_info = $Ads->getAdsbyId($ads_id);
            // debugger($ads_info,true);
            if ($ads_info){
                if ($_SESSION['user_id'] == $ads_info[0]->added_by){
                    $success = $Ads->updateAdsById($data, $ads_id);
                }else{
                    redirect('../ads', 'error', 'You are not allowed to access this Ads.');
                }
            }else{
                redirect('../ads', 'error', 'Ads not Found');
            }
        }else{
            $success = $Ads->addAds($data);
        }
        if ($success){
            redirect('../ads', 'success', 'Ads '.$act.'ed Successfully');
        }else{
            redirect('../ads', 'error', 'Problem while '.$act.'ing Ads');
        }
    }else if($_GET){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $ads_id = (int)$_GET['id'];
            if($ads_id){
                $act = substr(md5("Delete-Ads-".$ads_id.$_SESSION['token']), 3, 15);
                if(isset($act) && !empty($act)){
                    if ($act == $_GET['act']){
                        $ads_info = $Ads->getAdsbyId($ads_id);
                        if($ads_info){
                            $data = array(
                                'status'=>'Passive'
                            );
                            $success = $Ads->updateAdsById($data, $ads_id);
                            if($success){
                                redirect('../ads', 'success', 'Ads Deleted Successfully');
                            }else{
                                redirect('../ads', 'error', 'Error while Deleting Data');
                            }
                        }else{
                            redirect('../ads', 'error', 'Ads not Found');
                        }
                    }else{
                        redirect('../ads', 'error', 'Invalid Action');
                    }
                }else{
                    redirect('../ads', 'error', 'Action is required');
                }
            }else{
                redirect('../ads', 'error', 'ID is invalid');
            }
        }else{
            redirect('../ads', 'error', 'ID is required');
        }
    }else{
        redirect('../ads', 'error', 'Unauthorized Access');
    }
?>