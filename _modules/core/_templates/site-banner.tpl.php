<?php

if (isset($data)) {

$empty_body = strip_tags($data['body']);
if ($empty_body !== '') { ?>

<div id="top-banner" class="site-banner"><div id="close-top-banner" class="close" onclick="closeBanner();">X</div>
  <div class="container"><?php echo $data['body']; ?></div>
</div>

<script>
  // Get localstorage var
  var clicked = localStorage.getItem('clicked');
  var pastDate = localStorage.getItem('date');

  // Get date.
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;

  if (clicked == 'yes' && today == pastDate) {
    document.getElementById('top-banner').style.display = 'none';
  }

  function closeBanner() {
    var clicked = localStorage.getItem('clicked');
    document.getElementById('top-banner').style.display = 'none';
    localStorage.setItem('clicked', 'yes');
    localStorage.setItem('date', today);
  }
</script>
<?php } }?>