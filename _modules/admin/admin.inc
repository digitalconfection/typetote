<?php

// When user vists: /admin
$admin_content = new Route();
$admin_content->setPath('admin', function() {
  
  $content = new Entity();
  $template = new Template();
  $query = new Route();

  $page_content = $template->renderTemplateFile('_modules/admin', 'dashboard.tpl.php');
  $page_data['pagination_num'] = $query->getQuery('pg');
  $page_data['base_url'] = $template->baseUrl() . 'admin?q=' . $query->getQuery('q');

  if ($query->getQuery('q') == 'posts') {
    
    $page_data['sort'] = 'Post';
    if (is_file('_data/manifests/content_manifests.json')) {
      $options = array('type' => 'post');
      $page_data['items'] = $content->paginate($content->renderEntityList('_data/manifests/content_manifests.json', $options));
    }

  } else if ($query->getQuery('q') == 'pages') {
    
    $page_data['sort'] = 'Page';
    if (is_file('_data/manifests/content_manifests.json')) {
      $options = array('type' => 'page');
      $page_data['items'] = $content->paginate($content->renderEntityList('_data/manifests/content_manifests.json', $options)); 
    }

  } else if ($query->getQuery('q') == 'blocks') {
    
    $page_data['sort'] = 'Block';
    if (is_file('_data/manifests/block_manifests.json')) {
      $page_data['items'] = $content->paginate($content->renderEntityList('_data/manifests/block_manifests.json'));
    }
  
  } else {
  
    $page_data['items'] = $content->paginate($content->renderEntityList('_data/manifests/content_manifests.json'));
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
  }

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-form.tpl.php');
  $template->renderModuleJs('admin/js/file.js');
  $template->renderModuleJs('admin/js/publish.js');
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
  }

  // These might have to be file varibles that we then pass to thte theme.
  $template = new Template();
  $page_data = $content->loadEntity($path->getQueryPath());
  $page_data['base_url'] = $template->baseUrl();
  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-form.tpl.php');

  $template->renderModuleJs('admin/js/file.js');
  $template->renderModuleJs('admin/js/publish.js');
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
    if (is_file('_data/files/'. $media_check)) {
      $content->deleteEntity($media_check);
      $path->goToPath('admin/media');
    }
    else {
      $content->deleteEntity($id->getQueryPath());
    }
  }

  if (isset($_POST['no'])) {
    $path->goToPath('admin');
  }
  
  $page_data = $content->loadEntity($id->getQueryPath());
  $page_data['base_url'] = $template->baseUrl();
  $page_content = $template->renderTemplateFile('_modules/admin', 'entity-delete-form.tpl.php');
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
  }

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'menu-form.tpl.php');
  $page_data = $menu->readDataFile('_data/settings/menu.json');
  $template->renderModuleJs('admin/js/menu.js');
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
  }
  $template = new Template();
  $template->renderModuleJs('admin/js/category.js');
  $page_content = $template->renderTemplateFile('_modules/admin', 'category-form.tpl.php');
  $page_data = $category->readDataFile('_data/settings/category.json');
  include ($template->loadTheme('admin'));

});

// When user vists: /admin/media (main media page)
$admin_menus = new Route();
$admin_menus->setPath('admin/media', function() {

  $file = new Media();
  $template = new Template();
  $template->renderModuleJs('admin/js/file.js');
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-browser.tpl.php');
  $page_data['files'] = $file->browse_files();
  $page_data['url'] = $template->baseUrl();
  $page_data['embeded'] = 'no';

  include ($template->loadTheme('admin'));

});

// Media browser
$file_upload = new Route();
$file_upload->setPath('admin/media/browser', function() {

  $file = new Media();
  $template = new Template();
  $template->renderModuleJs('admin/js/file.js');
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-browser.tpl.php');
  $page_data['files'] = $file->browse_files();
  $page_data['url'] = $template->baseUrl();
  $page_data['embeded'] = 'yes';

  $page_data['utility_page'] = 'yes';
  include ($template->loadTheme('admin'));
});

// When user vists: /admin/media/upload
$file_upload = new Route();
$file_upload->setPath('admin/media/upload', function() {

  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $file = new Media();
    echo ($file->upload());
  };

  $template = new Template();
  $template->renderModuleJs('admin/js/file.js');
  $page_data['utility_page'] = 'yes';
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-upload.tpl.php');

  $page_data['utility_page'] = 'yes';
  include ($template->loadTheme('admin'));
});

// When user vists: /admin/settings
$admin_settings = new Route();
$admin_settings->setPath('admin/settings', function() {

  $site_info = new Entity();
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $site_info_data = $_POST;

    // Format to lowercase / Machine Names
    $site_info_data['admin_email'] = strtolower($_POST['admin_email']);
    $site_info_data['blog_name'] = $_POST['blog_name'];
    $blog_path = strtolower($site_info_data['blog_name']);
    $site_info_data['sec_key_1'] = password_hash($_POST['sec_key_1'], PASSWORD_DEFAULT);
    $site_info_data['sec_key_2'] = password_hash($_POST['sec_key_2'], PASSWORD_DEFAULT);
    $site_info_data['blog_path'] = str_replace(' ', '-', $blog_path);
    $site_info->saveSetting('site_info.json', $site_info_data);
  }

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'site-settings-form.tpl.php');
  $page_data = $site_info->readDataFile('_data/settings/site_info.json');
  include ($template->loadTheme('admin'));
});

// When user visits: /admin/site-banner
$site_banner = new Route();
$site_banner->setPath('admin/site-banner', function() {
  
  $site_banner = new Entity();
  // on save create a file in data called site banner.
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $site_banner_data = $_POST['entity'];
    $site_banner->saveSetting('site_banner.json', $site_banner_data);
  }

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'site-banner.tpl.php');
  $page_data = $site_banner->readDataFile('_data/settings/site_banner.json');

  $template->renderModuleJs('admin/js/publish.js');
  $template->renderModuleJs('admin/js/file.js');
  include ($template->loadTheme('admin'));
});


?>