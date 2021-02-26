<style media="screen">
  .table-show-in{
    collapse:0;
    width: 100%;
  }

  .table-show-in tr th{
    font-size: 12px;
    color:#878787;
    /* text-align: center; */
  }

  .table-show-in tr th,td{
    padding: 5px;
    /* border: 1px solid #b6b6b6; */
  }
</style>
<div class="col-md-8 mx-auto">
  <?php $i = 1; foreach ($this->db->field_data("$table") as $row):?>


  <div class="card mt-3">
    <div class="card-body card-content">
      <div class="row">
        <div class="col-sm-4">
          <table class="table-list">
            <tr>
              <td class="bold">No</td>
              <td>: <?=$i?></td>
            </tr>
            <tr>
              <td class="bold">Field name</td>
              <td>: <?=$row->name?></td>
            </tr>
            <tr>
              <td class="bold">Type</td>
              <td>: <?=$row->type?>(<?=$row->max_length?>)</td>
            </tr>
          </table>
        </div>

        <div class="col-sm-8 forms">
          <?php if ($row->primary_key > 0): ?>
            <input type="hidden" name="primary_key" id="primary_key" value="<?=$row->name?>">
          <?php endif; ?>
          <input type="hidden" id="field_name" name="mcrud[<?=$i?>][<?=$row->name?>][field_name]" value="<?=$row->name?>">
          <input type="hidden" id="sort" name="mcrud[<?=$i?>][<?=$row->name?>][sort]" value="<?=$i?>">

          <table class="table-show-in">
              <tr>
                <th colspan="4">Show In</th>
              </tr>

              <tr>
                <td>
                  <div class="form-check form-check-flat form-check-primary mb-3">
                    <label class="form-check-label">
                      <input type="checkbox" <?=$row->primary_key < 1 ? "checked":""?> class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_table]" value="true">
                      Column Table
                    <i class="input-helper"></i></label>
                  </div>
                </td>

                <td>
                  <div class="form-check form-check-flat form-check-primary mb-3">
                    <label class="form-check-label">
                      <input type="checkbox" <?=$row->primary_key < 1 ? "checked":""?> class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_add]" value="true">
                      Form Add
                    <i class="input-helper"></i></label>
                  </div>
                </td>

                <td>
                  <div class="form-check form-check-flat form-check-primary mb-3">
                    <label class="form-check-label">
                      <input type="checkbox" <?=$row->primary_key < 1 ? "checked":""?> class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_update]" value="true">
                      Form Update
                    <i class="input-helper"></i></label>
                  </div>
                </td>

                <td>
                  <div class="form-check form-check-flat form-check-primary mb-3">
                    <label class="form-check-label">
                      <input type="checkbox" <?=$row->primary_key < 1 ? "checked":""?> class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_view]" value="true">
                      View
                    <i class="input-helper"></i></label>
                  </div>
                </td>

                <td>
                  <div class="form-check form-check-flat form-check-primary mb-3">
                    <label class="form-check-label">
                      <input type="checkbox" <?=$row->primary_key < 1 ? "checked":""?> class="form-check-input" name="mcrud[<?=$i?>][<?=$row->name?>][show_in_filter]" value="true">
                      Filter
                    <i class="input-helper"></i></label>
                  </div>
                </td>

              </tr>
          </table>



          <div class="form-group">
              <label >Label</label>
              <input type="text" class="form-control form-control-sm" name="mcrud[<?=$i?>][<?=$row->name?>][field_label]" value="<?=str_replace("_", " ", ucwords($row->name))?>">
          </div>



          <div class="form-group mb-0">
            <label for="">Form Type</label>
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
                <label for="">label&nbsp;&nbsp;</label>
                <input type="text" name="mcrud[<?=$i?>][<?=$row->name?>][option][0][label]">
              </div>
              <div class="box">
                <label for="">value&nbsp;</label>
                <input type="text" name="mcrud[<?=$i?>][<?=$row->name?>][option][0][value]">
              </div>
            </div>
          </div>
          <a class="btn btn-sm btn-block add-option"><i class="fa fa-plus"></i> Add New</a>
        </div>


        <div class="box-container-relation display-none mt-0">
          <div class="form-group">
            <label for="">Select Table</label>
            <select class="form-control chosen chosen-select-width relation_table" name="mcrud[<?=$i?>][<?=$row->name?>][relation_table]" data-placeholder="Select table">
              <option value=""></option>
              <?php foreach ($this->db->list_tables() as $table): ?>
                <option value="<?= $table; ?>"><?= $table; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group display-none">
            <label for="">Select value</label>
            <select class="form-control chosen chosen-select-width relation_value" name="mcrud[<?=$i?>][<?=$row->name?>][relation_value]" data-placeholder="Select ID">
              <option value=""></option>
            </select>
          </div>

          <div class="form-group display-none">
            <label for="">Select label</label>
            <select class="form-control chosen chosen-select-width relation_label" name="mcrud[<?=$i?>][<?=$row->name?>][relation_label]" data-placeholder="Select label">
              <option value=""></option>
            </select>
          </div>

        </div>



        <div class="form-group mt-4">
          <label for="">Form Validation</label>
           <select class="form-control chosen  chosen-select-width rules_validation"  name="mcrud[<?=$i?>][<?=$row->name?>][rules][]" id="mcrud[<?=$i?>][<?=$row->name?>][rules]" multiple="multiple" data-placeholder="+ Add Rules">
             <option value=""></option>
           </select>
         </div>
        </div>
      </div>

    </div>
  </div>


  <?php $i++ ?>
  <?php  endforeach; ?>
</div>
