<?php 
$header = "Contact";
include 'inc/header.php'; ?>
<?php include 'inc/checklogin.php'; ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          <?php 
            // debugger($_SESSION); //SESSION destroy bha xa ki xaina check garna ko lagi after login and closing browser
            flashMessage(); // yo access garna include ma janxa ani header.php ma janxa ani header ma bhako include bata config ma janxa
          ?> 
            <div class="page-title">
              <div class="title_left">
                <h3>Contact</h3>
              </div>

              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Comments:</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Time</th>
                            <th>Comment Replied</th>
                            <th>Comment Type</th>
                            <th>Comment ID</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Contact = new contact();
                                $comments = $Contact->getAllAcceptContact();
                                // debugger($comments);s
                                if ($comments){
                                    foreach($comments as $key => $comment){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $comment->name; ?></td>
                                    <td><?php echo $comment->email; ?></td>
                                    <td><?php echo html_entity_decode($comment->subject); ?></td>
                                    <td><?php echo html_entity_decode($comment->message); ?></td>
                                    <td><?php echo date('M d, Y h:i:s a', strtotime($comment->created_date)); ?></td>
                                    <td><?php echo $comment->commentReplied; ?></td>
                                    <td><?php echo $comment->commentType; ?></td>
                                    <td><?php echo (isset($comment->commentid) && !empty($comment->commentid))?$comment->commentid:"0"; ?></td>
                                    <td>
                                        <a class="btn btn-success" onclick="comment(this);" data-commentID="<?php echo $comment->id ?>">
                                            Reply
                                        </a>
                                        <a href="process/contact?id=<?php echo($comment->id) ?>&amp;act=<?php echo substr(md5("Reject-Comment-".$comment->id.$_SESSION['token']), 3, 15) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject the comment?');">
                                            Reject
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </tbody>
                      </table>
                      <div class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="title">Admin's Reply</h4>
                            </div>

                            <form id="replyForm" action="../../process/contact" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="Admin">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Reply Message</label>
                                        <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="hidden" name="commentid" value="" id="comment_id">
                                    <input type="hidden" name="is_cms" value="1"/>
                                    <!-- <a  href="process/contact?id=<php echo($comment->id) ?>&amp;act=<php echo substr(md5("Reply-Comment-".$comment->id.$_SESSION['token']), 3, 15) ?>">
                                      <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    </a> -->
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" >
                                      Submit
                                    </button>
                                </div>
                            </form>
                            
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'inc/footer.php'; ?>
<script src="assets/js/datatable.js"></script>
<script>

	function comment(element){
    showModal();
		var id = $(element).data();
		console.log(id.commentid);
		$('#comment_id').val(id.commentid);
    $('#replyForm').attr('action', $('#replyForm').attr('action')+'?id='+id.commentid);
  }

  function showModal(){
        $('.modal').modal(); //.: getelementbyclass
        // var window = window.open();
    }
</script>
