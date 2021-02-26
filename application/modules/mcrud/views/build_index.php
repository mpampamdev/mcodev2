<?php $show_in_filter = $this->mcrud_build->showInFilter();
  $show_in_add = $this->mcrud_build->showInAdd();
?>
<div class="row">
  <div class="col-md-12 col-xl-12 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        {php_open_tag_echo}ucwords($title_module){php_close_tag}
      </div>
      <div class="card-body">
        <div class="mb-2">
<?php if (count($show_in_add) > 0): ?>
          <a href="{php_open_tag_echo}url("<?=strtolower($controller)?>/add"){php_close_tag}" class="btn btn-sm btn-success btn-icon-text"><i class="fa fa-file btn-icon-prepend"></i>{php_open_tag_echo}cclang("add_new"){php_close_tag}</a>
<?php endif; ?>
          <button type="button" id="reload" class="btn btn-sm btn-info-2 btn-icon-text"><i class="mdi mdi-backup-restore btn-icon-prepend"></i> <?=cclang("reload")?></button>
    <?php if (count($show_in_filter) > 0): ?>
      <a href="{php_open_tag_echo}url("<?=strtolower($controller)?>/filter/"){php_close_tag}" id="filter-show" class="btn btn-sm btn-primary btn-icon-text"><i class="mdi mdi-magnify btn-icon-prepend"></i> Filter</a>
    <?php endif; ?>
    </div>
        <table class="table table-bordered table-striped" id="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr><?php $show_in_table = $this->mcrud_build->showInTable(true);
                foreach ($show_in_table as $field) {
                  echo "\n\t\t\t\t\t\t\t<th>".$field."</th>";
                }
               ?>

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
          "url": "{php_open_tag_echo} url("<?=strtolower($controller)?>/json"){php_close_tag}",
          "type": "POST",
<?php if(count($show_in_filter) > 0): ?>
          "data":function(data){
<?php foreach ($show_in_filter as $field): ?>
<?php if(formType($field) == "option" OR formType($field) == "option_relation"):?>
              data.<?=$field?> = $("#<?=$field?>:checked").val();
<?php else: ?>
              data.<?=$field?> = $("#<?=$field?>").val();
<?php endif;?>
<?php endforeach; ?>
              }
<?php endif;?>
            },

      //Set column definition initialisation properties.
        "columnDefs": [
<?php
  for ($i=0; $i < count($show_in_table) ; $i++) {
    echo "\n\t\t\t\t\t{
            \"targets\": $i,
            \"orderable\": false
          },\n";
  }
 ?>

        {
            "className": "text-center",
            "orderable": false,
            "targets": <?=$i++?>

        },
      ],
    });

  $("#reload").click(function(){
    <?php if(count($show_in_filter) > 0): ?>
  <?php foreach ($show_in_filter as $field) { ?>
  $("#<?=$field?>").val("");
  <?php }?>
  <?php endif; ?>
  table.ajax.reload(null, false);
  });

  $(document).on("click","#filter-show",function(e){
    e.preventDefault();
    $('.modal-dialog').addClass('modal-md');
    $("#modalTitle").text('Filter');
    $('#modalContent').load($(this).attr('href'));
    $("#modalGue").modal('show');
  });

  $(document).on("click","#delete",function(e){
    e.preventDefault();
    $('.modal-dialog').addClass('modal-sm');
    $("#modalTitle").text('{php_open_tag_echo}cclang("confirm"){php_close_tag}');
    $('#modalContent').html(`<p class="mb-4">{php_open_tag_echo}cclang("delete_description"){php_close_tag}</p>
  														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'>{php_open_tag_echo}cclang("cancel"){php_close_tag}</button>
  	                          <button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=`+$(this).attr('alt')+`  data-url=`+$(this).attr('href')+`>{php_open_tag_echo}cclang("delete_action"){php_close_tag}</button>
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
