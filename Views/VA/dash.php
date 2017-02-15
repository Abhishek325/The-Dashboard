 <?php    
include($Service->Config()->get_basepath().'/Views/VA/header.php');
 echo "<section id='main-content'>
        <section class='wrapper'> 
          <div class='row'>
      <div class='col-md-6'>
       <section class='panel'> 
                <div id='c-slide' class='carousel slide auto panel-body'>
                    <ol class='carousel-indicators out'>";
                        echo "<li class='active' data-slide-to='0' data-target='#c-slide'>"; 
                        $c=$Service->Prote()->DBI()->Func()->thought()->getThoughts($id);
                        $ThoughtCounter=0;
                        foreach ($c as $data)
                        {
                         $ThoughtCounter++;   
                         echo "<li class='' data-slide-to='".$ThoughtCounter."' data-target='#c-slide'>";
                        }
                    echo "</ol>
                    <div class='carousel-inner'>
                    <div class='item text-center active'>
                                    <h3>Thought Processor</h3>
                                    <p>Displays thoughts and quotes</p>
                                    <small class='text-muted'>Click on the next arrow to view. Click <a href='#thought' data-toggle='modal'><b><u>here</u></b></a> to add more</a></small>
                                    </div>";
                         $c=$Service->Prote()->DBI()->Func()->thought()->getThoughts($id);
                         foreach ($c as $data) { 
                               echo "
                                    <div class='item text-center '> 
                                    <p>".$data->thought."</p>
                                    <small class='text-muted'>".$data->author."</small>
                                    </div>"; 
                         }
                    echo "  
                    </div>
                    <a data-slide='prev' href='#c-slide' class='left carousel-control' style='margin-top:4rem;'>
                        <i class='medium material-icons'>skip_previous</i>
                    </a>
                    <a data-slide='next' id='nextbtn' href='#c-slide' class='right carousel-control' style='margin-top:4rem;'>
                        <i class='medium material-icons'>skip_next</i>
                    </a>
                </div>
            </section>
    </div> 
    <div class='col-md-3'>
            <div class='mini-stat clearfix' style='padding:25px;height:11rem;margin-left:-2rem;' id='slideshow' onmouseover='showPicForm()' onmouseout='hidePicForm()'> 
                <div class='mini-stat-info'>
                    <center> 
                    <span style='font-size:12px;background:rgba(0,0,0,0.2);padding:3px;color:#fff;margin-top:-2rem;font-weight:400;'>Add pics here</span>
                    <span style='font-size:12px;display:none;background:rgba(0,0,0,0.2);padding:8px;margin-top:4rem;' id='pic_form'>
                      <form action='/members/tilepic' method='post' enctype='multipart/form-data'> 
                          <input type='file' name='image' id='image' style='width:70%;font-size:10px;color:#fff;float:left;display:inline' required/>
                          <input type='submit' name='submit' style='padding:3px;font-size:10px;background:#eeee;border:1px solid rgba(0,0,0,0.5);float:right;height:20px;' value='Add'><br>  
                      </form>  
                    </span></center>
                </div>
            </div>
        </div>  
        <div class='col-md-3'>
            <div class='mini-stat clearfix' style='padding:25px;height:11rem;margin-left:-2rem;'>";
            if(isset($success_msg)) 
            { 
              echo "<span class='mini-stat-icon tar'>&check;</span>";
              $info_msg=$success_msg;
              $title_head="Congrats";
            }
            else if(isset($default_select_error_msg))
            { 
              echo "<span class='mini-stat-icon orange'>&cross;</span>";
              $info_msg=$default_select_error_msg;
              $title_head="Sorry";
            }
            else
            { 
              echo "<span class='mini-stat-icon pink'><i class='medium material-icons'>thumb_up</i></span>";            
              $info_msg="No transaction pending for status approval";
              $title_head="Whoah";
            }
              echo "<div class='mini-stat-info'>
                   <span>".$title_head."</span>".$info_msg." 
              </div>
          </div>
        </div> 
    </div><!--row-->     
    <div class='row'>
        <div class='col-md-8' style='margin-top:-1rem;'>
            <div class='event-calendar clearfix'>
                <div class='col-lg-7 calendar-block'>
                    <div class='cal1 '>
                    </div>
                </div>
                <div class='col-lg-5 event-list-block' style='max-height:500px;overflow-y:scroll;'>
                    <div class='cal-day'>
                        <span>Today</span>
                        <div id='day1'></div>
                    </div>";
                    if($Service->Prote()->DBI()->Func()->event()->getEventCount(date("d"),date("m"),$id))
                    { 
                     echo "<ul class='event-list' style='margin-top:-2rem;overflow-y:scroll;max-height:150px;'> "; 
                      $c=$Service->Prote()->DBI()->Func()->event()->getCurrentDayEvents(date("d"),date("m"),$id); 
                      if(!$c)
                      {
                        echo "Hi";
                      }
                      else
                       foreach ($c as $data)
                       {  
                        echo "<li>".$data->ename."</li>";
                       }  
                    echo "</ul><br>";
                    }
                    //Default notes
                    if($Service->Prote()->DBI()->Func()->event()->getEventCount(date("d"),date("m"),$id)==0)
                     $LowerListHeight="200px;margin-bottom:10rem;"; 
                    else
                     $LowerListHeight="180px";  
                    echo "<ul id='todos' class='event-list' style='margin-top:-1rem;max-height:".$LowerListHeight.";overflow-y:scroll;'>";
                     $c=$Service->Database()->find_many("SELECT * from todo where uid=".$id."");
                      $count_notes=$Service->Prote()->DBI()->Func()->notes()->getcount($id);
                      if($count_notes==0)
                        echo "<li >No notes to display.<br>You can add a sticky note here that is always visible in this section.</li>";
                      else
                      foreach ($c as $data)
                      {  
                       echo "<li id='".$data->id."'>".$data->text."<form><input type='hidden' value='".$data->id."' name='id'><button id='btn".$data->id."' class='mybtns'  type='submit' onmouseover=\"line('".$data->id."')\" onmouseout=\"lineoff('".$data->id."')\" style='float:right;background:none;color:222;border:0;margin-top:-2rem;margin-right:-2rem;'>x</button></li></form>";
                      }  
                    echo "</ul>   
                    </div>
                     <!--<form action='/members/addnote' method='post'>-->
                     <form>
                    <input type='text' name='todo' id='todo' autocomplete='off' class='form-control evnt-input' placeholder='NOTES' style='margin-left:2rem;width:26rem;margin-bottom:0.5rem;'> 
                    </form> 
            </div>
        </div>
        <div class='col-md-4' style='margin-left:-2rem;margin-top:-1rem;'>
            <div class='profile-nav alt'>
            <section class='panel'>
                <div class='user-heading alt clock-row terques-bg'>
                    <h1><div id='date1'></div></h1>
                    <p class='text-left'><div id='day' style='font-size:18px;text-align:left;'></div></p>
                    <p class='text-left'><div id='time' style='font-size:20px;text-align:left;'></div></p>
                </div> 
                <header class='panel-heading tab-bg-dark-navy-blue '>
                    <ul class='nav nav-tabs'> 
                        <li class='active'>
                            <a data-toggle='tab' href='#about'>Alarm</a>
                        </li>
                        <li class=''>
                            <a data-toggle='tab' href='#profile'>Stopwatch</a>
                        </li> 
                    </ul>
                </header>
                <div class='panel-body'>
                    <div class='tab-content'> 
                        <div id='about' class='tab-pane active'>
                        <h4 style='font-weight:300;'>&nbsp;Alarm</h4>
                        <hr>
                        <div id='almstatus' style='float:right;font-weight:300;margin-top:-5.5rem;'>No Alarm.</div>
                         <form action='/members/addalarm' method='post'>
                          Set alarm time <b>:</b>&nbsp;";
                          if(date('i')==59)
                            echo "
                                <input type='number' name='ah' value='".(date('H')+1)."' class='form-control' style='width:70px;display:inline;'>
                                <input type='number' name='am' value='00' class='form-control' style='width:70px;display:inline;'>";
                          else
                          {
                           echo "<input type='number' name='ah' value='".date('H')."' class='form-control' style='width:70px;display:inline;'>"; 
                           if(date('i')<10)
                            echo "<input type='number' name='am' value='0".(date('i')+1)."' class='form-control' style='width:70px;display:inline;'>";
                           else
                            echo "<input type='number' name='am' value='".(date('i')+1)."' class='form-control' style='width:70px;display:inline;'>";        
                          }
                          echo "<button class='btn btn-primary' type='submit'>Set</button> 

                         </form><br>
                         <form  action='/members/alarm' method='post'>
                         Set after <b>:</b>
                          <input type='number' name='offset' required='' value='01' class='form-control' style='width:70px;margin-top:-1.5rem;display:inline;color:#333;'>
                           <select class='form-control m-bot15' name='drop' style='width:150px;font-weight:400;display:inline;color:#333;'>
                           <option value='m'>Minutes</option>
                           <option value='h'>Hour(s)</option>
                          </select> 
                          <button class='btn btn-primary' type='submit' style='float:right;'>Set</button> 
                         </form>
                         <form action='/members/delalarm' method='post'><button  class='btn btn-primary' style='float:right;margin-right:0.2rem;' type='submit'>Dismiss All</button>&nbsp;&nbsp;</form> 
                        </div>
                        <div id='profile' class='tab-pane'>
                          <h4 style='font-weight:300;'>&nbsp;Stopwatch</h4>
                           <hr>
                          <div id='clockstatus' style='float:right;margin-top:-5.5rem;font-weight:300;'>Ready</div>  
                        <div>
                         <h3 style='font-weight:300;text-align:center;font-size:30px;' id='StopWatch'>00:00:00</h3><br>
                         <div class='center'>
                          <center><button id='start' class='btn btn-success' onclick='init();'>Start</button>
                          <button id='pause' class='btn btn-success' onclick='PauseClock();'>Pause</button>
                          <button id='stop' class='btn btn-success'  onclick='stopTheClock();'>Stop</button>
                          </center>
                          <br><br>
                         </div>
                        </div>
                        </div>
                        <div id='contact' class='tab-pane'>Contact</div>
                    </div>
                </div> 
            </section>

                </div>
        </div> 
    </div> 
    <div class='row'>
    <div class='col-md-6'>
       <section class='panel'>  
                    <header class='panel-heading'>
                        Change the system preferences here :
                    </header>
                    <div class='panel-body'>  
                                    <div style='margin-bottom:0.3rem;margin-top:1rem;font-size:15px;'>Name<b> :</b> <span class='label label-primary'>".$name."</span><br></div>
                                    <div style='margin-bottom:0.3rem;margin-top:1rem;font-size:15px;'>Email<b> :</b> &nbsp;<span class='label label-info'>".$email."<br></div> 
                                    <div style='margin-bottom:0.3rem;margin-top:1rem;font-size:15px;'>PIN<b> : </b> &nbsp;&nbsp;&nbsp;
                                    <a href='/members/settings' style='color:#f2f2f2;'><span class='label label-danger'>Change</a></span><br></div>
                                    <!--<div style='margin-bottom:0.3rem;margin-top:0.5rem;'>Password [<a class='modal-trigger' href='#pwd' style='font-size:16px;'>change</a>]<br></div>-->
                                    <form action='/members/autotimemod' method='post'>
                                    <div style='margin-bottom:0.3rem;margin-top:0.5rem;'>Auto logout time<b> : 
                                    <div class='input-group ' style='margin-bottom:1.5rem;width:250px;'>
                                    <select class='form-control m-bot15' name='timecount' style='color:#666;'> 
                                     <option value='1'>Select here..</option>
                                     <option value='1'>1 minute</option>
                                     <option value='2'>2 minutes</option>
                                     <option value='3'>3 minutes</option>
                                     <option value='4'>4 minutes</option>
                                     <option value='5'>5 minutes</option>    
                                     </select> 
                                     <span class='input-group-addon btn-warning' style='cursor:pointer;padding:0;'>
                                     <button type='submit' style='padding:8px;background:none;border-width:0;color:#fff;'>
                                     Save</button></span>     
                                     </div>  
                                    </form>
                                    </b> 
       <p>Current autologout time <b>:</b> <span class='label label-inverse'>";
       echo $automin=($Service->Prote()->DBI()->Func()->users()->getautologouttime($id)-1)/60;
        if($automin>1)
          {echo ' minutes';}
        else echo ' minute'; 
      echo "</span></p> 
      </div> 
      </div>
      </section>
      </div>  
    <div class='col-md-6' style='margin-left:-2rem;'>
        <!--activity start-->
        <section class='panel'>
            <header class='panel-heading'>
                Activity log <span class='tools pull-right'>  
                <form>
                <button class='btn btn-danger' id='clear-act' type='submit' style='margin-top:-0.8rem'>Clear</button></form>
            </span>
            </header>  
          <div class='panel-body' style='min-height:223px;max-height:223px;overflow-y:scroll;'>";
           if($Service->Prote()->DBI()->Func()->activity()->countActivity($id)==0)
            { 
              echo "<div class='alert alert-warning clearfix'>
                    <span class='alert-icon'><div style='margin-left:1.5rem;margin-top:1rem;font-weight:600;'>&raquo;</div></span>
                    <div class='notification-info'>
                        <ul class='clearfix notification-meta' >
                            <li class='pull-left notification-sender'>No activity</li>
                            <li class='pull-right notification-time'></li>
                        </ul>
                        <p>There is no activity to display. Whenever an event is made to occur by user, an activity log is created corresponding to that event.</p>
                    </div>
                </div>";
            }
           $c=$Service->Database()->find_many("SELECT * from activity where uid=".$id." order by time DESC");  
           foreach ($c as $data)
           {  
            echo "<div class='alert alert-".$data->type." clearfix' id='actContainer' style='height:55px;padding:8px;margin:0 0 3px 0;'>
                    <span class='alert-icon'></span>
                    <div class='notification-info'>
                        <ul class='clearfix notification-meta' id='acts'>";   
                          echo "<li class='pull-left notification-sender'>".$data->act_des."</li> 
                        </ul>
                        <p id='actTimes'>Time stamp <b>:</b> ".$data->time."</p>
                    </div>
                </div>";
            }
          echo "</div>
        </section>
        <!--activity end-->
    </div> 
    </div>
    </section>
    </section>
    <!--main content end--> 
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src='/members/Static/VA/js/lib/jquery.js'></script>
<script src='/members/Static/VA/assets/jquery-ui/jquery-ui-1.10.1.custom.min.js'></script>
<script src='/members/Static/VA/bs3/js/bootstrap.min.js'></script>
<script src='/members/Static/VA/js/accordion-menu/jquery.dcjqaccordion.2.7.js'></script>
<script src='/members/Static/VA/js/scrollTo/jquery.scrollTo.min.js'></script>  
<script src='/members/Static/VA/assets/jQuery-slimScroll-1.3.0/jquery.slimscroll.js'></script>
<script src='/members/Static/VA/assets/skycons/skycons.js'></script>
<script src='/members/Static/VA/assets/jquery.scrollTo/jquery.scrollTo.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
<script src='/members/Static/VA/assets/calendar/clndr.js'></script>
<script src='/members/Static/VA/js/nicescroll/jquery.nicescroll.js' type='text/javascript'></script> 
<script src='http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js'></script>
<script src='/members/Static/VA/assets/calendar/moment-2.2.1.js'></script>
<script src='/members/Static/VA/js/calendar/evnt.calendar.init.js'></script>
<script src='/members/Static/VA/assets/jvector-map/jquery-jvectormap-1.2.2.min.js'></script>
<script src='/members/Static/VA/assets/jvector-map/jquery-jvectormap-us-lcc-en.js'></script> 
 
