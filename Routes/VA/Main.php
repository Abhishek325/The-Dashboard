 <?php  
 session_start();
date_default_timezone_set('Asia/Kolkata');
/**
 * @package Routes
 * @Caution Heavy use of closures Ahead
 **/  
$Router->get('/members/',function() use ($Service) {
	include('Views/VA/index.html');
}); 

$Router->get('/members/login',function() use ($Service) { 
	if($Service->Auth()->logged_in()){   
	 include('Views/VA/dash.php');
	}
	else{
		include($Service->Config()->get_basepath().'/Views/VA/login.html');
	}
});

$Router->get('/members/signup',function() use ($Service) {  
	 include('Views/VA/signup.html');  
});

$Router->get('/members/dashboard',function() use ($Service) { 
	 if($Service->Auth()->logged_in())  
	  include('Views/VA/dash.php'); 
	 else
	 header("location:/members/login") ; 
}); 

$Router->post('/members/signup',function() use ($Service) {   
	    $Service->Prote()->DBI()->Func()->users()->make_salt($_POST['email'],$_POST['pwd']);
		$pwd=$Service->Prote()->DBI()->Func()->users()->generate_hash($_POST['pwd']);   
	if($Service->Prote()->DBI()->Func()->users()->addUser($_POST['name'],$_POST['email'],$pwd))
	{
		$Service->Prote()->DBI()->Func()->thought()->add("Always be yourself, express yourself, have faith in yourself, do not go out and look for a successful personality and duplicate it.","Bruce Lee",
	    	$Service->Prote()->DBI()->Func()->users()->mapUserId($_POST['email']));
	    $Service->Prote()->DBI()->Func()->thought()->add("Difficulties in your life do not come to destroy you, but to help you realize your hidden potential and power.Let difficulties know that you too are difficult.","Abdul Kalam",
	    	$Service->Prote()->DBI()->Func()->users()->mapUserId($_POST['email']));
		$success="<p style='color:rgba(18, 60, 13, 0.62);'><b>Your details are saved successfully.</b></p>";
	     include('Views/VA/signup.html'); 
	}
	else
	{}
});

$Router->get('/members/validateName',function() use ($Service) {  
	$name=$_GET['name'];
	if($Service->Prote()->DBI()->Func()->users()->checkUserName($name)==true)
	 echo "<div style='color:rgb(255,0,9);font-size:15px;'>Username <em><u>".$name."</u></em> is already taken!!!</div>"; 
}); 

$Router->get('/members/validateEmail',function() use ($Service) {  
	$email=$_GET['email'];
	if($Service->Prote()->DBI()->Func()->users()->checkUserEmail($email)==true)
	 echo "<div style='color:rgb(255,0,9);font-size:15px;'>The Email-Id <em><u>".$email."</u></em> already exists!!!</div>"; 	
}); 

$Router->get('/members/getsignups',function() use ($Service) {  
   if($Service->Auth()->logged_in()){ 
   	$c=$Service->Database()->find_many("SELECT name,Email from users where name not in ('Abhishek','Swastik') order by Id;");
   	$res="";
   	foreach ($c as $data) { 
   	      $res  = $res. "<tr>
		   	  	    	<td class='numeric'>".$data->name."</td>
		   	  	    	<td class='numeric'>".$data->Email."</td>
		   	  	 	</tr>";
   	 }
   	 echo $res;
	}	
	else{
		header("location:/members/login");
	}  
}); 

$Router->get('members/interest',function() use ($Service) {
	if($Service->Auth()->logged_in())
	 include('Views/VA/interest.php');  
	else
	 header("location:/members/login");
});
$Router->post('/members/login',function() use ($Service) {    
	if($Service->Auth()->login($_POST['email'],$_POST['pwd'],$Service->Html()->auth_token))
	{    
		$_SESSION['email']=$_POST['email'];
		$_SESSION['userName']=$Service->Prote()->DBI()->Func()->users()->mapUser($_SESSION['email']);
		$_SESSION['userId']=$Service->Prote()->DBI()->Func()->users()->mapUserId($_SESSION['email']);
		$userInterestCount = $Service->Prote()->DBI()->Func()->users()->interestInit($_SESSION['userId']);
		if($userInterestCount) 
		  include('Views/VA/dash.php'); 
		else
		  header("location:/members/interest");  
	}
		else{   
				$act="Login attempt @".date('H').":".date('i');
  			 	$Service->Prote()->DBI()->Func()->notification()->add($Service->Prote()->DBI()->Func()->users()->mapUserId($_POST['email']),$act);  
  			 	$Service->Prote()->DBI()->Func()->activity()->add($Service->Prote()->DBI()->Func()->users()->mapUserId($_POST['email']),$act,"danger"); 	 
  			 	header("location:/members/login");    
		    }
});
 
$Router->post('/members/logout',function() use ($Service) {
	if($Service->Auth()->logout($_POST['auth_token'])){
		    header("location:/members/login");
		}
		else{
			echo "Could not log out.";
		}
});
//automated-session-logout
$Router->get('/members/automated-session-logout',function() use ($Service) {
	//This is a bit insecure.So, either eliminate or MODIFY.
	if($Service->Prote()->DBI()->Func()->users()->exitSessions())
	{ 
		$act="System on automated logout due to inactivity.";
	    $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"info"); 	 
		header("location:/members/login");
	}
	else
	{
	  $act="An automatic session logout failed. Please logout and login to fix.";
	  $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"info"); 	
	  header("location:/members/");
	}

});

$Router->get('/members/settings',function() use ($Service) {
	if($Service->Auth()->logged_in()){
		include('Views/VA/settings.html');
	}
	else{
		header("location:/members/dashboard");
	}
}); 

$Router->get('/members/write-post',function() use ($Service) {
	if($Service->Auth()->logged_in()){
		if($data=$Service->Prote()->DBI()->Func()->comment()->userSavedData($_SESSION['userName']))
		{
			$about=$Service->Prote()->DBI()->Func()->comment()->getSavedData($_SESSION['userName'],'postAbout');
			$title=$Service->Prote()->DBI()->Func()->comment()->getSavedData($_SESSION['userName'],'postTitle');
			$content=$Service->Prote()->DBI()->Func()->comment()->getSavedData($_SESSION['userName'],'postContent');
			$tags=$Service->Prote()->DBI()->Func()->comment()->getSavedData($_SESSION['userName'],'tags'); 
		} 
		else
		{
			$about="";
			$title="";
			$content="";
			$tags=""; 
		}
		 include('Views/VA/newpost.php'); 
	}
	else{
		header("location:/members/dashboard");
	}
}); 

$Router->get('/members/comment',function() use ($Service) {
	if($Service->Auth()->logged_in()){
		include('Views/VA/comment.php');
	}
	else{
		header("location:/members/dashboard");
	}
}); 

$Router->get('/members/projects',function() use ($Service) {
	if($Service->Auth()->logged_in()){
		include('Views/VA/project.php');
	}
	else{
		header("location:/members/dashboard");
	}
}); 
 

