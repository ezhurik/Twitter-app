<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login with Twitter in CodeIgniter by CodexWorld</title>
<style type="text/css">
h1{
font-family:Arial, Helvetica, sans-serif;
color:#999999;
}
.wrapper{width:600px; margin-left:auto;margin-right:auto;}
.welcome_txt{
	margin: 20px;
	background-color: #EBEBEB;
	padding: 10px;
	border: #D6D6D6 solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tw_box{
	margin: 20px;
	background-color: #FFF0DD;
	padding: 10px;
	border: #F7CFCF solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tw_box .image{ text-align:center;}

.tweetList{
	margin: 20px;
	padding:20px;
	background-color: #E2FFF9;
	border: #CBECCE solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.tweetList ul{
	padding: 0px;
	font-family: verdana;
	font-size: 12px;
	color: #5C5C5C;
}
.tweetList li{
	border-bottom: silver dashed 1px;
	list-style: none;
	padding: 5px;
}
p.error{font-size: 16px;color: #EA4335;}
</style>
</head>
<body>
<?php
if(!empty($error_msg)){
	echo '<p class="error">'.$error_msg.'</p>';	
}
?>

<?php
if(!empty($userData)){
	$outputHTML = '
		<div class="wrapper">
			<h1>Twitter Profile Details </h1>
			<div class="welcome_txt">Welcome <b>'.$userData['first_name'].'</b></div>
			<div class="tw_box">
				<p class="image"><img src="'.$userData['picture_url'].'" alt="" width="300" height="220"/></p>
				<p><b>Twitter Username : </b>'.$userData['username'].'</p>
				<p><b>Name : </b>'.$userData['first_name'].' '.$userData['last_name'].'</p>
				<p><b>Locale : </b>' . $userData['locale'].'</p>
				<p><b>Twitter Profile Link : </b><a href="'.$userData['profile_url'].'" target="_blank">'.$userData['profile_url'].'</a></p>
				<p><b>You are login with : </b>Twitter</p>
				<p><b>Logout from <a href="'.base_url().'user_authentication/logout">Twitter</a></b></p>';
	//Latest tweets
	if(!empty($tweets)){
		$outputHTML .= '<div class="tweetList"><strong>Latest Tweets : </strong>
			<ul>';
		foreach($tweets  as $tweet){
			$outputHTML .= '<li>'.$tweet->text.' <br />-<i>'.$tweet->created_at.'</i></li>';
		}
		$outputHTML .= '</ul></div>';
	}
	$outputHTML .= '</div>
		</div>';
}else{
	$outputHTML = '<a href="'.$oauthURL.'"><img src="'.base_url().'assets/img/sign-in-with-twitter.png" alt=""/></a>';
}
?>
<?php echo $outputHTML; ?>
</body>
</html>