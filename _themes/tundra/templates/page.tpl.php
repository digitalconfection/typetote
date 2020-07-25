<!DOCTYPE html>
<html lang="en">
<head>
<title><?php render_siteTitle($page_data); ?></title>
  <meta name="description" content="<?php render_siteDescription($page_data); ?>">
  <?php render_themeCSS('tundra'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
  <?php render_templateMetaHead($page_data); ?>
</head>
<body>

<?php #  Renders the site banner. ?>
<?php render_site_banner()?>

<div class="menu">
  <a href="<?php render_baseUrl(); ?>" class="logo"><?php echo $site_data['site_name']; ?></a>
    <div id="menu-icon" onclick="slideToggle()">☰</div>
    <div id="menu-well">
      <nav><?php render_site_menu(); ?></nav>
    </div>
  </div>
</div>

<main>
  <!-- Remove this if you decide to use page--front.tpl.php  -->
  <?php if ($page_data['template_type'] == 'front') { ?>
    <h1>Welcome to <?php echo $site_data['site_name']; ?></h1>
    
    <?php  
      $content = new Entity();
      $options = array(
        'status' => 'published',
        'type' => 'post',
        'category' => $site_data['blog_path'],
      );
      $content_list = $content->renderEntityList('_data/manifests/content_manifests.json', $options);
      $page_data['list'] = $content->paginate($content_list);
      render_templateList($page_data); 
    ?>
  <?php } ?>
  
  <?php #  This line renders a page overide i.e. page--front.tpl.php ?>
  <?php if (isset($page_content)) { include($page_content); } ?>

  <div class="container">
  <?php #  This line renders the content template, i.e. a post or page. ?>
  <?php if ($page_data['template_type'] == 'content') { ?>
    <article>
      <?php render_templateContent($page_data); ?>
    </article>
  <?php } ?>

  <?php #  This line renders a list page, i.e. blog, tag or category ?>
  <?php if ($page_data['template_type'] == 'list') { ?>
    <?php  render_templateList($page_data); ?>
  <?php } ?>

  <?php # This renders the 404 page. Customize as you see fit. ?>
  <?php if (isset($page_data['status'])) { if ($page_data['status'] == '404') {?>
    <h1>Gratz. You Broke it!</h1>
    <p>It looks like something terrible has happened, and this page no longer exists.</p>
  <?php } } ?>
  </div>
</main>

<footer>
  <div class="container">
    <div class="cc">
      ©<?php echo date('Y') . ' '?><a href="<?php render_baseUrl(); ?>"><?php echo $site_data['site_name']; ?></a>.
    </div>
  </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php render_themeJS('tundra'); ?>
</body>
</html>