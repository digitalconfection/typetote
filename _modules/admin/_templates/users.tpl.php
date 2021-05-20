<h1><i class="fas fa-user-friends"></i> Users</h1>
<p>Use the following form to grant site access to other people by entering their email address.</p>
<br>

<form method="post" enctype="multipart/form-data">
<div id="user_well" class="page-well">
<?php if (isset($page_data['users'])) { ?>
  <?php foreach ($page_data['users'] as $key => $user ) { ?>

    <div class="user_obj" id="<?php echo 'ob_'. $key ?>">
      <input type="text" name="user[<?php echo $key; ?>]" placeholder="Email Address" value="<?php echo $user ?>" required>
      <span class="x" onclick="removeUser('<?php echo 'ob_'. $key ?>');"><i class="fas fa-ban"></i></span>
    </div>
    
  <?php } ?>
<?php } else { ?>

  <div class="user_obj">
    <input type="text" name="user[0]" placeholder="Email Address" required>
  </div>

<?php } ?>
</div>

<div class="form-actions">
<input type="button" onclick="addUserRow()" class="alt-btn" value="+ Add User">
<input type="submit" value="Save">
</form>