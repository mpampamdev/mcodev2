<?php $show_in_add = $this->mcrud_build->showInAdd(); ?>
<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        {php_open_tag_echo}ucwords($title_module){php_close_tag}
      </div>
      <div class="card-body">
          <form action="{php_open_tag_echo}$action{php_close_tag}" id="form" autocomplete="off">
<?php foreach ($show_in_add as $field): ?>

<?php if (formType($field) != "timestamp"): ?>
          <div class="form-group">
            <label><?=label($field)?></label>
<?php endif; ?>
<?php if (formType($field) == "number"): ?>
            <input type="number" class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>">
<?php elseif(formType($field) == "text"): ?>
            <input type="text" class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>">
<?php elseif(formType($field) == "textarea"): ?>
            <textarea class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>" rows="3" cols="80"></textarea>
<?php elseif(formType($field) == "upload_image"): ?>
            <input type="file" name="img" class="file-upload-default" data-id="<?=$field?>"/>
            <div class="input-group col-xs-12">
              <input type="hidden" class="file-dir" name="file-dir-<?=$field?>" data-id="<?=$field?>"/>
              <input type="text" class="form-control form-control-sm file-upload-info file-name" data-id="<?=$field?>" placeholder="<?=label($field)?>" readonly name="<?=$field?>" />
            <span class="input-group-append">
              <button class="btn-remove-image btn btn-danger btn-sm" type="button" data-id="<?=$field?>" style="display:{php_open_tag_echo}$<?=$field?>!=''?'block':'none'{php_close_tag};"><i class="ti-trash"></i></button>
              <button class="file-upload-browse btn btn-primary btn-sm" data-id="<?=$field?>" type="button">Select File</button>
            </span>
            </div>
            <div id="<?=$field?>"></div>
<?php elseif(formType($field) == "text_editor"): ?>
            <textarea class="form-control text-editor" rows="3" data-original-label="<?=$field?>" name="<?=$field?>"></textarea>
            <div id="<?=$field?>"></div>
<?php elseif(formType($field) == "select"): ?>
            <select class="form-control form-control-sm select2" data-placeholder=" -- Select -- " name="<?=$field?>" id="<?=$field?>">
              <option value=""></option>
<?php
  $fieldOption = optionValue($field);
  for ($x=0; $x < count($fieldOption) ; $x++) {
?>
              <option value="<?=$fieldOption[$x]['value']?>"><?=$fieldOption[$x]['label']?></option>
<?php  } ?>
            </select>
<?php elseif(formType($field) == "option"): ?>
<?php
$fieldOption = optionValue($field);
for ($x=0; $x < count($fieldOption) ; $x++) {
?>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="<?=$field?>" value="<?=$fieldOption[$x]['value']?>">
                <?=$fieldOption[$x]['label']?>

                <i class="input-helper"></i>
              </label>
            </div>
<?php  } ?>
            <div id="<?=$field?>"></div>
<?php elseif(formType($field) == "option_relation"): ?>
            <!--
              app_helper.php - methode is_radio
              is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            {php_open_tag_echo}is_radio("<?=optionRelation($field, "relation_table")?>","<?=$field?>","<?=optionRelation($field, "relation_value")?>","<?=optionRelation($field, "relation_label")?>");{php_close_tag}
<?php elseif(formType($field) == "select_relation"): ?>
            <!--
              app_helper.php - methode is_select
              is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            {php_open_tag_echo}is_select("<?=optionRelation($field, "relation_table")?>","<?=$field?>","<?=optionRelation($field, "relation_value")?>","<?=optionRelation($field, "relation_label")?>");{php_close_tag}
<?php elseif(formType($field) == "date"): ?>
            <input type="date" class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>">
<?php elseif(formType($field) == "time"): ?>
            <input type="time" class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>">
<?php elseif(formType($field) == "datetime"): ?>
            <input type="datetime-local" class="form-control form-control-sm" placeholder="<?=label($field)?>" name="<?=$field?>" id="<?=$field?>">
<?php endif; ?>
<?php if (formType($field) != "timestamp"): ?>
          </div>
<?php endif; ?>
<?php endforeach; ?>

          <input type="hidden" name="submit" value="add">

          <div class="text-right">
            <a href="{php_open_tag_echo}url($this->uri->segment(2)){php_close_tag}" class="btn btn-sm btn-danger">{php_open_tag_echo}cclang("cancel"){php_close_tag}</a>
            <button type="submit" id="submit"  class="btn btn-sm btn-primary">{php_open_tag_echo}cclang("save"){php_close_tag}</button>
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
                      .html('{php_open_tag_echo}cclang("save"){php_close_tag}');
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
