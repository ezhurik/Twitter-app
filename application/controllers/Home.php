<?php

use Abraham\TwitterOAuth\TwitterOAuth;
class Home extends CI_Controller {

	var $code='';
	var $msg='';
	public function __construct()
	{
		parent::__construct();
		require "vendor/autoload.php";
		$this->load->helper('download');
		$this->load->model('Mdl_home','model');
	}

	public function index()
	{
		if (!isset($this->session->access_token)) {
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
			$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
			$this->session->oauth_token = $request_token['oauth_token'];
			$this->session->oauth_token_secret = $request_token['oauth_token_secret'];
			$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
			header('Location:' . $url);
		} 
		else 
		{
			$connection=$this->getConnection();
			$user = $connection->get("account/verify_credentials");
			$sessArr=array(
				'username'=>$user->name,
				'screenname'=>$user->screen_name,
				'description'=>$user->description,
				'followers'=>$user->followers_count,
				'following'=>$user->friends_count,
				'tweets'=>$user->statuses_count,
			);
			$this->session->set_userdata($sessArr);

			$tweets = $connection->get('statuses/home_timeline', ['count' => 20, 'exclude_replies' => true, 'screen_name' => $this->session->screenname, 'include_rts' => false]);

			$homeTweets=array();
			$homeTweetCounter=0;
			foreach ($tweets as $row) {
				if($homeTweetCounter >9)
				{
					break;
				}
				else
				{
					if(strpos($row->text, "https://") !== false)
					{
						$link=substr($row->text, strpos($row->text, 'https://'));
						$linkArr = explode(' ',trim($link));
						$homeTweets[$homeTweetCounter]['link']=$linkArr[0];
						$homeTweets[$homeTweetCounter]['tweet']=substr($row->text,0, strpos($row->text, 'https://'));;
					}
					else 
					{
						$homeTweets[$homeTweetCounter]['tweet']=$row->text;
					}

					$homeTweets[$homeTweetCounter]['username']=$row->user->name;
					$homeTweets[$homeTweetCounter]['screenName']=$row->user->screen_name;
					$homeTweets[$homeTweetCounter]['profilePic']=$row->user->profile_image_url;
				}
				$homeTweetCounter++;		   		
			}
		   
		   	//followers
			$followerList = $connection->get('followers/list', ['screen_name' => $this->session->screenname]);
			$followers = $followerList->users;

			$followersArr=array();
			$followersCounter=0;
			foreach ($followers as $row) {
				if($followersCounter > 11)
				{
					break;
				}
				$followersArr[$followersCounter]['name']=$row->name;
				$followersArr[$followersCounter]['screenName']=$row->screen_name;
				if(!isset($row->profile_image_url))
				{
					$followersArr[$followersCounter]['profilePic']=  base_url('images/defaultProfile.png');	
				}
				else
				{
					$followersArr[$followersCounter]['profilePic']= str_replace('_normal', '', $row->profile_image_url_https);
				}
				if(!isset($row->profile_banner_url))
				{
					$followersArr[$followersCounter]['bannerPic']= base_url('images/defaultBanner.png');	
				}
				else
				{
					$followersArr[$followersCounter]['bannerPic']=$row->profile_banner_url;
				}
				$followersArr[$followersCounter]['followers']=$row->followers_count;
				$followersArr[$followersCounter]['following']=$row->friends_count;
				$followersCounter++;
			}
		   	
			$data['homeTweets']=$homeTweets;
			$data['followers']=$followersArr;
			$this->load->view('home',$data);
		}

	}

	public function getConnection(){
		$access_token = $this->session->access_token;
		return $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	}

	public function getLatestTweets($username)
	{
		$connection=$this->getConnection();

		if($this->session->tweets <200)
		{
			$tweets = $connection->get('statuses/user_timeline', ['count' => $this->session->tweets, 'screen_name' => $username]);
			$counter=0;
			foreach ($tweets as $row) {
				$arr['val']=$row->text;
				$fin[] = $arr;
				$counter++;
			}
		}
		else
		{
			$tweets = $connection->get('statuses/user_timeline', ['count' => 200, 'screen_name' => $username]);
			$totalTweets[] = $tweets;
			$page = 0;
			for ($count = 200; $count < 3200; $count += 200) {
				$max = count($totalTweets[$page]) - 1;
				$tweets = $connection->get('statuses/user_timeline', ['count' => 200, 'max_id' => $totalTweets[$page][$max]->id_str, 'screen_name' => $username]);
				$totalTweets[] = $tweets;
				$page += 1;
			}
			foreach ($totalTweets as $page) {
				foreach ($page as $key) {
					$arr['val'] = $key->text;
					$fin[] = $arr;
				}
			}
		}
		return $fin; 
	}

	public function searchUser()
	{
		$connection=$this->getConnection();
		$data = $connection->get('users/search', array('q' => $this->input->post('keyword')));
		echo json_encode($data);
	}

