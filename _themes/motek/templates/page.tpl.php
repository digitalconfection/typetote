<!DOCTYPE html>
<html lang="en">
<head>
<title><?php render_siteTitle($page_data); ?></title>
  <meta name="description" content="<?php render_siteDescription($page_data); ?>">
  <?php render_themeCSS('motek'); ?>
  <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700|Nunito" rel="stylesheet">
  <?php render_templateMetaHead($page_data); ?>
</head>
<body>

<!-- Renders the site banner. -->
<?php render_site_banner()?>

<nav>
  <div class="container">
    <div class="nav-well">
      <div>
        <a href="" class="logo"><?php echo $site_data['site_name']; ?></a>
      </div>
      <div class="menu">
        <div id="menu-icon" onclick="slideToggle()">☰</div>
        <div id="menu-well">
          <?php render_site_menu(); ?>
          <a href="<?php render_baseUrl(); ?>search" class="search-icon">⌕</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="well">
<div class="container">
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

    <!-- This line renders a page overide i.e. page--front.tpl.php -->
    <?php if (isset($page_content)) { include($page_content); } ?>
  
    <!-- This line renders the content template, i.e. a post or page. -->
    <?php if ($page_data['template_type'] == 'content') { ?>
      <?php render_templateContent($page_data); ?>
    <?php } ?>

    <!-- This line renders a list page, i.e. blog, tag or category -->
    <?php if ($page_data['template_type'] == 'list') { ?>
      <?php  render_templateList($page_data); ?>
    <?php } ?>

    <!-- This renders the 404 page. Customize as you see fit. -->
    <?php if (isset($page_data['status'])) { if ($page_data['status'] == '404') {?>
      <h1>Gratz. You Broke it!</h1>
      <p>It looks like something terrible has happened, and this page no longer exists.</p>
    <?php } } ?>

  </main>

  <footer>
    <div class="cc">
      <span class="l">©<?php echo date('Y') . ' ' .$site_data['site_name']; ?></span><br>
      Proudly built with <a href="https://typetote.com">TypeTote</a>.
    </div>
  </footer>
  </div>
</div>

<div class="wave"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php render_themeJS('motek'); ?>
</body>
</html>