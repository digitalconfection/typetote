<?php

class Entity
{

  private $entity_dir = 'content';
  private $manifests_dir = 'manifests';
  private $settings_dir = 'settings';
  private $blocks_dir = 'blocks';

  public function createFile($path, $data) {
    $file = fopen($path, 'w+');
    fwrite($file , json_encode($data)); 
    fclose($file);
  }

  private function makeDirectory($name) {
    if (!file_exists($name)) {
      mkdir($name, 0777, true);
    }
  }

  /**
   * Method loads reads a manifest file.
   */
  public static function readDataFile($file)
  {
    if (is_file($file)) {
      $data = json_decode(file_get_contents($file), true);
      return $data;
    }
  } 

  // Alter here where the manfest is by entity type.
  public function createManifest($type)
  {
    // Set manifest info.
    $this->makeDirectory($this->manifests_dir);
    
    $file_name =  $type . '_manifests.json';
    $manifest_file = $this->manifests_dir . '/' . $file_name;

    if ($type == 'block'){
      $data_dir = $this->blocks_dir;
    } else {
      $data_dir = $this->entity_dir;
    }

    // scan through entity and build array.
    $entity_files = preg_grep('/^([^.])/', scandir($data_dir));

    if (empty($entity_files)){
      unlink($manifest_file);
    } else {
      // Loop through entity data and extract key needed info.
      $manifest_data = array();
      foreach ($entity_files as $file)
      {
        $file_data = json_decode(file_get_contents($data_dir . '/' . $file), true);
        $manifest_data[] = $file_data['meta'];

        // Save file to system
        $this->createFile($manifest_file, $manifest_data);
        $this->createSiteMap($manifest_data);
        $this->createRSS($manifest_file);
      }
    }
  }

  /**
   * method saves POST data into file. 
   * creates manfefst.
   */
  public function saveEntity($data)
  {

    // Sanitize Data
    $body = $data['body'];

    // Remove PHP include
    $body = str_replace('<?php', htmlentities('<?php', ENT_QUOTES), $body);
    $body = str_replace('<script', htmlentities('<script', ENT_QUOTES), $body);
    $body = str_replace('<iframe', htmlentities('<iframe', ENT_QUOTES), $body);
    $data['body'] = $body;

    // Check if blocks otherwise create standered entity.
    if ($data['meta']['entity_type'] == 'block') {
      $this->makeDirectory($this->blocks_dir);
      $block_file_name = str_replace(' ', '_', $data['title']);
      $block_file_name = strtolower('block_' . $block_file_name);
      $block_file_path = $this->blocks_dir . '/' . $block_file_name . '.json';
      $data['meta']['entity_id'] = $block_file_name;
      $data['meta']['entity_status'] = '';
      $this->createFile($block_file_path, $data);
      $this->createManifest('block');
      header('Location:' . SiteInfo::baseUrl() . 'admin?q=blocks');
    }
    else {

      // Make Dir.
      $this->makeDirectory($this->entity_dir);

      // Set file path.
      $entity_file_name = $data['meta']['entity_id'];
      $entity_file_path = $this->entity_dir . '/' . $entity_file_name . '.json';

      // Set summary if not set.
      if (empty($data['summary'])) {
        $summary = strip_tags($data['body']);
        ltrim($summary);
        if (strlen($summary) <= 125) {
          $data['summary'] = $summary;
        } else {
          $data['summary'] = substr($summary, 0, 125);
        }
      }

      // Save Tags:
      // Here we change spaces to dashes, re-add spaces for comma explode, make to lowerstring.
      $tags = str_replace(' ', '-', $data['meta']['tags']);
      $tags = str_replace(',-', ', ', $tags);
      $data['meta']['tags'] = strtolower($tags);

      // Reset the blog path to ensure its updated and appended with blog dir name.
      if ($data['meta']['entity_type'] == 'post') {
        $data['meta']['path'] = '';
      }

      // Pages can not be part of a category so reset that value if ever selected
      if ($data['meta']['entity_type'] == 'page') {
        $data['meta']['category'] = '';
      }

      // If status is set to draft, do not create a menu path.
      if ($data['meta']['entity_status'] == 'draft') {
        $data['meta']['path'] = '';
      } else {
        // Set path, if non-set make from title. (need to add clause for blog).
        if (empty($data['meta']['path'])) {
          $path = str_replace(' ', '-', $data['title']);
          $path = preg_replace('/[^A-Za-z0-9\-]/', '', $path);
          $path = strtolower($path);

          // If type is post, prepend with blog (TODO: will need to be blog name)
          if ($data['meta']['entity_type'] == 'post') {
            $path = $data['meta']['category'] .'/' . $path;
          }

        } else {
          $path = strtolower($data['meta']['path']);
        }
      }
      $data['meta']['path'] = $path;

      // Create file.
      $this->createFile($entity_file_path, $data);
      $this->createManifest('content');
      
      // Draft edit redirect location
      if ($data['meta']['entity_status'] == 'draft') {
        header('Location:' . SiteInfo::baseUrl() . 'admin/edit?q=' . $data['meta']['entity_id']);
      } else {
        header('Location:' . SiteInfo::baseUrl() . $data['meta']['path']);
      }
    }
  }

