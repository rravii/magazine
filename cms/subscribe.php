<?php 
$header = "Subscribe";
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
                <h3>Subscribe</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Subscriber:</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Subscriber's</th>
                            <th>Subscribed Date</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Subscribe = new subscribe();
                                $subscribe = $Subscribe->getAllSubscribe();
                                // debugger($comments);
                                if ($subscribe){
                                    foreach($subscribe as $key => $subscribes){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $subscribes->email; ?></td>
                                    <td><?php echo $subscribes->created_date; ?></td>
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
