<?php

$users = new Route();
$users->setPath('admin/users', function() {

  $category = new Entity();
  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $menu_data = $_POST['user'];
    $menu_data = array_map( 'strtolower', $menu_data ); 
    $category->saveSetting('users.json', $menu_data);
    header("Refresh:0");
  }
  $template = new Template();
  // $template->renderModuleJs('admin/js/user.js');
  $page_data['users'] = $category->readDataFile(SiteInfo::getDataDir() . '/settings/users.json');
  $page_data['assets'] = array(
    '_modules/admin/js/user.js'
  );
  
  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'users.tpl.php');
  include ($template->loadTheme('admin'));
});

?>