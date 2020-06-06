<?php 
    include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	// $bread = "Search";
	include 'inc/header.php';
?>

<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- post widget -->
            <div class="aside-widget">
                <div class="section-title">
                    <h2>Search Results:</h2>
                </div>

                <?php
                    if(isset($_GET['searchtext']) && !empty($_GET['searchtext'])){
                        $text = $_GET['searchtext'];
                        if($text){
                            $Blog = new blog();
                            $blog_info = $Blog->searchBlog($text);
                            //  debugger($blog_info,true);
                            if($blog_info){
                            foreach($blog_info as $key => $blog){
                                    // echo ($word." ");
                                    // if(lcfirst($word) == $text){
                                        // echo $blog->title;
                                        if(isset($blog->image) && !empty($blog->image) && file_exists(UPLOAD_PATH."blog/".$blog->image)){
                                            $thumbnail = UPLOAD_URL."blog/".$blog->image;
                                        }else{
                                            $thumbnail = UPLOAD_URL.'no-image.jpg';
                                        }
                ?>
                                    <!-- post -->
                                        <div class="col-md-4">
                                            <div class="post">
                                                <a class="post-img2" href="blog-post?id=<?php echo $blog->id ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
                                                <div class="post-body">
                                                    <div class="post-meta">
                                                        <a class="post-category <?php echo CAT_COLOR[($blog->categoryid)%4] ?>" href="#"><?php echo $blog->category; ?></a>
                                                        <span class="post-date"><?php echo date('M d, Y', strtotime($blog->created_date)); ?></span>
                                                    </div>
                                                    <h3 class="post-title"><a href="blog-post?id=<?php echo $blog->id ?>"><?php echo $blog->title; ?></a></h3>
                                                    <p>Total read : <?= ($blog->view)?$blog->view:0 ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- /post -->
					<?php
                                    // }else{
                                    //     continue;
                                    // }
                              
                            }
                        }else{
                            echo "<p>Sorry, No blogs found with ".$text." </p>";
                        }

                        }else{
                    ?>
                            <p>Sorry!! No blogs found. Please search for the appropiate content.</p>
                    <?php
                        }
                    }else{
                    ?>
                            <p>Sorry!! No blogs found. Please search for the appropiate content.</p>
                    <?php
                    }
                ?>

            </div>
            <!-- /post widget -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->

<?php include 'inc/footer.php'; ?>