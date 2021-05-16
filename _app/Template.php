<?php

class Template {

  public $theme;
  // public $page_content;

  // Set base Url
  // public function baseUrl()
  // {
  //   $dir = getcwd();
  //   $base_dir = substr($dir, strrpos($dir, '/') + 1);
  //   return '//' . $_SERVER['SERVER_NAME'] . '/' . $base_dir . '/';
  // }

  // Basic method to define and set the type of template to load.
  public function loadTheme($var) {

    $site = new SiteInfo();
    
    if ($var == 'admin') {
      return '_modules/admin/_theme/page.tpl.php';
    }
    if ($var == 'main') {

      if (isset($site->getSiteData()['headless']) && $site->getSiteData()['headless'] == 'enabled') {

        return '_modules/core/_templates/headless.tpl.php'; 

      } else {
        return $site->getSiteData()['front_theme'] . '/templates/' .'page.tpl.php';
      }

    }
  }

  // Render template file.
  public function renderTemplateFile($dir, $file)
  {
    return $dir . '/_templates/' . $file;
  }

  // Template override to load custom tpl file
  public function override($file_name, $theme)
  {
    return 'themes/' . $theme . '/' . $file_name . '.tpl.php';
  }
  
  public static function decodeTag($tag) {

    // First we take the tag and remove the dashes.
    $decoded_tag = str_replace('-', ' ', $tag);

    // Return text and make first letters upprecase.
    return ucwords($decoded_tag);

  }

}