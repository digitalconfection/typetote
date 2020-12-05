<div class="login-well">
<div class="login-msg login-msg--good">Please check your email for the login token.</div>

<a href="https://typetote.com" target="_blank"><img class="emblem" src="<?php echo SiteInfo::baseUrl() ?>/_modules/admin/img/tt-emb.svg"></a>
<div class="wrapper">
  <form method="post" enctype="multipart/form-data">
    <input type='text' name="token" placeholder="Enter Token" required>
    <input type="hidden" name="key_2" value="<?php echo $page_data['key_2'] ?>">
    <input type="submit" value="Login">
  </form>
</div>

</div>