<?php 
// TODO: find a better way to do this.
if ($page_data['items']['content']) { 

  if ($page_data['pagination_num']) {
    $pag_num = $page_data['pagination_num'];

  } else {
    $pag_num = 0;
  }

  $list = $page_data['items']['content'][$pag_num];

} else {
  $list = $page_data['list'];
}
?>

<h1><i class="fas fa-home"></i> Dashboard</h1>

<div class="dashboard-filter">
  <span class="label">View:</span> <a href="<?php echo SiteInfo::baseUrl() ?>admin"><i class="fas fa-home"></i> All</a> <a href="<?php echo SiteInfo::baseUrl() ?>admin?q=posts"><i class="fas fa-thumbtack"></i> Posts</a><a href="<?php echo SiteInfo::baseUrl() ?>admin?q=pages"><i class="fas fa-book"></i> Pages</a><a href="<?php echo SiteInfo::baseUrl() ?>admin?q=blocks"><i class="fas fa-th-large"></i> Blocks</a>
</div>
<?php if (empty($list)) { ?> 

  <h3>No content has been created.</h3>
  
<?php } else { ?>
  <div class="page-well">
  <b>Content: <?php echo $page_data['sort']; ?></b>
  <br>
  <br>
  
  <table class="striped-table">
    <?php foreach ($list as $item) { ?>
      <tr>
        <td>
        <!-- If in Draft mode show this -->
        <?php if($item['meta']['entity_status'] == 'draft'){?>
          <a href="<?php echo SiteInfo::baseUrl() . 'admin/' ?>edit?q=<?php echo $item['meta']['entity_id']; ?>"><?php echo $item['title'] ?></a>
          <span class="draft-icon">Draft</span>
        <?php } elseif($item['meta']['entity_type'] == 'block') { ?>
          <a href="<?php echo SiteInfo::baseUrl() . 'admin/' ?>edit?q=<?php echo $item['meta']['entity_id']; ?>"><?php echo $item['title'] ?></a>
        <?php } else { ?> 
          <a href="<?php echo SiteInfo::baseUrl() . $item['meta']['path']?>"><?php echo $item['title'] ?></a>
        <?php } ?>
        </td>

        <td><?php echo ucfirst($item['meta']['entity_type']); ?></td>
        <td><?php echo $item['meta']['date_published']; ?></td>
        <td><a href="<?php echo SiteInfo::baseURl() . 'admin/' ?>edit?q=<?php echo $item['meta']['entity_id'] ?>" title="Edit" class="utl-link">Edit</a> | <a href="<?php echo SiteInfo::baseURl() . 'admin/' ?>delete?q=<?php echo $item['meta']['entity_id'] ?>" class="utl-link">Delete</a></td>
      </tr>
    <?php } ?>
  </table>
  </div>
<?php } ?>

<br>
<br>
<a href="<?php echo SiteInfo::baseUrl() . 'admin/post'; ?>" class="btn"><i class="fas fa-edit"></i> Write</a>
<br>
<br>

<?php if (isset($page_data['items']['pagination'][1])) { ?>
    <ul class="pagination">
      <?php foreach ($page_data['items']['pagination'] as $key => $num) { ?>
   
          <li><a href="<?php echo $page_data['base_url'] .'&pg='.$num ?>"><?php echo $num + 1 ?></a></li>

      <?php } ?>
    </ul>
  <?php } ?>

  