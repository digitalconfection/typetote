<h1><i class="fas fa-edit"></i> Publish</h1>
<form method="post" id="entity_form" enctype="multipart/form-data" class="content-form">
  <div class="col">
    <div class="page-well">
      <div class="page-content">
        <input id="title" class="editor-title" type="text" name="entity[title]" placeholder="Title" value="<?php if (isset($page_data['title'])) { echo $page_data['title']; } ?>" required>
      </div>
    </div>
    <br>
    <?php include('editor.tpl.php') ?>
  </div>

  <div class="col-utility">
    <?php if ($page_data['meta']['entity_status'] == 'published') { ?>
        <a href="<?php echo SiteInfo::baseUrl()  . $page_data['meta']['path']?>" target="_blank">View Content <i class="fas fa-arrow-right"></i></a>
        <br>
        <br>
    <?php } ?>
    <div class="page-well">
      <div class="page-content">
      
      <label for="entity_type">Type:</label>
      <select name="entity[meta][entity_type]" id="entity_type" onchange="blockOptional();">
        <option value="post" <?php if ($page_data){ if ($page_data['meta']['entity_type'] == 'post'){?>selected="selected"<?php }} ?>>Post</option>
        <option value="page" <?php if ($page_data){ if ($page_data['meta']['entity_type'] == 'page'){?>selected="selected"<?php }} ?>>Page</option>
        <option value="block" <?php if ($page_data){ if ($page_data['meta']['entity_type'] == 'block'){?>selected="selected"<?php }} ?>>Block</option>
      </select>

      <?php
        $category_data = new Entity();
        $categories = $category_data->readDataFile('_data/settings/category.json');
        $site_info = new SiteInfo();
        $site_data = $site_info->getSiteData();
      ?>
      <div id="category-items" class="<?php if ($page_data['meta']['entity_type'] == 'block' or $page_data['meta']['entity_type'] == 'page') { echo 'hide'; }?>">
        <label for="category">Category:</label>
        <select name="entity[meta][category]" id="category">
          <option value='<?php echo $site_data['blog_path']; ?>'><?php echo $site_data['blog_name']; ?></option>
          <?php 
            foreach ($categories as $category) { ?>
              <option value="<?php echo $category['path']; ?>" <?php if ($page_data) { if ($page_data['meta']['category'] == $category['path']) { echo 'selected="selected"'; } } ?>><?php echo $category['name'] ?></option>
            <?php }
          ?>
        </select>
      </div>
      
      <div id="block_optional" class="<?php if ($page_data['meta']['entity_type'] == 'block') { echo 'hide'; }?>">
        <label for="entity_status">Status:</label>
        <select name="entity[meta][entity_status]" id="entity_status">
          <option value="draft" <?php if ($page_data){ if ($page_data['meta']['entity_status'] == 'draft'){?>selected="selected"<?php }} ?>>Draft</option>
          <option value="published" <?php if ($page_data){ if ($page_data['meta']['entity_status'] == 'published'){?>selected="selected"<?php }} ?>>Published</option>
        </select>

        <label for="tags">Tags:</label> 
        <input id="tags" type="text" name="entity[meta][tags]" value="<?php if (isset($page_data['meta']['tags'])) { echo $page_data['meta']['tags']; } ?>">

        <?php
          // render list of avalible tags.
          $tag_data = new Entity();
          $tags = $tag_data->readDataFile('_data/manifests/content_manifests.json');

          $tag_list = array();
          foreach ($tags as $tag) {
            $t = $tag['tags'];
            
            // Remove empty
            if ($tag['tags'] == '') {
              continue;
            }

            // If multiple tags are found, break them up.
            if (strpos($tag['tags'], ',') !== false) {

              $sub_tags = explode(',' ,$tag['tags']);
              foreach ($sub_tags as $sub_tag) {
                $tag_list[] = str_replace(' ', '', $sub_tag);
              }

            } else {
              $tag_list[] = $t;
            }
          } 

          $tag_list = array_unique($tag_list);

          echo '<ul class="existing_tags">';
          foreach ($tag_list as $key => $value) {
            echo '<li id="tag_'. $key .'" onClick="tagClick(this.id)"><i class="fa fa-tag" aria-hidden="true"></i> ' . $value . '</li>';
          }
          echo '</ul>';
        ?>
        
        <label for="body">Summery:</label> 
        <textarea id="body" name="entity[summery]"><?php if (isset($page_data['summery'])) { echo $page_data['summery']; } ?></textarea>

        <details>
          <summary>Metadata</summary>
          <label for="path">Path:</label> 
          <input id="path" type="text" name="entity[meta][path]" value="<?php if (isset($page_data['meta']['path'])) { echo $page_data['meta']['path']; }?>">
        
          <label for="date_published">Date Published:</label> 
          <input id="date_published" type="text" name="entity[meta][date_published]" value="<?php if (isset($page_data['meta']['date_published'])) { echo $page_data['meta']['date_published']; }?>">
          
          <label for="date_edited">Date Edited:</label> 
          <input id="date_edited" type="text" name="entity[meta][date_edited]" value="<?php if (isset($page_data['meta']['date_edited'])) { echo $page_data['meta']['date_edited']; }?>">
        </details>
      </div>

        <input type="hidden" name="entity[meta][entity_id]" value="<?php if (isset($page_data['meta']['entity_id'])) { echo $page_data['meta']['entity_id']; } else { echo time(); } ?>" required>
      </div>
    </div>
    <br>

    <div class="form-actions">
      <input type="submit" onclick="copyText('page_content', 'page_data');" value="Save">
      <?php if (isset($page_data['meta']['date_published'])) { ?>
        <a href="<?php echo SiteInfo::baseUrl() ?>admin/delete?q=<?php echo $page_data['meta']['entity_id'] ?>" class="delete-btn">Delete</a>
      <?php } ?>
    </div>

  </div>
</form>