  /**
   * Method used to delete entities.
   */
  public function deleteEntity($id)
  {
    
    // Check if media asset.
    if (preg_match('/\..*/', $id)) {
      $file = '_data/files/' . $id;
      unlink($file);
    }
    // Check that its a block.
    else if (preg_match('/block_.*/', $id)){
      $file = $this->blocks_dir . '/' . $id . '.json';
      unlink($file);
      $this->createManifest('block');
      header('Location:' . SiteInfo::baseUrl() . 'admin?q=blocks');
    }
    // Otherwise delete entity.
    else {
      $file = $this->entity_dir . '/' . $id . '.json';
      unlink($file);
      $this->createManifest('content');
      header('Location:' . SiteInfo::baseUrl() . 'admin');
    }
  }

  /**
   * Method loads entity via the id from files, and returns the data array.
   */
  public function loadEntity($id)
  {
    
    // Check if the id is prefaced with block.
    if (strpos($id, "block_") === 0) {
      $dir = $this->blocks_dir;
    }
    else {
      $dir = $this->entity_dir;
    }
    
    $file = $dir . '/' . $id . '.json';
    if (is_file($file)){
      $entity_data = $this->readDataFile($file);
      return $entity_data;
    }
  }

  /** 
   * Returns an array of entity data.
   */
  public function renderEntityList($manifest, &$options = null) 
  {
    
    if ($options == null) {
      $options = array();
    }

    if (key_exists('type', $options)) {
      $type = $options['type'];
    }

    if (key_exists('status', $options)) {
      $status = $options['status'];
    }

    if (key_exists('count', $options)) {
      $count = $options['count'];
    }

    if (key_exists('category', $options)){
      $category = $options['category'];
    }
    
    // Sort by recent published.
    $src_data = $this->readDataFile($manifest);
    if (isset($src_data)) {
      $date_published = array_column($src_data, 'date_published');
      array_multisort($date_published, SORT_DESC, $src_data);
    }

    $data = array();
    $i = 0;

    if (!empty($src_data)){
      foreach ($src_data as $item) {

        if (isset($status) && isset($type)) {
          
          // load by both status and type
          if ($item['entity_type'] == $type && $item['entity_status'] == $status) {
            
            // Check if category is set.
            if (isset($category)) {
              if($item['category'] == $category) {
                $entity = $this->loadEntity($item['entity_id']);
                $data[] = $entity;
              }
            } else {
              $entity = $this->loadEntity($item['entity_id']);
              $data[] = $entity;
            }
          }

        } 
        else if (isset($status) && !isset($type)) {
          
          // load by just status
          if ($item['entity_status'] == $status) {
            $entity = $this->loadEntity($item['entity_id']);
            $data[] = $entity;
          }

        } elseif (isset($type) && !isset($status)) {
          
          // load by just type
          if ($item['entity_type'] == $type) {
            $entity = $this->loadEntity($item['entity_id']);
            $data[] = $entity;  
          }

        } else {
          
          // Load all items.
          $entity = $this->loadEntity($item['entity_id']);
          $data[] = $entity;

        }

        if (isset($count)) {
          $i++;
          if($i == $count) break;
        }

      }

      return $data;
    }
  }

