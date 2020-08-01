<?php

class SiteInfo {

// Method to get site data.

  // Get Base Url.
  public static function baseUrl() {

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $dir = basename(dirname($_SERVER['PHP_SELF']));
    if ($dir == null) {
      return $protocol . $_SERVER['SERVER_NAME'] . '/';
    }
    else {
      return $protocol . $_SERVER['SERVER_NAME'] . '/' . $dir . '/';
    }
  }

  public static function getSiteData() {
    
    $data = Entity::readDataFile('_data/settings/site_info.json');
    return $data;
  }

}