<?php   
date_default_timezone_set('Asia/Kolkata'); 
$email=$_SESSION['email'];
$name=$Service->Prote()->DBI()->Func()->users()->getName($Service->Prote()->DBI()->Func()->users()->mapUserId($email));
$id=$Service->Prote()->DBI()->Func()->users()->mapUserId($email); 
 echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content='ThemeBucket'>
    <link rel='shortcut icon' href='/members/Static/VA/images/joker.jpg'>
    <title>".$name." online</title>
    <!--Core CSS -->
    <link href='/members/Static/VA/bs3/css/bootstrap.min.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/custom.css' rel='stylesheet'>
    <link href='/members/Static/VA/assets/jquery-ui/jquery-ui-1.10.1.custom.min.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/bootstrap-reset.css' rel='stylesheet'>
    <link href='/members/Static/VA/assets/font-awesome/css/font-awesome.css' rel='stylesheet'>
    <link href='/members/Static/VA/assets/jvector-map/jquery-jvectormap-1.2.2.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/clndr.css' rel='stylesheet'> 
    <link href='/members/Static/VA/assets/css3clock/css/style.css' rel='stylesheet'> 
    <link rel='stylesheet' href='/members/Static/VA/assets/morris-chart/morris.css'> 
     <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <link href='/members/Static/VA/css/style.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/style-responsive.css' rel='stylesheet'/>  
    <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
    <script src='https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'></script>
    <script src='/members/Static/VA/js/date_time.js'></script>
    <script src='/members/Static/VA/js/ajax.jquery.min.js'></script>
    <![endif]-->
</head> 
<div onmouseover='resetDormancy()' onclick='resetDormancy()' onkeypress='resetDormancy()'>
<body onLoad='startTime();showDay();reminder();sdate();'> 
<style type='text/css'> 
    #toast-container {
    display: block;
    position: fixed;
    z-index: 1001; }
    @media only screen and (max-width : 600px) {
      #toast-container {
        min-width: 100%;
        bottom: 0%; } }
    @media only screen and (min-width : 601px) and (max-width : 992px) {
      #toast-container {
        min-width: 30%;
        left: 5%;
        bottom: 7%; } }
    @media only screen and (min-width : 993px) {
      #toast-container {
        min-width: 8%;
        top: 10%;
        right: 7%; } } 
    .toast {
    border-radius: 2px; 
    width: auto;  
    position: relative;
    max-width: 100%; 
    font-family: \"Roboto\", sans-serif;
    display: block;
    -webkit-flex-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
    -webkit-justify-content: space-between;
    justify-content: space-between; }  
  </style>
