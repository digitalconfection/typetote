<h1><i class="fas fa-book"></i> Categories</h1>
<p>Use the following form to set up categories that you can use to organize post content.</p>
<br>

<form method="post" enctype="multipart/form-data">
<div id="category_well" class="page-well">
<?php if (isset($page_data['categroy'])) { ?>
  <?php foreach ($page_data['categroy'] as $key => $cat ) { ?>

    <div class="cat_obj" id="<?php echo 'ob_'. $key ?>">
      <input type="text" name="cat[<?php echo $key; ?>][name]" placeholder="Category Name" value="<?php echo $cat['name'] ?>">
      <input type="text" name="cat[<?php echo $key; ?>][path]" placeholder="Category Path (Must not have any spaces i.e &quot;dinner-menu&quot;)" value="<?php echo $cat['path'] ?>">
      <span class="x" onclick="removeCategory('<?php echo 'ob_'. $key ?>');"><i class="fas fa-ban"></i></span>
    </div>
    
  <?php } ?>
<?php } else { ?>

  <div class="cat_obj">
    <input type="text" name="cat[0][name]" placeholder="Category Name">
    <input type="text" name="cat[0][path]" placeholder="Category Path (Must not have any spaces i.e &quot;dinner-menu&quot;)">
  </div>

<?php } ?>
</div>

<div class="form-actions">
<input type="button" onclick="addCategoryRow()" class="alt-btn" value="+ Add Category">
<input type="submit" value="Save">
</form>