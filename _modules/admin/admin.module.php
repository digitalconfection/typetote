<?php
new Auth();
$site = new SiteInfo();
$site_info = $site->getSiteData();
$session_name = md5($site->baseUrl());

// Public Login.
$admin_content = new Route();
$admin_content->setPath('login', function() {

  $template = new Template();
  $site = new SiteInfo();
  $site_info = $site->getSiteData();
  $session_name = md5($site->baseUrl());


  // Show login email form.
  if (empty($_SESSION[$session_name]['auth']['template'])) {
    $auth_file = '_data/' . md5($_SERVER["REMOTE_ADDR"]) . '.json';
    $page_content = $template->renderTemplateFile('_modules/admin', 'login-email-form.tpl.php');
    $page_data['key_1'] = bin2hex(random_bytes(32));
    $page_data['key_2'] = bin2hex(random_bytes(64));

    // If post email is set, get key_1 and set to session.
    if (isset($_POST['email'])) {

      $user_data = new Entity();
      $users = $user_data->readDataFile('_data/settings/users.json');
      if ($users == null) {
        $users = array();
      }
      array_push($users,$site_info['admin_email']);
      $email_address = strtolower($_POST['email']);

      $_SESSION[$session_name]['auth']['key_1'] = $_POST['key_1'];
      if (in_array($email_address, $users) && hash_equals($_SESSION[$session_name]['auth']['key_1'], $_POST['key_1'])) {
        
        // Timegate the acceptance of the token.timeline
        $_SESSION[$session_name]['auth']['login_time_token'] = time();
        $_SESSION[$session_name]['auth']['user'] = $email_address;

        // Generate Token & load form.
        $token_core = hash('sha512',  mt_rand() . $_SERVER["REMOTE_ADDR"] . random_bytes(32) .  $site_info['sec_key_1']);
        $options = [
          'cost' => 12,
        ];
        $token = password_hash($token_core, PASSWORD_BCRYPT, $options);
        $_SESSION[$session_name]['auth']['token'] = str_replace('.', '', $token);

        // Mail Token:
        $to = $email_address;
        $subject = 'TypeTote Login';
        $txt = "This is your login code, copy and paste the following: \n" . $_SESSION[$session_name]['auth']['token'];
        $headers = "From: no-reply@" . $_SERVER['SERVER_NAME'];
        
        mail($to,$subject,$txt,$headers);
        $page_content = $template->renderTemplateFile('_modules/admin', 'login-token-form.tpl.php');
      }

      if (!in_array($email_address, $users)) {
        $message = 'Sorry the email you entered is incorrect. Please try again.';
      }
    }
    
    // If the token form is set, get login ID and key_2 var.
    if (isset($_POST['token'])) {
      $_SESSION[$session_name]['auth']['key_2'] = $_POST['key_2'];

      if (time() - $_SESSION[$session_name]['auth']['login_time_token'] > 600) {
        header('Location:' . SiteInfo::baseUrl() . 'admin/logout');
      }
      else {
        if ( hash_equals($_POST['token'], $_SESSION[$session_name]['auth']['token']) && hash_equals($_SESSION[$session_name]['auth']['key_2'], $_POST['key_2']) ) {
          $_SESSION[$session_name]['auth']['template'] = $site_info['sec_key_2'] . 'admin';
          $_SESSION[$session_name]['auth']['login_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION[$session_name]['auth']['login_time'] = time();

          header('Location:' . SiteInfo::baseUrl() . 'admin');
        }

        if ($_POST['token'] !== $_SESSION[$session_name]['auth']['token']) {
          $message_bad = 'Sorry the token you entered is incorrect. Please try again.';
        }
      }
    }
  }

  // Redirect user to admin if they are authenticated.
  if (isset($_SESSION[$session_name]['auth']['template']) &&  hash_equals($_SESSION[$session_name]['auth']['template'], $site_info['sec_key_2'] . 'admin')) {
    header('Location:' . SiteInfo::baseUrl() . 'admin');
  }

  $page_data['utility_page'] = 'yes';
  include ($template->loadTheme('admin'));

});

// After login show admin.
if (isset($_SESSION[$session_name]['auth']['template']) 
    && hash_equals($_SESSION[$session_name]['auth']['template'], $site_info['sec_key_2'] . 'admin') 
    && hash_equals($_SERVER['REMOTE_ADDR'], $_SESSION[$session_name]['auth']['login_ip']
    )
   ) {

  // After 30min logout and close session.
  if (time() - $_SESSION[$session_name]['auth']['login_time'] > 2700) {
    header('Location:' . SiteInfo::baseUrl() . 'admin/logout');
  } 
  else {
    $_SESSION[$session_name]['template']['admin_bar'] = 'yes';
    include('admin.inc');
  }

}

$admin_content = new Route();
$admin_content->setPath('admin/logout', function() {

  $logout = new Auth();
  $logout->logout();

});


?>