<section id='container'>
    <!--header start-->
    <header class='header fixed-top clearfix'>
        <!--logo start-->
        <div class='brand'>

            <a href='#' class='logo' style='color:#fff;text-transform:none;'>
               #".$name."
            </a>
            <div class='sidebar-toggle-box'> 
                <div class='fa-bars' style='margin-top:-0.8rem;margin-left:0.2rem;font-size:20px;color:#fff;'>&laquo;</div>
            </div>
        </div>
        <!--logo end-->

        <div class='nav notify-row' id='top_menu'>
            <!--  notification start -->
            <ul class='nav top-menu'>   
                <!-- notification dropdown start-->
                <li id='header_notification_bar' class='dropdown'>
                    <a data-toggle='dropdown' class='dropdown-toggle' href='#'>";
                    $c=$Service->Prote()->DBI()->Func()->notification()->get_count($id); 
                    echo "<i class=' tiny material-icons' style='font-size:18px;margin-top: 0.4rem;'>toc</i>";
                    if($c)
                     echo "<span class='badge bg-warning' id='notiCount'>".$c."</span>";
                    echo "</a>
                    <ul class='dropdown-menu extended notification' id='noti'>
                        <li>
                            <p>Notifications</p>
                        </li>";
                     if($c>3)
                     {
                        echo "<div style='height:225px;overflow-y:scroll;'>";
                        $c=$Service->Database()->find_many("SELECT * from notification where uid=".$id.""); 
                          foreach ($c as $data)
                          {   
                           echo "<li id='".$data->id."'>
                                <div class='alert alert-info clearfix'>
                                    <span class='alert-icon'><!--<i class='fa fa-bolt'></i>--><div style='margin-left:1.2rem;margin-top:0.3rem;font-weight:800;font-size:18px;'>&raquo;</div></span>
                                    <div class='noti-info'>".$data->noti;  
                            echo "</div> 
                            <form><input type='hidden' value='".$data->id."' name='notid'> 
<button type='submit' id='notif".$data->id."' class='mynotis' style='background:none;border:none;float:right;margin-top:1rem;'><b style='color:#000;font-size:13px;'>X</b></button></form>  
                                </div>
                            </li> "; 
                          }
                          echo "</div>";
                          echo "<li><div class='alert alert-danger clearfix'> 
                                <form>
                                <button type='submit' id='delAllNoti' style='width:100%;padding:0;margin:0;background:none;border:none;'><b style='color:#000;font-size:13px;'>Remove All</b></button></form></div></li>";
                     }
                     else if($c<=3) 
                      { 
                          $c=$Service->Database()->find_many("SELECT * from notification where uid=".$id."");
                          foreach ($c as $data)
                          {  
                           echo "<li id='".$data->id."'>
                                <div class='alert alert-info clearfix'>
                                    <span class='alert-icon'><!--<i class='fa fa-bolt'></i>--><div style='margin-left:1.2rem;margin-top:0.3rem;font-weight:800;font-size:18px;'>&raquo;</div></span>
                                    <div class='noti-info'>".$data->noti;  
                            echo "</div> 
                            <form><input type='hidden' value='".$data->id."' name='notid'> 
<button type='submit'  id='notif".$data->id."' class='mynotis'  style='background:none;border:none;float:right;margin-top:1rem;'><b style='color:#000;font-size:13px;'>X</b></button></form>  
                                </div>
                            </li> ";
                          }
                      }
                    echo "</ul>
                </li>
                <!-- notification dropdown end -->
            </ul> 
            <!--  notification end -->  
        </div>
        <div class='top-nav clearfix'>
            <!--search & user info start-->
            <ul class='nav pull-right top-menu'> 
                <li>
                    <input type='text' class='form-control search' placeholder=' Search'> 
                </li>
                <!-- user login dropdown start-->
                <li class='dropdown'>
                    <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
                        <img alt='' src='/members/Static/VA/images/joker.jpg'>
                        <span class='username'>".$name."</span>
                        <b class='caret'></b>
                    </a>
                    <ul class='dropdown-menu extended logout'>
                        <li><a href='/members/settings'><i class='large material-icons'>settings_applications</i>Settings</a></li>
                        <li><a href='#'><i class='large material-icons'>perm_identity</i>Profile</a></li>
                        <li><form action='/members/logout' method='post'>
                            <input type='hidden' value='".$Service->Html()->auth_token."' name='auth_token'>
                            <button type='submit' style='border:none;font-size:12px;width:100%;text-align:left;padding:7px;'><i class='tiny material-icons' style='float: left;font-size:18px;'>lock</i> &nbsp;&nbsp;&nbsp;Logout</button>
                           </form>
                           </li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
                <li>
                    <div class='toggle-right-box'>
                        <div class='fa-bars' style='margin-top:-0.8rem;margin-left:0.2rem;font-size:20px;color:#777;'>&raquo;</div>
                    </div>
                </li>
            </ul>
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id='sidebar' class='nav-collapse'>
            <!-- sidebar menu start-->
            <ul class='sidebar-menu' id='nav-accordion'>
                <li>
                    <a href='/members/dashboard'> 
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href='/members/event'> 
                        <span>Event</span>
                    </a>
                    <div id='eventstat' style='margin-left:2.0rem;margin-top:-4rem;font-size:11px;padding:7px;'></div>
                </li>
                <!--<li>
                    <a href='#'> 
                        <span>HTML test</span>
                    </a>
                </li>-->
                <li class='sub-menu'> 
                    <a href='#reminder' data-toggle='modal' style=''>Reminder</a>
                       <div id='rem' style='margin-left:2.6rem;margin-top:-1.5rem;font-size:11px;'></div> 
                       <div style='float:right;margin-top:-1.5rem;'>";
                       if($Service->Prote()->DBI()->Func()->reminder()->get_count($id))
                       { 
                         $c=$Service->Database()->find_many("SELECT * from reminder where uid=".$id."");
                         foreach ($c as $data)
                         {  
                         echo "<form action='/members/delrem' method='post'>
                         <input type='hidden' value='".$data->rid."' name='reminderid'>
                         <button type='submit' style='background:none;border:none;margin-right: 1rem;'>
                          <b>X</b>
                         </button>
                         </form>
                         </div><br> ";
                         break;//For displaying one reminder at a time.
                         } 
                       }        
                echo " </li> 
                <li>
                    <a href='/members/write-post'> 
                        <span>Write a post</span>
                    </a>
                </li>   
                <li>
                    <a href='/members/projects'> 
                        <span>Projects</span>
                    </a>
                </li> 
                <!--<li>
                    <a href='Views/VA/custom/MyFirstAjaxApp.html'> 
                        <span>Word search engine</span>
                    </a>
                </li>-->" ;
                if($name=="Abhishek"||$name=="Swastik")
                echo " <li> 
                <a href='#signups' data-toggle='modal' style=''>Signups</a>
                </li>";
            echo " </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--right sidebar start-->