$Router->post('/members/getpostdet',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		$post = "<h3>".$Service->Prote()->DBI()->Func()->comment()->getPostTitle($_POST['post'])."</h3> <br> <p style='max-height: 15rem;overflow-y: scroll;padding: 4px;margin-top: -2rem;'>".
		$Service->Prote()->DBI()->Func()->comment()->getPostContent($_POST['post'])."</p>";
		$pid=$_POST['post'];
		include('Views/VA/comment.php');
	}
	else{
		header("location:/members/dashboard");
	}
}); 

$Router->post('/members/makecomment',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if($Service->Prote()->DBI()->Func()->comment()->makeComment($_POST['postid'],$_POST['userComment'],$_SESSION['userName']))
		{ 
		  $success="<p style='color:rgba(18, 60, 13, 0.62);'><b>Your comment has been made successfully.</b></p>"; 
		  $pid =base64_encode(base64_encode(openssl_encrypt($_POST['postid'],"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode("")), 0,16))));
		  header("location:/blogs/post/".$pid); 		
		}
		else
		{
			echo "Oops...something went wrong<br>Please wait";
			header("refresh:2;url=/members/dashboard"); 
		}
	}
	else{
		header("location:/members/dashboard");
	}
}); 

$Router->post('/members/changepin',function() use ($Service) { 
	if($Service->Prote()->DBI()->Func()->users()->getpin($_SESSION['userId'])==$_POST['opin'])
	{
		if($_POST['npin1']==$_POST['npin2'])
			if($Service->Prote()->DBI()->Func()->users()->change_pin($_POST['npin1'],$_SESSION['userId']))
			{
				 $pin_changed="<p style='color:#f00;margin-top:-1rem;'><b>Pin has been changed succesfully.</b></p>";
				 $act="Pin changed.<br>@".date('H').":".date('i');
				 $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$act);
				 $act="User pin changed ";
         		 $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"danger"); 
	   			 include('Views/VA/settings.html');    
			}
		else
		{ 
		 echo "<b>Pins don't match.Try again !!!</b><br>Please  wait...";
		 header("refresh:1;url=/members/settings");		
		}
	}
	else
	{
		echo "<b>Wrong pin...</b><br>Please  wait...";
		header("refresh:1;url=/members/settings");
	}

}); 

$Router->post('/members/changepassword',function() use ($Service) { 
		$Service->Prote()->DBI()->Func()->users()->make_salt($_SESSION['email'],$_POST['opwd']);
		$pwd=$Service->Prote()->DBI()->Func()->users()->generate_hash($_POST['opwd']);   
	if($Service->Prote()->DBI()->Func()->users()->getpwd($_SESSION['userId'])==$pwd)
	{  
			if($Service->Prote()->DBI()->Func()->users()->change_pwd($_POST['npwd'],$_SESSION['userId']))
			{
				 $pwd_changed="<p style='color:#f00;margin-top:-1rem;'><b>Password has been changed succesfully.</b></p>";
				 $act="Password changed.<br>@".date('H').":".date('i');
				 $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$act);
				 $act="User password changed ";
         		 $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"danger"); 
	   			 include('Views/VA/settings.html');    
			}
		else
		{ 
		 echo "<b>Passwords don't match.Try again !!!</b><br>Please  wait...";
		 header("refresh:1;url=/members/settings");		
		}
	}
	else
	{
		echo "<b>Wrong password...</b><br>Please  wait...";
		header("refresh:1;url=/members/settings");
	}

}); 
$Router->get('/members/changepwd',function() use ($Service) {
		$email=$Service->Prote()->DBI()->Func()->data()->getEmail($_SESSION['userId']);
		$pwd="Abhishek123";
		crypt($pwd, $email.'5UCK5'.$pwd); 
		if($Id=$this->$Service->Prote()->DBI()->Func()->data()->verify($email,$pwd))
		 echo "Correct";
		exit();
	echo $Service->Prote()->DBI()->Func()->data()->getpwd();
});
 
$Router->post('/members/addnote',function() use ($Service) {
	if($Service->Auth()->logged_in()&&$_POST['todo']){
		if($Service->Prote()->DBI()->Func()->notes()->add($_POST['todo'],$_SESSION['userId'])) 
			echo "
				<script type='text/javascript'>
                  return;
                </script>";
		else
			echo "Sorry..Something went wrong.!!";
	}
	      header("location:/members/dashboard") ;
	
});

$Router->post('/members/addcom',function() use ($Service) {
	$desc='Comment';
	if($Service->Auth()->logged_in()&&$_POST['comment']){
		if($Service->Prote()->DBI()->Func()->data()->add($desc,$_POST['comment'],$_SESSION['userId']))
		  header("location:/members/dashboard") ;
		else
			echo "Sorry..Something went wrong.!!";
	}
	      header("location:/members/dashboard") ;
	
});  

$Router->post('/members/post/photos',function() use ($Service) { 
	header('Content-Type: application/json');
        $json = array();
   $count=$_POST['fileCount'];   
   $pid=openssl_decrypt(base64_decode(base64_decode($_POST['postid'])),"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16));  
   if(!$count||!$pid)
   {
   	//header("location:/members/dashboard");
   	json_decode("Empty input of non file data");
   	exit();
   }
  for($i=1;$i<=$count;$i++)
  { 
  	if(isset($_FILES['val'.$i])) 
  	{
  		    $target_dir = '../blogs/Static/VA/uploads/posts/';
			$new_filename = 'newpic'.uniqid();
			$file_img_name = $new_filename.basename($_FILES['val'.$i]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES['val'.$i]["tmp_name"]);
			    if($check !== false) {
			        //echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        //echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			else
			{
			 echo "Seems like an error..";  
			 echo "Click <a href='/members/write-post'>here</a> to go back";
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size
			if ($_FILES['val'.$i]["size"] > 1000000) {
			    //echo "Sorry, your file is too large."; 
			    echo "File size too large (Upload file less than 10MB).";
			    exit();
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType);
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			    exit();
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES['val'.$i]["tmp_name"], $target_file)) { 
				 $Service->Prote()->DBI()->Func()->comment()->addPostSecondaryImagesMap($pid,$file_img_name); 
				 echo json_decode($json);
			    }
			    else
			    	echo "Error in uploading file ";
  	}
  }
  else
  	echo "Empty";
}
	echo "<h3>All images successfully uploaded</h3>Redirecting..."; 
	  header("refresh:2;url=/members/dashboard"); 
});

$Router->post('/members/userinit',function() use ($Service) {
	if($Service->Auth()->logged_in())
	{ 
	 if($_POST['status']&&$_POST['title'])
	 {
	    if($Service->Prote()->DBI()->Func()->comment()->addUserValues($_POST['status'],$_POST['title'],$_SESSION['userName']))
	    {   	
	     $success="<p style='color:rgba(18, 60, 13, 0.62);'><b>Your details are saved successfully.</b></p>";
	     include('Views/VA/newpost.php');	
	    }
	    else
	    {
	    	echo "Something went wrong<br><b>Redirecting...</b>";
	    	header("refresh:2;url=/members/write-post"); 
	    }
	 }
	 else
		 header("location:/members/write-post");
	}
	else
	 	 header("location:/members/login");
});

