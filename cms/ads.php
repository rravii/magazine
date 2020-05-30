<?php 
$header = "Ads";
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
                <h3>Ads</h3>
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
                    <h2>List of Ads:</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <a href="javascript:;" class="btn btn-primary" onclick="addAds();">Add Ads</a> <!-- javascript:; is #(deadlink) -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>S.N</th>
                            <th>Url</th>
                            <th>AdType</th>
                            <th>Image</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $Ads = new ads();
                                $adds = $Ads->getAllAds();
                                // debugger($adds,true);
                                if ($adds){
                                    foreach($adds as $key => $ads){
                                ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $ads->url; ?></td>
                                    <td><?php echo $ads->adType; ?></td>
                                    
                                    <?php 
                                      if (isset($ads->image) && !empty($ads->image) && file_exists(UPLOAD_PATH."ads/".$ads->image)){
                                        $thumbnail = UPLOAD_URL.'ads/'.$ads->image;
                                      }else{
                                        $thumbnail = UPLOAD_URL.'no-image.jpg';
                                      }
                                    ?>
                                    
                                    <td><img src="<?php echo($thumbnail) ?>" alt="" style="width: 300px; height:auto; "></td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-info" onclick="editAds(this);" data-ads_info='<?php echo(json_encode($ads)) ?>'>
                                        <!-- $ads ma bhako data lai json_encode garae ra hamlae data-ads_info ma rakheko ho i.e 
                                            php ko data lai html ma convert garya aba html ko lai js ma garna milxa -->
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a href="process/ads?id=<?php echo($ads->id) ?>&amp;act=<?php echo substr(md5("Delete-Ads-".$ads->id.$_SESSION['token']), 3, 15) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the ads?');">
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
                                <h4 class="modal-title" id="title">Add Ads</h4>
                            </div>

                            <form action="process/ads" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Url:</label>
                                        <input type="text" class="form-control" placeholder="Url" name="url" id="url">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ad Type:</label><br>
                                        <input type="radio" name="adType" id="adType0" value="widead">Widead(728 X 100)<br>
                                        <input type="radio" name="adType" id="adType1" value="simplead">Simplead(300 X 250)
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ads Image</label>
                                        <input type="file" name="image" id="image" accept="image/*">
                                    </div>

                                    <div class="form-group ">
                                      <img src="<?php echo($thumbnail) ?>" id="thumbnail" style="width: 300px;height: auto;">
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="old_image" name="old_image">
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
<script src="assets/js/datatable.js"></script>
<script type="text/javascript">
    // function adType(){
    //     $('#image').css("width: 300px;height: auto;");
    // }

    function addAds(){
        $('#title').html('Add Ads');
        $('#url').val("");
        $('#id').removeAttr('value');
        $('#thumbnail').attr('src','');
        $('#adType0').prop('checked',false);
        $('#adType1').prop('checked',false);
        $('#old_image').val('');
        showModal();
    }

    function editAds(element){ // mathi editAds(this): here this le id denote gari ra ko xa
        var ads_info = $(element).data('ads_info'); // data-ads_info: ads_info name ho ra data ma data baseko xa
        if (typeof(ads_info) != 'object'){ // checking whether data received, json_encode bhayera ako xa ki nai
            ads_info = JSON.parse(ads_info); // typecasting into object
        }
        console.log(ads_info);

        $('#title').html('Edit Ads');
        $('#url').val(ads_info.url);// js ma bhako data lai pheri html ma halera display garako
        var type =ads_info.adType=='widead'?0:1;
        console.log('merotype',type,ads_info.adType);
        $('#adType'+type).prop('checked',"checked");
        $('#id').val(ads_info.id);
        $('#old_image').val(ads_info.image);
        $('#thumbnail').attr('src','/upload/ads/'+ads_info.image);
        showModal();
    }

    function showModal(){
        $('.modal').modal(); //.: getelementbyclass
    }
    var _URL = window.URL || window.webkitURL;

    document.getElementById("image").onchange = function () {
      var file, img,width,height;
      if ((file = this.files[0])) {
        img = new Image();
        var objectUrl = _URL.createObjectURL(file);
        img.onload = function () {
          width = this.width;
          height = this.height;
          console.log(width,height);
          if(!$('#adType0').prop('checked')&&!$('#adType1').prop('checked')){
            $('#image').val('');
            alert('Please First Check the add Type');

          }else{
            if($('#adType0').prop('checked')&&this.width>=728 && this.height<=100){
              document.getElementById("thumbnail").src=objectUrl;
            }else{
              if($('#adType1').prop('checked')&&this.width<=300 && this.height>=100 && this.height<=250){
              document.getElementById("thumbnail").src=objectUrl;
              }else{
                $('#image').val('');
              alert('Please choose the appropriate ad Type for the image');
              }
            }
          }
        
            // alert(this.width + " " + this.height);

            _URL.revokeObjectURL(objectUrl);
        };
        img.src = objectUrl;
     
      
    }
        // var reader = new FileReader();

        // reader.onload = function (e) {
        //   console.log(this.width);
        //     // get loaded data and render thumbnail.
        //     console.log(e.target);
        //     document.getElementById("thumbnail").src = e.target.result;
        // };

        // // read the image file as a data URL.
        // reader.readAsDataURL(this.files[0]);
    };
    
</script>