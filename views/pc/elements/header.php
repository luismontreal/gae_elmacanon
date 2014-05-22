<!DOCTYPE html>
<html>
<head>
    <title><?=$data['seo']['title']?></title>
        <?if($data['seo']['index']) : ?>
        <meta name="robots" content="index, follow, all" />
        <?else:?>
        <meta name="robots" content="noindex, nofollow" />
        <?endif;?>
        <meta http-equiv="Content-Language" content="en" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="google-site-verification" content="68aQQc78KavTc4VbdY1ZrApV5RPGlpvlAbTlr5ZavJk" />
	<link rel="stylesheet" type="text/css" href="/pc/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="/pc/css/global.css" />
	<link type="text/css" rel="stylesheet" href="/pc/css/color-button.css" />
	<!-- js Boots_from -->
	<script src="/pc/js/jquery.js"></script>
        <script src="/pc/js/bootstrap.min.js"></script>
        <script src="/pc/js/custom.js"></script>
	<!-- end Boots_from -->
        <!-- Google analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-51160359-1', 'elmacanon.com');
            ga('send', 'pageview');
        </script>
        <!-- End google analytics -->
        
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true">
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="/">
				<span>El</span><span class="cl-blue">macanon</span>
			</a>
			<div class="nav-collapse">
				<ul class="nav pull-left">
                                    <li><a href="/">Home</a></li>
                                    <!--li><a href="/categories">Categories</a></li>
                                    <li><a href="/tags">Tags</a></li>
                                    <!--li><a href="element.html">Element</a></li>
                                    <li><a href="detail.html">Detail</a></li>
                                    <li><a href="pricing-plans.html">Pricing Plans</a></li>
                                                    <li><a href="grid-layout.html">Grid Layout</a></li>

                                    <li class="divider-vertical"></li>

                                    <li class="avatar_small"><a href="account.html"></a></li>
                                    <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                                    john doe
                                                    <b class="caret"></b>
                                            </a>
                                            <ul class="dropdown-menu">
                                                                    <li>
                                                                            <a href="profile.html">
                                                                                    <i class="icon-user"></i>
                                                                                    Account Setting  </a>
                                                                    </li>
                                                                    <li>
                                                                            <a href="setting.html">
                                                                                    <i class="icon-lock"></i> Change Password</a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    <li>
                                                                            <a href="login.html"><i class="icon-off"></i> Logout</a>
                                                                    </li>
                                                            </ul>
                                    </li-->
                            </ul>
			</div>
		</div>
	</div>
</div>
<!-- end navbar -->
