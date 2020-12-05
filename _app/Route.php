<?php

class Route {
  
  /**
   * returns a 200 response & executies function logic.
   */
  private function response($fn) 
  {
    
    http_response_code(200);
    $fn();
  }

  public function __construct()
  {
    
    // Remove Fb track path.
    $dir = basename(dirname($_SERVER['PHP_SELF']));
    $curent_url = strip_tags($_SERVER['REQUEST_URI']);
    $curent_url = preg_replace('/\?fbclid=.*/', '', $curent_url);

    if ($dir == '') {
      $curent_url = ltrim($curent_url, '/');
    } else {
      $curent_url = str_replace('/' . $dir .'/', '', $curent_url);
    }

    $this->uri = $curent_url;
    $this->dir = getcwd();
    $this->base_dir = substr($this->dir, strrpos($this->dir, '/') + 1);
  }

  /**
   * Method used for setting a strict rout path with no assumptions.
   */
  public function setPath($path, $fn) 
  {
    $q = $path . '?';
    if (SiteInfo::baseURl() . $this->uri == SiteInfo::baseURl() . $path or SiteInfo::baseURl() . $this->uri == SiteInfo::baseURl() . $path . '/') 
    {      
      $this->response($fn);
    } else {
      if (strpos($this->uri, $q) !== false)
      {
        $this->response($fn);   
      }
    }
  }

  /**
   * Method used for setting a strict route path but with peramitor options. 
   */
  public function setQueryPath($path, $fn) 
  {
    $q = $path . '?';
    if (strpos($this->uri, $q) !== false)
    {
      $this->response($fn);   
    }
  }

  /**
   * Method used to query a path after its set.
   * Possibly no longer needed.
   */
  public function getQueryPath() 
  {
    $url = $this->uri;

    $query = preg_replace('/.*?q=/', '', $url);
    if (!empty($query)) 
    {
      
      // sanitize, remove possible tags, and exentions. 
      $query = strip_tags($query);
      $query = preg_replace('/\..../', '', $query);
      return $query;
    }   
  }

  public function getQuery($val) {

    if (isset($_GET[$val])) {
      $q = $_GET[$val];
      $q = strip_tags($q);
  
      return $q;
    } else {
      return null;
    }
   
  }

  public function getPath() 
  {
    $path = $this->uri;
    return strip_tags($path);
  }

  public function getPathName() {
    $path = $this->uri;
    $path = strip_tags($path);
    $path = preg_replace('/\?.*/', '', $path);

    return $path;


  }

  // Get raw query from url (only use knowingly)
  public function getRawQuery() 
  {
    $url = $this->uri;
    $query = preg_replace('/.*?q=/', '', $url);
    return $query;
  }

  public function goToPath($path)
  {
    header('Location: '. Siteinfo::baseUrl() . $path);
  }
}
?>