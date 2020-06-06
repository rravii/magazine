<?php 
$header = "Join";
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
                <h3>Join</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of join:</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Time</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Join = new join();
                                $joins = $Join->getAllJoin();
                                // debugger($comments);
                                if ($joins){
                                    foreach($joins as $key => $join){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $join->name; ?></td>
                                    <td><?php echo $join->email; ?></td>
                                    <td><?php echo html_entity_decode($join->message); ?></td>
                                    <td><?php echo date('M d, Y h:i:s a', strtotime($join->created_date)); ?></td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'inc/footer.php'; ?>
<script src="assets/js/datatable.js"></script>
