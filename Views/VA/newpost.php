 <?php
include($Service->Config()->get_basepath().'/Views/VA/header.php');  
  echo " 
    <link rel='stylesheet' type='text/css' href='/members/Static/VA/assets/bootstrap-fileupload/bootstrap-fileupload.css' /> 
    <link rel='stylesheet' href='/members/Static/VA/assets/file-uploader/css/jquery.fileupload.css'>
    <link rel='stylesheet' href='/members/Static/VA/assets/file-uploader/css/jquery.fileupload-ui.css'>  
    <!-- Include Font Awesome. --> 
    <script src='/members/Static/VA/ckeditor/ckeditor.js'></script>

    <style>
    .myHelper
    { 
     display:inline;
     padding:4px;
     border:1px solid #ccc;
     border-radius:2px;
    } 
    .myHelper:hover
    {
        background:rgba(119, 119, 119, 0.38);           
    }
    </style>
    <section id='main-content' class=''>
        <section class='wrapper'>  
        <div class='row'>
            <div class='col-lg-12'>
                <section class='panel'> 
                    <div class='panel-body'>
                     <div id='time' style='text-shadow:none;color:#aaa;font-size:15px;display:inline;'></div> 
                                <div id='day' style='display:none;'></div> 
                                <div id='day1' style='display:none;'></div>
                                <div id='date1' style='text-shadow:none;color:#aaa;font-size:15px;display:inline;'></div> 
                                <audio src='/members/Static/VA/sounds/hour.mp3' hidden='true'></audio> 
                                <div id='almstatus' style='float:right;font-weight:300;margin-top:-5rem;font-size:16px;margin-right:0.5rem;'>No Alarm.</div>";
                    $flag=$Service->Prote()->DBI()->Func()->comment()->checkUserInitValues($Service->Prote()->DBI()->Func()->users()->mapUser($_SESSION['email'])); 
                    if($flag)
                    { 
                        if(isset($success))
                        {
                            echo "<br>$success Click <a href='/members/write-post'><b>here</b></a> to write a post";
                            exit();
                        }
                        else
                        {  
                          if(isset($_SESSION['msg']))
                          {
                           $_SESSION['msg'] = "";
                            echo "<br>".$_SESSION['msg']."";
                          }
                            echo "<br><div style='float:right;margin-top:-2rem;'>
                            <label><a href='#ustatus' data-toggle='modal'>Change status/title/picture</a></label></div>";
                        echo "<form class='form-horizontal bucket-form' method='post' action='/members/addcomment' enctype='multipart/form-data' novalidate onsubmit='return confirm(\"Are you sure?\")'> 
                            <div class='form-group'> 
                                <label class='col-sm-2 control-label'></label>
                                <div class='col-sm-8'> 
                                <center>
                                    <div class='fileupload fileupload-new' data-provides='fileupload'>
                                        <div class='fileupload-new thumbnail' style='width: 200px; height: 150px;'> 
                                        </div>
                                        <div class='fileupload-preview fileupload-exists thumbnail' style='max-width: 200px; max-height: 150px; line-height: 20px;'> 
                                        </div>
                                        <div>
                                                   <span class='btn btn-white btn-file'>
                                                   <span class='fileupload-new'><i class='fa fa-paper-clip'></i> Select an image <b>here</b> to reflect your post on blog stream</span>
                                                   <span class='fileupload-exists'>Change</span>
                                                   <input type='file' name='image' id='image' class='default' required>
                                                   </span>
                                            <a href='#' class='btn btn-danger fileupload-exists' data-dismiss='fileupload'><i class='fa fa-trash'></i> Remove</a>
                                        </div>
                                    </div>  
                                    </center>
                                    <input type='text'class='form-control' name='about' style='color:#888;' placeholder='Write something about the post' maxlength='200' required autocomplete='off' value='".$about."'> 
                                    <input type='text'class='form-control' name='title' style='color:#888;' placeholder='Write the title of the post' required autocomplete='off' value='".$title."'> 
                                    <textarea   name='comment' id='real' hidden=''></textarea>
                                    <input type='text'class='form-control' name='tags' style='color:#888;display:inline;width:85%' placeholder='Mention tags for the post' autocomplete='off' value='".$tags."' required>
                                     <a href='#tags' data-toggle='modal'>
                                    <div class='myHelper'><b>?</b></div></a>  
                                    <!-- WYSIWYG editor -->
                                    <textarea name='editor1' id='editor1'>".$content."</textarea>
                                    <script>
                                        CKEDITOR.replace( 'editor1', {customConfig: '/custom/ckeditor_config.js'} );  
                                    </script> 
                        <div class='col-md-12'> <br>
                        <div class='col-md-12'> 
                        <section class='panel' style=' margin-top:-1.5rem;'>
                            <div class='panel-body btn-gap'>
                            <center>
                                <button type='button' id='saveBtn' 
                                class='btn btn-success' style='margin-right:-0.1rem;'>Save</button> 
                                <button type='submit' name='submit' class='btn btn-info' style='margin-right:-0.1rem;'>Submit</button> 
                                <br> 
       <div id='speech' style='margin-top:1rem;'>
    <span id='labnol' contenteditable='true'></span> 
    <span id='notfinal'></span> 
    <span id='warning'></span> 
  </div><br>    
    <span id='messages'> 
      <br><a href='#'  class='btn btn-default' onclick='javascript:action();return false;' id='btn'>Speak</a> 
    </span>   
<span class='language' hidden><div class='select-wrapper'><i class='mdi-navigation-arrow-drop-down active'></i><input type='text' class='select-dropdown' readonly='true' data-activates='select-options-66605473-d794-30d3-e7f9-d06c5639dbd5' value='India'><ul id='select-options-66605473-d794-30d3-e7f9-d06c5639dbd5' class='dropdown-content select-dropdown'></ul><select name='lang' id='lang' onchange='updateLang(this)' class='initialized'><optgroup label='English'><option value='6'>Australia</option><option value='7'>Canada</option>
<option value='8'>India</option><option value='9'>New Zealand</option><option value='10'>South Africa</option>
<option value='11'>United Kingdom</option><option value='12'>United States</option></optgroup><optgroup label='--'></optgroup></select></div></span> 
  <img id='status' src='/members/Static/VA/images/listen.gif' style='margin: auto; display: none;'>
          </div>
                            </center>
                            </div>
                        </section>
                         </div>
                         </div>  
                        </form>
                    </div>
                </section>  
            </div>
        </div>   
        <!-- page end-->
        <!-- page end-->";
      }
    }
    else
        echo "
        <form class='form-horizontal bucket-form' method='post' action='/members/userinit'> 
                            <div class='form-group'><sbr> 
                                <label class='col-sm-2 control-label' style='text-align:left;'>Before you write a post, let us know certain things about you so that we can tell the same to others&nbsp;<img src='/members/Static/VA/images/smileys/wink.png' alt='smiley' draggable='false' style='margin-top:-0.5rem;height:20px;' onclick=\"add('wink')\"/> </label>
                                <div class='col-sm-8'>  
                                    <input type='text'class='form-control' name='status' style='color:#888;width:85%' placeholder='Write a status here' autocomplete='off' maxxlength='200' required> 
                                    <div class='input-group m-bot15'  style='width:85%;margin-top:2px;'>
                                <input type='text' name='title' placeholder='write a small title that descibes you the best' class='form-control' maxlength='25' required> 
                                              <span class='input-group-btn'>
                                                <button class='btn btn-success' type='Submit'>Go!</button>
                                              </span>
                            </div>
                                 
                        </section> 
                         </div>  
                        </form>

    ";
   echo "</section>
   </section> 
    <!--Modal-->
    <div class='modal fade' id='tags' tabindex='-1' role='dialog' aria-labelledby='myModalLabel1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title'>Tags in a post</h4>
                                        </div>
                                        <div class='modal-body'> 
                                        Tags are a set of <b>keywords</b> in a post that makes it easier for search engine to filter the post as per user search. In order to make your post easily accessible to user searches, make use of tags to get more and more user views.<br><br> 
                                        <center>Write your tag names separated by commas (,) as shown below<b>:</b><br><br>
                                        <div class='myHelper' style='background:#e2e2e2;padding:7px;'>Music,Entertainment,Justin Beieber</div></center> 
                                        </div>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>  
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end--> 
        <!--Modal-->
    <div class='modal fade' id='ustatus' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title'>Update status/title here</h4>
                                        </div>
                                        <div class='modal-body'>  
                                          <form class='form-horizontal bucket-form' method='post' action='/members/updateuserinit'> 
                            <div class='form-group'><sbr> 
                                <p style='margin-left:1rem;'>&nbsp;&nbsp;Update your title and status here. </p>
                                <div class='col-sm-10'>  
                                    <input type='text'class='form-control' name='updstatus' style='color:#888;' placeholder='Write a status here' autocomplete='off' maxxlength='200' required> 
                                    <div class='input-group m-bot15'  style='margin-top:2px;'>
                                <input type='text' name='updtitle' placeholder='write a small title that describes you the best' class='form-control' maxlength='25' required>     
                                    <span class='input-group-btn'>
                                      <button class='btn btn-success' type='Submit'>Go!</button>
                                    </span>
                            </div>
                            </form><hr>  
                        <form action='/members/updatePic' method='post' enctype='multipart/form-data'>
                        <p>Select a new image to put it as your profile picture.<br>Hover over <b>Your file</b> button to verify file name. </p>
                        <span class='btn btn-success fileinput-button'>
                                    <i class='glyphicon glyphicon-plus'></i>
                                    <span>Your file</span>
                                    <input type='file' name='userPic' required>
                         </span>  
                         <button  class='btn btn-success' name='submit' type='Submit' style='display:inline;'>Upload</button>
                        </form>      
                        </section> 
                         </div>   
                                        </div>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>  
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end--> 
    <!--main content end-->   
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src='/members/Static/VA/js/lib/jquery.js'></script>
<script src='/members/Static/VA/assets/jquery-ui/jquery-ui-1.10.1.custom.min.js'></script>
<script src='/members/Static/VA/bs3/js/bootstrap.min.js'></script>  
<script src='/members/Static/VA/js/nicescroll/jquery.nicescroll.js' type='text/javascript'></script> 
<script src='/members/Static/VA/js/dictation.js'></script> 
<script type='text/javascript' src='/members/Static/VA/assets/bootstrap-fileupload/bootstrap-fileupload.js'></script>
<!--common script init for all pages-->
<script src='/members/Static/VA/js/scripts.js'></script> 
<script type='text/javascript'>
var dormantCount=".$Service->Prote()->DBI()->Func()->users()->getautologouttime($id)."; 
 function resetDormancy()
  { 
    if(dormantCount<10) 
     //Materialize.toast('Woaah..that was really close. <img src=\"/members/Static/VA/images/smileys/wink.png\"><img src=\"/members/Static/VA/images/smileys/cool.png\">',5000);
    dormantCount=". $Service->Prote()->DBI()->Func()->users()->getautologouttime($id)."; 
  }
var commentData='';
  function add(Value)
  {  
     commentData=document.getElementById('tar').innerHTML+'<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"display:inline;height:20px;\"/>'; 
     document.getElementById('tar').innerHTML+='<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"margin-top:2px;display:inline\">'; 
  }
  function setdata()
  {
   document.getElementById('real').value=document.getElementById('tar').innerHTML;  
  } 

  $('#saveBtn').click(function(e){   
    var x = this.id;
    var noteid = x.substring(3,x.length); 
    $.ajax({
    type: 'POST',
    url: '/members/savePost', 
    data: 'about='+$(\"[name='about']\").val()+'&title='+$(\"[name='title']\").val()+'&editor1='+CKEDITOR.instances['editor1'].getData()+'&tags='+$(\"[name='tags']\").val(),
    cache: false,
    success: function(result){ 
      alert('Post saved successfully!!!');
    }
   });
   return false; 
});
</script> 
</body>
</div>
</html>";