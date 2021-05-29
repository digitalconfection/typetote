<?php

// When user vists: /admin
$admin_content = new Route();
$admin_content->setPath('admin', function() {
  
  $content = new Entity();
  $template = new Template();
  $query = new Route();

  $page_content = $template->renderTemplateFile('_modules/admin', 'dashboard.tpl.php');
  $page_data['pagination_num'] = $query->getQuery('pg');
  $page_data['base_url'] = SiteInfo::baseUrl() . 'admin?q=' . $query->getQuery('q');

  if ($query->getQuery('q') == 'posts') {
    
    $page_data['sort'] = 'Post';
    if (is_file(SiteInfo::getDataDir() . '/manifests/content_manifests.json')) {
      $options = array('type' => 'post');
      $page_data['items'] = $content->paginate($content->renderEntityList(SiteInfo::getDataDir() . '/manifests/content_manifests.json', $options));
    }

  } else if ($query->getQuery('q') == 'pages') {
    
    $page_data['sort'] = 'Page';
    if (is_file(SiteInfo::getDataDir() . '/manifests/content_manifests.json')) {
      $options = array('type' => 'page');
      $page_data['items'] = $content->paginate($content->renderEntityList(SiteInfo::getDataDir() . '/manifests/content_manifests.json', $options)); 
    }

  } else if ($query->getQuery('q') == 'blocks') {
    
    $page_data['sort'] = 'Block';
    if (is_file(SiteInfo::getDataDir() . '/manifests/block_manifests.json')) {
      $page_data['items'] = $content->paginate($content->renderEntityList(SiteInfo::getDataDir() . '/manifests/block_manifests.json'));
    }
  
  } else { 
    $page_data['items'] = $content->paginate($content->renderEntityList(SiteInfo::getDataDir() . '/manifests/content_manifests.json'));
    $page_data['sort'] = 'All';
  }

  $page_data['utility_page'] = 'no';
  include ($template->loadTheme('admin'));
});

// When user vists: /admin/post
$admin_create = new Route();
$admin_create->setPath('admin/post', function() {
  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $path = new Route();
    $content = new Entity();
    // Adjust publish date.
    $_POST['entity']['meta']['date_published'] =  date('m') . '/' . date('d') .'/' . date('Y') ; // Intial Creation Date
    
    $content->saveEntity($_POST['entity']);
    header("Refresh:0");

  }

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-form.tpl.php');

  $page_data['assets'] = array(
    '_modules/admin/js/quill.min.js',
    '_modules/admin/_theme/css/quill.snow.css',
    '_modules/admin/js/file.js',
    '_modules/admin/js/publish.js'
  );

  include ($template->loadTheme('admin'));
});

// To edit content. admin/edit?q=[id]
$admin_edit = new Route();
$admin_edit->setQueryPath('admin/edit', function() {
  $path = new Route();
  $content = new Entity();
  
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    // Edit date
    $_POST['entity']['meta']['date_edited'] =  date('m') . '/' . date('d') .'/' . date('Y') ; // Intial Creation Date
    $content->saveEntity($_POST['entity']);
    header("Refresh:0");
  }

  // These might have to be file varibles that we then pass to thte theme.
  $template = new Template();
  $page_data = $content->loadEntity($path->getQueryPath());
  $page_data['base_url'] = SiteInfo::baseUrl();
  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-form.tpl.php');

  $page_data['assets'] = array(
    '_modules/admin/js/quill.min.js',
    '_modules/admin/_theme/css/quill.snow.css',
    '_modules/admin/js/file.js',
    '_modules/admin/js/publish.js'
  );

  include ($template->loadTheme('admin'));
});

// to delete content.
$admin_delete = new Route();
$admin_delete->setQueryPath('admin/delete', function() {
  $id = new Route();
  $path = new Route();
  $content = new Entity();
  $template = new Template();

  if (isset($_POST['yes'])) {
    // Media, check if this is a possible media asset. 
    $media_check = basename($_SERVER['REQUEST_URI']);
    $media_check = str_replace('delete?q=', '', $media_check);
    if (is_file(SiteInfo::getDataDir() . '/files/'. $media_check)) {
      $content->deleteEntity($media_check);
      $path->goToPath('admin/media');
    }
    else {
      $content->deleteEntity($id->getQueryPath());
    }
  }

  $page_data = $content->loadEntity($id->getQueryPath());
  $page_data['base_url'] = SiteInfo::baseUrl();

  if (isset($_POST['no'])) {
    // If no title is found then its a media asset.
    if (!isset($page_data['title'])) {
      $path->goToPath('admin/media');
    } else {
      $path->goToPath('admin');
    }
  }
  
  if (!isset($page_data['title'])) {
    $page_data['title'] = $id->getQueryPath();
  }

  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-delete-form.tpl.php');
  include ($template->loadTheme('admin'));
});

// When user visits: /admin/category
$admin_category = new Route();
$admin_category->setPath('admin/category', function() {
  
  $category = new Entity();
  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $menu_data = $_POST['cat'];
    asort($menu_data);
    $category->saveSetting('category.json', $menu_data);
    header("Refresh:0");
  }
  
  $page_data['categroy'] = $category->readDataFile(SiteInfo::getDataDir() . '/settings/category.json');
  $page_data['assets'] = array(
    '_modules/admin/js/category.js'
  );

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'category-form.tpl.php');
  include ($template->loadTheme('admin'));
});

// When user vists: /admin/menus
$admin_menus = new Route();
$admin_menus->setPath('admin/menu', function() {
  $menu = new Entity();
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $menu_data = $_POST['menu'];
    usort($menu_data, function($a, $b) {
      return $a['weight'] <=> $b['weight'];
    });
    $menu->saveSetting('menu.json', $menu_data);
    header("Refresh:0");
  }

  $page_data['menu'] = $menu->readDataFile(SiteInfo::getDataDir() . '/settings/menu.json');
  $page_data['assets'] = array(
    '_modules/admin/js/menu.js'
  );
  
  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'menu-form.tpl.php');
  include ($template->loadTheme('admin'));
});

// When user visits: /admin/site-banner
$site_banner = new Route();
$site_banner->setPath('admin/site-banner', function() {
  
  $site_banner = new Entity();
  // on save create a file in data called site banner.
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $_POST['entity']['body'] = strip_tags($_POST['entity']['body'], '<a>');

    $site_banner->saveSetting('site_banner.json', $_POST['entity']);
    header("Refresh:0");
  }

  $page_data = $site_banner->readDataFile(SiteInfo::getDataDir() . '/settings/site_banner.json');
  $page_data['assets'] = array(
    '_modules/admin/js/quill.min.js',
    '_modules/admin/_theme/css/quill.snow.css',
    '_modules/admin/js/file.js',
    '_modules/admin/js/publish.js'
  );

  if (isset($page_data['body'])) {
    $page_data['body'] = htmlspecialchars_decode($page_data['body']);
  }
  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'site-banner.tpl.php');

  include ($template->loadTheme('admin'));
});

// Load Admin Media Routes
include '_inc/media.inc';

// When user visits: /admin/users
include '_inc/users.inc';

// When user vists: /admin/settings
include '_inc/settings.inc';

?>