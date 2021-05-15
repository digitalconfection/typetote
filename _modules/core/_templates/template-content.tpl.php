<?php if ($page_data['template_type'] == 'content') { ?>
  <article>
  <h1 class="title"><?php echo $page_data['title']; ?></h1>
  <div class="content"><?php echo $page_data['body']; ?></div>
  <?php renderTags($page_data['meta']['tags']); ?>
  </article>
<?php } ?>