<div class='right-sidebar'> 
<ul class='right-side-accordion'>
<!--<li class='widget-collapsible'>
    <a href='#' class='head widget-head red-bg active clearfix'>
        <span class='pull-left'>work progress (5)</span>
        <span class='pull-right widget-collapse'><i class='ico-minus'></i></span>
    </a>
    <ul class='widget-container'>
        <li>
            <div class='prog-row side-mini-stat'>
                <div class='side-graph-info'>
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class='side-mini-graph'>
                    <div class='p-delivery'>
                        <div class='sparkline' data-type='bar' data-resize='true' data-height='30' data-width='90%' data-bar-color='#39b7ab' data-bar-width='5' data-data='[200,135,667,333,526,996,564,123,890,564,455]'>
                        </div>
                    </div>
                </div>
            </div>
            <div class='prog-row side-mini-stat'>
                <div class='side-graph-info payment-info'>
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class='side-mini-graph'>
                    <div class='p-collection'>
                        <span class='pc-epie-chart' data-percent='45'>
                        <span class='percent'></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='prog-row side-mini-stat'>
                <div class='side-graph-info'>
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class='side-mini-graph'>
                    <div class='d-pending'>
                    </div>
                </div>
            </div>
            <div class='prog-row side-mini-stat'>
                <div class='col-md-12'>
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class='progress progress-xs mtop10'>
                        <div style='width: 50%' aria-valuemax='100' aria-valuemin='0' aria-valuenow='20' role='progressbar' class='progress-bar progress-bar-info'>
                            <span class='sr-only'>50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class='widget-collapsible'>
    <a href='#' class='head widget-head terques-bg active clearfix'>
        <span class='pull-left'>contact online (5)</span>
        <span class='pull-right widget-collapse'><i class='ico-minus'></i></span>
    </a>
    <ul class='widget-container'>
        <li>
            <div class='prog-row'>
                <div class='user-thumb'>
                    <a href='#'><img src='/members/Static/VA/images/avatar1_small.jpg' alt=''></a>
                </div>
                <div class='user-details'>
                    <h4><a href='#'>Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class='user-status text-danger'>
                    <i class='fa fa-comments-o'></i>
                </div>
            </div>
            <div class='prog-row'>
                <div class='user-thumb'>
                    <a href='#'><img src='/members/Static/VA/images/avatar1.jpg' alt=''></a>
                </div>
                <div class='user-details'>
                    <h4><a href='#'>Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class='user-status text-success'>
                    <i class='fa fa-comments-o'></i>
                </div>
            </div>
            <div class='prog-row'>
                <div class='user-thumb'>
                    <a href='#'>Hey</a>
                </div>
                <div class='user-details'>
                    <h4><a href='#'>Jhone Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class='user-status text-warning'>
                    <i class='fa fa-comments-o'></i>
                </div>
            </div>
            <div class='prog-row'>
                <div class='user-thumb'>
                    <a href='#'><img src='/members/Static/VA/images/avatar1_small.jpg' alt=''></a>
                </div>
                <div class='user-details'>
                    <h4><a href='#'>Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class='user-status text-info'>
                    <i class='fa fa-comments-o'></i>
                </div>
            </div>
            <div class='prog-row'>
                <div class='user-thumb'>
                    <a href='#'><img src='/members/Static/VA/images/avatar1.jpg' alt=''></a>
                </div>
                <div class='user-details'>
                    <h4><a href='#'>Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class='user-status text-danger'>
                    <i class='fa fa-comments-o'></i>
                </div>
            </div>
            <p class='text-center'>
                <a href='#' class='view-btn'>View all Contacts</a>
            </p>
        </li>
    </ul>