$Router->post('/members/updatePic',function() use ($Service) { 
	$target_dir = '../blogs/Static/VA/uploads/users/';
			$new_filename = 'user'.uniqid();
			$file_img_name = $new_filename.basename($_FILES['userPic']["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES['userPic']["tmp_name"]);
			    if($check !== false) {
			        //echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        //echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			else
			{
			 echo "Seems like an error..";  
			 echo "Click <a href='/members/write-post'>here</a> to go back";
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size
			if ($_FILES['userPic']["size"] > 1000000) {
			    //echo "Sorry, your file is too large."; 
			    echo "File size too large (Upload file less than 10MB).";
			    exit();
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType);
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			    exit();
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES['userPic']["tmp_name"], $target_file)) { 
			    	//delete the previous picture. Save the planet.
			    	$OldPic=$Service->Prote()->DBI()->Func()->comment()->getImageName($_SESSION['userName']); 
				   if($Service->Prote()->DBI()->Func()->comment()->updateUserPic($_SESSION['userName'],$file_img_name))
				 {
				 	if($OldPic!="default.jpg")
				 	 unlink("../blogs/Static/VA/uploads/users/".$OldPic);
				 	$success="<p style='color:rgba(18, 60, 13, 0.62);'><b>Your picture has been changed successfully.</b></p>";
	     		    include('Views/VA/newpost.php');
				 } 
			    }
			    else
			    	echo "Error in uploading file ";
    }

});

$Router->post('/members/updateuserinit',function() use ($Service) {
	if($Service->Auth()->logged_in())
	{ 
	 if($_POST['updstatus']&&$_POST['updtitle'])
	 {
	    if($Service->Prote()->DBI()->Func()->comment()->updateUserValues($_POST['updstatus'],$_POST['updtitle'],$_SESSION['userName']))
	    {   	
	     $success="<p style='color:rgba(18, 60, 13, 0.62);'><b>Your details are updated successfully.</b></p>";
	     include('Views/VA/newpost.php');	
	    }
	    else
	    {
	    	echo "Something went wrong<br><b>Redirecting...</b>";
	    	header("refresh:2;url=/members/write-post"); 
	    }
	 }
	 else
		 header("location:/members/write-post");
	}
	else
	 	 header("location:/members/login");
});

$Router->get('/members/ftesft',function() use ($Service){
echo "<html>  
		    			<title>Posted to Jargonsmaze Blogs</title>
		    			<link rel='stylesheet' href='Static/VA/css/foundation.css' /> 
		    			<br> 
		           	    <div class='row'>
		                <div class='large-12 columns'>
		            	<div class='callout panel' style='box-shadow:2px 4px 3px #eee;'>
		            	<h2><b>Post successfull!</b></h2> <br>
		                <p><strong>What do you want do now ?</strong>
		                <ul>
		                <li><a href='/blogs' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>View all posts</a></li>
		                <li>Add more images to the post here.<br>
		                  <button onClick='nameFunction()' class='small btn' style='padding:7px;'>Click here</button> to add more images.<br/>
							<form method='post' action='/members/post/photos' id='imageuploadform' enctype='multipart/form-data'>
							<input type='hidden' id='fileCount' name='fileCount'>
							<input type='hidden' name='postid' valu='".base64_encode(base64_encode(openssl_encrypt(2,"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16))))."'>
							<span id='myForm'>
							</span>
							<button type='submit' name='submit' class='small success btn' onClick='setFileCount()' id='btnupload' style='padding:7px;'>Submit</button>
							<button type='reset' class='small alert btn' style='padding:7px;'>Reset</button>
							<div id='progress'></div>
							</form>
							<script src='/members/Static/VA/js/ajax.jquery.min.js'></script>
							<script type='text/javascript'>
							/* set global variable i */ 
							var i=0;  
							function increment(){
							i +=1;                        
							} 
							function setFileCount()
							{ 
								document.getElementById('fileCount').value=i; 

							}
							function removeElement(parentDiv, childDiv){ 
							     if (childDiv == parentDiv) {
							          alert('The parent div cannot be removed.');
							     }
							     else if (document.getElementById(childDiv)) {     
							          var child = document.getElementById(childDiv);
							          var parent = document.getElementById(parentDiv);
							          parent.removeChild(child); 
							     }
							     else {
							          alert('Child div has already been removed or does not exist.');
							          return false;
							     }
							}  

							function nameFunction()
							{
							var r=document.createElement('span');
							r.setAttribute('style', 'display:block;margin-bottom:-0.8rem;'); 
							var y = document.createElement('INPUT');
							y.setAttribute('type', 'file');
							y.setAttribute('required', 'true');
							y.setAttribute('style', 'width:20rem;background:#fff;'); 
							var g = document.createElement('IMG');
							g.setAttribute('src', '/members/Static/VA/images/delete.png'); 
							g.setAttribute('style', 'margin-left:-1.5rem;'); 
							increment(); 
							y.setAttribute('Name','val'+i);
							r.appendChild(y);
							g.setAttribute('onclick', 'removeElement(\"myForm\",\"id_'+ i +'\")');
							r.appendChild(g);
							r.setAttribute('id', 'id_'+i);
							document.getElementById('myForm').appendChild(r);
							}  

							$('#btnupload').click(function(e) { 
						    $('#imageuploadform').submit();
						    e.preventDefault();
							}); 
							$('#imageuploadform').submit(function(e) { 
							 var formData = new FormData(this); 
							 formData.append(fileCount,2);
						    $.ajax({
						        type:'POST',
						        url: '/members/post/photos',
						        data:formData, 
						        cache:false,
						        contentType: false,
						        processData: false, 
						        success:function(data){
						            console.log(data); 
						          alert('data returned successfully'); 
						        }, 
						        error: function(data){
						            console.log(data); 
						        }
						    }); 
						    e.preventDefault(); 
						});
						function progress(e){ 
						    if(e.lengthComputable){
						        var max = e.total;
						        var current = e.loaded; 
						        var Percentage = (current * 100)/max; 
								document.getElementById('progress').innerHTML=Percentage;
						        if(Percentage >= 100)
						        {
						           // process completed  
						        }
						    }  
						 }
						</script>		
		                </li>
						<li><b>Other links:</b><br>
						<ul>
						 <li><a href='/members/dashboard' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>Dashboard</a></li>
						 <li><a href='/members/write-post' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>Make another post</a></li>
						</ul>
						</li>
		                </ul>
		                </p>
		            	</div>
		          		</div>
		        		</div> ";
});

$Router->post('/members/savePost',function() use ($Service) {  
	if($Service->Prote()->DBI()->Func()->comment()->save($_POST['about'],$_POST['title'],$_POST['editor1'],$_POST['tags'],$_SESSION['userName']))
	{ 
	  return "Success";
	}
});

$Router->post('/members/addcomment',function() use ($Service) {  
	if($Service->Auth()->logged_in()&&$_POST['editor1']){ 
		if($Service->Prote()->DBI()->Func()->comment()->add($_POST['about'],$_POST['title'],$_POST['editor1'],$_POST['tags'],$_SESSION['userName']))
		  	{ 
			$target_dir = '../blogs/Static/VA/uploads/';
			$new_filename = 'newpic'.uniqid();
			$file_img_name = $new_filename.basename($_FILES["image"]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image"]["tmp_name"]);
			    if($check !== false) {
			        //echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        //echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			else
			{
			 echo "Seems like an error..";  
			 echo "Click <a href='/members/write-post'>here</a> to go back";
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size
			if ($_FILES["image"]["size"] > 1000000) {
			    //echo "Sorry, your file is too large."; 
			    echo "File size too large (Upload file less than 10MB).";
			    exit();
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType);
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			    exit();
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {    
			      //echo "<br>The file ". basename( $_FILES["image"]["name"]). " has been uploaded successfully.<br><img src='images/".$file_img_name."' height='75px' width='150px'>"; 

			     $Service->Prote()->DBI()->Func()->comment()->addImageMap($Service->Prote()->DBI()->Func()->comment()->getCurPostId($_SESSION['userName']),$file_img_name);
			    	$postId = $Service->Prote()->DBI()->Func()->comment()->getCurPostId($_SESSION['userName']);
					echo "<html>  
		    			<title>Posted to Jargonsmaze Blogs</title>
		    			<link rel='stylesheet' href='Static/VA/css/foundation.css' /> 
		    			<br> 
		           	    <div class='row'>
		                <div class='large-12 columns'>
		            	<div class='callout panel' style='box-shadow:2px 4px 3px #eee;'>
		            	<h2><b>Post successfull!</b></h2> <br>
		                <p><strong>What do you want do now ?</strong>
		                <ul>
		                <li><a href='/blogs' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>View all posts</a></li>
		                <li>Add more images to the post here.<br>
		                  <button onClick='nameFunction()' class='small btn' style='padding:7px;'>Click here</button> to add more images.<br/>
							<form method='post' action='/members/post/photos'  enctype='multipart/form-data'>
							<input type='hidden' id='fileCount' name='fileCount'>
							<input type='hidden' name='postid' value='".base64_encode(base64_encode(openssl_encrypt($postId,"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16))))."'>
							<span id='myForm'>
							</span>
							<button type='submit' name='submit' class='small success btn' onClick='setFileCount()' id='btnupload' style='padding:7px;'>Submit</button>
							<button type='reset' class='small alert btn' style='padding:7px;'>Reset</button>
							<div id='progress'></div>
							</form>
							<script type='text/javascript'>
							/* set global variable i */ 
							var i=0;  
							function increment(){
							i +=1;                        
							} 
							function setFileCount()
							{ 
								document.getElementById('fileCount').value=i; 

							}
							function removeElement(parentDiv, childDiv){ 
							     if (childDiv == parentDiv) {
							          alert('The parent div cannot be removed.');
							     }
							     else if (document.getElementById(childDiv)) {     
							          var child = document.getElementById(childDiv);
							          var parent = document.getElementById(parentDiv);
							          parent.removeChild(child); 
							     }
							     else {
							          alert('Child div has already been removed or does not exist.');
							          return false;
							     }
							}  

							function nameFunction()
							{
							var r=document.createElement('span');
							r.setAttribute('style', 'display:block;margin-bottom:-0.8rem;'); 
							var y = document.createElement('INPUT');
							y.setAttribute('type', 'file');
							y.setAttribute('required', 'true');
							y.setAttribute('style', 'width:20rem;background:#fff;'); 
							var g = document.createElement('IMG');
							g.setAttribute('src', '/members/Static/VA/images/delete.png'); 
							g.setAttribute('style', 'margin-left:-1.5rem;'); 
							increment(); 
							y.setAttribute('Name','val'+i);
							r.appendChild(y);
							g.setAttribute('onclick', 'removeElement(\"myForm\",\"id_'+ i +'\")');
							r.appendChild(g);
							r.setAttribute('id', 'id_'+i);
							document.getElementById('myForm').appendChild(r);
							}   
						</script>		
		                </li>
						<li><b>Other links:</b><br>
						<ul>
						 <li><a href='/members/dashboard' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>Dashboard</a></li>
						 <li><a href='/members/write-post' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>Make another post</a></li>
						</ul>
						</li>
		                </ul>
		                </p>
		            	</div>
		          		</div>
		        		</div>  ";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			        exit();
			    }
			}  
  			 $act="New post(".$_POST['title'].")<br>@".date('H').":".date('i');
  			 $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$act);  
	}
	else
	{ 
	  echo "<h3>Something went wrong....Please wait</b>"; 
	  header("refresh:2;url=/members/write-post"); 
	}
}
else
  {
  	echo "Cant take a post without its content";
	  header("refresh:2;url=/members/write-post"); 
  }
});
$Router->post('/members/del',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
	 if($Service->Prote()->DBI()->Func()->notes()->remove($_POST['id'],$_SESSION['userId'])) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
}); 
$Router->post('/members/delrem',function() use ($Service) {
	if($Service->Auth()->logged_in()){
	  if($Service->Prote()->DBI()->Func()->reminder()->delete($_POST['reminderid'],$_SESSION['userId'])) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
});
$Router->post('/members/delalarm',function() use ($Service) {
	if($Service->Auth()->logged_in()){
	  if($Service->Prote()->DBI()->Func()->alarm()->removeAllAlarms($_SESSION['userId'])) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
});
$Router->post('/members/delnoti',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
	  if($Service->Prote()->DBI()->Func()->notification()->remove($_POST['notid'],$_SESSION['userId'])) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
}); 
$Router->post('/members/delAllnoti',function() use ($Service) {
	if($Service->Auth()->logged_in()){
	  if($Service->Prote()->DBI()->Func()->notification()->removeAll($_SESSION['userId'])) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
});
$Router->post('/members/delfile',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
		if(file_exists($_POST['path'].$_POST['name']))
		{ 
			//Create a temp
			if(!is_dir("Views/VA/temp"))
			{
              if(mkdir("Views/VA/temp"))
              {
                $file=fopen($_POST['path'].$_POST['name'], "r") or die("Unable to locate the file."); 
                fclose($file);
                $data=file_get_contents($_POST['path'].$_POST['name']); 
                $temp=fopen("Views/VA/temp/temp".date("d").date('s'), "w") or die("Unable to locate the file.");  
                fwrite($temp,"/*Data saved from the file".$_POST['name']."\nParent file: ".$_POST['name']."\nDeleted on : ".date('D')."/".date('m')." ".date('H').":".date('i')."*/\n------------------------".$data);
                fclose($temp);
              }
              else
              { 
              	echo "Unable to create directory.";
              }
			}
			else
			{
				$file=fopen($_POST['path'].$_POST['name'], "r") or die("Unable to locate the file."); 
                fclose($file);
                $data=file_get_contents($_POST['path'].$_POST['name']);
                $temp=fopen("Views/VA/temp/temp".date("d").date('s'), "w") or die("Unable to locate the file.");
                fwrite($temp,"/*Data saved from the file".$_POST['name']."\nParent file: ".$_POST['name']."\nDeleted on : ".date('D')."/".date('m')." ".date('H').":".date('i')."*/\n------------------------".$data);
                fclose($temp);
			}  
			$file=$_POST['path'].$_POST['name'];
			unlink($file); 
			$file=$_POST['name'];//Only name..no path
			$act=$file." deleted.<br>@".date('H').":".date('i');
			$Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$act);
			echo "<html>  
    			<title>File exists</title>
    			<link rel='stylesheet' href='Static/VA/css/foundation.css' /> 
    			<br>
    			<div class='large-8 medium-8 columns'>
           	    <div class='row'>
                <div class='large-12 columns'>
            	<div class='callout panel' style='box-shadow:2px 4px 3px #eee;'>
            	<h2><b>File removed!!!</b></h2> <br>
                <p><strong>Notification of this deletion is added.</strong></p>
                <ul>
                <b><u>Details:</u></b>
                <li><b>Filename: ".$_POST['name']."</b></li>
                <li><b>Deletion time: ".date('H').":".date('i')."</b></li>
                </ul>
                <a href='/members/dashboard'><b>Dashboard</b></a>
            	</div>
          		</div>
        		</div> 
      			</div>	 
     			</html> 
			";
			header("refresh:30;url=/members/dashboard");
		}
		else
		{
			echo "<b>File (<i>".$_POST['name']."</i>) doesn't exist.</b><br><a href='/members/dashboard'>Dashboard</a>"; 
			header("refresh:30;url=/members/dashboard");
		}
	} 
		else
			echo "Error 404,file not found.";; 
});

