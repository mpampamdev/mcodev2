<link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.css">
<script src="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.min.js"></script>
<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <?=$this->load->view("menu")?>
        <h4 class="card-title"><?=ucfirst($title_module)?> / Logo</h4>
          <?php if (is_allowed("config_view_logo")): ?>
        <table class="table-setting table-striped table-hover">
          <tr>
            <td class="table-title">Logo (Size 350 x 100px)</td>
            <td>
              <a href="javascript:void(0);" id="logo" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="7" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('logo')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Logo Mini (Size 40 x 34px)</td>
            <td>
              <a href="javascript:void(0);" id="logo_mini" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="8" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('logo_mini')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Favicon</td>
            <td>
              <a href="javascript:void(0);" id="favicon" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="9" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('favicon')?></a>
            </td>
          </tr>
        </table>

        <p class="mt-4">
          <a href="<?=url("filemanager")?>" class="badge badge-primary" target="_blank"><i>Open Filemanager</i></a>
        </p>
      <?php else: ?>
        <?php $this->load->view("core/error403") ?>
      <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php if (is_allowed("config_view_logo")): ?>
<script type="text/javascript">
$(document).ready(function(){
  $.fn.editable.defaults.mode = 'inline';
  $.fn.editable.defaults.ajaxOptions = {type: "POST",dataType : 'JSON'};
   $.fn.editableform.buttons ='<button type="submit" class="btn btn-primary btn-sm editable-submit">' +
                               '<i class="fa fa-fw fa-check"></i>' +
                               '</button>' +
                               '<button type="button" class="btn btn-default btn-sm editable-cancel">' +
                               '<i class="fa fa-fw fa-times"></i>' +
                               '</button>';

  $('#logo').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#logo_mini').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#favicon').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });
});
</script>
<?php endif; ?>
