<?php 
$header = "Category";
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
                <h3>Category</h3>
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
                    <h2>List of Categories:</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <a href="javascript:;" class="btn btn-primary" onclick="addCategory();">Add Category</a> <!-- javascript:; is #(deadlink) -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Category = new category();
                                $Categories = $Category->getAllCategory();
                                // debugger($Categories);
                                if ($Categories){
                                    foreach($Categories as $key => $category){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $category->categoryname; ?></td>
                                    <td><?php echo html_entity_decode($category->description); ?></td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-info" onclick="editCategory(this);" data-category_info='<?php echo(json_encode($category)) ?>'>
                                        <!-- $category ma bhako data lai json_encode garae ra hamlae data-category_info ma rakheko ho i.e 
                                            php ko data lai html ma convert garya aba html ko lai js ma garna milxa -->
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a href="process/category?id=<?php echo($category->id) ?>&amp;act=<?php echo substr(md5("Delete-Category-".$category->id.$_SESSION['token']), 3, 15) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the category?');">
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
                                <h4 class="modal-title" id="title">Add Category</h4>
                            </div>

                            <form action="process/category" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Category Name</label>
                                        <input type="text" class="form-control" placeholder="Category Name" name="categoryname" id="categoryname">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Category Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
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
    function addCategory(){
        $('#title').html('Add Category');
        $('#categoryname').val("");
        $('#id').removeAttr('value');
        showModal();
    }

    function editCategory(element){ // mathi editCategory(this): here this le id denote gari ra ko xa
        var category_info = $(element).data('category_info'); // data-category_info: category_info name ho ra data ma data baseko xa
        if (typeof(category_info) != 'object'){ // checking whether data received, json_encode bhayera ako xa ki nai
            category_info = JSON.parse(category_info); // typecasting into object
        }
        console.log(category_info);

        $('#title').html('Edit Category');
        $('#categoryname').val(category_info.categoryname);// js ma bhako data lai pheri html ma halera display garako
        $('#id').val(category_info.id);
        showModal(category_info.description);
    }

    function showModal(data=""){
        ckeditor(data);
        $('.modal').modal(); //.: getelementbyclass
    }

    function ckeditor(data=""){
        $('.ck').remove();
        ClassicEditor
        .create( document.querySelector( '#description' ) ) //#: getelementbyid
        .then( editor => {
            editor.setData(data);
        } )
        .catch( error => {
            console.error( error );
        } );
    }
    
</script>