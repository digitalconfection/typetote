<?php

new Auth();

$admin_login = new Route();
$admin_login->setPath('login', function() {
  
  $redirect = new Route();
  $auth_file = '_data/' . md5($_SERVER["REMOTE_ADDR"]) . '.json';
  $template = new Template();

  // Set first session.
  if ($_SESSION['auth']['p1'] == null && $_SESSION['auth']['p2'] == null) {
    $page_content = $template->renderTemplateFile('_modules/admin', 'login-email-form.tpl.php');
    $page_data['template_type'] = 'login';

    // Set CFR (key_1):
    if (empty($_SESSION['key_1'])) {
      $_SESSION['key_1'] = bin2hex(random_bytes(32));
    }
    $page_data['key_1'] = $_SESSION['key_1'];

    $site = new SiteInfo();
    $site_info = $site->getSiteData();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
      
      if (hash_equals($_SESSION['key_1'], $_POST['key_1'])) {

        if (hash_equals($_POST['email'], $site_info['admin_email'])) { 
          $token = hash('sha512',  md5(date("H:i:s")) - mt_rand() . $_SERVER["REMOTE_ADDR"] . random_bytes(32) .  $site_info['sec_key_1']);
          
          $_SESSION['auth']['p1'] = hash('sha512', random_bytes(32) . md5($_SERVER["REMOTE_ADDR"]));
          $_SESSION['auth']['login_token'] = password_hash($token, PASSWORD_DEFAULT);

          // Mail Token:
          $to = $site_info['admin_email'];
          $subject = 'TypeTote Login';
          $txt = "This is your login code, copy and paste the following: \n" . $_SESSION['auth']['login_token'];
          $headers = "From: no-reply@" . $_SERVER['SERVER_NAME'];
          
          mail($to,$subject,$txt,$headers);
        }
      }
    }
  }

  // Set second session.
  if (isset($_SESSION['auth']['p1']) && $_SESSION['auth']['p2'] == null ){

    // Set CFR (key_2):
    if (empty($_SESSION['key_2'])) {
      $_SESSION['key_2'] = bin2hex(random_bytes(32));
    }
    $page_data['key_2'] = $_SESSION['key_2'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

      // Auth check second CFR key (key_2)
      if (hash_equals($_SESSION['key_2'], $_POST['key_2'])) {

        if (hash_equals($_POST['token'], $_SESSION['auth']['login_token'])){
          
          $_SESSION['auth']["p2"] = hash('sha512', random_bytes(32) . $_SERVER['REMOTE_ADDR'] .  $site_info['sec_key_2']);
          $_SESSION['auth']['login_ip'] = $_SERVER["REMOTE_ADDR"]; // Capture the IP of the token entered.
          
          $auth_data = array(
            'p1' =>  $_SESSION['auth']["p1"],
            'p2' =>  $_SESSION['auth']["p2"],
            'ip' => $_SESSION['auth']['login_ip'],
            'time' =>  time()
          );

          $login_auth = new Entity(); 
          $login_auth->createFile($auth_file,  $auth_data);
          $redirect->goToPath('admin');
        }
      }
    }
    $page_content = $template->renderTemplateFile('_modules/admin', 'login-token-form.tpl.php');
    $page_data['template_type'] = 'login';
  }
  $admin_theme = new Template();
  include ($admin_theme->loadTheme('admin'));
});

// On admin logout run script to hide /admin from public.
if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {  

  $login_auth = new Entity(); 
  $auth_file = '_data/' . md5($_SERVER["REMOTE_ADDR"]) . '.json';
  
  // If auth data matches sessions.
  $auth_validate_data = $login_auth->readDataFile($auth_file);  
  if (hash_equals($auth_validate_data['p1'], $_SESSION['auth']["p1"])
      && hash_equals($auth_validate_data['p2'], $_SESSION['auth']["p2"])
      && hash_equals($auth_validate_data['ip'], $_SERVER["REMOTE_ADDR"])) {

      // After 30min logout and delete file.
      if (time() - $auth_validate_data['time'] > 2700) {
        $GLOBALS['utility_page'] = 'yes';
        unlink($auth_file);
        session_regenerate_id(true);
        session_unset(); 
        session_destroy();
        header('Location:' . SiteInfo::baseUrl()) . 'login';
      }

      // Otherwise include admin module.
      $GLOBALS['utility_page'] = 'no';
      $_SESSION['template']['admin_bar'] = 'yes';
      include('admin.inc');

      // Logout
      $admin_logout = new Route();
      $admin_logout->setPath('admin/logout', function() {
        $logout = new Auth();
        unlink('_data/' . md5($_SERVER["REMOTE_ADDR"]) . '.json');
        $logout->logout();
      });

  } else {
    header('Location:' . SiteInfo::baseUrl()) . 'login';
  }

}




?>