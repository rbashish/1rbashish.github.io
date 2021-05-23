<!-- ?php
	if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
		var_dump($_POST);
		$secret = "6Lcq3V0UAAAAALp-VcIG87fpqy8dfT6ZG6hfR_rr";
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response'];
		$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		$arr = json_decode($rsp,TRUE);
		if($arr['success']) {
			echo 'Your mail was sent';
		} else {
			echo 'SPAM';
		}
	}-->

<?php
if($_POST)
{

    
    $name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject     = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message   = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
    
    if(empty($name)) {
		$empty[] = "<b>Name</b>";		
	}
	if(empty($email)) {
		$empty[] = "<b>Email</b>";
	}
	if(empty($subject)) {
		$empty[] = "<b>Sunject</b>";
	}	
	if(empty($message)) {
		$empty[] = "<b>Message</b>";
	}
	
	if(!empty($empty)) {
		$output = json_encode(array('type'=>'error', 'text' => implode(", ",$empty) . ' Required!'));
        die($output);
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //email validation
	    $output = json_encode(array('type'=>'error', 'text' => '<b>'.$email.'</b> is an invalid Email, please correct it.'));
		die($output);
	}
	
	//reCAPTCHA validation
	if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
		var_dump($_POST);
		$secret = "6Lcq3V0UAAAAALp-VcIG87fpqy8dfT6ZG6hfR_rr";
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response'];
		$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		$arr = json_decode($rsp,TRUE);
		if($arr['success']) {
			echo 'Verified';
		} else {
			echo 'SPAM';
		}
	}
	
	/*if (isset($_POST['g-recaptcha-response'])) {
		
		//require('component/recaptcha/src/autoload.php');		
		
		//$recaptcha = new \ReCaptcha\ReCaptcha(SECRET_KEY, new \ReCaptcha\RequestMethod\SocketPost());
		$secret = "6Lcq3V0UAAAAALp-VcIG87fpqy8dfT6ZG6hfR_rr";
		$remoteip = $_SERVER['REMOTE_ADDR'];
		//$resp = $secret->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		  /*if (!$resp->success()) {
				$output = json_encode(array('type'=>'error', 'text' => '<b>Captcha</b> Validation Required!'));
				die($output);				
		  }	*/
		 /* $arr = json_decode($rsp,TRUE);
		if($arr['success']) {
		echo 'Captcha verified';
		} else {
			echo 'Captcha not verified';
		}
	}*/
	
	$toEmail = "dev.rbashish@gmail.com";
	$mailHeaders = "From: " . $name . "<" . $email . ">\r\n";
	if (mail($toEmail, "Contact Mail", $content, $mailHeaders)) {
	    $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$name .', thank you for the comments. We will get back to you shortly.'));
	    die($output);
	} else {
	    $output = json_encode(array('type'=>'error', 'text' => 'Unable to send email, please contact'.SENDER_EMAIL));
	    die($output);
	}
}
?>