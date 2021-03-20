<?php
/**
 * The core module is used to do basic route and template rendering.
 */
$theme = new Template();
$site_data = SiteInfo::getSiteData();

// Front Page.
$front_page = new Route();
if ($front_page->getPath() == '') {
  
  // Load override template.
  $override_template = 'page--front.tpl.php';
  $override_file = $site_data['front_theme'] . '/templates/' . $override_template;
  
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
      if ($item['entity_id']) {
        $GLOBALS['entity_id'] = $item['entity_id'];

      }

      // Here we do a check, if there is a page type we show that only if there is no path override.

      $override_page_content = 'page--' . $page_data['meta']['path'] . '.tpl.php';
      $override_page_type = 'page--type--' . $page_data['meta']['category'] . '.tpl.php';

      if (is_file($site_data['front_theme'] . '/templates/' . $override_page_content)) {
        $page_data['template_type'] = 'file';
        $page_content = $site_data['front_theme'] . '/templates/' . $override_page_content;
      } else {
        
        if (is_file($site_data['front_theme'] . '/templates/' . $override_page_type)) {
          $page_data['template_type'] = 'file';
          $page_content = $site_data['front_theme'] . '/templates/' . $override_page_type;
        }
      
      }

      http_response_code(200);
      include ($theme->loadTheme('main'));
    }
  }
}

// This renders a content list, i.e. blog index or category index.
$content_list_data = SiteInfo::getSiteContentListData();
foreach ($content_list_data as $list_page) {

  $category = new Route();
  $category->setPath($list_page['path'], function() {

    $site_info = new SiteInfo();
    $site_data = $site_info->getSiteData();
    $theme = new Template();
    $content = new Entity();
    $query = new Route();

    $path_data = $site_info->getSiteContentListData();

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
    $page_data['items'] = $content->paginate($content_list);
    $page_data['template_type'] = 'list';
    $page_data['title'] = ucfirst($path['name']);
    $page_data['pagination_num'] = $query->getQuery('pg');
    $page_data['base_url'] = $theme->baseUrl() . $path['path'] .'?';
  
    // Load override template.
    $override_template = 'page--' . $path['path'] . '.tpl.php';
    $override_file = $site_data['front_theme'] . '/templates/' . $override_template;
    if (is_file($override_file)) {
      $page_content = $override_file;
    }
  
    http_response_code(200);
    include ($theme->loadTheme('main'));

  });
}

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
