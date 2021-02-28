<?php $show_in_filter = $this->mcrud_build->showInFilter();?>
<form autocomplete="off">
<?php foreach ($show_in_filter as $field): ?>

  <div class="form-group">
<?php if (formType($field) == "datetime" OR formType($field) == "timestamp"): ?>
    <input type="datetime-local" id="<?=$field?>" class="form-control form-control-sm" placeholder="<?=label($field)?>" />
<?php elseif(formType($field) == "time"): ?>
    <input type="datetime-local" id="<?=$field?>" class="form-control form-control-sm" placeholder="<?=label($field)?>" />
<?php elseif(formType($field) == "time"): ?>
    <input type="time" id="<?=$field?>" class="form-control form-control-sm" placeholder="<?=label($field)?>" />
<?php elseif(formType($field) == "select"): ?>
    <select class="form-control form-control-sm select2" data-placeholder=" -- Select <?=label($field)?> -- " name="<?=$field?>" id="<?=$field?>">
      <option value=""></option>
<?php
    $fieldOption = optionValue($field);
    for ($x=0; $x < count($fieldOption) ; $x++) {
?>
      <option value="<?=$fieldOption[$x]['value']?>"><?=$fieldOption[$x]['label']?></option>
<?php  } ?>
    </select>
<?php elseif(formType($field) == "option"): ?>
      <label class="mb-0"><?=label($field)?></label>
<?php
  $fieldOption = optionValue($field);
for ($x=0; $x < count($fieldOption) ; $x++) {
?>
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" id="<?=$field?>" name="<?=$field?>" value="<?=$fieldOption[$x]['value']?>">
          <?=$fieldOption[$x]['label']?>
          <i class="input-helper"></i>
        </label>
      </div>
<?php  } ?>
<?php elseif(formType($field) == "option_relation"): ?>
      <label class="mb-0"><?=label($field)?></label>
              <!--
                app_helper.php - methode is_radio
                is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
              --->
      {php_open_tag_echo}is_radio_filter("<?=optionRelation($field, "relation_table")?>","<?=$field?>","<?=optionRelation($field, "relation_value")?>","<?=optionRelation($field, "relation_label")?>");{php_close_tag}
<?php elseif(formType($field) == "select_relation"): ?>
              <!--
                app_helper.php - methode is_select
                is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
              --->
      {php_open_tag_echo}is_select_filter("<?=optionRelation($field, "relation_table")?>","<?=$field?>","<?=optionRelation($field, "relation_value")?>","<?=optionRelation($field, "relation_label")?>","<?=label($field)?>");{php_close_tag}
<?php else: ?>
    <input type="text" id="<?=$field?>" class="form-control form-control-sm" placeholder="<?=label($field)?>" />
<?php endif; ?>
  </div>

<?php endforeach; ?>

  <button type='button' class='btn btn-default btn-sm' data-dismiss='modal'>{php_open_tag_echo}cclang("cancel"){php_close_tag}</button>
  <button type="button" class="btn btn-primary btn-sm" id="filter">Filter</button>
</form>

<script type="text/javascript">
  $(document).on("click","#filter",function(e){
    e.preventDefault();
    $("#table").DataTable().ajax.reload();
    $('#modalGue').modal('hide');
  })
</script>