</li>-->
<li class='widget-collapsible'>
    <a href='#' class='head widget-head purple-bg active'>
        <span class='pull-left'> recent activity (3)</span>
        <span class='pull-right widget-collapse'><i class='ico-minus'></i></span>
    </a>
    <ul class='widget-container'>
        <li>"; 
                 $c=$Service->Database()->find_many("SELECT * from activity where uid=".$id." order by time DESC LIMIT 3");   
                 foreach ($c as $data){  
                    echo "<div class='prog-row'>
                        <div class='user-thumb rsn-activity'>
                            <!--<i class='fa fa-clock-o'></i>-->
                            <div style='margin-left:1.2rem;margin-top:0.3rem;font-weight:600;font-size:18px;'>&raquo;</div>
                        </div><div class='rsn-details '>
                        <p class='text-muted'>
                            ".$data->time."
                        </p>
                        <p>
                        <a href='#'>#Dashboard</a><br>".$data->act_des."</p>
                        </div>
                        </div> ";
                    }
        echo "</li>
    </ul>
</li> 
</ul>
</div> 
<!--Modal-->
        <div class='modal fade' id='reminder' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>  
                                    <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                            <h4 class='modal-title'>Reminder</h4>
                                        </div>
                                        <div class='modal-body'>  
                                        Add a reminder to your system to intimate you when you are using dashboard.
                                        <form action='/members/remind' method='post'> 
                                            <br><center>
                                            <input type='text' class='form-control' name='rtext' placeholder='Reminder text/Name ' required style='width:70%;'><br>
                                            <input type='number' class='form-control' name='hour' value='".date('H')."' placeholder='Hours' required autocomplete='off' style='width:75px;margin-top:-3rem;;display:inline;'>
                                            <div style='margin-top:-3rem;display:inline;font-size:22px;'> : </div>
                                            <input type='number' class='form-control' name='min' value='".date('i')."' placeholder='Minutes' required off' style='width:75px;margin-top:-3rem;;display:inline;'><br>
                                            <input type='text' class='form-control' name='linkname' value='http://'   placeholder='Action link to be opened' required autocomplete='off' style='width:70%;' >
                                        </div></center>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>
                                            <button class='btn btn-success' type='submit'>Save</button>
                                        </form>    
                                        </div>      
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end-->
        <!--Modal-->
        <div class='modal fade' id='thought' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'> 
                                        <div class='modal-body'>  
                                          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h3 class='modal-title'>Thought Processor</h3>
                                        </div>
                                        <div class='modal-body'>   
                                        Add some of the most inspiring thoughts and quotes to your dashboard and keep yourselves motivated.<br> 
                                        <form action='/members/addthought' method='post'>
                                        <center>
                                        <input type='text' class='form-control' name='thought' placeholder='Thought/Quote.' required  autocomplete='off' >
                                        <input type='text' class='form-control' name='author'  placeholder='Author ' required autocomplete='off' style='width:50%;margin-top:0.1rem;' > 
                                        </center> 
                                        </div></center>
                                        <div class='modal-footer'>
                                            <button data-dismiss='modal' class='btn btn-alert' type='button'>Close</button>
                                            <button class='btn btn-success' type='submit'>Save</button>
                                        </form>    
                                        </div>      
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end-->
        <!--Modal-->
        <div class='modal fade' id='signups' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>  
                                    <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                            <h4 class='modal-title'>Sign ups</h4>
                                        </div>
                                        <div class='modal-body'>  
                                        <center><p id='listmsg'>Click on the below button to list signups on the website.</p>
                                        <button class='btn btn-success' id='listbtn' onclick='listSignups()'>List now</button><br>
                                        <table class='table table-bordered table-striped table-condensed' id='listTable' style='display:none;margin-top:2rem;'>
                                        <thead>
                                        <tr>  
                                            <th class='numeric'>Name</th>
                                            <th class='numeric'>Email</th> 
                                        </tr>
                                        </thead>
                                        <tbody id='listsignupbtn'>  
                                        </tbody>
                                        </table>
                                        <button class='btn btn-success' id='relistbtn' onclick='listSignups()' style='display:none;'>Refresh list</button>
                                        </center>
                                        </div>
                                    </div>
                                </div>
         </div>
        <!-- Modal end-->