<!--common script init for all pages-->
<script src='/members/Static/VA/js/scripts.js'></script> 

<script type='text/javascript'>  
$('#nextbtn').click();
  var commentData='';
  function add(Value)
  {  
     commentData=document.getElementById('tar').innerHTML+'<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"display:inline;height:20px;\"/>'; 
     document.getElementById('tar').innerHTML+='<img src=/members/Static/VA/images/smileys/'+Value+'.png style=\"margin-top:2px;display:inline\">'; 
  }
  function setdata()
  {
   document.getElementById('real').value=commentData+document.getElementById('tar').innerHTML; 
  }
  function line(id)
  { 
    document.getElementById(id).style.textDecoration='line-through';
    document.getElementById(id).style.fontWeight='600';
    //Store currently written text in temp..
    //var temp=document.getElementById('todo').value; 
   }
  function lineoff(id)
  { 
    document.getElementById(id).style.textDecoration='none';
    document.getElementById(id).style.fontWeight='400';
  }
    var imgSrcs=['Static/VA/uploads/newpic1.jpg'];";
    $handle=opendir("Static/VA/uploads");
    while(false!==($entry=readdir($handle)))
    {
      if($entry!="." && $entry!="..")
        echo "imgSrcs.push('Static/VA/uploads/".$entry."');";
    }
     echo "setInterval(function()
        {
          
          $('#slideshow').css('background', 'url(' + imgSrcs[imgSrcs.push(imgSrcs.shift())-1] + ') no-repeat center');
          $('#slideshow').css('background-size','cover');
          $('#slideshow').css('-webkit-transition','all 0.8s ease-in-out');
          $('#slideshow').css('-moz-transition','all 0.8s ease-in-out');
          $('#slideshow').css('-o-transition','all 0.8s ease-in-out');
          $('#slideshow').css('-ms-transition','all 0.8s ease-in-out');
        }, 3000); 

