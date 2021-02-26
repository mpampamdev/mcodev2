<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        <?=ucwords($title_module)?>
      </div>
      <div class="card-body">
        <div class="mb-2">
          <?php if (is_allowed('crud_generator_add')): ?>
            <a href="<?=site_url("mcrud")?>" class="btn btn-sm btn-success btn-icon-text"><i class="fa fa-file btn-icon-prepend"></i> Add Module Crud Generator</a>
          <?php endif; ?>
          <button type="button" id="reload" class="btn btn-sm btn-info-2 btn-icon-text"><i class="mdi mdi-backup-restore btn-icon-prepend"></i> Reload</button>
          <a href="<?=url("m_crud_generator/about")?>" id="about" class="btn btn-sm btn-info"><i class="mdi mdi-information btn-icon-prepend"></i></a>
        </div>
        <table class="table table-bordered table-striped" id="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>Module name</th>
							<th>Module Directroy</th>
							<th>Table</th>
							<th>Created at</th>
              <th>#</th>
            </tr>
          </thead>

        </table>

      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
$(document).ready(function(){
var table;
//datatables
  table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      "ordering": true,
      "searching": false,
      "info": false,
      "bLengthChange": false,
      oLanguage: {
          sProcessing: '<i class="fa fa-spinner fa-spin fa-fw"></i> Loading...'
      },

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?= url("m_crud_generator/json")?>",
          "type": "POST",
            },

      //Set column definition initialisation properties.
        "columnDefs": [

					{
            "targets": 0,
            "orderable": false
          },

					{
            "targets": 1,
            "orderable": false
          },

					{
            "targets": 2,
            "orderable": false
          },

					{
            "targets": 3,
            "orderable": false
          },

        {
            "className": "text-center",
            "orderable": false,
            "targets": 4
        },
      ],
    });

  $("#reload").click(function(){
      table.ajax.reload(null, false);
  });

  $(document).on("click","#about",function(e){
    e.preventDefault();
    $('.modal-dialog').removeClass('modal-sm')
                      .removeClass('modal-md')
                      .addClass('modal-lg');
    $("#modalTitle").text('About');
    $('#modalContent').load($(this).attr('href'));
    $("#modalGue").modal('show');
  });

  $(document).on("click","#delete",function(e){
    e.preventDefault();
    $('.modal-dialog').removeClass('modal-lg')
                      .removeClass('modal-md')
                      .addClass('modal-sm');
    $("#modalTitle").text('<?=cclang("confirm")?>');
    $('#modalContent').html(`<p class="mb-4"><?=cclang("delete_description")?></p>
  														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
  	                          <button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=`+$(this).attr('alt')+`  data-url=`+$(this).attr('href')+`><?=cclang("delete_action")?></button>
  														`);
    $("#modalGue").modal('show');
  });


  $(document).on('click','#ya-hapus',function(e){
    $(this).prop('disabled',true)
            .text('Processing...');
    $.ajax({
            url:$(this).data('url'),
            type:'POST',
            cache:false,
            dataType:'json',
            success:function(json){
              $('#modalGue').modal('hide');
              swal(json.msg, {
                icon:json.type_msg
              });
              $('#table').DataTable().ajax.reload();
            }
          });
  });


});
</script>
