 <?php
include($Service->Config()->get_basepath().'/Views/VA/header.php');  
  echo " 
    <link rel='stylesheet' type='text/css' href='/members/Static/VA/assets/bootstrap-fileupload/bootstrap-fileupload.css' />

    <link rel='stylesheet' href='/members/Static/VA/assets/file-uploader/css/jquery.fileupload.css'>
    <link rel='stylesheet' href='/members/Static/VA/assets/file-uploader/css/jquery.fileupload-ui.css'>
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
                                <div id='almstatus' style='float:right;font-weight:300;margin-top:-5rem;font-size:16px;margin-right:0.5rem;'>No Alarm.</div>  ";
                                if(isset($success))  
                                    echo "<br>".$success; 

                                if(isset($post))
                                { 
                                  echo "<div class='col-sm-6' style='margin-top:2rem;width:100%;text-align:left;'>   
                                  <div class='input-group ' style='margin-bottom:1.5rem;'>
                                  ".$post."<br>
                                  <form class='form-horizontal bucket-form' method='post' action='/members/makecomment' >
                                  <input type='hidden' value='".$pid."' name='postid'>
                                   <input type='text'class='form-control' name='userComment' style='color:#666;border-radius:5px;width:90%;' placeholder='Write your comment here' maxlength='200' required autocomplete='off'> 
                                  <span class='input-group-addon btn-warning' style='cursor:pointer;padding:6.5px;display:inline;margin-left:-5.5px;'><button type='submit' style='padding:8px;background:none;border-width:0;color:#fff;'>comment</button></span>  
                                  </form>" ; 
                                  echo " </div>
                                  </div>"; 
                                }
                        else 
                          {
                            echo "<form class='form-horizontal bucket-form' method='post' action='/members/getpostdet' > 
                            <form class='form-horizontal bucket-form' method='post' action='/members/searchproject'> 
                            <div class='form-group'> 
                                <label class='col-sm-3 control-label'></label>
                                <div class='col-sm-6'>   
                                  <div class='input-group ' style='margin-bottom:1.5rem;'>
                                  <select class='form-control m-bot15' name='post' style='color:#666;'> 
                                        <option value='0'>Select a post to make comment</option>";
                                         $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
                                          mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
                                          $sql="SELECT postId,postTitle,substring(postContent,1,55) as postContent from post";
                                          $result = mysqli_query($conn,$sql);   
                                          while($row=mysqli_fetch_assoc($result))   
                                          { 
                                            echo "<option value='".$row['postId']."'  style=''>".$row['postContent']."...</option>";
                                          }
                                          mysqli_close($conn);
                                    echo "</select> 
                                    <span class='input-group-addon btn-warning' style='cursor:pointer;padding:0;'><button type='submit' style='padding:8px;background:none;border-width:0;color:#fff;'>Get post</button></span>     
                                    </div> 
                                  </form>";
                                }
                                echo "</center>
                                </div>   
                    </div>
                </section>  
            </div>
        </div>   
        <!-- page end--> </section>
   </section> 
    
    <!--main content end-->   
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src='/members/Static/VA/js/lib/jquery.js'></script>
<script src='/members/Static/VA/assets/jquery-ui/jquery-ui-1.10.1.custom.min.js'></script>
<script src='/members/Static/VA/bs3/js/bootstrap.min.js'></script>  
<script src='/members/Static/VA/js/nicescroll/jquery.nicescroll.js' type='text/javascript'></script>   
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
</script>
</body>
</div>
</html>";