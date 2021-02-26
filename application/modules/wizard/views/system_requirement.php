<h3>System Requirement</h3>
<section>
  <div class="row">
    <div class="col-lg-12 steps2 card-description">
      <h4>System Requirement</h4>
      <hr>
      <table class="table table-striped table-bordered table-step2">
        <tr>
          <th>Server requirements</th>
          <th class="text-center" width="100">Status</th>
        </tr>

        <tr>
          <td>PHP Version 5.6+ (<b><?=phpversion();?></b>)</td>
          <td class="text-center">
            <?php if ($php_version): ?>
                <i class="ti-check text-success"></i>
              <?php else: ?>
                <i class="ti-close text-danger"></i>
            <?php endif; ?>
            <input type="hidden" name="php_version" id="php_version" value="<?=($php_version == false) ? "0":"1"?>">
          </td>
        </tr>

        <tr>
          <td>Mysqli extension</td>
          <td class="text-center">
            <?php if ($mysql_version): ?>
                <i class="ti-check text-success"></i>
              <?php else: ?>
                <i class="ti-close text-danger"></i>
            <?php endif; ?>
          </td>
        </tr>


      </table>


      <table class="table table-striped table-bordered table-step2 mt-3">
        <tr>
          <th>Directory & File Permission</th>
          <th class="text-center" width="100">Status</th>
        </tr>


        <?php foreach ($directory_permission as $perm): ?>
          <tr>
            <td>./<?=$perm?></td>
            <td class="text-center">
              <?php if (!is_writable(FCPATH . $perm)): ?>
                  <i class="ti-close text-danger"></i>
                  <input type="hidden" class="file-dir" name="dir_file_permission[]" id="dir_file_permission" value="0">
                <?php else: ?>
                  <i class="ti-check text-success"></i>
                  <input type="hidden" class="file-dir" name="dir_file_permission[]" id="dir_file_permission" value="1">
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>



    </div>
  </div>
</section>
