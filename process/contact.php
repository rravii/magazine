<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $redirectUrl='../contact';

    $Contact = new contact();
    
    // debugger($_POST,true);
    if($_POST){
        // var_dump($_POST);
        // return;
        $act = "Add";
        if(isset($_POST['is_cms'])){
            $redirectUrl ='../cms/contact';
            $data = array(
                'name' => sanitize($_POST['name']), //sanitize: remove all illegal character
                'email' =>"admin@gmail.com", 
                'subject' => "Replied by Admin", 
                'message' => sanitize(htmlentities($_POST['message'])),
                'status' => 'Active',
                'state' => 'accept',
                'commentReplied' => 'replied'
            );
        }else{
            $data = array(
                'name' => sanitize($_POST['name']), //sanitize: remove all illegal character
                'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL), 
                'subject' => sanitize(htmlentities($_POST['subject'])), 
                'message' => sanitize(htmlentities($_POST['message'])),
                'status' => 'Active',
                'state' => 'accept'
            );
        }

        // debugger($data,true);
        if(isset($_POST['commentid']) && !empty($_POST['commentid'])){
            //Reply
            $comment_id = (int)$_POST['commentid']; // type casting
            $data['commentid'] = $comment_id;
            $data['commentType'] = 'reply';
        }else{
            //Comment
            $comment_id = false;
            $data['commentType'] = 'comment';
        }

        // adding in database:
        if ($comment_id){
            $comment_info = $Contact->getContactbyId($comment_id);
            // debugger($comment_info,true);
            if ($comment_info){
                $dataMain = array(
                    'commentReplied'=>'replied'
                );
                $success = $Contact->addContact($data);
                if($success&&isset($_POST['is_cms'])){
                $Contact->updateContactById($dataMain, $comment_id);
                }      
            }else{
                redirect($redirectUrl, 'error', 'Comment not Found');
            }
        }else{
            $success = $Contact->addContact($data);
        }
        if ($success){     
            redirect($redirectUrl, 'success', 'Comment '.$act.'ed Successfully');
        }else{
            redirect($redirectUrl, 'error', 'Problem while '.$act.'ing Comment');
        }
    }

  

    
?>