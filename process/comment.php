<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Comment = new comment();

    // debugger($_POST,true);
    if($_POST){
        $act ="Add";
        $data = array(
            'name' => sanitize($_POST['name']), //sanitize: remove all illegal character
            'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL), 
            'website' => sanitize($_POST['website']), 
            'message' => sanitize(htmlentities($_POST['message'])),
            'status' => 'Active',
            'blogid' => (int)$_POST['blogid'],
            'state' => 'waiting'
        );

        // debugger($data);
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
            $comment_info = $Comment->getCommentbyId($comment_id);
            // debugger($comment_info,true);
            if ($comment_info){
                    $success = $Comment->addComment($data);
            }else{
                redirect('../blog-post?id='.$data['blogid'], 'error', 'Comment not Found');
            }
        }else{
            $success = $Comment->addComment($data);
        }
        if ($success){
            redirect('../blog-post?id='.$data['blogid'], 'success', 'Comment '.$act.'ed Successfully');
        }else{
            redirect('../blog-post?id='.$data['blogid'], 'error', 'Problem while '.$act.'ing Comment');
        }
    }
?>