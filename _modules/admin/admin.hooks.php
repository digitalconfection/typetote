<?php 

function checkIfAdmin() {
  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();
  return $site_data['admin_email'] == $_SESSION[array_keys($_SESSION)[0]]['auth']['user'];
}

?>