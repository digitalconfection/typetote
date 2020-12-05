<?php 
if (isset($page_data['results']['content'][0])) { 

  if ($page_data['pagination_num']) {
    $pag_num = $page_data['pagination_num'];

  } else {
    $pag_num = 0;
  }

  $list = $page_data['results']['content'][$pag_num];
}

if ($page_data['query'] == '') {
  $text = '';
} else {
  $text = ' <h3>Sorry</h3>
  <p>We are sorry no results were found for <b>'. $page_data['query'] .'</b>.</p>';
}

?>

<h1>Search</h1>

<?php include ('search-bar.tpl.php'); ?>

<?php if ($page_data['status'] == 'no') { ?>

  <?php echo $text ?>

<?php } ?>

<?php if ($page_data['status'] == 'yes') { ?>
  <?php foreach ($list as $result) { ?>
    <article>
      <h3><a href="<?php echo $result['link']; ?>"><?php echo ucwords($result['title']); ?></a></h3>
      <p><?php echo $result['summery'] ?></p>
      <?php renderTags($result['tags']); ?>
    </article>
  <?php }?>
<?php } ?>

<?php if (isset($page_data['results']['pagination'][1])) { ?>
<ul class="pagination">
  <?php foreach ($page_data['results']['pagination'] as $key => $num) { ?>
    <li><a href="<?php echo $page_data['base_url'] .'&pg='.$num ?>"><?php echo $num + 1 ?></a></li>
  <?php }  ?>
</ul>
<?php } ?>
