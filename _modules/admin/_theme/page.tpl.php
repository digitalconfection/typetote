<html>
<head>
  <title>TypeTote - Admin</title>
  <link rel="stylesheet" type="text/css" href="<?php echo SiteInfo::baseUrl(); ?>_modules/admin/_theme/css/style.css">
</head>
<body>

<?php if ($GLOBALS['utility_page'] == 'no') { ?>  
<div class="admin-well">
  <div class="admin-col">
    <a href="<?php echo SiteInfo::baseUrl(); ?>admin/"><img class="tt-logo-side" src="<?php echo SiteInfo::baseUrl();?>_modules/admin/img/tt-emb.svg"></a>
    <nav>
      <ul>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/">Dashboard <i class="fas fa-home"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/post">Publish <i class="fas fa-edit"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/media">Images <i class="fas fa-image"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/category">Categories <i class="fas fa-book"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/menu">Menu <i class="fas fa-link"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/site-banner"">Site Banner<i class="fas fa-bullhorn"></i></a></li>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>admin/settings">Settings <i class="fas fa-cog"></i></a></li>
        <hr>
        <li><a href="<?php echo SiteInfo::baseUrl(); ?>">Back to Site <i class="fas fa-caret-square-left"></i></a></li>
      </ul>
    </nav>
  </div>
  <div class="admin-body">
    <div class="admin-utility">
      <a href="<?php echo SiteInfo::baseUrl(); ?>admin/logout"> Logout <i class="fas fa-power-off"></i></a>
    </div>
    <?php include ($page_content) ?>
    <div class="cc">
      <br>
      <hr>
      Thank you for using <a href="https://typetote.com" target="_blank">TypeTote</a>! You Rock!. <i class="far fa-smile-beam"></i>
      <br>
      <br>
      Version: <b><?php include ('version.txt'); ?></b>
    </div>
</div>

<?php } else { ?>
  <style>
    .admin-col, .admin-utility, .cc, pre {
      display: none
    }

    .admin-body {
      min-height: unset;
      width: 100%;
      padding: 0;
    }

    body {
      border: hidden !important;
      padding: 0;
      margin: 0;
    }
  </style>
<?php } ?>

</body>
</html>