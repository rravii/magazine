<?php 
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
    define('CAT_COLOR', ['cat-1', 'cat-2', 'cat-3', 'cat-4']);
?>

<div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">X</button>
      <h3>Please select the topic you are interested in:</h3>
</div>
<div class="modal-body">
    <div class="panel panel-default">
        <form action="cms/process/join" method="post">
            <div class="panel-body">
                    <?php 
                        $Category = new category();
                        $categories = $Category->getAllCategory();
                        if ($categories){
                            foreach($categories as $key => $category){
                    ?>
                            <div class="post-meta" style="padding: 25px 0px 0px 0px;">
                                <a class="post-category <?php echo CAT_COLOR[$category->id%4] ?>" href="loadmore?id=<?php echo $category->id; ?>">
                                    <?=$category->categoryname ?>
                                </a>
                            </div>
                    <?php
                            }
                        }
                    ?>
                    <!-- <div class="text-left">Name:</div>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="text-left">Email:</div>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="text-left">Skills and Experience:</div>
                    <textarea name="message" id="message" cols="30" rows="6" class="form-control"></textarea> -->
            </div>
        </form>
    </div>
</div>