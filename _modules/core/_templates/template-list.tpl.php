<?php
if ($page_data['list']['content'] !== '') { 

  if ($page_data['pagination_num']) {
    $pag_num = $page_data['pagination_num'];

  } else {
    $pag_num = 0;
  }

  $list = $page_data['list']['content'][$pag_num];

} else {
  $list = $page_data['list'];
}
?>

<div class="list-well">
<?php if (isset($page_data['title'])) { ?>
  <h1><?php echo $page_data['title']; ?></h1>
<?php } ?>

<?php if (!empty($list)) { ?>
  
  <?php foreach ($list as $item) { ?>

    <article>
      <h3><a href="<?php echo $item['meta']['path']; ?>"><?php echo $item['title']; ?></a></h3>
      <p><?php echo $item['summery']; ?></p>
      <?php renderTags($item['meta']['tags']); ?>
    </article>

  <?php } ?>

    <?php if (isset($page_data['list']['pagination'][1])) { ?>
        <ul class="pagination">
          <?php foreach ($page_data['list']['pagination'] as $key => $num) { ?>
            <li><a href="<?php echo $page_data['base_url'] .'&pg='.$num ?>"><?php echo $num + 1 ?></a></li>
          <?php }  ?>
        </ul>
    <?php } ?>
  <?php } else { ?>

  <b>No content has been created yet.</b>

<?php } ?>
</div>