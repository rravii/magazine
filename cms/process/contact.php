<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Contact = new contact();

    if($_GET){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $comment_id = (int)$_GET['id'];
            if($comment_id){
                $reject_act = substr(md5("Reject-Comment-".$comment_id.$_SESSION['token']), 3, 15);
                if ($reject_act == $_GET['act']){
                    $comment_info = $Contact->getContactbyId($comment_id);
                    if($comment_info){
                        $data = array(
                            'state'=>'reject'
                        );
                        $success = $Contact->updateContactById($data, $comment_id);
                        if($success){
                            redirect('../contact', 'success', 'Comment rejected Successfully');
                        }else{
                            redirect('../contact', 'error', 'Error while rejecting Comment');
                        }
                    }else{
                        redirect('../contact', 'error', 'Comment not Found');
                    }
                }else{
                    redirect('../contact', 'error', 'Invalid Action');
                }
            }else{
                redirect('../contact', 'error', 'ID is invalid');
            }
        }else{
            redirect('../contact', 'error', 'ID is required');
        }
    }else{
        redirect('../contact', 'error', 'Unauthorized Access');
    }
?>