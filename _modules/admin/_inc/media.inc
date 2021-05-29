<?php

// When user vists: /admin/media (main media page)
$admin_media = new Route();
$admin_media->setPath('admin/media', function() {

  $file = new Media();
  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-browser.tpl.php');
  $page_data['files'] = $file->browse_files();
  $page_data['url'] = SiteInfo::baseUrl();
  $page_data['embeded'] = 'no';
  $page_data['assets'] = array(
    '_modules/admin/js/file.js'
  );

  include ($template->loadTheme('admin'));
});

// Media browser
$file_upload = new Route();
$file_upload->setPath('admin/media/browser', function() {

  $file = new Media();
  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-browser.tpl.php');
  $page_data['files'] = $file->browse_files();
  $page_data['url'] = SiteInfo::baseUrl();
  $page_data['embeded'] = 'yes';
  $page_data['assets'] = array(
    '_modules/admin/js/file.js'
  );

  $page_data['utility_page'] = 'yes';
  include ($template->loadTheme('admin'));
});

// When user vists: /admin/media/upload
$file_upload = new Route();
$file_upload->setPath('admin/media/upload', function() {

  if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $file = new Media();
    echo ($file->upload());
  };

  $template = new Template();
  $page_content = $template->renderTemplateFile('_modules/admin', 'media-upload.tpl.php');
  $page_data['utility_page'] = 'yes';
  $page_data['assets'] = array(
    '_modules/admin/js/file.js'
  );
  include ($template->loadTheme('admin'));
});

?>