<?php 

function checkIfAdmin() {
  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();
  return $site_data['admin_email'] == $_SESSION[array_keys($_SESSION)[0]]['auth']['user'];
}

// How to render module and external assets.
function renderAssets($page_data) {

  $site = new SiteInfo();
  if (isset($page_data['assets'])) {
    foreach ($page_data['assets'] as $key => $asset) {

      if (strpos($asset, '_modules/') !== false) {
  
        if (strpos($asset, '.css') !== false) {
          echo '<link href="' . $site->baseUrl() . $asset . '" rel="stylesheet">'. PHP_EOL;
        }
    
        if (strpos($asset, '.js') !== false) {
          echo '<script src="' . $site->baseUrl() . $asset . '" type="text/javascript" async></script>'. PHP_EOL;
        }
      } else {

        // For extneral listed assets.
        if (strpos($asset, '.css') !== false) {
          echo '<link href="' . $asset . '" rel="stylesheet">'. PHP_EOL;
        }
    
        if (strpos($asset, '.js') !== false) {
          echo '<script src="' . $asset . '"></script>'. PHP_EOL;
        }

      }
    }
  }

}

?>