  public function paginate($array, $count = null) {
    
    if ($array) {

    if (isset($count)) {
        $output = array_chunk($array, $count);
      }
      else  {
        $output = array_chunk($array, 10);
      }

      $entity_list = array(
        'content' => $output,
        'pagination' => array_keys($output),
      );

      return $entity_list;
    }
  }

  /**
   * Returns a list of entities with a status, 
   */
  public function renderEntityListStatus($src_array, $status) {

    $data = array();
    foreach ($src_array as $item) {

      if ($item['meta']['entity_status'] == $status) {
        $data[] = $item;
      }
    
    }
    return $data;
  }

  /**
   * Used to create a defualt setting file. 
   */
  public function saveSetting($dir, $file_name, $data) {
    $this->makeDirectory($dir . '/' . $this->settings_dir);
    $settings_file = $dir . '/' . $this->settings_dir . '/' . $file_name;

    // For settings items, we need to go through the array and santize the data.
    foreach ($data as $key => $item) {
      
      // If setting submited is multi array
      if (is_array($item)) {

        // Loop through each item 
        foreach ($item as $prop => $object) {

          // Stantize HTML
          $item[$prop] = htmlspecialchars($object);

        }
        $data[$key] = $item;        
    
      } else {
        
        // Stantize HTML
        $data[$key] = htmlspecialchars($item);
      }
    }

    $this->createFile($settings_file, $data);
  }

  // Used to create a static sitemap after content manifest is generated.
  public function createSiteMap($src) {
    $xml_header = '<?xml version="1.0" encoding="UTF-8"?><urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"></urlset>';
    $xml = new SimpleXMLElement($xml_header);
    
    // Add homepage
    $homepage = $xml->addChild('url');
    $homepage->addChild('loc', SiteInfo::baseUrl());
    $homepage->addChild('lastmod', date('c', time()));

    // Addd blogpage to sitemap
    $blog_path = SiteInfo::baseUrl() . SiteInfo::getSiteData()['blog_path'];
    $blogpage = $xml->addChild('url');
    $blogpage->addChild('loc', $blog_path);
    $blogpage->addChild('lastmod', date('c', time()));

    // TODO: add a menu check for category pages.
    foreach ($src as $item) {
      $url = $xml->addChild('url');
      $url->addChild('loc', SiteInfo::baseUrl() . $item['path']);
      if (empty($item['date_edited'])) {
        $time = strtotime($item['date_published']);
        $time = date('c', $time);
        $url->addChild('lastmod',  $time);
      } else {
        $time = strtotime($item['date_edited']);
        $time = date('c', $time);
        $url->addChild('lastmod', $time);
      }
    }

    $file = fopen('_data/sitemap.xml', 'w+');
    fwrite($file ,$xml->asXML()); 
    fclose($file);
  }

  public function createRSS($manifest)
  {
    $site_data = $this->readDataFile('_data/settings/site_info.json');
    $rss_header = '<?xml version="1.0" encoding="UTF-8"?><rss></rss>';
    $rss = new SimpleXMLElement($rss_header);
    $rss->addAttribute('version', '2.0');
    
    // Channel section.
    $channel = $rss->addChild('channel');
    $channel->addChild('title', $site_data['site_name']);
    $channel->addChild('link', SiteInfo::baseUrl());
    $channel->addChild('description', $site_data['site_description']);

    $data = $this->renderEntityList($manifest);

    // Set items
    foreach ($data as $i) {
   
      $item = $rss->addChild('item');
      $item->addChild('title', $i['title']);
      $item->addChild('link', SiteInfo::baseUrl() . $i['meta']['path']);
      $item->addChild('description', $i['summary']);
    }

    // Save File
    $file = fopen('_data/rss.xml', 'w+');
    fwrite($file ,$rss->asXML()); 
    fclose($file);
  }
}
?>