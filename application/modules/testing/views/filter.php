<form autocomplete="off">

  <div class="form-group">
    <input type="text" id="title" class="form-control form-control-sm" placeholder="Title" />
  </div>


  <div class="form-group">
    <input type="text" id="desc" class="form-control form-control-sm" placeholder="Desc" />
  </div>


  <div class="form-group">
              <!--
                app_helper.php - methode is_select
                is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
              --->
      <?=is_select_filter("auth_user","id_user","id_user","name","Id user");?>
  </div>


  <div class="form-group">
      <label class="mb-0">Id image</label>
              <!--
                app_helper.php - methode is_radio
                is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
              --->
      <?=is_radio_filter("filemanager","id_image","id","file_name");?>
  </div>


  <div class="form-group">
      <label class="mb-0">Status</label>
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" id="status" name="status" value="1">
          ON          <i class="input-helper"></i>
        </label>
      </div>
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" id="status" name="status" value="2">
          OFF          <i class="input-helper"></i>
        </label>
      </div>
  </div>


  <button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
  <button type="button" class="btn btn-primary btn-sm" id="filter">Filter</button>
</form>

<script type="text/javascript">
  $(document).on("click","#filter",function(e){
    e.preventDefault();
    $("#table").DataTable().ajax.reload();
    $('#modalGue').modal('hide');
  })
</script>
