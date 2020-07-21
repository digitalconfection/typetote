<?php
// Change this to 0 on production!
$dev_mode = 0;

// Dev Dumps:
error_reporting(0);

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
  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();

  // Boostrap modules & Hookss
  include_once('_app/_bootstrap.php');

} else {
  
  // Load Install File.
  $install = fopen("install.php", "w");
  fwrite($install, file_get_contents('_app/install_config/install.file'));
  fclose($install);
  include($install);
  header('Location:' . SiteInfo::baseUrl() . 'install.php');
}


// 404 Page
if ((http_response_code() == '404')) {

  $page_data['status'] = '404';
  $override_template = 'page--404.tpl.php';
  $override_file = '_themes/' .   $GLOBALS['main_theme'] . '/' . $override_template;
  if (is_file($override_file)) {
    $page_content = $override_file;
  }

  $theme = new Template();
  include ($theme->loadTheme('main'));
}

// Dev Mode.
if ($dev_mode == 1) {
  
  if(strpos($_SERVER['REQUEST_URI'], 'login') !== false){

    $dev_msg = 'Development mode is on! Change it in the index.php file before going to production.';
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

    if ($_SESSION['auth']['login_token']) {
      echo '<div class="dev-mode">';
      echo '<div>Login Code:<br>' . $_SESSION['auth']['login_token'] . '</div>';
      echo '<div>' . $dev_msg . '</div></div>';
    }
  }
}

?>