<audio id='audio' src='/members/Static/VA/sounds/reminder.mp3' loop ></audio>
<audio id='hour' src='/members/Static/VA/sounds/hour.mp3'></audio>  
<audio id='thecountdown' src='/members/Static/VA/sounds/thecountdown.mp3'></audio>  
<script src='/members/Static/VA/js/ajax.jquery.min.js'></script>
<script src='/members/Static/VA/js/materialize.js'></script>  
<script type='text/javascript'>

var al=0,alon=0; 
  var dormantCount=".$Service->Prote()->DBI()->Func()->users()->getautologouttime($id).";  
  function resetDormancy()
  {  
    if(dormantCount<10)    
     Materialize.toast('Woaah..that was really close.',5000);  
    dormantCount=". $Service->Prote()->DBI()->Func()->users()->getautologouttime($id)."; 
  }
function alarmF()
  {   
    var today=new Date();
    var h1= '".$Service->Prote()->DBI()->Func()->alarm()->get_htime($id)."';
    var m1='".$Service->Prote()->DBI()->Func()->alarm()->get_mtime($id)."';
    var h=today.getHours();
    var m=today.getMinutes();
    h1=checkTime(h1);
    m1=checkTime(m1);
    ";
    if($Service->Prote()->DBI()->Func()->alarm()->get_count($id))
    {       
       echo "document.getElementById('almstatus').innerHTML='@<b>'+h1+':'+m1;  
       if(h==h1&&m==m1)
       {
        al=0;
        if(alon==0)
        {   
         Materialize.toast('Alarm Activated.',59000 );
         alon=1;
         var audio = document.getElementById('audio');
         audio.play();
        }
         document.getElementById('almstatus').innerHTML='Alarm On.';

       }
       else if(h1>=h&&m1<m)
       {";
         $Service->Database()->query('UPDATE `alarm` SET `done` = 1 WHERE hr<="'.date('H').'" and min<"'.date('i').'" and uid="'.$id.'";'); 
         if($Service->Prote()->DBI()->Func()->alarm()->remove($id))
         {
          echo "
          alon=0;
          if(al==0)
          {  
           Materialize.toast('Deleted alarms with done status.',30000 ); 
           al=1; 
          }
          ";  
         }
         else
          echo "Materialize.toast('Unable to delete old alarms!!!.',5000 );";
         echo "   
       }
       "; 
    }
    else
      echo "document.getElementById('almstatus').innerHTML='No Alarm.';";
  //***Delete this if reminder is settled:
    echo "t=setTimeout(function(){alarmF();},500);"; 
    echo " 
  }     
 var showF=0;
  var showNotification=0;
  var eveflag=0;
  var autoLogoutf=0;
  var timCounter=0;
  remNotification=0;
  function reminder()
  {
    timCounter++;
    if(dormantCount<10&&timCounter%2==0)
    { 
     /*Materialize.toast('System inactive for too long. Logging out in '+dormantCount+'s',1000);
     var caudio = document.getElementById('thecountdown');
     caudio.play();*/
    }
    var today=new Date();
    var h1= '".$Service->Prote()->DBI()->Func()->reminder()->get_htime($id)."';
    var m1='".$Service->Prote()->DBI()->Func()->reminder()->get_mtime($id)."';
    var s1=00;
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();   
            if((m1-m)>0)
             document.getElementById('rem').innerHTML='<b> ".$Service->Prote()->DBI()->Func()->reminder()->get_text($id)."  </b><br>'+ 'ready in '+ ( m1-m) +' minute(s)<br>' ;
           else
             document.getElementById('rem').innerHTML='No Reminders';
            m=checkTime(m);
            s=checkTime(s);
            if((h==h1&&m1==m)||(h==h1&&(m1-m)==0))
            {
              if(showNotification==0)
              { ";   
               if($Service->Prote()->DBI()->Func()->reminder()->get_text($id)!=null)
               { 
                echo "var audio = document.getElementById('audio');
                    audio.play(); 
                    showNotification=1;";
               }
               if($Service->Prote()->DBI()->Func()->reminder()->get_link($id)!="http://")
               { 
                echo "$(document).ready(function(){
                      window.open('".$Service->Prote()->DBI()->Func()->reminder()->get_link($id)."', '_blank'); 
                }); 
                ";
               }
              echo " }
              showF=0;
              document.getElementById('rem').innerHTML='<b> ".$Service->Prote()->DBI()->Func()->reminder()->get_text($id)."  </b><br>'+ ' &nbsp;is activated<br>'; 
              if(remNotification==0)
              { 
               Materialize.toast('Reminder to ".$Service->Prote()->DBI()->Func()->reminder()->get_text($id)." is activated', 10000); 
               remNotification=1;
              }
            }
            else if((m>m1)||(h>h1))
            {
             showNotification=0;  
             "; 
             if($Service->Prote()->DBI()->Func()->reminder()->get_count($id))
            echo "  
               if(h>h1)
               {
                if((m-m1)<0)
                 document.getElementById('rem').innerHTML='No Reminders';  
                else  
                document.getElementById('rem').innerHTML='<b><em>".$Service->Prote()->DBI()->Func()->reminder()->get_text($id)." </em></b><br>'+(h-h1)+'h and '+(m-m1)+' minutes ago';
               }
               else 
               { 
                document.getElementById('rem').innerHTML='<b><em>".$Service->Prote()->DBI()->Func()->reminder()->get_text($id)." </em></b><br>'+(m-m1)+' minutes ago';
               }
            }";
           else 
              echo "document.getElementById('rem').innerHTML='No Reminders';
            }";

            echo " 
            else if(h>h1)
              {".   
               $Service->Prote()->DBI()->Func()->reminder()->remove(date('H'),$id).
             "
             if(showF==0)
             { 
              Materialize.toast('Deleted expired reminders.', 60000);
              showF=1;  
             }
           }
            //Event check goes here.. 
            ";
             $nextEventDay=$Service->Prote()->DBI()->Func()->event()->getNextEventDay(date('d'),date('m'),$id); 
             $nextEventMonth=$Service->Prote()->DBI()->Func()->event()->getNextEventMonth(date('d'),date('m'),$id); 

             if($Service->Prote()->DBI()->Func()->event()->getEventCount($nextEventDay,$nextEventMonth,$id)==1)
             { 
              if($eventName=$Service->Prote()->DBI()->Func()->event()->getEvents($nextEventDay,$nextEventMonth,$id))  
                echo "document.getElementById('eventstat').innerHTML='<font color=\"#333\">Coming event @".($nextEventDay)." '+mapmonth('".$nextEventMonth."')+' <b>:</b></font><br><b>".$eventName."</b>';";  
             }
             else if($Service->Prote()->DBI()->Func()->event()->getEventCount($nextEventDay,$nextEventMonth,$id)>1)
             {
              echo "var events='<font color=\"#333\">Coming events @".$nextEventDay." '+mapmonth('".$nextEventMonth."')+'</font><ul>';";
              $c=$Service->Database()->find_many("select `ename` from event where day=".($nextEventDay)." and month=".$nextEventMonth." and uid=".$id.";");
              foreach ($c as $data)
              {
               echo "events=events+'<li style=\"margin-left:-1rem;list-style-type:disc;\">".$data->ename."</li>';";
              }

              echo "document.getElementById('eventstat').innerHTML='<b>'+events+'</b></ul>';";
             }
             //today's events:
             if($Service->Prote()->DBI()->Func()->event()->getEventCount(date('d'),date('m'),$id))
             {
               
              $eves=$Service->Database()->find_many("SELECT * from event where day=".date('d')." and month=".date('m')." and uid=".$id." order by ename;"); 
                echo "document.getElementById('eventstat').innerHTML='<br><strong>Todays\'s events :</strong><font color=\"#333\"></font>";
                foreach ($eves as $e) { 
                 $eventName=str_replace("&lt;br&gt;", "<br>&raquo; ", $e->ename);
                 echo "<br>&raquo; <b>".$eventName."</b>";  
                }
                echo "';";
             }
             //tomorrow's events:
             else if($Service->Prote()->DBI()->Func()->event()->getEventCount((date('d')+1),date('m'),$id))
             {  
                $eves=$Service->Database()->find_many("SELECT * from event where day=".(date('d')+1)." and month=".date('m')." and uid=".$id." order by ename;"); 
                echo "document.getElementById('eventstat').innerHTML='<br><strong>Tomorrow\'s events :</strong><font color=\"#333\"></font>";
                foreach ($eves as $e) { 
                 $eventName=str_replace("&lt;br&gt;", "<br>&raquo; ", $e->ename);
                 echo "<br>&raquo; <b>".$eventName."</b>";  
                }
                echo "';";
              }     
             else
             {
               //finally...no today's or tomorrow's event(s) or no upcoming events(s)..:|
                echo "document.getElementById('eventstat').style.color=\"#777\";";
                echo "document.getElementById('eventstat').innerHTML='<br>No upcoming events';" ; 
             }
             //Auomated event deletion:
             echo " if(eveflag==0)";
             if($Service->Prote()->DBI()->Func()->event()->getEventCount(date('d')-1,date('m'),$id)&&$Service->Prote()->DBI()->Func()->event()->delEvents(date('d'),date('m'),$id))
             { 
              echo "Materialize.toast('Removed finished events of the day.',10000);eveflag=1;"; //?4
             }
             echo "t=setTimeout(function(){reminder();alarmF();},500);  
  }  
  
  $('#delAllNoti').click(function(e){   
   $.ajax({
    type: 'POST',
    url: '/members/delAllnoti',
    data: ' ',
    cache: false,
    success: function(result){    
      $(noti).empty();  
      $('<li><p>Notifications</p></li>').appendTo('#noti');  
       document.getElementById('notiCount').innerHTML='';
    }
   }); 
   return false; 
}); 

