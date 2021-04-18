<base href="<?php render_baseUrl() ?>">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <meta name="referrer" content="origin"> -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php render_siteTitle($page_data);?>">
<meta name="twitter:description" content="<?php render_siteDescription($page_data); ?>">
<meta name="twitter:image" content="<?php echo $twitter_og; ?>">

<!-- Facebook Card -->
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php render_baseUrl() ?>" />
<meta property="og:title" content=""<?php render_siteTitle($page_data);?>" />
<meta property="og:description" content="<?php render_siteDescription($page_data); ?>"/>
<meta property="og:image" content="<?php echo $fb_og; ?>"/>

<link rel="shortcut icon" type="image/x-icon" href="<?php render_baseUrl() ?><?php echo $site_data['front_theme']?>/favicon.ico">

<?php if ((http_response_code() == '200')) { ?>
  <link rel="canonical" href="<?php echo $canonical; ?>"/>
<?php } ?>