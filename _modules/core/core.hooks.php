<?php
/**
 * core.hooks.php 
 * This file is processed after classes and before the module files.
 * This primarily used for short coding template renders, from the $page_data attribute.
 */

// Render a list of content. Used for summaries.
function render_templateList($page_data, $no_title = null, $no_description = null) {
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
  $path = new Route();
  
  if (isset($page_data['meta']['featured_image'])) {
    $fb_og = $page_data['meta']['featured_image'];
    $twitter_og = $page_data['meta']['featured_image'];
  } else {
    $fb_og = $site_info->baseUrl() . $site_data['front_theme'] . '/img/og_facebook.png';
    $twitter_og = $site_info->baseUrl() . $site_data['front_theme'] . '/img/og_twitter.png';
  }

  $canonical = $site_info->baseUrl() . $path->getPath();
  include('_templates/meta_head.tpl.php');
}

// Render ThemeJS
function render_themeJS() {

  $theme = (array)SiteInfo::getSiteData()['front_theme'];
  $file = $theme[0] .'/js/script.js';
  
  if (file_exists($file)) {
    echo '<script src="' . SiteInfo::baseUrl(). $file .'" type="text/javascript"></script>';
  }
}

// Render ThemeCSS
function render_themeCSS() {
  $theme = (array)SiteInfo::getSiteData()['front_theme'];
  $file = $theme[0] .'/css/style.css';
  
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
  $data['body'] = htmlspecialchars_decode($data['body']);
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
        echo '<li><a href="' . SiteInfo::baseUrl() .'tags?q='. $tag . '">' . Template::decodeTag($tag) . '</a></li>';
      } else {
        echo '<li><a href="' . SiteInfo::baseUrl() .'tags?q='. $tag . '">' . Template::decodeTag($tag) . '</a>,</li>';
      }
    }
    echo '</ul></div>';
  }
}

// Function to render a category link.
function renderCategoryLink($data) {
  echo '<div class="category"><a href="' . SiteInfo::baseUrl() . $data . '">' . Template::decodeTag($data) . '</a></div>';
}

function renderBodyClass() {
  $path = new Route();

  if ($path->getPath() == '') {
    $class = 'home';
  } else {
    $class = str_replace('/', '-', $path->getPath());
  }
  return $class;
}

// Render title for template.
function render_siteTitle($page_data) {
  global $site_data;
  if(isset($page_data['title'])) { echo $page_data['title'] . ' - '; } else { if( isset($site_data['site_slogan'])){ echo $site_data['site_slogan'] . ' - '; } }?><?php echo $site_data['site_name'];
}

// Render site Description
function render_siteDescription($page_data) {
  global $site_data;
  $path = new Route();
  if(isset($page_data['summary'])){ 
    echo $page_data['summary']; 
  }

  else if (!empty($page_data['cat_description'])) {
    echo $page_data['cat_description']; 
  }

  else if ($path->getPath() == $site_data['blog_path'] && !empty($site_data['blog_description'])) {
    echo $site_data['blog_description']; 
  }
  else { echo $site_data['site_description']; }
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

// Render Breadcrumbs
function render_breadcrumbs($homelink = null) {
  
  $site_info =  new SiteInfo();
  $dir = basename(dirname($_SERVER['PHP_SELF']));

  if ($dir) {
    $breadcrumbs = ltrim($_SERVER['REQUEST_URI'], '/');
  } else {
    $breadcrumbs = $_SERVER['REQUEST_URI'];
  }
  
  $links = explode('/', $breadcrumbs);
  $length = count($links);
  $x = 1;

  if ($homelink !== null) {
    $first_breadcrumb = $homelink;
  } else {
    $first_breadcrumb = 'Home';
  }

  $links[0] = '';
  $page = new Route();

  // Only show if not on homepage.
  if ($page->getPath() !== '' xor http_response_code() == '404' xor strpos($page->getPath(), 'tag') !== false) {

    echo '<br><div class="breadcrumbs"><ol>';
      foreach ($links as $key => $link) {

        $link_text = str_replace('-', ' ', $link);

        if ($key == 0) {
          echo '<li><a href="'.  $site_info->baseUrl() . '">'. ucfirst($first_breadcrumb) .'</a></li>';
        } else if ($x === $length) {

          echo '<li>' . ucwords($link_text) . '</li>';
        } 
        else {
          echo '<li><a href="'.  $site_info->baseUrl() . $link .'">' . ucfirst($link_text) . '</a></li>';
        }
        $x++;
      }
    echo '</ol></div>';
  }

}

?>
