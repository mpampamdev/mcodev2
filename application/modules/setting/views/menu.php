<?php $uri = $this->uri->segment(3) ?>
<div class="mb-4">
<?php if ($uri == ""): ?>
  <a class="btn btn-sm btn-icon-text text-dark">
    <i class="fa fa-window-restore"></i> Default
  </a>
<?php else: ?>
  <a href="<?=url("setting")?>" class="btn btn-primary btn-sm btn-icon-text">
    <i class="fa fa-window-restore"></i> Default
  </a>
<?php endif; ?>

<?php if ($uri == "logo"): ?>
  <a class="btn btn-sm btn-icon-text text-dark">
    <i class="fa fa-window-restore"></i> Logo
  </a>
  <?php else: ?>
  <a href="<?=url("setting/logo")?>" class="btn btn-success btn-sm btn-icon-text">
    <i class="fa fa-image"></i> Logo
  </a>
<?php endif;?>


<?php if ($uri == "sosmed"): ?>
  <a class="btn btn-sm btn-icon-text text-dark">
    <i class="fa fa-window-restore"></i> Social Media
  </a>
  <?php else: ?>
  <a href="<?=url("setting/sosmed")?>" class="btn btn-info btn-sm btn-icon-text">
    <i class="fa fa-globe"></i> Social Media
  </a>
<?php endif;?>


<?php if ($uri == "core"): ?>
  <a class="btn btn-sm btn-icon-text text-dark">
    <i class="fa fa-window-restore"></i> Core
  </a>
  <?php else: ?>
  <a href="<?=url("setting/core")?>" class="btn btn-danger btn-sm btn-icon-text">
    <i class="fa fa-cogs"></i> Core
  </a>
<?php endif;?>



</div>
