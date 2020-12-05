<h1><i class="fas fa-cog"></i> Settings</h1>
<p>Use the following form to change the site settings.</p>
<br>

<form method="post" enctype="multipart/form-data">
  <div class="page-well">
  <details>
    <summary><b>General: </b></summary>
    <br>
    <div class="page-content">
      <label for="site_name">Site Name:</label>
      <input id="site_name" type="text" placeholder="Site Name" name="site_name" value="<?php if (isset($page_data['site_name'])) { echo $page_data['site_name']; } ?>" required>

      <label for="site_slogan">Site Slogan:</label>
      <input id="site_slogan" type="text" placeholder="Site Slogan" name="site_slogan" value="<?php if (isset($page_data['site_slogan'])) { echo $page_data['site_slogan']; } ?>">

      <label for="site_description">Site Description:</label>
      <textarea id="site_description" name="site_description" placeholder="Site Description"><?php if (isset($page_data['site_description'])) { echo $page_data['site_description']; } ?></textarea required>

      <label for="admin_email">Admin Email:</label>
      <input id="admin_email" type="text" placeholder="Admin Email" name="admin_email" value="<?php if (isset($page_data['admin_email'])) { echo $page_data['admin_email']; } ?>" required>

      <label for="blog_name">Blog Title:</label>
      <input id="blog_name" type="text" placeholder="Blog Name" name="blog_name" value="<?php if (isset($page_data['blog_name'])) { echo $page_data['blog_name']; } else { echo 'blog'; }?>" required>
      <div class="cc">Blog Path: <a href="<?php echo Siteinfo::baseUrl() . $page_data['blog_path']; ?>"><?php echo $page_data['blog_path']; ?></a></div>

    </div>
  </div>
  </details>
  <br>

  <div class="page-well">
  <details>
    <summary><b>Theme Info:</b></summary>
    <br>
    <div class="page-content">
      <label for="front_theme">Front Theme:</label>    
      <select id="front_theme" name="front_theme" required>
        <?php $themes = preg_grep('/^([^.])/', scandir('_themes')); ?>
        <?php foreach($themes as $theme_name) { ?>
          <?php if ($page_data['front_theme'] == $theme_name) { ?>
            <option value="<?php echo $theme_name ?>" selected="selected"><?php echo $theme_name ?></option>
          <?php } else { ?>
            <option value="<?php echo $theme_name ?>"><?php echo $theme_name ?></option>
          <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  </details>
  <br>

  <div class="page-well">
  <details>
    <summary><b>Open Graph & Google:</b></summary>
    <br>
    <div class="page-content">
      <label for="twitter_sn">Twitter Username</label>
      <input id="twitter_sn" type="text" name="twitter_sn" placeholder="Twitter Username" value="<?php if (isset($page_data['twitter_sn'])) { echo $page_data['twitter_sn']; } ?>">
      
      <label for="ga_ua_code">Google Analytics Tracking ID:</label>
      <input id="ga_ua_code" type="text" name="ga_ua_code" placeholder="UA Code" value="<?php if (isset($page_data['ga_ua_code'])) { echo $page_data['ga_ua_code']; } ?>">
    </div>
  </div>
  </details>
  <br>

  <div class="page-well">
  <details>
    <summary><b>Key Questions:</b></summary>
    <br>
    <p>The following questions are part of TypeTotes security login process. We recommend changing these answers over time. What you see are hashed values, and you do not need to remember what you wrote previously.</p>
    <div class="page-content">
      <label for="sec_key_1">Favorite food?</label>
      <input id="sec_key_1" type="text" name="sec_key_1" placeholder="Your Response." value="<?php if (isset($page_data['sec_key_1'])) { echo $page_data['sec_key_1']; } ?>" required>
      
      <label for="sec_key_2">What is the cutest animal?</label>
      <input id="sec_key_2" type="text" name="sec_key_2" placeholder="Your Response." value="<?php if (isset($page_data['sec_key_2'])) { echo $page_data['sec_key_2']; } ?>" required>
      
      </div>
  </div>
  </details>
  <br>

  <div class="page-well">
  <details>
    <summary><b>Headless CMS Settings</b></summary>
      <br>
      <p>Mark the checkbox below to enable headless mode and bypass the default template system.</p>
      <input class="ie-form" type="checkbox" id="headless" name="headless" value="enabled" <?php if (isset($page_data['headless'])){ if ($page_data['headless'] == 'enabled') { echo 'checked'; } }?>>
      <label class="ie-form" for="headless"> Enable headless mode</label><br>
      </div>
  </details>

  <div class="form-actions">
    <input type="submit" value="Save">
  </div>
</form>