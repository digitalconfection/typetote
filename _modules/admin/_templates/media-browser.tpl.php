<?php if (empty($page_data['utility_page']) or $page_data['utility_page'] !== 'yes') { ?>
<h1><i class="fas fa-photo-video"></i> Media</h1>
<p>Browse or upload new images and PDFs</p>

<?php }?>

<div id="upload" class="upload-thing hide">
  <iframe frameborder="0" width="100%" src="<?php echo SiteInfo::baseUrl(); ?>admin/media/upload"></iframe>
  <button href="#" class="alt-btn" id="upload-cncl" onclick="toggle('upload');">Cancel</button>
</div>

<button onclick="toggle('upload');"><i class="fas fa-angle-double-up"></i> Upload Media</button>
<br>
<br>

<?php if ($page_data['files']) { ?>
<div class="media_browser">
  <?php foreach ($page_data['files'] as $file) { ?>
    <div class="thumbnail">
      <div class="page-well">
        <?php 
          $file_type =  pathinfo($file, PATHINFO_EXTENSION);
          if ($file_type == 'pdf') { ?>
            <div class="thumb-img file-icon" style="background-image: url('<?php echo SiteInfo::baseUrl() . '/_modules/admin/img/file-icon.png'?>');"></div>
          <?php } else { ?>
            <div class="thumb-img" style="background-image: url('<?php echo SiteInfo::baseUrl() . SiteInfo::getDataDir() . '/files/' . $file ?>');"></div>
        <?php }?> 
          <br>
          <div class="file-name"><?php echo $file ?></div>
          <?php if ($page_data['embeded'] == 'yes') { ?>
            <a onclick="placeFile('<?php echo SiteInfo::baseUrl() . SiteInfo::getDataDir() . '/files/' . $file ?>');" class="click"><i class="far fa-arrow-alt-circle-down" title="Embed Asset"></i> Select</a>
          <?php } else { ?>
          <div class="thumbnail-link">
            <a href="<?php echo SiteInfo::baseUrl() . SiteInfo::getDataDir() . '/files/' . $file ?>" target="_blank"><i class="fas fa-link" title="View Asset"></i> </a>
            <a href="<?php echo SiteInfo::baseUrl() . 'admin/delete?q=' . $file ?>"><i class="fas fa-ban" title="Delete Asset"></i></a>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
</div>  
  
<?php } else { ?>

  <h3>No Media has been uploaded.</h3>

<?php } 

?>

