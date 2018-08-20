<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>RT Camp</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">
	<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/fav.png') ?>"/>
	<link href="img/apple-touch-icon.png" rel="apple-touch-icon">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">
	<link href="<?= base_url('assets/lib/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>lib/animate/animate.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <!-- autocomplete -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- autocomplete -->    
    <link href="<?= base_url('assets/') ?>css/style.css" rel="stylesheet">
    <script type="text/javascript">
        var BASE_URL = "<?php echo base_url(); ?>";
    </script>
</head>

<body>
    <header id="header">
    	<div class="container-fluid">
    		<div id="logo" class="pull-left">
    			<h1><a href="<?= base_url('home') ?>" class="scrollto">RT CAMP</a></h1>
    		</div>
    		<nav id="nav-menu-container">
    			<ul class="nav-menu">
    				<li class="srchBox">
                        <input type="text" placeholder="Search name" name="searchName" id="searchName">
                    </li>
                   
                  <ul class="" role="menu" aria-labelledby="dropdownMenu"  id="DropdownNames"></ul>
                  <li class="menu-has-children"><a href="#">Download</a>
                   <ul>
                      <li class="menu-has-children"><a href="#">My Followers</a>
                         <ul>
                            <li><a href="javascript:void(0)" onclick="downloadUserFollowers('<?= $this->session->screenname ?>','pdf')" >PDF</a></li>
                            <li><a href="javascript:void(0)" onclick="downloadUserFollowers('<?= $this->session->screenname ?>','xml')" >XML</a></li>
                        </ul>
                    </li>
                    <li class="menu-has-children"><a href="#">My Tweets</a>
                     <ul>
                        <li><a href="javascript:void(0)" onclick="downloadUserTweets('<?= $this->session->screenname ?>','pdf')">PDF</a></li>
                        <li><a href="javascript:void(0)" onclick="downloadUserTweets('<?= $this->session->screenname ?>','xml')">XML</a></li>
                    </ul>
                </li>
            </ul>
        </li>
         <li class="btnTweetLi">
                        <button type="button" class="btn btn-primary pl-2 pr-2" data-toggle="modal" data-target="#tweetModal">
                          Tweet
                      </button>
                  </li>
        <li class="menu-has-children"><a href="#"><?= $this->session->username ?></a>
           <ul>
              <li><a href="#team">Followers</a></li>
              <li><a href="<?= base_url('home/logout'); ?>">Logout</a></li>
          </ul>
      </li>
  </ul>
</nav>
</div>
</header>