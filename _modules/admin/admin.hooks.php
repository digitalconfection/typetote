<?php 

function checkIfAdmin() {
  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();
  return $site_data['admin_email'] == $_SESSION[array_keys($_SESSION)[0]]['auth']['user'];
}

// Function to render JS files from modules for the admin.
function renderAssetsJS($page_data) {
  $site = new SiteInfo();
  if (isset($page_data['assets'])) {
    foreach ($page_data['assets'] as $asset) {
      if (strpos($asset, '.js') !== false) {
        echo '<script src="' . $site->baseUrl() . $asset . '" type="text/javascript" async></script>'. PHP_EOL;
      }
    }
  }
}

// Function to render CSS files from modules for the admin.
function renderAssetsCSS($page_data) {
  $site = new SiteInfo();
  if (isset($page_data['assets'])) {
    foreach ($page_data['assets'] as $asset) {
        if (strpos($asset, '.css') !== false) {
          echo '<link href="' . $site->baseUrl() . $asset . '" rel="stylesheet">'. PHP_EOL;
        }
      }
    }
}




?>