$Router->post('/members/disdel',function() use ($Service) {
	if($Service->Auth()->logged_in()&&$_POST['val']==$Service->Prote()->DBI()->Func()->users()->getpin($_SESSION['userId'])){  
	   $superuser="defined";
	   include('Views/VA/project.php');     
	 }
	else
			{
				 $wrongpin="<p style='color:#f00;margin-top:-1rem;'><b>Invalid pin !!! Try again .</b></p>";
				 $act="Wrong pin.<br>@".date('H').":".date('i');
				 $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$act);
	   			 include('Views/VA/project.php');   
			} 
}); 

$Router->post('/members/addsite',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
		if($_POST['web']&&$_POST['weburl'])
        {
        	if($Service->Prote()->DBI()->Func()->web()->add($_POST['web'],$_POST['weburl']))
		  	 header("location:/members/dashboard") ; 
		}
		else
			echo "Sorry..Something went wrong.!!";
	}
});

$Router->post('/members/remind',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if(!is_numeric($_POST['hour'])||!is_numeric($_POST['min']))
		{
			echo "<h3>Invalid input obtained.</h3>Exiting...<br>
			<a href='/members/dashboard'>Dashboard.</a>";
			exit(); 
		}
		if($_POST['rtext']&&$_POST['hour']&&$_POST['min'])
        {
        	if(($_POST['hour']<0||$_POST['hour']>23)||($_POST['min']<0||$_POST['min']>59))
        	{
              echo "Invalid values";
              exit();
        	}  
        	else if($_POST['hour']==date('H')&&$_POST['min']<=date('i')) 
        	{ 	
           	 header("location:/members/dashboard") ; 
        	}
            else if($Service->Prote()->DBI()->Func()->reminder()->add($_POST['rtext'],$_POST['hour'],$_POST['min'],$_POST['linkname'],$_SESSION['userId']))
           	 header("location:/members/dashboard") ;     
		}
		else
			echo "Sorry..Something went wrong.!!";
	}
});
$Router->post('/members/addalarm',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if(!is_numeric($_POST['ah'])||!is_numeric($_POST['am']))
		{
			echo "<h3>Invalid input obtained.</h3>Exiting...<br>
			<a href='/members/dashboard'>Dashboard.</a>";
			exit();
		}
		if( $_POST['ah']&&$_POST['am'])
        {
        	if(($_POST['ah']<0||$_POST['ah']>23)||($_POST['am']<0||$_POST['am']>59))
        	{
              echo "<h3>Invalid values</h3>";
              exit();
        	}  
        	else if($_POST['ah']==date('H')&&$_POST['am']<=date('i')) 
        	{ 	
           	 header("location:/members/dashboard") ; 
        	}
            else if($Service->Prote()->DBI()->Func()->alarm()->add($_POST['ah'],$_POST['am'],$_SESSION['userId']))
		  	 header("location:/members/dashboard") ; 
		}
		else
			echo "Sorry..Something went wrong.!!";
	}
}); 
$Router->post('/members/alarm',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if(!is_numeric($_POST['offset']))
		{
			echo "<h3>Invalid input obtained.</h3>Exiting...<br>
			<a href='/members/dashboard'>Dashboard.</a>";
			exit();
		}
		if( $_POST['offset'])
        { 
        	if($_POST['drop']=='h')
        	{
        		if($_POST['offset']>0&&$_POST['offset']<23)
        		{
        		 $res=date('H')+$_POST['offset'];
        		 if($res>23)
        		 {
        		 	$res=$res-24;
        		 }
        		 if($Service->Prote()->DBI()->Func()->alarm()->add($res,date('i'),$_SESSION['userId']))
        		 	 header("location:/members/dashboard") ;
        		}
        		else
        		{
        			echo "Invalid data values....<br>Please wait..";
        			header("refresh:3;url=/members/dashboard");
        		}
        	}
        	else if($_POST['drop']=='m')
        	{
        		if($_POST['offset']>0)
        		{
        		 $minutes=date('i')+$_POST['offset']; 
        		 if($minutes==60)
        		 { 
        		 	$hours=date("H");
        		 	$minutes=0;
        		 }
        		 else if($minutes>60)
        		 { 
        		 	$temp=$minutes;
        		 	$minutes=($minutes%60);//e.g 121 minutes will be made as (121%60)=1
        		 	$hours=date("H")+($temp/60);
        		 } 	
        		 else 
        		   $hours=date('H'); 
        		 if($Service->Prote()->DBI()->Func()->alarm()->add($hours,$minutes,$_SESSION['userId']))
        		   header("location:/members/dashboard") ; 
        		}
        	}
		}
		else
			echo "Sorry..Something went wrong.!!";
	}
}); 

