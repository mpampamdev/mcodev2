<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <?=$this->load->view("menu")?>
        <h4 class="card-title"><?=ucfirst($title_module)?> / Database</h4>
        <div class="pt-5 pb-5 col-md-8 mx-auto">
          <div class="row">
            <?php if (is_allowed('config_database_backup')): ?>
              <div class="col-sm-6">
                <div class="dropdown">
                  <button class="btn btn-lg btn-success btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-vector-difference-ba"></i> Backup/Download Database
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?=url('core/backupdatabase/1')?>">Download</a>
                    <a class="dropdown-item" href="<?=url('core/backupdatabase/2')?>">Save on list restore</a>
                    <a class="dropdown-item" href="<?=url('core/backupdatabase/3')?>">Download & Save on list restore</a>
                  </div>
                </div>
              </div>
            <?php endif; ?>
              <div class="col-sm-6">
                <div class="dropdown">
                  <button class="btn btn-lg btn-primary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-vector-difference-ba"></i> Import/Restore Database
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if (is_allowed('config_database_import')): ?>
                    <a class="dropdown-item" id="import" href="<?=url('core/backupdatabase')?>">Import</a>
                    <?php endif; ?>
                    <?php if (is_allowed('config_database_restore')): ?>
                    <a class="dropdown-item" id="restore" href="<?=url('setting/restoreDatabase')?>">List Restore</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
