<?php
  // After a period of time, a notice will inform the user if they would like to extend the login session.  
  if (isset($_POST['session_extend'])) {
    if ($_POST['session_extend'] == 'Yes') {
      $_SESSION[array_keys($_SESSION)[0]]['auth']['login_time'] = time();
      header("Refresh:0");
    } 
  
    if ($_POST['session_extend'] == 'No') {
      $_SESSION['no_extend'] = 'Yes';
      header("Refresh:0");
    } 
  }
?>

<?php if (!isset($_SESSION['no_extend'])) { ?>
  <div id="session-form" style="display: none;">
    <form class="session-notice-box" method="post" enctype="multipart/form-data">
      <h1>Need More Time?</h1>
      <p>Your session is about to expire, and you will be logged out. Would you like to extend it?</p>
      <input type="submit" value="Yes" name="session_extend">
      <input type="submit" value='No' name="session_extend" class="alt-btn">
    </form>
  </div>

  <script>
    window.setInterval(function(){
      let sessionTime = new Date(Number(<?php echo $_SESSION[array_keys($_SESSION)[0]]['auth']['login_time'];?>))
      let currentTime = parseInt((new Date().getTime() / 1000).toFixed(0));

      if (currentTime - sessionTime > 2200) { // 2200
      document.getElementById('session-form').style.display = 'grid';
      } 
    }, 120 * 1000);
  </script>
<?php } ?>