$Router->post('/members/addthought',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if($_POST['thought']&&$_POST['author'])
		{
		  if($Service->Prote()->DBI()->Func()->thought()->add($_POST['thought'],$_POST['author'],$_SESSION['userId']))
            header("location:/members/dashboard") ; 	
		}
		}
		else
			echo "Sorry..Something went wrong.!!";  
});  

$Router->post('/members/autotimemod',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if($_POST['timecount']>0&&$_POST['timecount']<=5)
		{
		  if($Service->Prote()->DBI()->Func()->users()->update($_POST['timecount'],$_SESSION['userId']))
            header("location:/members/settings") ; 	
		}
		else
			echo "Not your cup of tea. :)";
		}
		else
			echo "Sorry..Something went wrong.!!";  
});

$Router->post('/members/tilepic',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
			$target_dir = 'Static/VA/uploads/';
			$new_filename = 'newpic'.uniqid();
			$file_img_name= $new_filename.basename($_FILES["image"]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image"]["tmp_name"]);
			    if($check !== false) {
			        //echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        //echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			else
			{
			 echo "Seems like an error..";  
			 echo "Click <a href='/members/dashboard'>here</a> to go back";
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size
			if ($_FILES["image"]["size"] > 1000000) {
			    //echo "Sorry, your file is too large.";
			    $default_select_error_msg="Picture upload failed due to large size";
				  include('Views/VA/dash.php');   
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType);
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			    exit();
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { 
			      //echo "<br>The file ". basename( $_FILES["image"]["name"]). " has been uploaded successfully.<br><img src='images/".$file_img_name."' height='75px' width='150px'>";
				  $success_msg="Picture has been succesfully added";
				  include('Views/VA/dash.php');  
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			        exit();
			    }
			}
		}
		else
			header("location:/members/login");
}); 

