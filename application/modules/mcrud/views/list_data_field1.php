<div class="card mb-4">
  <div class="card-body">
    <table class="table table-bordered field-list" id="list_field">
      <thead class="bg-primary text-white">
        <tr>
           <th valign="midle" style="text-align: center;width:10px">#</th>
           <th valign="midle" style="width:200px">Field</th>
           <th valign="midle" style="text-align: center;width:180px">#</th>
           <th valign="midle" style="text-align: center;width:200px">Input Type</th>
           <th valign="midle" style="text-align: center;width:200px">Validation</th>
        </tr>
      </thead>


      <tbody id="sorted_table">
        <?php $i = 1; foreach ($this->db->field_data("$table") as $row):?>
        <tr>
          <?php if ($row->primary_key > 0): ?>
            <input type="hidden" name="primary_key" id="primary_key" value="<?=$row->name?>">
          <?php endif; ?>
          <input type="hidden" id="field_name" name="mcrud[<?=$i?>][<?=$row->name?>][field_name]" value="<?=$row->name?>">
          <td class="drag field-name">
            <i class="fa fa-arrows"></i>
            <input type="hidden" class="sort" name="mcrud[<?=$i?>][<?=$row->name?>][sort]" value="<?=$i?>">
          </td>
          <td class="field-name">
              <input type="text" id="label-field" class="label-field"  name="mcrud[<?=$i?>][<?=$row->name?>][label]" value="<?=$row->name?>">
              <span style="font-size:11px;"><?=$row->type?>(<?=$row->max_length?>)</span>
              <input type="hidden" name="mcrud[<?=$i?>][<?=$row->name?>][max_length]" value="<?=$row->max_length > 0 ? $row->max_length:"0"?>">
          </td>
          <td>
            <div class="form-check form-check-flat form-check-primary mb-3">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_table]" value="true">
                Show In Table
              <i class="input-helper"></i></label>
            </div>
          </td>
          <td>
            <div class="form-group mb-0 mt-0">
              <select class="form-control chosen chosen-select-width form_type" name="mcrud[<?=$i?>][<?=$row->name?>][form_type]" id="mcrud[<?=$i?>][<?=$row->name?>][form_type]">
                <?php foreach ($form_type as $form_types): ?>
                  <?php
                    if ($row->type == "int" AND $form_types['type']=="number") {
                      $selected = "selected";
                    }elseif ($row->type == "varchar" AND $form_types['type']=="text") {
                      $selected = "selected";
                    }elseif ($row->type == "text" AND $form_types['type']=="textarea") {
                      $selected = "selected";
                    }elseif ($row->type == "date" AND $form_types['type']=="date") {
                      $selected = "selected";
                    }elseif ($row->type == "time" AND $form_types['type']=="time") {
                      $selected = "selected";
                    }elseif ($row->type == "datetime" AND $form_types['type']=="datetime") {
                      $selected = "selected";
                    }else {
                      $selected = "";
                    }
                   ?>
                  <option value="<?=$form_types['type']?>" class="<?=$form_types['type']?>" <?=$selected?> opsi="<?=$form_types['opsi']?>" title="<?=$form_types['type']?>"><?=ucwords(str_replace("_"," ",$form_types['type']))?></option>
                <?php endforeach; ?>
              </select>
          </div>

          <div class="box-container-option display-none">
            <div class="box-option">
              <div class="box-option-item">
                <div class="box">
                  <label for="">label</label>
                  <input type="text" name="mcrud[<?=$i?>][<?=$row->name?>][option][0][label]">
                </div>
                <div class="box">
                  <label for="">value</label>
                  <input type="text" name="mcrud[<?=$i?>][<?=$row->name?>][option][0][value]">
                </div>
              </div>
            </div>
            <a class="btn btn-sm btn-block add-option"><i class="fa fa-plus"></i> Add New</a>
          </div>

        </td>
        <td>
          <div class="form-group mt-4">
             <select class="form-control chosen  chosen-select-width rules_validation"  name="mcrud[<?=$i?>][<?=$row->name?>][rules][]" id="mcrud[<?=$i?>][rules][<?=$row->name?>]" multiple="multiple" data-placeholder="+ Add Rules">
               <option value=""></option>
             </select>
           </div>
        </td>
        </tr>

      <?php $i++ ?>
      <?php  endforeach; ?>

      </tbody>
    </table>
  </div>
</div>


public function __construct()
{

  if (file_exists(APPPATH.'config/app.php')) {
    if (file_exists(APPPATH.'config/app.cfg')) {
      $arr= json_decode(file_get_contents(APPPATH.'config/app.cfg'), true);
      $arr2 	= array("app" => "m-code", "author" =>  "mpampam", "version" => "V.0.0.1", "facebook" => "https://web.facebook.com/mpampam", "fanspage" => "https://web.facebook.com/programmerjalanan", "youtube" => "https://www.youtube.com/channel/UC1TlTaxRNdwrCqjBJ5zh6TA", "instagram"=>"https://www.instagram.com/programmer_jalanan");
      $result = array_diff($arr , $arr2);
      if (!empty($result)) {
        echo "Please DO NOT modify this information";
        die();
      }
    }else {
      echo "Please DO NOT modify this information";
      die();
    }
  }else {
    echo "Please DO NOT modify this information";
    die();
  }
