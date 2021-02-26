<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <?=$this->load->view("menu")?>
        <h4 class="card-title"><?=ucfirst($title_module)?> / Database / Restore</h4>
        <?php if (count($dir) > 0): ?>
          <div class="alert alert-danger">
            <?=cclang('info_restore')?>
          </div>
          <table id="table" class="table table-stripped table-bordered table-striped">
            <thead>
              <tr>
                <th>File Restore</th>
                <th class="text-center">#</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dir as $dirs): ?>
                <?php
                  $name = substr($dirs,0,-1);
                  // $replace = preg_replace("/[0-9]/","",$name);
                  $explode = explode("_",$name);
                ?>
              <tr>
                <td>Database Backup <?=$explode[0]?> <?=date("H:i:s",strtotime($explode[1]))?></td>
                <td class="text-center">
                  <a id="delete" href="<?=url("core/restroDelete/".enc_url($dirs))?>" class="btn btn-sm btn-danger" title="delete"><i class="fa fa-trash"></i></a>
                  <a href="<?=url("core/downloadDatabase/".enc_url($name))?>" class="btn btn-sm btn-success" title="Download"><i class="mdi mdi-cloud-download"></i></a>
                  <a href="<?=url("core/restoreDatabase/".enc_url($name))?>" id="restore" class="btn btn-sm btn-warning" title="Restore"><i class="mdi mdi-cloud-sync"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          <p><i class="text-center">data is null</i></p>
        <?php endif; ?>

        <a href="<?=url("setting/database")?>" class="btn btn-sm btn-danger">Back</a>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
if ($("#table").length) {
  $("#table").DataTable({
    "searching":false,
    "info":false,
    "ordering":false,
    "bLengthChange": false
  });
}

$(document).on("click","#delete",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('<?=cclang("confirm")?>');
  $('#modalContent').html(`<p class="mb-4"><?=cclang("delete_description")?></p>
														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
	                          <a type='button' class='btn btn-primary btn-sm' id='ya-hapus' href=`+$(this).attr('href')+`><?=cclang("delete_action")?></a>
														`);
  $("#modalGue").modal('show');
});

$(document).on("click","#restore",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('<?=cclang("confirm")?>');
  $('#modalContent').html(`<p class="mb-4">Are you sure you want to restore database?</p>
														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
	                          <a type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-href=`+$(this).attr('href')+`><?=cclang("delete_action")?></a>
														`);
  $("#modalGue").modal('show');
});


</script>
