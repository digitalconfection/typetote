<?php
/**
 * core.hooks.php 
 * This file is processed after classes and before the module files.
 * This primarily used for short coding template renders, from the $page_data attribute.
 */

// Render a list of content. Used for summaries.
function render_templateList($page_data) {
  include('_templates/template-list.tpl.php');
}

// Render content used for pages and posts. 
function render_templateContent($page_data) {
  include('_templates/template-content.tpl.php');
}



// Render the meta head items.
function render_templateMetaHead($page_data){
  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();

  if (isset($page_data['meta']['featured_image'])) {
    $fb_og = $page_data['meta']['featured_image'];
    $twitter_og = $page_data['meta']['featured_image'];
  } else {
    $fb_og = $site_info->baseUrl() . '_themes/'. $site_data['front_theme'] . '/img/og_facebook.png';
    $twitter_og = $site_info->baseUrl() . '_themes/'. $site_data['front_theme'] . '/img/og_twitter.png';

  }

  include('_templates/meta_head.tpl.php');
}

// Render ThemeJS
function render_themeJS() {

  $theme = (array)SiteInfo::getSiteData()['front_theme'];
  $file = '_themes/'. $theme[0] .'/css/script.js';
  
  if (file_exists($file)) {
    echo '<script src="' . SiteInfo::baseUrl(). $file .'" type="text/javascript"></script>';
    
  }
}

// Render ThemeCSS
function render_themeCSS() {
  $theme = (array)SiteInfo::getSiteData()['front_theme'];
  $file = '_themes/'. $theme[0] .'/css/style.css';
  
  if (file_exists($file)) {
    echo '<link rel="stylesheet" type="text/css" href="'. SiteInfo::baseUrl(). $file .'">';
  }
}

// Function to render menu on tempalte.
function render_siteMenu() {
  
  $menu = new Entity();
  $menu_data = $menu->readDataFile('_data/settings/menu.json');
  include('_templates/site_menu.tpl.php');
}

// Render blocks
function render_block($name) {

  $block_data = new Entity();
  $block_file = '_data/blocks/block_' . $name . '.json';
  $block = $block_data->readDataFile($block_file);

  echo $block['body'];
}

// Site Banner
function render_siteBanner() {
  $site_banner = new Entity();
  $data = $site_banner->readDataFile('_data/settings/site_banner.json');
  include('_templates/site-banner.tpl.php');
}

// Function used to render tag data from comma value.
function renderTags($tag_data) {

  if ($tag_data) {
    $tag_objects = explode(', ', $tag_data);
    echo '<div class="tags"><ul>';
    foreach ($tag_objects as $tag) {

      // For last item remove comma.
      if ($tag == end( $tag_objects )) {
        echo '<li><a href="' . SiteInfo::baseUrl() .'tags?q='. $tag . '">' . ucfirst($tag) . '</a></li>';
      } else {
        echo '<li><a href="' . SiteInfo::baseUrl() .'tags?q='. $tag . '">' . ucfirst($tag) . '</a>,</li>';
      }
    }
    echo '</ul></div>';
  }
}

// Render title for template.
function render_siteTitle($page_data ) {
  global $site_data;
  if(isset($page_data['title'])) { echo $page_data['title'] . ' - '; } else { if( isset($site_data['site_slogan'])){ echo $site_data['site_slogan'] . ' - '; } }?><?php echo $site_data['site_name'];
}

// Render site Description
function render_siteDescription($page_data) {
  global $site_data;
  if(isset($page_data['data']['summary'])){ echo $page_data['data']['summary']; } else { echo $site_data['site_description']; }
}

// Render Base Url
function render_baseUrl() {
  $url = new SiteInfo();
  echo $url->baseUrl();
}

// Render GA
function render_ga() {

  $site_info =  new SiteInfo();
  $ga = $site_info->getSiteData()['ga_ua_code'];
  if ($ga) {
    echo '<script>window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "'. $site_info->getSiteData()['ga_ua_code'] .'");</script>';
  }
}

?>
