<?php
// Unless explicitly set everything is a 404 (will need a dynamic page route)
http_response_code(404);

// Load Classes
include_once('_app/_autoload.php');

// Set install path.
if (is_file('_data/settings/site_info.json')) {
  
  // If install file exisits remove it.
  if (is_file('install.php')) {
    unlink('install.php');
  }
  
  // Load Site Info:
  $site = new SiteInfo();
  $site_data = $site->getSiteData();
  $site_data['session'] = md5($site->baseUrl());

  // Boostrap modules & Hookss
  include_once('_app/_bootstrap.php');

  // 404 Page
  if ((http_response_code() == '404')) {

    $page_data['status'] = '404';
    $override_template = 'page--404.tpl.php';
    $override_file = '_themes/' .   $site_data['front_theme'] . '/' . $override_template;
    if (is_file($override_file)) {
      $page_content = $override_file;
    }

    $theme = new Template();
    include ($theme->loadTheme('main'));
  }

  // Dev Mode, to enable create a file called dev.php in the website root.
  if (file_exists('dev.php')) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(strpos($_SERVER['REQUEST_URI'], 'login') !== false){

      $dev_msg = 'Development mode is on! Remove the dev.php file before going to production.';
      echo '<style>
      .dev-mode {
        position: fixed;
        display: block;
        bottom: 0;
        width: 100%;
        text-align: center;
        padding: .8em;
        background-color: #FFF5F1;
        border-top: 1px solid #FE6D48;
        color: #AC4319;
        font-size: medium;
      }
      </style>';
    
      if (isset($_SESSION[$site_data['session']]['auth']['token'])) {
        echo '<div class="dev-mode">';
        echo '<div>Login Code:<br>' . $_SESSION[$site_data['session']]['auth']['token'] . '</div>';
        echo '<div>' . $dev_msg . '</div></div>';
      }
    }
  }

  // Show admin bar to the top of the page when user is logged in.
  if (isset($_SESSION[$site_data['session']]['template']['admin_bar']) && $_SESSION[$site_data['session']]['template']['admin_bar'] == 'yes') {
    if (strpos($_SERVER['REQUEST_URI'], 'admin') == false) {  
      $admin_bar_data = new Entity();
      // Value defiend in core.module.php
      $page_data = $admin_bar_data->loadEntity($GLOBALS['entity_id']);
      include('_modules/admin/_templates/admin-bar.tpl.php');
    }
  }

} else {
  
  // Load Install File.
  $install = fopen("install.php", "w");
  fwrite($install, file_get_contents('_app/install_config/install.file'));
  fclose($install);
  include($install);
  header('Location:' . SiteInfo::baseUrl() . 'install.php');
}



?>