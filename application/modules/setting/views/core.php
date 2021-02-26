<link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.css">
<style media="screen">
  .editable-empty{
    color:red!important;
  }
</style>
<script src="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.min.js"></script>
<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <?=$this->load->view("menu")?>
        <h4 class="card-title"><?=ucfirst($title_module)?> / Core</h4>
        <?php if (is_allowed("config_view_core")): ?>
        <table class="table-setting table-striped table-hover">
          <tr>
            <td class="table-title"><?=cclang("time_zone")?></td>
            <td>
              <a href="javascript:void(0);" id="time_zone" data-url="<?=url("setting/update_action")?>" data-type="select" data-value="<?=$this->config->item("time_zone")?>" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("time_zone")?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Encryption Key</td>
            <td>
              <a href="javascript:void(0);" id="encryption_key" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("encryption_key")?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Encryption Url</td>
            <td>
              <a href="javascript:void(0);" id="encryption_url" data-url="<?=url("setting/update_action")?>" data-type="select" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("encryption_url") == 1 ? "Y":"N"?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Url suffix</td>
            <td>
              <a href="javascript:void(0);" id="url_suffix" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("url_suffix")?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Route admin</td>
            <td>
              <a href="javascript:void(0);" id="route_admin" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="998" class="editable editable-click" title="<?=cclang("update")?>"><?=ADMIN_ROUTE?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Route login</td>
            <td>
              <a href="javascript:void(0);" id="route_login" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="998" class="editable editable-click" title="<?=cclang("update")?>"><?=LOGIN_ROUTE?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title">Max Upload</td>
            <td>
              <a href="javascript:void(0);" id="max_upload" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("max_upload")?></a> Kb
            </td>
          </tr>

          <tr>
            <td class="table-title"><?=cclang("language")?></td>
            <td>
              <a href="javascript:void(0);" id="language" data-url="<?=url("setting/update_action")?>" data-type="select" data-value="<?=$this->config->item("language")?>" data-pk="999" class="editable editable-click" title="<?=cclang("update")?>"><?=$this->config->item("language")?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title"><?=cclang("user_log_activity")?></td>
            <td>
              <a href="javascript:void(0);" id="user_log_status" data-url="<?=url("setting/update_action")?>" data-type="select" data-value="<?=setting('user_log_status')?>" data-pk="61" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('user_log_status')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title"><?=cclang("maintenance")?></td>
            <td>
              <a href="javascript:void(0);" id="maintenance_status" data-url="<?=url("setting/update_action")?>" data-type="select" data-value="<?=setting('maintenance_status')?>" data-pk="60" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('maintenance_status')?></a>
            </td>
          </tr>
        </table>
      <?php else: ?>
        <?php $this->load->view("core/error403") ?>
      <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php if (is_allowed("config_view_core")): ?>
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


  $('#maintenance_status').editable({
    inputclass: 'form-control-sm',
    source: [
  			{value: 'Y', text: 'Y'},
  			{value: 'N', text: 'N'}
  		],
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#encryption_key').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#encryption_url').editable({
    inputclass: 'form-control-sm',
    source: [
  			{value: "TRUE", text: 'Y'},
  			{value: "FALSE", text: 'N'}
  		],
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#url_suffix').editable({
    inputclass: 'form-control-sm',
    success: function(data ,newValue) {
     if (data.success != true) {
       return data.msg;
     }else {
       location.href='<?=base_url()?><?=ADMIN_ROUTE?>/setting/core'+newValue;
     }
   }
  });

  $('#route_admin').editable({
    inputclass: 'form-control-sm',
    success: function(data ,newValue) {
     if (data.success != true) {
       return data.msg;
     }else {
       location.href='<?=base_url()?>'+data.value+"/setting/core<?=$this->config->item("url_suffix")?>";
     }
   }
  });

  $('#route_login').editable({
    inputclass: 'form-control-sm',
    success: function(data ,newValue) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#max_upload').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });


  $('#user_log_status').editable({
    inputclass: 'form-control-sm',
    source: [
  			{value: 'Y', text: 'Y'},
  			{value: 'N', text: 'N'}
  		],
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#language').editable({
    inputclass: 'form-control-sm',
    source: [
  			{value: 'indonesia', text: 'indonesia'},
  			{value: 'english', text: 'english'}
  		],
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });


  $('#time_zone').editable({
    inputclass: 'form-control-sm',
    source: <?=$time_zone?>,
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });


});
</script>
<?php endif; ?>
