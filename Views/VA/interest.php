 <?php
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
    <link rel='shortcut icon' href='/members/Static/VA/images/joker.jpg'>
    <title>".$name." online</title>
    <!--Core CSS -->
    <link href='/members/Static/VA/bs3/css/bootstrap.min.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/bootstrap-reset.css' rel='stylesheet'> 
    <link href='/members/Static/VA/assets/font-awesome/css/font-awesome.css' rel='stylesheet'> 
    <link href='/members/Static/VA/css/style.css' rel='stylesheet'>
    <link href='/members/Static/VA/css/style-responsive.css' rel='stylesheet'/>   
    <script src='/members/Static/VA/js/ajax.jquery.min.js'></script>
    <![endif]--> 
<script  type='text/javascript' src='/members/Static/VA/js/typeahead.min.js'></script>
<script type='text/javascript'>
$(document).ready(function(){ 
  $('input.typeahead').typeahead({
    name: 'accounts', local: ["; 
    $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargons_db") or die("Unable to connect to the database !!");   
        $sql="SELECT interest from interest order by interest LIMIT 20000";
        $result = mysqli_query($conn,$sql); 
        while($row=mysqli_fetch_assoc($result))
        {
          //echo $row['value'];
          echo "'".$row['interest']."',";
        }     
        echo "'Test']";     
echo "}); 
});  
var interests='';

function setVal()
{  
  if(interests=='')
   interests = document.getElementById('interest').value;  
  else if(interests.includes(document.getElementById('interest').value))
  {
    alert('This interest has already been added.Please try something else.');
  }
  else
  interests  = interests + ',' + document.getElementById('interest').value; 
  document.getElementById('interest_list').innerHTML=interests;
  document.getElementById('interest').value='';
}
function finalizeVal()
{
  document.getElementById('real_int').value = interests;  
}
</script>
<style type='text/css'>
.bs-example{
  font-family: sans-serif;
  position: relative;
  margin: 100px;
}
.typeahead, .tt-query, .tt-hint {
  border: 2px solid #ccc;
  border-radius: 5px;
  font-size: 24px;
  height: 30px;
  line-height: 30px;
  outline: medium none;
  padding: 20px 12px;
  width: 100%;
}
.typeahead {
  background-color: #FFFFFF;
}
.typeahead:focus {
  border: 2px solid #0097CF;
}
.tt-query {
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;  
}
.tt-hint {
  color: #999999;
}
.tt-dropdown-menu {
  background-color: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); 
  padding: 8px 0;
  width: 100%;
}

.tt-suggestion {
  font-size: 24px;
  line-height: 24px;
  padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
  background-color: #0097CF;
  color: #FFFFFF;
}
.tt-suggestion p {
  margin: 0;
}
</style>
</head>
<body>  
<section id='main-content'>
        <section class='wrapper'> 
        <div class='row'>
            <div class='col-sm-10'>
                <section class='panel'>
                    <header class='panel-heading'> 
                       Add your interests here
                    </header>
                    <div class='panel-body'> 
                    <div style='text-align: center;'>   
                    <h5>Before we start suggesting things for you, do suggest us about what you actually are interested in. <br></h5>
                    <input class='form-control typeahead tt-query m-bot15' id='interest' type='text' style='color:#222;' autofocus required>    
                    <button type='submit' class='btn btn-info' onclick='setVal()' style='height:44px;margin-top:-12px;margin-left:-3px;'>Add this</button>
                    </div> 
                    <form class='form-horizontal bucket-form' method='post' action='/members/addinterest' style='text-align: center;'>   
                    <input type='hidden' name='interest' id='real_int'>
                    <center>
                     <h5><b><u>Interests</u></b><b>:</b> <div id='interest_list' style='margin-top:8px;font-size:16px;'><i>Enter something in above text box for hint...</i></div></h5>
                    </center><br>
                    <button type='submit' class='btn btn-success' onclick='finalizeVal()'  style='height:40px;margin-top:-12px;margin-left:-3px;'>Done, Let's go</button>
                    </form> 
                    </div>
                </section>
            </div>
        </div> 
        </section>
    </section>
</body> 
</html>";