function showPicForm()
{ 
  document.getElementById('pic_form').style.display='block';
}
function hidePicForm()
{ 
  document.getElementById('pic_form').style.display='none';
}  
</script>

<script type='text/javascript'>
$('#todo').keypress(function(e){ 
 var todo = $('#todo').val();    
 if(e.keyCode=='13') 
 { 
  var dataString = 'todo='+ todo;    
   $.ajax({
    type: 'POST',
    url: '/members/addnote',
    data: dataString,
    cache: false,
    success: function(result){   
      //:D This code could be dangerous
      $('<li>',{html:todo})
        .appendTo('#todos'); 
       document.getElementById('todo').value=''; 
    }
   }); 
   return false;
 }
});
 
$('.mybtns').click(function(e){   
    var x = this.id;
    var noteid = x.substring(3,x.length); 
    $.ajax({
    type: 'POST',
    url: '/members/del',
    data: 'id='+noteid,
    cache: false,
    success: function(result){      
    document.getElementById(noteid).style.display='none';     
    }
   });
   return false; 
});

$('#clear-act').click(function(e){   
   $.ajax({
    type: 'POST',
    url: '/members/activity.log/clear_activity_log',
    data: ' ',
    cache: false,
    success: function(result){    
      $(acts).empty(); 
      $(actContainer).nextAll().remove(); 
       document.getElementById('actContainer').innerHTML='<h4 style=\"color:#3c3c43;font-size:14px;padding:5px;\">There is no activity to display.<br>Activity log cleared at <b>".date('H').":".date('i')."</b></h4>'; 
       document.getElementById('actTimes').innerHTML='';  
    }
   }); 
   return false; 
});    
</script>
</body>
</div>
</html>";