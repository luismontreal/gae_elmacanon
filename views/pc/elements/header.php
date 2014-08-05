<!DOCTYPE html>
<html>
<head>
    <title><?=@$data['seo']['title']?></title>
        <meta name="RATING" content="RTA-5042-1996-1400-1577-RTA" />
        
	<?php 
	if(empty($data['seo']['index'])) {
	    $data['seo']['index'] = 'noindex, nofollow';
	}
	?>
        <meta name="robots" content="<?=$data['seo']['index']?>" />                        
        <meta name="google-translate-customization" content="70cb57e407230552-e8217eb3457c16cd-g2436a6e02f0b0e29-11">
        <meta name="google-site-verification" content="68aQQc78KavTc4VbdY1ZrApV5RPGlpvlAbTlr5ZavJk" />
        <meta http-equiv="Content-Language" content="en" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
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

<body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true" onload="loadAssets();">
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="/">
				<span>El</span><span class="cl-blue">macanon</span>
			</a>
			<div class="tabs-left">
				<ul class="nav pull-left nav-tabs">
                                    <li <?= empty($data['params']['category']) || $data['params']['category'] == 'straight'? 'class="active"' : '';?>><a href="/?straight=1">Straight</a></li>
                                    <li <?= !empty($data['params']['category']) && $data['params']['category'] == 'gay' ? 'class="active"' : '';?>><a href="/gay">Gay</a></li>
                                    <li <?= !empty($data['params']['category']) && $data['params']['category'] == 'shemale' ? 'class="active"' : '';?>><a href="/shemale">Shemale</a></li>                                   
                            </ul>
                            <!--Google Translate -->
                            <div id="google_translate_element"></div>                            
                            <!--Ends Google Translate -->
			</div>
		</div>
	</div>
</div>
<!-- end navbar -->
