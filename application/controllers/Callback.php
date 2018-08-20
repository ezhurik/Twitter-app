<?php
use Abraham\TwitterOAuth\TwitterOAuth;
class Callback extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		require "vendor/autoload.php";
	}

	public function index()
	{
		if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $this->session->oauth_token) {
			$request_token = [];
			$request_token['oauth_token'] = $this->session->oauth_token;
			$request_token['oauth_token_secret'] = $this->session->oauth_token_secret;
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
			$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
			$this->session->access_token = $access_token;
			// redirect user back to index page

			header('Location:https://twitter.lochawala.com/home');

		}		



	}

}

?>