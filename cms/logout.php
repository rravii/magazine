<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php'; // DOCUMENT_ROOT samma chai magazine/ samma ko part dinxa
    // 'config/init.php' le config bhitra ko sabai file load hunxa 
    $user = new user();
    $datas = array( //database ma bhako session token lai empty garxa
        'session_token' => ''
    );
    $user->updateUserByEmail($datas,$_SESSION['user_email']);

    if(isset($_COOKIE['_auth_user']) && !empty($_COOKIE['_auth_user'])){ // deleteing cookie logout bhayo bhanae
        setcookie('_auth_user'," ",time()-(60*60*24*7),'/');
    }
    session_unset(); // process bhitra login.php ma bhako sabai variable lai unset gar dinxa including $_SESSION['token']
    redirect('login');
?>