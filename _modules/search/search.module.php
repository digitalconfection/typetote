<?php

$search_results = new Route();
$search_results->setPath('search', function() {

  $query = new Route();
  $search_data = new Entity();
  $template = new Template();
  $options = array(
    'status' => 'published'
  );
  $raw_data = $search_data->renderEntityList('_data/manifests/content_manifests.json', $options);

  if ($raw_data) {
    $search_array = array();
    foreach ($raw_data as $data) {

      $i['title'] = strtolower($data['title']);
      $i['body'] = strtolower($data['body']);
      $i['summery'] = strtolower($data['summery']);
      $i['link'] = strtolower($data['meta']['path']);
      $i['tags'] = strtolower($data['meta']['tags']);

      $search_array[] = $i;
    }

    $search_results = array();
    $term = strtolower($query->getQuery('q'));

    if (!empty($term)) {
      foreach($search_array as $result){

        if (strpos($result['title'], $term) !== false or strpos($result['body'], $term) !== false){

          $search_results[] = $result;
          $page_data['status'] = 'yes';

        } else {

          $page_data['status'] = 'no';
        }
      }
    }
    
  }

  // If $search_results is not empty, return as $page_data for template rendering.
  $page_data['query'] = $query->getQuery('q');
  if (!empty($search_results)) {
    $page_data['results'] = $search_data->paginate($search_results);
    $page_data['status'] = 'yes';
  } else {
    $page_data['status'] = 'no';
  }

  $site_info = new SiteInfo;
  $site_data = $site_info->getSiteData();
  if ($page_data['query']) {
    $page_data['title'] = $page_data['query'];
  }
  else {
    $page_data['title'] = 'Search';
  }
  $page_data['pagination_num'] = $query->getQuery('pg');
  $page_data['base_url'] = SiteInfo::baseUrl() . 'search?q=' . $query->getQuery('q');

  $page_content = $template->renderTemplateFile('_modules/search', 'search-page.tpl.php');
  include ($template->loadTheme('main'));

});
?>