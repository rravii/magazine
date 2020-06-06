<?php 
$header = "Archive";
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
                <h3>Archive</h3>
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
                    <h2>List of Archives:</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <a href="javascript:;" class="btn btn-primary" onclick="addArchive();">Add Archive</a> <!-- javascript:; is #(deadlink) -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Archive Name</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Day</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Archive = new archive();
                                $archives = $Archive->getAllArchive();
                                // debugger($archives);
                                if ($archives){
                                    foreach($archives as $key => $archive){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($archive->date)); ?></td>
                                    <td><?php echo date('Y', strtotime($archive->date)); ?></td>
                                    <td><?php echo date('M', strtotime($archive->date)); ?></td>
                                    <td><?php echo date('d', strtotime($archive->date)); ?></td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-info" onclick="editArchive(this);" data-archive_info='<?php echo(json_encode($archive)) ?>'>
                                        <!-- $archive ma bhako data lai json_encode garae ra hamlae data-archive_info ma rakheko ho i.e 
                                            php ko data lai html ma convert garya aba html ko lai js ma garna milxa -->
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a href="process/archive?id=<?php echo($archive->id) ?>&amp;act=<?php echo substr(md5("Delete-Archive-".$archive->id.$_SESSION['token']), 3, 15) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the archive?');">
                                            <i class="fa fa-trash-o"></i>
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
                                <h4 class="modal-title" id="title">Add Archive</h4>
                            </div>

                            <form action="process/archive" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Archive Date</label>
                                        <input type="date" class="form-control" placeholder="Archive Date" name="date" id="date">
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="hidden" id="id" name="id">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>
<script src="assets/js/datatable.js"></script>
<script type="text/javascript">
    function addArchive(){
        $('#title').html('Add Archive');
        $('#date').val("");
        $('#id').removeAttr('value');
        showModal();
    }

    function editArchive(element){ // mathi editArchive(this): here this le id denote gari ra ko xa
        var archive_info = $(element).data('archive_info'); // data-archive_info: archive_info name ho ra data ma data baseko xa
        if (typeof(archive_info) != 'object'){ // checking whether data received, json_encode bhayera ako xa ki nai
            archive_info = JSON.parse(archive_info); // typecasting into object
        }
        console.log(archive_info);
        $('#title').html('Edit Archive');
        $('#date').val(archive_info.date);// js ma bhako data lai pheri html ma halera display garako
        $('#id').val(archive_info.id);
        showModal();
    }

    function showModal(){
        $('.modal').modal(); //.: getelementbyclass
    }
    
</script>