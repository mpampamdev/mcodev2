<h3>System configuration</h3>
<section>
  <div class="row">
    <div class="col-lg-12 steps4 card-description">
      <h4>System configuration</h4>
      <hr>
      <div class="form-group">
        <label for="">url_suffix</label>
        <input type="text" class="form-control form-control-sm" name="url_suffix" id="url_suffix" value="<?=$this->config->item("url_suffix")?>">
      </div>

      <div class="form-group">
        <label for="">encryption_key</label>
        <input type="text" class="form-control form-control-sm" name="encryption_key" id="encryption_key" value="<?=$this->config->item("encryption_key")?>">
      </div>

      <div class="form-group">
        <label for="">encryption_url</label>
        <select class="form-control form-control-sm" name="encryption_url" id="encryption_url">
          <option  value="false">N</option>
          <option <?=$this->config->item("encryption_url") == true ? "selected":""?> value="true">Y</option>
        </select>
      </div>


      <div class="form-group">
        <label for="">time_zone</label>
        <select class="form-control form-control-sm select-option" name="time_zone" id="time_zone">
          <?php foreach ($time_zone as $timezone): ?>
            <option <?=$this->config->item("time_zone") == $timezone ? "selected":""?> value="<?=$timezone?>"><?=$timezone?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="">max_upload</label> (Kb)
        <input type="text" class="form-control form-control-sm" name="max_upload" id="max_upload" value="<?=$this->config->item("max_upload")?>">
      </div>
    </div>
  </div>
</section>