$('.my  notis').click(function(e){   
    var x = this.id;
    var noteid = x.substring(5,x.length);    
    var notiC=document.getElementById('notiCount').innerHTML; 
    $.ajax({
    type: 'POST',
    url: '/members/delnoti',
    data: 'notid='+noteid,
    cache: false,
    success: function(result){      
    document.getElementById(noteid).style.display='none';     
    document.getElementById('notiCount').innerHTML=notiC-1;
    }
   });
   return false; 
}); 
 
function listSignups(){
            document.getElementById('listTable').style.display='table';
            document.getElementById('relistbtn').style.display='block';
            document.getElementById('listTable').style.marginTop='-2rem';
            document.getElementById('listbtn').style.display='none';
            document.getElementById('listmsg').innerHTML='Here&#8217;s the list of signed up users.<br>Click on <b>Refresh list</b> button to re-generate the below list <b>:</b>';
            var ajaxRequest; 
            try{ 
            ajaxRequest = new XMLHttpRequest();
            }catch (e){ 
            try{
            ajaxRequest = new ActiveXObject('Msxml2.XMLHTTP');
            }catch (e) {
            try{
            ajaxRequest = new ActiveXObject('Microsoft.XMLHTTP');
            }catch (e){ 
             alert('Your browser broke!');
             return false;
            }
            }
            }  
          ajaxRequest.onreadystatechange = function(){
          if(ajaxRequest.readyState == 4){ 
            document.getElementById('listsignupbtn').innerHTML = ajaxRequest.responseText;      
           }
        }   
        ajaxRequest.open('GET', '/members/getsignups', true);
        ajaxRequest.send(null);
        }     
</script>";
?>