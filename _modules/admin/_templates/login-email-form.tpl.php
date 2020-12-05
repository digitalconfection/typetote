<div class="login-well">
  
<?php if(isset($message)) { ?>
  <div class="login-msg login-msg--bad"><?php echo $message ?></div>
<?php } ?>
  
  <a href="https://typetote.com" target="_blank"><img class="emblem" src="<?php echo SiteInfo::baseUrl() ?>/_modules/admin/img/tt-emb.svg"></a>
  <div class="wrapper">
    <form method="post" enctype="multipart/form-data">
      <input type='text' name="email" placeholder="Enter Your Email" required>
      <input type="hidden" name="key_1" value="<?php echo $page_data['key_1'] ?>">
      <input type="submit" value="Start">
    </form>
  </div>

  <a href="<?php echo SiteInfo::baseUrl() ?>"><i class="fas fa-arrow-left"></i> Back To Home</a>
</div>