<style>
  .admin-bar {
    background-color: rgba(0, 0, 0, 0.8);
    font-size: medium;
    position: fixed;
    width: 96%;
    top: 0;
    right: 0;
    padding: 5px 2% 5px 2%;
  }

  .admin-bar a {
    color: white;
    margin-left: 1em;
  }

  .admin-bar--logout {
    float: right;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<script>
  // To add padding to top to allow for bar regardless of theme. 
  document.getElementsByTagName("body")[0].style.paddingTop = "39px";
</script>
<div id="admin-bar" class="admin-bar">
  <a href="<?php echo SiteInfo::baseUrl(); ?>admin/"><i class="fas fa-home"></i> <span>Admin</span></a>
  
  <?php if ($page_data) { ?>
    <a href="<?php echo SiteInfo::baseUrl() . 'admin/edit?q=' . $page_data['meta']['entity_id']; ?>"><i class="fas fa-pen"></i> <span>Edit</span></a>
  <?php } ?>

  <a class="admin-bar--logout" href="<?php echo SiteInfo::baseUrl(); ?>admin/logout"><i class="fas fa-power-off"></i> <span>Logout</span></a>
</div>