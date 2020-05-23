<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    
    // redirect('cms/index');
    // debugger($_SERVER)

    $user = new user();
    // $data = array(
    //     'username' => 'Khwopa',
    //     'email' => 'khwopa@magazine.com',
    //     'role' => "Admin"
    // );

    $data = array(
        'username' => 'Ravi',
        'session_token' => tokenize()
    );

    // $data1 = "username = 'admin', email = 'admin@skdfjllk.com'" //yasto ni data pathau na sakxa and we cant deny its wrong so db.php ma else portion ma add garya xa
    // $user->addUser($data);
    // $datas=$user->getUserbyId(3);
    // $datas=$user->getUserbyEmail('admin@magazine.com');
    // $datas=$user->updateUserbyEmail($data,'admin@magazine.com'); //yo email ko detail update bhayera mathi ko ravi bhan nae detail bata change hunxa
    
    $user->deleteUserbyEmail('khwopa@magazine.com');
    // debugger($datas);

?>