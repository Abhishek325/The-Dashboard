 <?php
include($Service->Config()->get_basepath().'/Views/VA/header.php'); 
 echo "<section id='main-content' class=''>
        <section class='wrapper'>  
        <div class='row'>  
            <div class='col-lg-12'>
                <section class='panel'>
                <header class='panel-heading tab-bg-dark-navy-blue '>
                    <ul class='nav nav-tabs'>
                        <li class='active'>
                            <a data-toggle='tab' href='#p1'>Add a new project to the system</a>
                        </li>
                        <li class=''>
                            <a data-toggle='tab' href='#p2'>Update a project status</a>
                        </li>
                        <li class=''>
                            <a data-toggle='tab' href='#p3'>Drop a project</a>
                        </li>

                    </ul>
                </header>
                <div class='panel-body'>
                    <div class='tab-content'>
                        <div id='p1' class='tab-pane "; 
                        if(!isset($project_details)&&!isset($superuser)&&!isset($wrongpin))
                            echo "active";
                        echo "'> 
                            <form class='form-horizontal bucket-form' method='post' action='/members/newproject'> 
                            <div class='form-group'> 
                                <label class='col-sm-3 control-label'></label> 
                                <div class='col-sm-6'>  
                                  <center style='font-size:50px;text-shadow:2px 3px 2px #ccc;'> PR<img src='/members/Static/VA/images/project.png' style='width:12%;margin-top:-0.8rem;animation:spin 2s linear infinite;'>JECT</center>";
                                  if(isset($Service->Html()->error))
                                  {
                                    echo "<center>".$Service->Html()->error."<br><p style='margin-top:-2.5rem;font-size:15px;'>Add project details <a data-toggle='tab' href='#p2'><b>here</b></a>.</p></center>"; 
                                  }   
                                  echo "<input type='text'class='form-control' autocomplete='off' required name='name' style='color:#888;' maxlength='25' placeholder='Write the name of the project'> 
                                    <select class='form-control m-bot15' name='type' style='margin-top:0.5rem;color:#888;'> 
                                        <option value='1'>Normal</option>
                                        <option value='2'>Secret</option>
                                        <option value='3'>Test</option> 
                                    </select>
                                    <input type='date' class='form-control' autocomplete='off' required name='deadline' style='color:#888;margin-top:-0.95rem;' placeholder='Specify a project deadline'>  
                                    <textarea class='form-control' required name='description' style='color:#888;margin-top:0.5rem;' rows='5' placeholder='Write the project description here.'></textarea>  
                                <div class='col-md-12'> 
                        <section class='panel' >
                            <div class='panel-body btn-gap'>
                            <center>
                                <button type='submit' class='btn btn-info' style='margin-right:-0.05rem;'>Submit</button>
                                <a data-toggle='tab' href='#p2' class='btn btn-success'>Update a project</a> 
                                <a data-toggle='tab' href='#p3' class='btn btn-danger'>Drop a project</a> 
                                <br> 
                            </center>
                            </div>
                        </section>
                        </div>
                        </form>
                        </div>
                        </div></div>
                        <div id='p2' class='tab-pane ";
                        if(isset($project_details)&&!isset($superuser)&&!isset($wrongpin))
                            echo "active";
                        echo "'>
                            <form class='form-horizontal bucket-form' method='post' action='/members/searchproject'> 
                            <div class='form-group'> 
                                <label class='col-sm-3 control-label'></label>
                                <div class='col-sm-6'>  
                                  <center style='font-size:50px;text-shadow:2px 3px 2px #ccc;'> PR<img src='/members/Static/VA/images/project.png' style='width:12%;margin-top:-0.8rem;animation:spin 2s linear infinite;'>JECT</center>
                                  <div class='input-group ' style='margin-bottom:1.5rem;'>
                                    <select class='form-control m-bot15' name='type' style='color:#666;'> 
                                        <option value='0'>Select a project...</option>";
                                         $c=$Service->Prote()->DBI()->Func()->projects()->getProjects($id);
                                         foreach ($c as $data) { 
                                            echo "<option value='".$data->id."' style='text-transform:uppercase;'>".$data->name."</option>";
                                         }
                                    echo "</select> 
                                <span class='input-group-addon btn-warning' style='cursor:pointer;padding:0;'><button type='submit' style='padding:8px;background:none;border-width:0;color:#fff;'>Details</button></span>     
                                    </div> 
                                  </form>
                                  <div class='col-md-12'>";
                                if(isset($default_select_error_msg))
                                {
                                    echo $default_select_error_msg; 
                                }
                                else if(isset($project_details))    
                                { 
                                echo "<section class='panel'>  
                                       <center><h3 style='color:#444;text-transform:uppercase;'><u>#".$Service->Prote()->DBI()->Func()->projects()->getProjectName($project_id,$id)."</u>:</h3>
                                        <p style='font-size:18px;'>Deadline : ".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineDay($project_id,$id)." ".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineMonth($project_id,$id)." , ".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineYear($project_id,$id)."<br>"; 
                                        echo "<div class='progress progress-striped active progress-sm' style='width:50%;'>
                                              <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)."' aria-valuemin='0' aria-valuemax='100' style='width:".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)."%;'>
                                                  <span class='sr-only'>".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)."% Complete</span>
                                                  <p style='margin-top:-4px;font-size:11px;'>".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)."% complete</p>
                                              </div>
                                              </div>";  
                                       if($Service->Prote()->DBI()->Func()->projects()->getProjectModuleCount($project_id,$id))         
                                       {
                                        $c=$Service->Prote()->DBI()->Func()->projects()->getProjectModules($project_id,$id);
                                        echo "<h4>Modules:</h4><ul style='font-size:16px;'>";
                                        foreach ($c as $data) { 
                                            echo "<li><code>".$data->module."
                                                  <form action='/members/project/removemodule' method='post' style='display:inline;'><input type='hidden' name='project' value='".$project_id."'><input type='hidden' name='module' value='".$data->module."'><button type='submit' style='padding:0;background:none;border:none;display:inline;'>x</button></form></code>
                                                  </li>";
                                        }
                                        echo "</ul><a href='#module' data-toggle='modal' class='btn btn-success'>Add more</a>";
                                       }
                                       else
                                        echo "No modules to display.<br><a href='#module' data-toggle='modal' class='btn btn-success'>Add modules</a>"; 
                                  echo "&nbsp;<a href='#progress' data-toggle='modal' class='btn btn-info'>Progress</a></center> 
                                      </section>";
                                }
                         echo "</div>
                        </div></div>  
                        </div>
                        <div id='p3' class='tab-pane ";
                        if(isset($superuser)||isset($wrongpin))
                            echo "active";
                        echo "'>";
                        
                        if(!isset($superuser))
                         echo "<p style='margin-top:-1rem;color:#d00;'>Display secret projects through <a href='#pin' data-toggle='modal' style='color:#e00;'><b><u>here</u></b></a>.<br>";
                        else
                         echo "<p style='margin-top:-1rem;color:#777;'>Hide secret projects through <a href='/members/hide-secret-projects' style='color:#666;'><b><u>here</u></b></a>.<br>";       
                        if(isset($wrongpin))
                            echo $wrongpin;
                        echo "</p><h4>Current projects:</h4><p style='margin-top:-1rem;'>Hover over the project name to get its description.</p><ul>";
                        if($project_count=$Service->Prote()->DBI()->Func()->projects()->getProjectCount($id))
                        { 
                          $c=$Service->Prote()->DBI()->Func()->projects()->getProjects($id);
                           foreach ($c as $data) { 
                              $pid=$Service->Prote()->DBI()->Func()->projects()->getProjectId($data->name,$id);
                              echo "<li style='width:500px;overflow-x:hidden;'><button data-original-title='#".strtoupper($data->name)."' data-content='".$data->desc."' data-placement='top' data-trigger='hover' class='btn-info popovers' style='background:none;color:#666;border-width:0;text-transform:uppercase;font-size:16px;'>".$data->name." (".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($pid,$id)."% complete)</button><form action='/members/project/remove' method='post' style='display:inline;'><input type='hidden' name='projectid' value='".$pid."'><button type='submit' style='padding:0;background:none;border:none;display:inline;float:right;margin-right:10rem'><b>x</b></button></form></li>";
                           }  
                         if(isset($superuser))//just to be double sure...
                         {
                             $c=$Service->Prote()->DBI()->Func()->projects()->getSecretProjects($id);
                             if($c){ 
                              foreach ($c as $data) { 
                                 echo "<li><button data-original-title='#".strtoupper($data->name)."' data-content='".$data->desc."' data-placement='top' data-trigger='hover' class='btn-info popovers' style='background:none;color:#999;border-width:0;text-transform:uppercase;font-size:16px;'>".$data->name."</button></li>";
                              }
                             }  
                         }   
                        }   
                        else
                        echo "No project to display.";                                   
                        echo "</ul></div> 
                    </div>
                </div>
            </section>     
            <div id='time' style='text-shadow:none;color:#aaa;font-size:15px;display:inline;'></div>
                                <div id='day' style='display:none;'></div> 
                                <div id='day1' style='display:none;'></div>
                                <div id='date1' style='text-shadow:none;color:#aaa;font-size:15px;display:inline;'></div>
                                <audio src='/members/Static/VA/sounds/hour.mp3' hidden='true'></audio>
            </div>
        </div>  
        <!-- page end-->";
        if($project_count>0)
        {  
        echo "<!--Modal-->
        <div class='modal fade' id='module' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title'>";
                                            if(isset($project_details))//&&!$Service->Prote()->DBI()->Func()->projects()->getProjectModuleCount($project_id)
                                                echo $n=$Service->Prote()->DBI()->Func()->projects()->getProjectName($project_id,$id);
                                            else $n="";
                                            echo " - modules</h4>
                                        </div>
                                        <div class='modal-body'> 
                                        Enter the modules to be added to the project <b>".$n."</b>.<br>Please note that multiple modules should be separated by commas (,)
                                        <form action='/members/addmodule' method='post'>
                                        <input type='hidden' value='".$project_id."' name='project'>
                                            <br><input type='text' class='form-control' autocomplete='off' required name='modules' style='color:#666;' placeholder='Write the modules of the project'>                                              
                                        </div>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>
                                            <button class='btn btn-success' type='submit'>Save</button>
                                        </form>    
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end-->
        <!--Modal-->
        <div class='modal fade' id='pin' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title'>Enter the 4 digit pin</h4>
                                        </div>
                                        <div class='modal-body'> 
                                        In order to list secret projet details, please enter your pin below:
                                        <form action='/members/disdel' method='post'>
                                        <input type='hidden' value='".$project_id."' name='project'>
                                            <br><input type='password' class='form-control' autocomplete='off' required name='val' style='color:#666;width:25%;' pattern='[0-9]{4}' placeholder='Enter the pin'>                                              
                                        </div>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>
                                            <button class='btn btn-success' type='submit'>Save</button>
                                        </form>    
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end-->
        <!--Modal-->
        <div class='modal fade' id='progress' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>  
                                    <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                            <h4 class='modal-title'>Update progress of your project</h4>
                                        </div>
                                        <div class='modal-body'>   
                                        Update the progress of your project here.<br>The progress defines the completion status of the project.<br>
                                        <br><b><u>Details:</u></b><br> 
                                        <p style='color:#222;'>
                                        Project <b>:</b> <span class='label label-inverse'>".$Service->Prote()->DBI()->Func()->projects()->getProjectName($project_id,$id)."</span> ,
                                        Progress <b>:</b> <span class='label label-info'>".$Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)."%</span> , 
                                        Deadline <b>:</b> <span class='label label-danger'>".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineDay($project_id,$id)." ".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineMonth($project_id,$id)." , ".$Service->Prote()->DBI()->Func()->projects()->getProjectDeadlineYear($project_id,$id)."</span>
                                        <hr>
                                        <center><form action='/members/project/progress' method='post'> 
                                        Enter the progress value here:
                                              <div class='input-group m-bot15' style='width:200px;'>
                                              <input type='hidden' name='project' value='".$project_id."'>
                                                <input type='number' name='value' pattern='[0-9]+' class='form-control' value='".($Service->Prote()->DBI()->Func()->projects()->getProjectProgress($project_id,$id)+1)."' style='color:#666;' required>
                                                <span class='input-group-btn'>
                                                <button class='btn btn-success' type='submit'>update</button>
                                                </span>
                                              </div>
                                        </form>
                                        </center>      
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end--> ";  
       }
        echo "</section>
    </section> 
</section>
<div id='almstatus' style='float:right;font-weight:300;margin-top:-5.5rem;font-size:16px;margin-right:0.5rem;'>No Alarm.</div>
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
var commentData='';
  function add(Value)
  {  
     commentData=document.getElementById('tar').innerHTML+'<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"display:inline;height:20px;\"/>'; 
     document.getElementById('tar').innerHTML+='<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"margin-top:2px;display:inline\">'; 
  }
  function setusers()
  {
   document.getElementById('real').value=document.getElementById('tar').innerHTML;  
  } 
</script>
</body>
</div>
</html>";