$Router->get('/members/event',function() use ($Service) {
	if($Service->Auth()->logged_in()){
		include('Views/VA/event.php');
	}
	else{
		header("location:/members/login");
	}
}); 

$Router->post('/members/addevent',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if($_POST['emonth']<=12&&$_POST['emonth']>=1&&$_POST['etext'])
		{ 
			if($_POST['eday']>0&&$_POST['eday']<=31)
			{  	 
			 if($_POST['etype']=="one_time" || $_POST['etype']=="all_time")
			 {  
			 	$index=0;
			 	$i=0;  
			    $mod=array();
				while($data=str_getcsv($_POST['etext']))
				{
					for ($i=0; $i < count($data); $i++) {   
						$mod[$index++]=$data[$i];
					} 
					break;
				} 		 
			   for ($i=0; $i < count($mod); $i++) {  
				  	$event=$mod[$i]; 
				  	$event=str_replace("<", "&lt;", $event);
				  	$event=str_replace(">", "&gt;", $event); 
			        $Service->Prote()->DBI()->Func()->event()->add($event,$_POST['eday'],$_POST['emonth'],$_POST['etype'],$_SESSION['userId']);
			   }
			   $event_success="All events succesfully added";
			   include('Views/VA/event.php');
		     }
		     else echo "Try something better !!!";
			}
			else
			 header("location:/members/dashboard") ; 		
		}
		else 
		   header("location:/members/dashboard") ; 	
		}
		else
			echo "Sorry..Something went wrong.!!";  
});  

$Router->post('/members/addinterest',function() use ($Service) {
	if($Service->Auth()->logged_in()){
	 $interests = $_POST['interest']; 
				$index=0;
			 	$i=0;  
			    $intrsts=array();
	 while($data=str_getcsv($interests))
				{
					for ($i=0; $i < count($data); $i++) {   
						$intrsts[$index++]=$data[$i];
					} 
					break;
				} 		 
			   for ($i=0; $i < count($intrsts); $i++) {  
				  	$intrst=$intrsts[$i];  
			        $Service->Prote()->DBI()->Func()->users()->addInterest($intrst,$_SESSION['userId']);
			   }
			header("location:/members/dashboard");	   
	}
	 else
	 	header("location:/members/login");
});

$Router->post('/members/delevent',function() use ($Service) {
	if($Service->Auth()->logged_in()){
     $ename=$Service->Prote()->DBI()->Func()->event()->getEventName($_POST['id'],$_SESSION['userId']);
	 if($Service->Prote()->DBI()->Func()->event()->delEvent($_POST['id'],$_SESSION['userId']))   	   
	 { 
		 		$act= $ename." event removed";
	            $notification= $ename." event removed<br>@".date('H').":".date('i');
	            $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"success");
	            $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$notification); 
				include('Views/VA/event.php');  
	 }
		else
			echo "Sorry..Something went wrong.!!";
	}
	 else
	 	header("location:/members/login");
});

$Router->post('/members/html',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
		if($_POST['filename']==""&&$_POST['code']=="")
		{
		  header("location:/members/testDir");	
		} 
		else if($_POST['code']=='Remove'||$_POST['code']=='remove')
		{ 
	      if(file_exists("Views/VA/custom/".$_POST['filename']))
	      { 
           if(unlink("Views/VA/custom/".$_POST['filename']))
           { 
            echo "<h3>File '".$_POST['filename']."' removed successfully.<br><br>
                  <a href='/members/dashboard' style='padding:7px;background:#ee6e73;text-decoration:none;color:#fff;font-size:19px;'>
	               Dashboard</a></h3>
            ";
            $act=$_POST['filename']." file removed";
            $notification=$_POST['filename']." removed<br>@".date('H').":".date('i');
            $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"warning");
            $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$notification); 
           }
          }
          else
          	echo "No such file exists.";
		}
	   	else if($_POST['filename']&&$_POST['code'])
		{ 

		  $name=$_POST['filename'];
		  $name=preg_replace ("/ +/", " ", $name);
		  //Prevent injections.Save the planet.
		  $invalid_sym=array("<",">","?");
		  foreach ($invalid_sym as $sym) {
		  	if(strpos($name, $sym)!==false)
		  	{
		      echo "<h3>Invalid filename.</h3><h5>Terminating...</h5><a href='/members/dashboard'>Dashboard.</a>";
		  	  exit();		
		  	}
		  }
		  if($name==" ")
		  {
		  	echo "<h3>Invalid filename.</h3><h5>Terminating...</h5><a href='/members/dashboard'>Dashboard.</a>";
		  	exit();
		  }
		  if(file_exists("Views/VA/custom/".$_POST['filename']))
		  { 
		  	echo " <html>  
    			<title>File exists</title>
    			<link rel='stylesheet' href='Static/VA/css/foundation.css' /> 
    			<br>
    			<div class='large-8 medium-8 columns'>
           	    <div class='row'>
                <div class='large-12 columns'>
            	<div class='callout panel' style='box-shadow:2px 4px 3px #eee;'>
            	<h2><b>File already exists!!!</b></h2> <br>
                <p><strong>What do you want do now ?</strong>
                <ul>
                <li><b><a href='".$_POST['filename']."' target='_new'>Open</a> the file.</b></li>
                <li><form action='/delfile' method='post'>
                     <input type='hidden' name='name' value='".$_POST['filename']."'>
                     <input type='hidden' name='path' value='Views/VA/custom/'>
                    <button type='submit' href='Views/VA/custom/".$_POST['filename']."' style='color:#f00;background:none;padding:0;margin:0;'><b>Delete</b></button> the file.
                    </form>
                </li>
				<li><b>Other links:</b><br>
				 <ul>
				 <li><a href='/members/dashboard' style='font-weight:600;text-shadow:1px 2px 1px #ddd;'>Dashboard</a></li>
				 </ul>
				</li>
                </ul>
                </p>
            	</div>
          		</div>
        		</div> 
      			</div>	 
     			</html>
  			 "; 
		  }
		  else
		  { 	
		   $myfile = fopen("Views/VA/custom/".$name, "w") or die("Unable to locate the file."); 
 		   $txt = "<html>".$_POST['code']."</html>";  
		   fwrite($myfile, $txt);
		   fclose($myfile);  
		   header("location:Views/VA/custom/$name");
		  }
		}
		else
		{ 
			echo "<h3>Invalid Value input.</h3>Terminating...<br><a href='/members/dashboard'>Dashboard.</a>";
		  	exit();
		}
	}
	else
     echo "Sorry..Something went wrong.!!";  
});

