<h1><i class="fas fa-link"></i> Menu</h1>
<p>Use the following form to set the main menu.</p>
<br>

<form method="post" enctype="multipart/form-data">
<div id="menu_well" class="page-well">
  <!-- When Menu file is set -->
  <?php if (isset($page_data['menu'])) { ?>
   <?php  foreach ($page_data['menu'] as $menu ) { ?>
      <div class="menu_obj" id="<?php echo 'ob_'. $menu['weight'] ?>">
        <input type="text" name="menu[<?php echo $menu['weight'] ?>][name]" placeholder="Menu Name" value="<?php echo $menu['name'] ?>">
        <input type="text" name="menu[<?php print $menu['weight'] ?>][path]" placeholder="Menu Path" value="<?php echo $menu['path'] ?>">
        <input type="text" class="obj_order" name="menu[<?php print $menu['weight'] ?>][weight]" value="<?php echo $menu['weight'] ?>">
        <span class="x" onclick="removeMenu('<?php echo 'ob_'. $menu['weight'] ?>');"><i class="fas fa-ban"></i></span>
      </div>
    <?php } ?>
  <?php } else { ?>

  <!-- When Menu file is not set -->
  <div class="menu_obj">
    <input type="text" name="menu[0][name]" placeholder="Menu Name">
    <input type="text" name="menu[0][path]" placeholder="Menu Path">
    <input type="text" class="obj_order" name="menu[0][weight]" value="0">
  </div>
  
  <?php } ?>

</div>

<div class="form-actions">
<input type="button" onclick="addMenuRow()" class="alt-btn" value="+ Add Menu Item">
<input type="submit" value="Save">
</form>