<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        <?=ucwords($title_module)?>
      </div>
      <div class="card-body">
          <form action="<?=$action?>" id="form" autocomplete="off">
          
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control form-control-sm" placeholder="Title" name="title" id="title" value="<?=$title?>">
          </div>
        
          <div class="form-group">
            <label>Desc</label>
            <textarea class="form-control text-editor" rows="3" data-original-label="desc" name="desc" id="desc"><?=$desc?></textarea>
          </div>
        
          <div class="form-group">
            <label>Id user</label>
            <!--
              app_helper.php - methode is_select
              is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            <?=is_select("auth_user","id_user","id_user","name","$id_user");?>
          </div>
        
          <div class="form-group">
            <label>Id image</label>
            <!--
              app_helper.php - methode is_radio
              is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            <?=is_radio("filemanager","id_image","id","file_name","$id_image");?>
          </div>
        
          <div class="form-group">
            <label>Status</label>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" <?=($status == 1 ? "checked":"")?> class="form-check-input" name="status" value="1">
                ON
                <i class="input-helper"></i>
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" <?=($status == 2 ? "checked":"")?> class="form-check-input" name="status" value="2">
                OFF
                <i class="input-helper"></i>
              </label>
            </div>
            <div id="status"></div>
          </div>
        
        
          <input type="hidden" name="submit" value="update">

          <div class="text-right">
            <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger"><?=cclang("cancel")?></a>
            <button type="submit" id="submit"  class="btn btn-sm btn-primary"><?=cclang("update")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$("#form").submit(function(e){
e.preventDefault();
var me = $(this);
$("#submit").prop('disabled',true).html('Loading...');
$(".form-group").find('.text-danger').remove();
$.ajax({
      url             : me.attr('action'),
      type            : 'post',
      data            :  new FormData(this),
      contentType     : false,
      cache           : false,
      dataType        : 'JSON',
      processData     :false,
      success:function(json){
        if (json.success==true) {
          location.href = json.redirect;
          return;
        }else {
          $("#submit").prop('disabled',false)
                      .html('<?=cclang("save")?>');
          $.each(json.alert, function(key, value) {
            var element = $('#' + key);
            $(element)
            .closest('.form-group')
            .find('.text-danger').remove();
            $(element).after(value);
          });
        }
      }
    });
});
</script>