$Router->post('/members/newproject',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if($_POST['name']&&$_POST['deadline']&&$_POST['description'])
		{
			if($_POST['type']>=1&&$_POST['type']<=3)
			{
				if($Service->Prote()->DBI()->Func()->projects()->add($_POST['name'],$_POST['deadline'],$_POST['type'],$_POST['description'],$_SESSION['userId']))
				{ 
					$Service->Html()->error='<h4>Project added successfully.</h4>';
					include('Views/VA/project.php'); 
				}
				else
				{
					$Service->Html()->error='<h4>Project with same name already exists. Try some other name.</h4>';
					include('Views/VA/project.php'); 
				}
			}
			else
				echo "Invalid type.";
		} 
		else
			echo "Please fill up all the fields.";
		}
		else
			echo header("location:/members/login");  
}); 

$Router->post('/members/searchproject',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if($_POST['type']>0)
		{
			 $project_details='Ready';
			 $project_id=$_POST['type'];
			 include('Views/VA/project.php');  
		} 
		else
		{
			$project_details='Ready';//just to get oter tab ready
			$default_select_error_msg="<p style='color:#f00;margin-top:-1rem;'><b>Please select a project to get its details !!!</b></p>";
			include('Views/VA/project.php');  
		}
		}
		else
			echo header("location:/members/login");  
}); 

$Router->post('/members/addmodule',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if($_POST['project']&&$_POST['modules'])
		{
				$Id1=$_POST['project'];
			    $mod=array();
			    $index=0; 
				while($data=str_getcsv($_POST['modules']))
				{
					for ($i=0; $i < count($data); $i++) {   
						$mod[$index++]=$data[$i];
					} 
					break;
				} 		 
			   for ($i=0; $i < count($mod); $i++) {  
				  	$interest=$mod[$i];
				   $Service->Prote()->DBI()->Func()->projects()->addProjectMap($Id1,strtolower($interest),$_SESSION['userId']);  			   
		} 
		  $project_details='Ready';//just to get oter tab ready
		  $default_select_error_msg="<p style='color:#00;margin-top:-1rem;'><b>Module <code>".$_POST['modules']."</code> succesfully added to the project <u>".$Service->Prote()->DBI()->Func()->projects()->getProjectName($_POST['project'])."</u>.</b></p>";
		  include('Views/VA/project.php');  
		} 
		else
			echo "Please fill up all the fields.";
		}
		else
			echo header("location:/members/login");  
});  


$Router->get('/members/hide-secret-projects',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		//reset the variable
		include('Views/VA/project.php');
	}
	else
		header("location:/members/login");
});

$Router->post('/members/project/remove',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		 $project=$Service->Prote()->DBI()->Func()->projects()->getProjectName($_POST['projectid'],$_SESSION['userId']);
		 $Service->Prote()->DBI()->Func()->projects()->remove($_POST['projectid'],$_SESSION['userId']); 
		 $project_details='Ready';//just to get oter tab ready
		 $default_select_error_msg="<p style='color:#f00;margin-top:-1rem;'>Project <code>".$project."</code> succesfully removed.</p>";
		 $act="Project ".$project." removed";
         $Service->Prote()->DBI()->Func()->activity()->add($_SESSION['userId'],$act,"warning");
         $notification="Project ".substr($project,10)." removed <br>@".date('H').":".date('i');
         $Service->Prote()->DBI()->Func()->notification()->add($_SESSION['userId'],$notification);  
		 include('Views/VA/project.php');  
		}
		else
			echo header("location:/members/login");  
});

$Router->post('/members/project/removemodule',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		 $Service->Prote()->DBI()->Func()->projects()->removeModule($_POST['project'],$_POST['module'],$_SESSION['userId']); 
		 $project_details='Ready';//just to get oter tab ready
		 $default_select_error_msg="<p style='color:#f00;margin-top:-1rem;'><b>Module <code>".$_POST['module']."</code> succesfully deleted from the project <u>".$Service->Prote()->DBI()->Func()->projects()->getProjectName($_POST['project'],$_SESSION['userId'])."</u>.</b></p>";
		 include('Views/VA/project.php');  
		}
		else
			echo header("location:/members/login");  
}); 

$Router->post('/members/project/progress',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
		if($_POST['value']>0 && $_POST['value']<100){  
		 if($Service->Prote()->DBI()->Func()->projects()->UpdateProgress($_POST['project'],$_POST['value'],$_SESSION['userId']))
		 {   
		  $project_details='Ready';//just to get oter tab ready
		  $default_select_error_msg="<p style='color:#5C7733;margin-top:-1rem;'><b>Progress of the project <u>".$Service->Prote()->DBI()->Func()->projects()->getProjectName($_POST['project'],$_SESSION['userId'])."</u> has been updated succesfully.</b></p>";
		  include('Views/VA/project.php');  
		 }
		 else
		 {   
		  $project_details='Ready';//just to get oter tab ready
		  $default_select_error_msg="<p style='color:#000;margin-top:-1rem;'><b>Looks like something went wrong. Try again !!!.</b></p>";
		  include('Views/VA/project.php');  
		 }	
		}
		else
		{
		  $project_details='Ready';//just to get oter tab ready
		  $default_select_error_msg="<p style='color:#000;margin-top:-1rem;'><b>Invalid progress value . Try again !!!.</b></p>";
		  include('Views/VA/project.php');  
		}
		}
		else
			echo header("location:/members/login");  
}); 


