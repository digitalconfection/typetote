<div class="login-well">

<?php if (isset($message_bad)) {?> 
  <div class="login-msg login-msg--bad"><?php echo $message_bad ?></div>
<?php } else { ?>
  <div class="login-msg login-msg--good">Please check your email for the login token. This token will expire in 10min. Do not leave this page.</div>
<?php } ?>

<a href="https://typetote.com" target="_blank"><img class="emblem" src="<?php echo SiteInfo::baseUrl() ?>/_modules/admin/img/tt-emb.svg"></a>
<div class="wrapper">
  <form method="post" enctype="multipart/form-data">
    <input type='text' name="token" placeholder="Enter Token" required>
    <input type="hidden" name="key_2" value="<?php echo $page_data['key_2'] ?>">
    <input type="submit" value="Login">
  </form>
</div>

<a href="<?php echo SiteInfo::baseUrl() ?>"><i class="fas fa-arrow-left"></i> Back To Home</a>
</div>