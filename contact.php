<?php 
	include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	$bread = "Contact";
	include 'inc/header.php';
?>
		<!-- section -->
		<div class="section" id="ReplySection">
			<!-- container -->
			<div class="container" >
				<!-- row -->
				<div class="row">
				
					<div class="col-md-6">
						<div class="section-row">
							<h3>Contact Information</h3>
							<p>Please reach us through the information provided below or you can us the message section to mail us and we will reply you soon.</p>
							<ul class="list-style">
								<li><p><strong>Email:</strong> <a href="#">admin@gmail.com</a></p></li>
								<li><p><strong>Phone:</strong>---------</p></li>
								<li><p><strong>Address:</strong>-----------</p></li>
							</ul>
						</div>
					</div>
					<div class="col-md-5 col-md-offset-1">
						<div class="section-row">
							<h3>Send A Message</h3>
							<form action="process/contact" method="post">
								<div class="row">
									<div class="col-md-7">
										<div class="form-group">
											<span>Name</span>
											<input class="input" type="text" name="name">
										</div>
									</div>
									<div class="col-md-7">
										<div class="form-group">
											<span>Email</span>
											<input class="input" type="email" name="email">
										</div>
									</div>
									<div class="col-md-7">
										<div class="form-group">
											<span>Subject</span>
											<input class="input" type="text" name="subject">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="input" name="message" placeholder="Message"></textarea>
										</div>
										<input type="hidden" name="commentid" value="" id="comment_id">
										<button class="primary-button" type="submit">Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /row -->

					<!-- comments -->
					<div class="section-row">
							<div class="section-title">
								<h2>
								Contact Comments
								</h2>
							</div>

							<div class="post-comments">

								<?php  
									$Contact = new contact();
									$comments = $Contact->getAllAcceptContacts();
									if($comments){
										foreach ($comments as $key => $comment){
								?>
											<!-- comment -->
											<div class="media">
												<div class="media-left">
													<img class="media-object" src="./assets/img/avatar.png" alt="">
												</div>
												<div class="media-body">
													<div class="media-heading">
														<h4><?php echo $comment->name; ?></h4>
														<span class="time"><?php echo date('M d, Y h:i:s a',strtotime($comment->created_date)); ?></span>
													</div>
													<h5>Subject:&emsp;<?php echo html_entity_decode($comment->subject); ?></h5>
													<p>&emsp;<?php echo html_entity_decode($comment->message); ?></p>

													<?php 
														$replies = $Contact->getAllAcceptReplyByComment($comment->id);
														if ($replies){
															foreach($replies as $key => $reply){
													?>
																<!-- reply -->
																	<div class="media">
																		<div class="media-left">
																			<img class="media-object" src="./assets/img/avatar.png" alt="">
																		</div>
																		<div class="media-body">
																			<div class="media-heading">
																				<h4><?php echo $reply->name; ?></h4>
																				<span class="time"><?php echo date('M d, Y h:i:s a', strtotime($reply->created_date)); ?></span>
																			</div>
																			<h5>Subject:&emsp;<?php echo html_entity_decode($reply->subject); ?></h5>
																			<p>&emsp;<?php echo html_entity_decode($reply->message); ?></p>
																		</div>
																	</div>
																<!-- /reply -->
													<?php
															}
														}
													?>
												</div>
											</div>
											<!-- /comment -->
								<?php
										}
									}
								?>
								
							</div>
						</div>
						<!-- /comments -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

<?php include 'inc/footer.php' ?>

<script>
	function comment(element){
		var id = $(element).data();
		console.log(id.commentid);
		$('#comment_id').val(id.commentid);
	}
</script>