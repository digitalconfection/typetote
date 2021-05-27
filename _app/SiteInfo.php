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

  // Method used to get site data.
  public static function getSiteData() {
    
    $data = Entity::readDataFile('_data/settings/site_info.json');
    return $data;
  }

  // This method gets the list of site categories that build the index pages.
  public static function getSiteContentListData() {
    $site_data = Entity::readDataFile('_data/settings/site_info.json');
    $site_blog = array(array('name' => $site_data['blog_name'], 'path' => $site_data['blog_path']));

    $categories = Entity::readDataFile('_data/settings/category.json');
    if (!empty($categories)) {
      return array_merge($site_blog, $categories);
    } else  {
      return $site_blog;
    }
  }

  // This method is used to check if a file multistie.php is created.
  // If its created set the data dir for either a single site or a multistie.
  public static function getDataDir() {

    if (file_exists('multisite.php')) {

      $data_dir = '_data/' . $_SERVER['HTTP_HOST'];

    }
    else {
      $data_dir = '_data';
    }

    return $data_dir;

  }

}