<?php
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    $Category = new category();

    // debugger($_POST);
    if($_POST){
        $data = array(
            'categoryname' => sanitize($_POST['categoryname']), //sanitize: remove all illegal character
            'description' => htmlentities($_POST['description']), //sanitize is not used as it will remove all the effects used in description..... and htmlentities means &lt;p&gt format ma save hunu in db
            'status' => 'Active',
            'added_by' => $_SESSION['user_id']
        );

        // debugger($data);
        if(isset($_POST['id']) && !empty($_POST['id'])){
            //update
            $act = 'update';
            $category_id = (int)$_POST['id']; // type casting
        }else{
            //add
            $act = 'add';
            $category_id = false;
        }

        // adding in database:
        if ($category_id){

        }else{
            $success = $Category->addCategory($data);
        }
        if ($success){
            redirect('../category', 'success', 'Category Added Successfully');
        }else{
            redirect('../category', 'error', 'Problem while adding Category');
        }
    }else{
        redirect('../category', 'error', 'Unauthorized Access');
    }
?>