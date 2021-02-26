<link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.css">
<script src="<?=base_url()?>_temp/backend/vendors/xeditable/bootstrap-editable.min.js"></script>
<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <?=$this->load->view("menu")?>
        <h4 class="card-title"><?=ucfirst($title_module)?> / Social Media</h4>
        <?php if (is_allowed("config_view_sosmed")): ?>
        <table class="table-setting table-striped table-hover">
          <tr>
            <td class="table-title"><i class="ti-facebook cl-facebook"></i> Facebook</td>
            <td>
              <a href="javascript:void(0);" id="facebook" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="50" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('facebook')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title"><i class="ti-instagram cl-instagram"></i> Instagram</td>
            <td>
              <a href="javascript:void(0);" id="instagram" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="51" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('instagram')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title"><i class="ti-youtube cl-youtube"></i> Youtube</td>
            <td>
              <a href="javascript:void(0);" id="youtube" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="52" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('youtube')?></a>
            </td>
          </tr>

          <tr>
            <td class="table-title"><i class="ti-twitter cl-twitter"></i> Twitter</td>
            <td>
              <a href="javascript:void(0);" id="twitter" data-url="<?=url("setting/update_action")?>" data-type="text" data-pk="53" class="editable editable-click" title="<?=cclang("update")?>"><?=setting('twitter')?></a>
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

<?php if (is_allowed("config_view_sosmed")): ?>
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



  $('#facebook').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#instagram').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#youtube').editable({
    inputclass: 'form-control-sm',
    success: function(data) {
     if (data.success != true) {
       return data.msg;
     }
   }
  });

  $('#twitter').editable({
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
