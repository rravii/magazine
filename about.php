<?php 
	include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	$bread = "About";
	include 'inc/header.php';
?>
		
		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-8">
						<div class="section-row">
							<p>WebMeg is a web developers site, with tutorials and references on web development languages such as HTML, CSS, JavaScript, PHP, SQL, Python, jQuery, Java, C++, C#, React, Node.js, XML, W3.CSS, and Bootstrap, covering most aspects of web programming.</br>

							WebMeg was originally created for development, sharing and learning purpose.</p>
							<p></p>
							<figure class="figure-img">
								<img class="img-responsive" src="./assets/img/about-1.jpg" alt="">
							</figure>
							<p>The following statements describes the privacy practices for WebMeg:</p>
								<ul class="list-style">
									<li><p>We do not collect any personal information from our users.</p></li>
									<li><p>Visits are logged for aggregate statistics and diagnosis.</p></li>
									<li><p>Security settings protect the misuse of sensitive information.</p></li>
								</ul>
						</div>
						<div class="row section-row">
							<div class="col-md-6">
								<figure class="figure-img">
									<img class="img-responsive" src="./assets/img/about-2.jpg" alt="">
								</figure>
							</div>
							<div class="col-md-6">
								<h3>Our Mission</h3>
								<p>Learning, Sharing and Development is the main aim of this website. Besides this below are some other mission of the website:</p>
								<ul class="list-style">
									<li><p>----------------</p></li>
									<li><p>-------------------</p></li>
									<li><p>-----------------------</p></li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- aside -->
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

						<!-- post widget -->
						<div class="aside-widget">
							<div class="section-title">
								<h2>Most Read</h2>
							</div>

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
										<div class="post post-widget">
											<a class="post-img" href="blog-post?id=<?php echo $blog->id ?>"><img src="<?php echo ($thumbnail); ?>" alt=""></a>
											<div class="post-meta">
												<a class="post-category <?php echo CAT_COLOR[($blog->categoryid)%4] ?>" href="#"><?php echo $blog->category; ?></a>
											</div>
											<div class="post-body">	
												<h4 class="post-title"><a href="blog-post?id=<?php echo $blog->id ?>"><?php echo $blog->title; ?></a></h4>
											</div>
										</div>
							<?php
									}
								}
							?>

							<!-- <div class="post post-widget">
								<a class="post-img" href="blog-post.html"><img src="./assets/img/widget-1.jpg" alt=""></a>
								<div class="post-body">
									<h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
								</div>
							</div> -->
						</div>
						<!-- /post widget -->
					</div>
					<!-- /aside -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

<?php include 'inc/footer.php' ?>