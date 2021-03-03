<?php $show_in_view = $this->mcrud_build->showInView();  ?>
<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card-header bg-primary text-white">
      {php_open_tag_echo}ucwords($title_module){php_close_tag}
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
<?php foreach ($show_in_view as $field): ?>
<?php if (formType($field) == "datetime" OR formType($field) == "timestamp"): ?>
        <tr>
          <td><?=label($field)?></td>
          <td>{php_open_tag_echo}$<?=$field?> != "" ? date('d-m-Y H:i',strtotime($<?=$field?>)):""{php_close_tag}</td>
        </tr>
<?php elseif (formType($field) == "date"): ?>
      <tr>
        <td><?=label($field)?></td>
        <td>{php_open_tag_echo}$<?=$field?> != "" ? date('d-m-Y',strtotime($<?=$field?>)):""{php_close_tag}</td>
      </tr>
<?php elseif (formType($field) == "time"): ?>
        <tr>
          <td><?=label($field)?></td>
          <td>{php_open_tag_echo}$<?=$field?> != "" ? date('H:i',strtotime($<?=$field?>)) : ""{php_close_tag}</td>
        </tr>
<?php elseif (formType($field) == "upload_image"): ?>
        <tr>
          <td><?=label($field)?></td>
          <td>{php_open_tag_echo}is_image($<?=$field?>){php_close_tag}</td>
        </tr>
<?php else: ?>
        <tr>
          <td><?=label($field)?></td>
          <td>{php_open_tag_echo}$<?=$field?>{php_close_tag}</td>
        </tr>
<?php endif; ?>
<?php endforeach; ?>
        </table>

        <a href="{php_open_tag_echo}url($this->uri->segment(2)){php_close_tag}" class="btn btn-sm btn-danger mt-3">{php_open_tag_echo}cclang("back"){php_close_tag}</a>
      </div>
    </div>
  </div>
</div>
