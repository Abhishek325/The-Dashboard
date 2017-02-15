 <?php
include($Service->Config()->get_basepath().'/Views/VA/header.php'); 
$id=$Service->Prote()->DBI()->Func()->users()->mapUserId($_SESSION['email']);  
 echo "<section id='main-content' class=''>
        <section class='wrapper'>  
        <div class='row'>  
            <div class='col-lg-12'>
             <section class='panel'>
                <header class='panel-heading tab-bg-dark-navy-blue '>
                    <ul class='nav nav-tabs'>
                        <li class='active'>
                            <a data-toggle='tab' href='#event'>Add an event</a>
                        </li>
                        <li class=''>
                            <a data-toggle='tab' href='#list'>List events</a>
                        </li> 
                    </ul>
                </header>
                <div class='panel-body'>
                    <div class='tab-content'> 
                        <div id='event' class='tab-pane active '> 	
						<form class='form-horizontal bucket-form' method='post' action='/members/addevent' name='myform'> 
						 <div class='form-group'> 
						 <label class='col-sm-3 control-label'></label> 
						 <div class='col-sm-5'>  
						 <center style='font-size:50px;text-shadow:2px 3px 2px #ccc;'>Event Handler</center> 
						 In order to add multiple event for same day, separate each event with a comma (,) while writing in event name field.
						 <input type='text'class='form-control' autocomplete='off' required name='etext' style='color:#888;' maxlength='25' placeholder='Event text/name'> 
						 <p style='margin-top:1rem;margin-bottom:-2px;color:#999;margin-left:0.2rem;'>Select the date of the event.</p>
						 <select class='form-control m-bot15' onchange='setdays()' name='emonth' id='emonth' style='width:160px;margin-top:0.5rem;color:#888;display:inline;'> 
						  <option value='0'>Select month..</option>
						  <option value='1'>January</option>
						  <option value='2'>February</option>
						  <option value='3'>March</option>
						  <option value='4'>April</option>
						  <option value='5'>May</option>
						  <option value='6'>June</option>
						  <option value='7'>July</option>
						  <option value='8'>August</option>
						  <option value='9'>September</option>
						  <option value='10'>October</option>
						  <option value='11'>November</option>
						  <option value='12'>December</option> 
						 </select>
						<select class='form-control' name='eday' id='mys' style='width:100px;margin-top:-1rem;color:#888;display:inline;' required></select>
						<select class='form-control' name='etype' style='width:158px;margin-top:-1rem;color:#888;display:inline;' required>
						 <option value='one_time'>One time event</option>
						 <option value='all_time'>All time event</option>
						</select> 
						<center>  
						<p style='color:#e00;'>";
						if(isset($event_success))
							echo $event_success;
						echo "</p></center> 
						<div class='col-md-12'> 
						<section class='panel' >
						<div class='panel-body btn-gap'>
						<center>
						 <a href='#' class='btn btn-info' onclick='settoday()'>Tomorrow</a>
						 <button type='submit' class='btn btn-success' style='margin-right:-0.05rem;'>Submit</button> 
						 <br>
						</center>
						</div>
						</section>
						</div>
						</div>
						</div>
						</form>  
                        </div>
                        <div id='list' class='tab-pane '>
			          <div class='row'>
			          <div class='col-sm-12'>
			          <section class='panel'>
                    <header class='panel-heading'>  
                    Events added to the system 
                    </header>
                    <div class='panel-body'>
                        <section id='unseen'>
                            <table class='table table-bordered table-striped table-condensed'>
                                <thead>
                                <tr> 
                                    <th>Event</th>
                                    <th class='numeric'>Date</th>
                                    <th class='numeric'>Type</th> 
                                </tr>
                                </thead>
                                <tbody>";
                                if($Service->Prote()->DBI()->Func()->event()->countEvents($id)==0)
                                {
                                    echo "<tr>
                                          <td>No events yet</td>
                                          <td>-</td>
                                          <td>-</td>
                                          </tr>";
                                }
                                else
                                { 
                                $c=$Service->Prote()->DBI()->Func()->event()->getAllEvents($id);
                                foreach ($c as $data) { 
                                echo "<tr id='".$data->eid."'> 
                                    <td>".$data->ename."</td>
                                    <td class='numeric'>".$data->day." ".$Service->Prote()->DBI()->Func()->event()->getEventMonth($data->month,$id)."</td>";
                                    if($data->type=="all_time")
                                    	$etype="All time";
                                    else
                                    	$etype="One time";
                                    echo "<td class='numeric'>".$etype;      
                                    if($data->type=="one_time") 
                                    	echo "<form style='display:inline;'><input type='hidden' value='".$data->eid."' name='id'><button type='submit' id='eve".$data->eid."' class='myevent'  style='background:none;color:222;border:0;margin-top:-2rem;margin-left:1rem;'>x</button></form>";
                                echo "</tr>"; 
                            	}
                            }
                                echo "</tbody>
                            </table>
                        </section>
                    </div>
                </section> 
            </div>
        </div>	
                        </div> 
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
          </div>
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
/*var dormantCount=".$Service->Prote()->DBI()->Func()->users()->getautologouttime($id)."; 
 function resetDormancy()
  { 
    if(dormantCount<10) 
     //Materialize.toast('Woaah..that was really close. <img src=\"/members/Static/VA/images/smileys/wink.png\"><img src=\"/members/Static/VA/images/smileys/cool.png\">',5000);
    dormantCount=". $Service->Prote()->DBI()->Func()->users()->getautologouttime($id)."; 
  }*/ 

$('.myevent').click(function(e){   
    var x = this.id;
    var eveid = x.substring(3,x.length); 
    $.ajax({
    type: 'POST',
    url: '/members/delevent',
    data: 'id='+eveid,
    cache: false,
    success: function(result){      
    document.getElementById(eveid).style.display='none';     
    }
   });
   return false; 
});    
</script>
</body>
</div>
</html>";