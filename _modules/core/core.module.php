<?php
/**
 * The core module is used to do basic route and template rendering.
 */
$theme = new Template();
$site_info = new Entity();
$site_data = $site_info->readDataFile('_data/settings/site_info.json');

// Front Page.
$front_page = new Route();
if ($front_page->getPath() == '') {
  
  // Load override template.
  $override_template = 'page--front.tpl.php';
  $override_file = '_themes/' .   $site_data['front_theme'] . '/templates/' . $override_template;
  
  if (is_file($override_file)) {
    $page_data['template_type'] = 'file';
    $page_content = $override_file;
  }
  
  $page_data['template_type'] = 'front';
  http_response_code(200);
  include ($theme->loadTheme('main'));
}

// Content page.
$path = new Route();
$template = new Template();
$content = new Entity();
$manifest = $content->readDataFile('_data/manifests/content_manifests.json');

if (!empty($manifest)){
  foreach ($manifest as $item)
  {
    if ($path->getPath() == $item['path'] && $path->getPath() !== '')
    {

      // Get and build $page_data array.
      $page_data = $content->loadEntity($item['entity_id']);
      $page_data['template_type'] = 'content';

      // This is for the admin bar to call the data.
      $GLOBALS['entity_id'] = $item['entity_id'];

      $override_template = 'page--' . $page_data['meta']['path'] . '.tpl.php';
      $override_file = '_themes/' .   $site_data['front_theme'] . '/templates/' . $override_template;

      if (is_file($override_file)) {
        $page_data['template_type'] = 'file';
        $page_content = $override_file;
      }

      http_response_code(200);
      include ($theme->loadTheme('main'));
    }
  }
}

// Category Listing
$categories = $site_info->readDataFile('_data/settings/category.json');
if (is_array($categories)) {

  foreach ($categories as $category_page) {

    $category = new Route();
    $category->setPath($category_page['path'], function() {

      $site_info = new SiteInfo();
      $site_data = $site_info->getSiteData();
      $theme = new Template();
      $content = new Entity();
      $query = new Route();

      $path_data = $content->readDataFile('_data/settings/category.json');

      $path = array();
      foreach ($path_data as $item) {
        if ($item['path'] == $query->getPathName()) {
          $path['name'] = $item['name'];
          $path['path'] = $item['path'];
        }
      }
           
      $options = array(
        'status' => 'published',
        'type' => 'post',
        'category' => $path['path'],
      );
      $content_list = $content->renderEntityList('_data/manifests/content_manifests.json', $options);
      $page_data['list'] = $content->paginate($content_list);
      $page_data['template_type'] = 'list';
      $page_data['title'] = ucfirst($path['name']);
      $page_data['pagination_num'] = $query->getQuery('pg');
      $page_data['base_url'] = $theme->baseUrl() . $path['path'] .'?';
    
      // Load override template.
      $override_template = 'page--' . $path['path'] . '.tpl.php';
      $override_file = '_themes/' .   $site_data['front_theme'] . '/tempaltes/' . $override_template;
      if (is_file($override_file)) {
        $page_content = $override_file;
      }
    
      http_response_code(200);
      include ($theme->loadTheme('main'));

    });
  }
}

// Blog Index Page
$blog = new Route();
$blog->setPath($site_data['blog_path'], function() {

  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();
  $theme = new Template();
  $content = new Entity();
  $query = new Route();

  $options = array(
    'status' => 'published',
    'type' => 'post',
    'category' => $site_data['blog_path'],
  );
  $content_list = $content->renderEntityList('_data/manifests/content_manifests.json', $options);
  $page_data['list'] = $content->paginate($content_list);
  $page_data['template_type'] = 'list';
  $page_data['title'] = ucfirst($site_data['blog_name']);
  $page_data['pagination_num'] = $query->getQuery('pg');
  $page_data['base_url'] = $theme->baseUrl() . $site_data['blog_name'] .'?';

  // Load override template.
  $override_template = 'page--' . $site_data['blog_name'] . '.tpl.php';
  $override_file = '_themes/' .   $site_data['front_theme'] . '/tempaltes/' . $override_template;
  if (is_file($override_file)) {
    $page_content = $override_file;
  }

  http_response_code(200);
  include ($theme->loadTheme('main'));
});

// Tags
$tags = new Route();
$tags->setQueryPath('tags', function() {

  $site_info = new SiteInfo();
  $site_data = $site_info->getSiteData();
  $template = new Template();

  $query = new Route();
  $tag_data = new Entity();
  $options = array(
    'status' => 'published'
  );
  $raw_data = $tag_data->renderEntityList('_data/manifests/content_manifests.json',  $options);

  $tag_results = array();
  foreach ($raw_data as $tag) {

    $tags = strtolower($tag['meta']['tags']);
    $query_term = strtolower($query->getQuery('q'));

    if(strpos($tags, $query_term) !== false) {
     $tag_results[] = $tag;
    }
  }

  // If tag results are not empty render page.
  if (!empty($tag_results)) {
    $page_data['list'] = $tag_data->paginate($tag_results);

    $page_data['template_type'] = 'list';
    $page_data['base_url'] = $template->baseUrl() . 'tags?q=' . $query->getQuery('q');
    $page_data['pagination_num'] = $query->getQuery('pg');
    $page_data['title'] = 'Tag: ' . ucwords($query->getQuery('q'));

    include ($template->loadTheme('main'));
  }
  else {
    http_response_code(404);
  }
});

?>