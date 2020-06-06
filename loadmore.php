<?php 
	include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$cat_id = (int)$_GET['id'];
		if($cat_id){
			$Category = new category();
			$category_info = $Category->getCategorybyId($cat_id);
			if($category_info){
				$category_info = $category_info[0];
				$concade = $category_info->categoryname;
			}else{
				redirect('index');
			}
		}else{
			redirect('index');
		}
	}else{
		redirect('index');
	}
	$bread = "More Content | ".$concade;
	include 'inc/header.php';
?>

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="section-title">
							<h2>According to read:</h2>
						</div>
					</div>
									
					<?php
						$Blog = new blog();
						$count = $Blog->getNumberBlogByCategory($cat_id);
						// debugger($count,true);
						$count_info = $count[0]->total;
						$recentBlog = $Blog->getAllPopularBlogByCategoryWithLimit($cat_id, 0, $count_info);
						// debugger($recentBlog);
						if($recentBlog){
							foreach($recentBlog as $key => $blog){
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
							}
						}
					?>
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

<?php include 'inc/footer.php' ?>