$Router->get('/members/testDir',function() use ($Service) {
	if($Service->Auth()->logged_in()){  
	  if ($handle = opendir('Views/VA/custom')) { 
	   echo "<h2>List of test files.</h2><a href='/members/dashboard' style='padding:7px;background:#ee6e73;text-decoration:none;color:#fff;font-size:19px;'>
	  	Dashboard</a><br><br>";
       while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") { 
            echo "<img src='Static/VA/images/chrome.jpg' width='17'>
                  <a href='Views/VA/custom/$file' style='text-decoration:none;font-size:20px;padding:7px;'>$file</a><br>";
        }
    }
    echo "";
    closedir($handle);
}	
}
	else
     header("location:/members/");  
});
//for the posts
$Router->get('/members/technical/([A-Za-z0-9]+.+)',function() use ($Service) {
	    $header=$_SERVER['REQUEST_URI'];
	    $header=preg_replace ("/%20/"," ",$header);
	    $c=$Service->Database()->find_many("SELECT * from diary where header like '".substr($header,11)."';"); 
	    echo " 
	    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
	    <title>Tehnical stuff</title>
	    <link rel='stylesheet' href='/Static/VA/css/foundation.css' /> 
	    <link rel='shortcut icon' href='/Static/VA/images/diary.png' type='image/x-icon'>
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	    </head>
		<body>
	    <div class='row'>
	    <div class='large-12 columns'>
	    <h1 align='left'>".substr($header,11)."</h1><br>
	    </div>
	    </div>
	    <style>
	    .panel{
	      font-family: 'Open Sans', sans-serif;
	    }
	    </style> 
		<div class='row'>
	      <div class='large-8 medium-8 columns'>
	         <div class='row'>";
	         foreach ($c as $data)
	         echo " <div class='large-12 columns' style='background:#ECFAFF;padding-top:1rem;'>".$data->text."</div>";
	        echo "</div>
	       </div>
	     </div>   
	      ";  
	    $c=$Service->Database()->find_many("SELECT * from diary where header like '".$header."' ");  
             if($c)
             {  
              foreach ($c as $data)
               {
                   echo "<section id='".$data->header."'></section>";
                   echo "<div class='callout panel'><h5>".$data->header."</h5>".$data->text."<strong>";  ;
                 echo  substr($data->time,10,6)." hrs, ". $Service->Prote()->DBI()->Func()->comment()->get_access_date_month($data->cid)." ".$Service->Prote()->DBI()->Func()->comment()->get_access_date_day($data->cid).", ".$Service->Prote()->DBI()->Func()->comment()->get_access_year($data->cid)."</strong> </div>";
               }
             } 
             /*else
              header("location:/members/unknown");*/
}); 
//The activity log.
$Router->get('/members/activity.log',function() use ($Service) {
	if($Service->Auth()->logged_in()){ 
      if($Service->Prote()->DBI()->Func()->activity()->countActivity($_SESSION['userId'])==0)
      {
      	echo "<title>Activity Log.</title><h3><u>Activity log :  </u></h3>No activity to display.<br><a href='/members/dashboard' style='text-decoration:none;font-weight:600;'>&laquo; Dashboard</a>";
      	exit();  
      }
      $id=$_SESSION['userId'];
	  $c=$Service->Database()->find_many("SELECT * from activity where uid=".$id." order by time"); 
	  echo "<title>Activity Log.</title><h3><u>Activity log :  </u></h3><ul>"; 
          foreach ($c as $data)
          { 
          	echo "<li style='font-size:19px;padding:6px;line-height:0.6;'>".$data->act_des." @".$data->time."</li>";
          }
     echo "</ul>"; 
     echo "<form action='/members/activity.log/clear_activity_log' method='post'><a href='/members/dashboard' style='text-decoration:none;font-weight:600;'>&laquo; Dashboard</a><button type='submit'>Clear</button></form>";    
	}
	else
     header("location:/members/login");  
});
$Router->post('/members/activity.log/clear_activity_log',function() use ($Service) {
	if($Service->Auth()->logged_in()){   
		if($Service->Prote()->DBI()->Func()->activity()->remove($_SESSION['userId']))
         header("location:/members/dashboard"); 
      }
	else
     header("location:/members/");  
});  

$Router->get('/members/testMail',function() use ($Service) { 
		$Service->Prote()->DBI()->Func()->users()->sendEmail();
});  

$Router->get('/members/forgot-password',function() use ($Service) { 
	  $email = $_GET['email'];
	  if(empty($email))
	  {
	  	header("location:/members/login");
	  	exit();
	  } 
	 $body="You are receiving this email for your request to reset your password.<br> Please <a href='http://jargonsmaze.com/members/resetPassword?email=".base64_encode($email)."&time=".time()."' target='_new'>click here</a> to reset or copy paste the below link in your browser:<br><a href='http://jargonsmaze.com/members/resetPassword?email=".base64_encode($email)."&time=".time()."'' target='_new'>http://jargonsmaze.com/members/resetPassword?email=".base64_encode($email)."&time=".base64_encode(time())."</a>"; 
	 $subject="Reset Password";
	 if($Service->Prote()->DBI()->Func()->users()->sendEmail($body,$email,$subject))
	 { 	
		$msg = "Mail has been sent to the mail id : ".$email." to reset password.";
		include('Views/VA/login.html');			 
	 } 
	else
	{
		$msg = "Please check your email Id.";
		include('Views/VA/login.html');	
	}
});  

$Router->get('/members/resetPassword',function() use ($Service) {  
	 $email = $_GET['email']; 
	 include('Views/VA/resetPwd.html');  
});

$Router->post('/members/resetPassword',function() use ($Service) {
  $pwd1=$_POST['pwd1']; 	
  $pwd2=$_POST['pwd2']; 	 
  if($pwd1!=$pwd2)
  {
   $msg="Entered password don't match!!!";
   $email=$_POST['email'];
   include('Views/VA/resetPwd.html');    	
   exit();
  }
 $uid=$Service->Prote()->DBI()->Func()->users()->mapUserId(base64_decode($_POST['email']));
 if($Service->Prote()->DBI()->Func()->users()->resetPwd(base64_decode($_POST['email']),$pwd1,$uid))
 {
   $msg="Password has been changed.";
   include('Views/VA/login.html');    
 }
});

$Router->post('/members/sendMailfromHome',function() use ($Service) {  	
 if($Service->Prote()->DBI()->Func()->users()->sendEmail($_POST['message'],"iamtheking1abhishek@gmail.com","Mail from ".$_POST['email']."(".$_POST['name'].")"))
 {
   $msg="Mail has been sent successfully. We will connect with you shortly";
   include('Views/VA/login.html');    
 }
});

$Router->post('/members/',function() use ($Service) {  	
 if($Service->Prote()->DBI()->Func()->users()->sendEmail($_POST['message'],"iamtheking1abhishek@gmail.com","Mail from ".$_POST['email']."(".$_POST['name'].")"))
 {
   $msg="Mail has been sent successfully. We will connect with you shortly";
   include('Views/VA/login.html');    
 }
});
/*
$Router->post('/members/restore',function() use ($Service) {
	if($Service->Auth()->logged_in()){   	 
		   if($Service->Prote()->DBI()->Func()->notes()->restore()) 
		  	header("location:/members/dashboard") ; 
		else
			echo "Sorry..Something went wrong.!!";
	}
});*/ 