	public function getUserTweets()
	{
		$connection=$this->getConnection();
		$username=$this->input->post('searchedUsername');
		$tweets = $connection->get('statuses/user_timeline', ['count' => 20, 'exclude_replies' => true, 'screen_name' => $username]);
		$homeTweets=array();
		$homeTweetCounter=0;
		foreach ($tweets as $row) {
			if($homeTweetCounter >9)
			{
				break;
			}
			else
			{
				if(strpos($row->text, "https://") !== false)
				{
					$link=substr($row->text, strpos($row->text, 'https://'));
					$linkArr = explode(' ',trim($link));
					$homeTweets[$homeTweetCounter]['link']=$linkArr[0];
					$homeTweets[$homeTweetCounter]['tweet']=substr($row->text,0, strpos($row->text, 'https://'));;
				}
				else 
				{
					$homeTweets[$homeTweetCounter]['tweet']=$row->text;
				}

				$homeTweets[$homeTweetCounter]['username']=$row->user->name;
				$homeTweets[$homeTweetCounter]['screenName']=$row->user->screen_name;
				$homeTweets[$homeTweetCounter]['profilePic']=$row->user->profile_image_url;
			}
			$homeTweetCounter++;		   		
		}
		echo json_encode($homeTweets);
	}

	public function downloadTweets()
	{
		$username=$this->input->post('username');
		$type=$this->input->post('type');
		$tweets=$this->getLatestTweets($username);
		switch ($type) {
			case "pdf":
			$this->downloadPdf($tweets,$username);
			break;
			
			case "xml":
			$this->downloadXml($tweets,$username);
			break;

			default:
			$code=0;
			$msg='Invalid Request';
			break;
		}

	}

	public function createTweet()
	{
		$connection=$this->getConnection();
		$parameters=array();
		if(!empty($_FILES['tweetImg']))
		{
			$media1 = $connection->upload('media/upload', ['media' => $_FILES['tweetImg']['tmp_name']]);
			$parameters = [
				'status' => $this->input->post('txt'),
				'media_ids' => implode(',', [$media1->media_id_string])
			];
		}
		else
		{
			$parameters = [
				'status' => $this->input->post('txt'),
			];
		}
		$result = $connection->post('statuses/update', $parameters);
		$code='';
		$msg='';
		if($result->id_str !='')
		{
			$response['code']=0;
			$response['msg']="You have tweeted sucessfully";
		}
		else
		{
			$response['code']=1;
			$response['msg']="Something went wrong. PLease try again";
		}
		echo json_encode($response);
	}

	public function getMyFollowers()
	{
		$connection=$this->getConnection();
		$profiles = array();
		$ids = $connection->get('followers/ids');
		$ids_arrays = array_chunk($ids->ids, 100);
		foreach($ids_arrays as $implode) {
			$results = $connection->get('users/lookup', array('user_id' => implode(',', $implode)));
			foreach($results as $profile) {
				$profiles[$profile->screen_name] = $profile->name;
			}
		}
		return $profiles;
	}


	// followers
	public function downloadFollowers()
	{
		$username=$this->input->post('username');
		$type=$this->input->post('type');
		$followers=$this->getUserFollowers($username);
		switch ($type) {
			case "pdf":
			$this->downloadPdf($followers,$username);
			break;
			
			case "xml":
			$this->downloadXml($followers,$username);
			break;
			
			default:
			break;
			$code=0;
			$msg='Invalid Request';
			break;
		}

	}

	public function getUserFollowers($username)
	{
		$connection=$this->getConnection();
		$followers = $connection->get('followers/list', array('screen_name' => $username, 'count' => 200));
		$followersArr=array();
		foreach ($followers->users as $row) {
			$followersArr[]['val']=$row->screen_name;
		}
		return $followersArr;
	}
	
	public function downloadXml($values,$name)
	{
		$timestamp = date('YmdHis');
		$fileName = $name . $timestamp . '.xml';
		$xml = new DOMDocument("1.0",'utf-8');
		$usersXml = $xml->createElement("usersXml");
		$xml->preserveWhiteSpace = false; 
		$xml->formatOutput = true;
		$xml->appendChild($usersXml);
		foreach ($values as $row) {
			$userXml = $xml->createElement("userXml");
			$usersXml->appendChild($userXml);
			$followerXml = $xml->createElement("value", $row['val']);
			$userXml->appendChild($followerXml);
		}
		header("Content-Disposition: attachment; filename=" . $fileName);
		header("Content-Type: application/octet-stream");
		echo $xml->saveXML();
	}

	public function downloadPdf($values,$name)
	{
		require_once(APPPATH.'libraries/pdf/fpdf.php');
		$timestamp = date('YmdHis');
		$fileName =  $name.$timestamp.'.pdf';
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 8);
		$count = 1;
		foreach ($values as $row) {
			$content = $count . "-" . $row['val'];
			$pdf->MultiCell(190, 5, $content, 1);
			$count++;
		}
		$pdf->Output("D", $fileName);
		header("Content-Disposition: attachment; filename=" . $fileName);
		header("Content-Type: application/octet-stream");
		header("Content-Description: File Transfer");
		header("Content-Length: " . filesize($fileName));
		readfile($fileName);
		unlink($fileName);
		exit();
	}

	public function logout()
	{
		session_destroy();
		redirect('welcome');
	}

}

?>