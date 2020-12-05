<?php 

if ($page_data['query'] == 'search') {
  $placeholder = '';
} else {
  $placeholder = $page_data['query'];
}

?>

<div class="search-box">
  <form action="search?q=" method="get">
    <input type="text" name="q" placeholder="Search Site" value="<?php echo $placeholder ?>" required>
    <input type="submit" value="Search" />
  </form>
</div>