<?php 
	include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	include 'inc/header.php';
?>

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">	
					<?php 
						$Blog = new blog();
						$featuredBlog = $Blog->getAllFeaturedBlogWithLimit(0,5);
						// debugger($featuredBlog);
						if (isset($featuredBlog[0]) && !empty($featuredBlog[0]) && isset($featuredBlog[1]) && !empty($featuredBlog[1])){
					?>
					<!-- post -->
							<div class="col-md-6">
								<div class="post post-thumb">
									<?php
										if(isset($featuredBlog[0]->image) && !empty($featuredBlog[0]->image) && file_exists(UPLOAD_PATH."blog/".$featuredBlog[0]->image)){
											$thumbnail = UPLOAD_URL."blog/".$featuredBlog[0]->image;
										}else{
											$thumbnail = UPLOAD_URL.'no-image.jpg';
										}
									?>
									<a class="post-img1" href="blog-post?id=<?php echo($featuredBlog[0]->id); ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
									<div class="post-body">
										<div class="post-meta">
											<a class="post-category <?php echo CAT_COLOR[($featuredBlog[0]->categoryid)%4] ?>" href="#"><?php echo $featuredBlog[0]->category; ?></a>
											<span class="post-date"><?php echo date('M d, Y', strtotime($featuredBlog[0]->created_date)); ?></span>
										</div>
										<h3 class="post-title"><a href="blog-post?id=<?php echo($featuredBlog[0]->id); ?>"><?php echo $featuredBlog[0]->title; ?></a></h3>
									</div>
								</div>
							</div>
					<!-- /post -->
							
					<!-- post -->
							<div class="col-md-6">
								<div class="post post-thumb">
									<?php
										if(isset($featuredBlog[1]->image) && !empty($featuredBlog[1]->image) && file_exists(UPLOAD_PATH."blog/".$featuredBlog[1]->image)){
											$thumbnail = UPLOAD_URL."blog/".$featuredBlog[1]->image;
										}else{
											$thumbnail = UPLOAD_URL.'no-image.jpg';
										}
									?>
									<a class="post-img1" href="blog-post?id=<?php echo($featuredBlog[1]->id); ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
									<div class="post-body">
										<div class="post-meta">
											<a class="post-category <?php echo CAT_COLOR[($featuredBlog[1]->categoryid)%4] ?>" href="#"><?php echo $featuredBlog[1]->category; ?></a>
											<span class="post-date"><?php echo date('M d, Y', strtotime($featuredBlog[1]->created_date)); ?></span>
										</div>
										<h3 class="post-title"><a href="blog-post?id=<?php echo($featuredBlog[1]->id); ?>"><?php echo $featuredBlog[1]->title; ?></a></h3>
									</div>
								</div>
							</div>
							<!-- /post -->
					<?php
						}
					?>
				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="section-title">
							<h2>Recent Posts</h2>
						</div>
					</div>
									
					<?php
						$recentBlog = $Blog->getAllRecentBlogWithLimit(0,6);
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
											</div>
										</div>
									</div>
								<!-- /post -->
					<?php
							}
						}
					?>

					<!-- post -->
					<!-- <div class="col-md-4">
						<div class="post">
							<a class="post-img" href="blog-post.html"><img src="./assets/img/post-3.jpg" alt=""></a>
							<div class="post-body">
								<div class="post-meta">
									<a class="post-category cat-1" href="category.html">Web Design</a>
									<span class="post-date">March 27, 2018</span>
								</div>
								<h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
							</div>
						</div>
					</div> -->
					<!-- /post -->
				</div>
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->
		
		<!-- section -->
		<div class="section section-grey">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="section-title text-center">
							<h2>Featured Posts</h2>
						</div>
					</div>

					<?php
						if (isset($featuredBlog[2]) && !empty($featuredBlog[2]) && isset($featuredBlog[3]) && !empty($featuredBlog[3]) && isset($featuredBlog[4]) && !empty($featuredBlog[4])){
					?>
							<!-- post -->
							<div class="col-md-4">
										<div class="post">
											<?php
												if(isset($featuredBlog[2]->image) && !empty($featuredBlog[2]->image) && file_exists(UPLOAD_PATH."blog/".$featuredBlog[2]->image)){
													$thumbnail = UPLOAD_URL."blog/".$featuredBlog[2]->image;
												}else{
													$thumbnail = UPLOAD_URL.'no-image.jpg';
												}
											?>
											<a class="post-img2" href="blog-post?id=<?php echo($featuredBlog[2]->id); ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
											<div class="post-body">
												<div class="post-meta">
													<a class="post-category <?php echo CAT_COLOR[($featuredBlog[2]->categoryid)%4] ?>" href="#"><?php echo $featuredBlog[2]->category; ?></a>
													<span class="post-date"><?php echo date('M d, Y', strtotime($featuredBlog[2]->created_date)); ?></span>
												</div>
												<h3 class="post-title"><a href="blog-post?id=<?php echo($featuredBlog[2]->id); ?>"><?php echo $featuredBlog[2]->title; ?></a></h3>
											</div>
										</div>
									</div>
							<!-- /post -->
							<!-- post -->
							<div class="col-md-4">
										<div class="post">
											<?php
												if(isset($featuredBlog[3]->image) && !empty($featuredBlog[3]->image) && file_exists(UPLOAD_PATH."blog/".$featuredBlog[3]->image)){
													$thumbnail = UPLOAD_URL."blog/".$featuredBlog[3]->image;
												}else{
													$thumbnail = UPLOAD_URL.'no-image.jpg';
												}
											?>
											<a class="post-img2" href="blog-post?id=<?php echo($featuredBlog[3]->id); ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
											<div class="post-body">
												<div class="post-meta">
													<a class="post-category <?php echo CAT_COLOR[($featuredBlog[3]->categoryid)%4] ?>" href="#"><?php echo $featuredBlog[3]->category; ?></a>
													<span class="post-date"><?php echo date('M d, Y', strtotime($featuredBlog[3]->created_date)); ?></span>
												</div>
												<h3 class="post-title"><a href="blog-post?id=<?php echo($featuredBlog[3]->id); ?>"><?php echo $featuredBlog[3]->title; ?></a></h3>
											</div>
										</div>
									</div>
							<!-- /post -->
							<!-- post -->
							<div class="col-md-4">
										<div class="post">
											<?php
												if(isset($featuredBlog[4]->image) && !empty($featuredBlog[4]->image) && file_exists(UPLOAD_PATH."blog/".$featuredBlog[4]->image)){
													$thumbnail = UPLOAD_URL."blog/".$featuredBlog[4]->image;
												}else{
													$thumbnail = UPLOAD_URL.'no-image.jpg';
												}
											?>
											<a class="post-img2" href="blog-post?id=<?php echo($featuredBlog[4]->id); ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
											<div class="post-body">
												<div class="post-meta">
													<a class="post-category <?php echo CAT_COLOR[($featuredBlog[4]->categoryid)%4] ?>" href="#"><?php echo $featuredBlog[4]->category; ?></a>
													<span class="post-date"><?php echo date('M d, Y', strtotime($featuredBlog[4]->created_date)); ?></span>
												</div>
												<h3 class="post-title"><a href="blog-post?id=<?php echo($featuredBlog[4]->id); ?>"><?php echo $featuredBlog[4]->title; ?></a></h3>
											</div>
										</div>
									</div>
							<!-- /post -->
					<?php
						}
					?>

					<!-- post -->
					<!-- <div class="col-md-4">
						<div class="post">
							<a class="post-img" href="blog-post.html"><img src="./assets/img/post-4.jpg" alt=""></a>
							<div class="post-body">
								<div class="post-meta">
									<a class="post-category cat-2" href="category.html">JavaScript</a>
									<span class="post-date">March 27, 2018</span>
								</div>
								<h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
							</div>
						</div>
					</div> -->
					<!-- /post -->

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-12">
								<div class="section-title">
									<h2>Most Read</h2>
								</div>
							</div>
							<!-- post -->

							<?php
								$popularBlog = $Blog->getAllPopularBlogWithLimit(0, 4);
								// debugger($popularBlog);
								if($popularBlog){
									foreach($popularBlog as $key => $blog){
										if(isset($blog->image) && !empty($blog->image) && file_exists(UPLOAD_PATH."blog/".$blog->image)){
											$thumbnail = UPLOAD_URL."blog/".$blog->image;
										}else{
											$thumbnail = UPLOAD_URL.'no-image.jpg';
										}
							?>
										<!-- post -->
											<div class="col-md-12">
												<div class="post post-row">
													<a class="post-img" href="blog-post?id=<?php echo $blog->id ?>"><img src="<?php echo $thumbnail; ?>" alt=""></a>
													<div class="post-body">
														<div class="post-meta">
															<a class="post-category <?php echo CAT_COLOR[$blog->categoryid%4] ?>" href="#"><?php echo $blog->category; ?></a>
															<span class="post-date"><?php echo date('M d, Y', strtotime($blog->created_date)); ?></span>
														</div>
														<h3 class="post-title"><a href="blog-post?id=<?php echo $blog->id ?>"><?php echo $blog->title; ?></a></h3>
														<p>
															<?php echo substr(html_entity_decode($blog->content), 0, 100)."...<br>"; ?>
															<a href="blog-post?id=<?php echo $blog->id ?>">Read More</a>
														</p>
													</div>
												</div>
											</div>
										<!-- /post -->
							<?php
									}
								}
							?>
							
							<!-- post -->
							<!-- <div class="col-md-12">
								<div class="post post-row">
									<a class="post-img" href="blog-post.html"><img src="./assets/img/post-2.jpg" alt=""></a>
									<div class="post-body">
										<div class="post-meta">
											<a class="post-category cat-3" href="category.html">Jquery</a>
											<span class="post-date">March 27, 2018</span>
										</div>
										<h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
									</div>
								</div>
							</div> -->
							<!-- /post -->

							<!-- ad -->
							<div class="col-md-12">
								<div class="section-row">
									<?php
										$Ad = new ads();
										$Ads = $Ad->getAdsByAdtypeWidead();
										// debugger($Ads);
										if(isset($Ads[0]) && !empty($Ads[0])){
											if(isset($Ads[0]->image) && !empty($Ads[0]->image) && file_exists(UPLOAD_PATH."ads/".$Ads[0]->image)){
												$thumbnail = UPLOAD_URL."ads/".$Ads[0]->image;
											}else{
												$thumbnail = UPLOAD_URL.'no-image.jpg';
											}
									?>
											<a href="<?php echo '//'.$Ads[0]->url; ?>" target="_blank">
												<img class="img-responsive center-block" src="<?php echo $thumbnail;?>" alt="">
											</a>
									<?php
										}
									?>
								</div>
							</div>
							<!-- ad -->
							
							<div class="col-md-12">
								<div class="section-row">
									<button class="primary-button center-block" href="load" data-toggle="modal" data-target="#theModal">Load More</button>
								</div>
							</div>
							<div id="theModal" class="modal fade text-center">
								<div class="modal-dialog">
									<div class="modal-content">
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-md-4">
						<!-- ad -->
						<div class="aside-widget text-center">
							<?php
								$Ad = new ads();
								$Ads = $Ad->getAdsByAdtypeSimplead();
								// debugger($Ads);
								if(isset($Ads[0]) && !empty($Ads[0])){
									if(isset($Ads[0]->image) && !empty($Ads[0]->image) && file_exists(UPLOAD_PATH."ads/".$Ads[0]->image)){
										$thumbnail = UPLOAD_URL."ads/".$Ads[0]->image;
									}else{
										$thumbnail = UPLOAD_URL.'no-image.jpg';
									}
							?>
								<a href="<?php echo '//'.$Ads[0]->url; ?>" target="_blank" style="display: inline-block;margin: auto;">
									<img class="img-responsive" src="<?php echo $thumbnail; ?>" alt="">
								</a>
							<?php 
								}
							?>
						</div>
						<!-- /ad -->
						
						<!-- catagories -->
						<div class="aside-widget">
							<div class="section-title">
								<h2>Catagories</h2>
							</div>
							<div class="category-widget">
								<ul>
									<?php 
										if($categories){
											foreach($categories as $key => $category){
									?>
												<li><a href="#" class="<?php echo CAT_COLOR[$category->id%4] ?>"><?php echo $category->categoryname; ?><span>
												<?php
													$Count = $Blog->getNumberBlogByCategory($category->id);
													echo ($Count[0]->total);
												?>
												</span></a></li>
									<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
						<!-- /catagories -->

						<!-- tags -->
						<div class="aside-widget">
							<div class="tags-widget">
								<ul>
									<?php
										$categories = $Category->getAllCategory();
										if($categories){
											foreach($categories as $key => $category){
									?>
												<li><a href="category?id=<?php echo $category->id; ?>"><?php echo $category->categoryname; ?></a></li>
									<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
						<!-- /tags -->
						
						<!-- archive -->
						<div class="aside-widget">
							<div class="section-title">
								<h2>Archive</h2>
							</div>
							<div class="archive-widget">
								<ul>
									<?php 
										$Archive = new archive();
										$archives = $Archive->getAllArchive();
										if($archives){
											foreach($archives as $key => $archive){
									?>
												<li><a href="archive?id=<?php echo $archive->id ?>"><?php echo date('M d, Y', strtotime($archive->date)); ?></a></li>
									<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
						<!-- /archive -->
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

<?php include 'inc/footer.php' ?>