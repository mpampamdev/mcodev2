<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <link rel="shortcut icon" href="<?=base_url()?>_temp/uploads/img/<?=setting("favicon")?>" />
    <link href="<?=base_url()?>_temp/backend/css/icons.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/jquery-toast-plugin/jquery.toast.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/chosen/chosen.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/css/custom.css">
    <link rel="shortcut icon" href="<?=base_url()?>_temp/backend/images/favicon.png" />



    <script src="<?=base_url()?>_temp/backend/vendors/js/vendor.bundle.base.js"></script>
    <!-- <script src="<?=base_url()?>_temp/backend/vendors/sortable/Sortable.js"></script> -->
    <script src="<?=base_url()?>_temp/backend/vendors/sweetalert/sweetalert.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/select2/select2.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/chosen/chosen.jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      var BASE_URL = "<?=base_url()?>";
    </script>
    <style media="screen">
    body{
      background: #142935!important
    }
      .content-wrapper{
         min-height:700px;
         padding-bottom: 300px;
         background: #142935!important
        }

      .card.card-table{
        border-radius: 10px;
      }

        .drag{
          cursor: move;
          text-align: center;
        }

        .display-none{
          display:none;
           transition: width 2s linear 1s;
        }

        .label-field{
          border:none;
          border-bottom: 1px dotted #217cc7;
          font-weight: 600;
          font-size: 16px;
          color:#217cc7;
        }

        .label-field:focus{
          border-bottom: 1px dotted #217cc7;
        }

        .chosen-container .chosen-results{
          font-size: 12px;
          max-height: 200px!important;
        }
        .chosen-container-multi .chosen-choices li.search-choice{
          font-size: 12px;
          margin : 3px 3px 3px 0;
        }
        .chosen-container-single .chosen-single{
          padding: 5px 0 0 5px !important;
        }

        .loading{
          text-align: center;
          margin-top:20px;
        }

        .loading p{
          font-weight: bold;
        }

        .box-container-option{
          margin: 0;
          background: #efefef;
        }

        .box-container-option a.add-option{
          font-size: 12px!important;
          height: 30px!important;
          padding: 5px!important;
          background: #40a5d6;
          border-radius:0!important;
        }

        .box-container-option a.add-option:hover{
          cursor: pointer;
        }


        .box-option-item{
          border: 1px solid #d2d6de;
          border-top: none;
          padding: 4px;
          position: relative;
        }

        .box-container-option .box-option .box label{
          font-size: 12px;
          padding-right:10px;
        }

        .box-container-option .box-option .box input{
          background: #efefef;
          border:none;
          border-bottom: 1px dotted #909090;
          font-size: 12px;
          padding-top:0;
          width: 50%;
        }

        .box-container-option .box-option-item a.delete-option{
          position: absolute;
          bottom: 5px;
          right:10px;
        }

        .box-container-option .box-option-item a.delete-option:hover{
          cursor: pointer;
        }

        .box-container-relation{
          margin:0;
          background: #efefef;
          border: 1px solid #d2d6de;
          border-top: none;
          padding: 10px;
          position: relative;
        }

        .box-container-relation .form-group{
          margin-bottom: 3px!important;
        }

        .box-container-relation .form-group label{
          font-size: 11px!important;
          margin-bottom: 3px!important;
        }

        .table-list{
          collapse:0;
          width: 100%;
        }
        .table-list tr td{
          font-size: 14px;
          color:#737373;
          padding:5px;
          /* border:1px solid #c1c1c1; */
        }

        .table-list tr td.bold{
          font-weight: 500;
          /* width: 150px; */
        }

        .form-group label{
          color:#737373;
          font-size: 12px!important;
          font-weight: 500;
        }

        /*.forms{
          border-left:1px solid #c1c1c1;
        }*/

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

        .card.card-border-radius{
          border-radius: 10px;
        }

        .card-content .form-group .form-control-sm{
          height: 2.1405rem!important;
          border-radius: 0!important;
          font-size: 13px!important;
        }

        .card-content .form-check .form-check-label{
          font-size: 0.775rem!important;
        }

        .loading-keyboard{
          display: none;
          text-align: center;
          position: fixed;
          z-index:999;
          width: 100%;
          height: 900px;
          background-color: rgba(0, 0, 0, 0.88);
        }

        .loading-keyboard img{
          margin-top: 100px;
          margin-left: 400px;
          margin-right: 400px;
        }

        .loading-keyboard p{
          /* padding-top: 200px; */
          text-align: center;
          font-size: 22px;
          font-weight: 600;
          padding: 20px;
          color:#33ff00;
          animation:blinking 1.5s infinite;
        }

        @keyframes blinking{
          /*0%{   color: #fff;   }*/
          0%{   color: #1cff00; }
          50%{   color: #30a43b; }
          100%{  color: transparent;   }
          }

    </style>
  </head>
  <body>
    <div class="loading-keyboard">
      <img src="<?=base_url()?>_temp/backend/loading.svg" alt="">
      <p>Sabar Yahhh!!! Lagi Ngoding...</p>
    </div>
    <div class="container-scroller">
        <div class="content-wrapper" >
          <form id="form" action="<?=base_url("mcrud/action")?>" autocomplete="off">
          <div class="mb-3 col-lg-8 mx-auto">
            <div class="card card-table">
              <!-- <div class="card-header bg-primary text-white">
                <?=$title?>
              </div> -->
              <div class="card-body">
                  <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Select Table</label>
                      <div class="col-sm-10">
                        <select class="form-control form-control-sm select-option" style="width:100%;" name="table" id="table" data-placeholder="Select Table">
                          <option value=""></option>
                          <?php foreach ($table as $tables): ?>
                            <option value="<?=$tables?>"><?=$tables?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Title</label>
                      <div class="col-sm-10">
                        <input class="form-control form-control-sm" type="text" name="title" id="title" placeholder="Title"/>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Controllers</label>
                      <div class="col-sm-10">
                        <input class="form-control form-control-sm" type="text" name="controllers" id="controllers" placeholder="Controllers"/>
                      </div>
                    </div>
              </div>
            </div>
          </div>


          <div class="loading display-none">
            <div class="spinner-grow text-primary"></div>
            <div class="spinner-grow text-primary"></div>
            <div class="spinner-grow text-primary"></div>
            <p>Loading...</p>
          </div>

          <div id="content-crud"></div>

          <div class="rules-validation display-none">
            <option value="" class="text textarea select password editor upload_image date time datetime select option"></option>
            <?php foreach ($groups as $group): ?>
              <option value="<?=$group['validation']?>" class="<?=str_replace(',', ' ', $group['group']); ?>" title="<?=$group['validation']?>"><?= ucwords(str_replace('_',' ',$group['validation'])); ?></option>
            <?php endforeach; ?>
          </div>

          <div class="text-center mt-5 mb-5">
            <a type="submit" href="<?=url('m_crud_generator')?>" class="btn btn-lg btn-danger"> Cancel</a>
            <button type="submit" name="button" class="btn btn-lg btn-primary" id="submit"> Build module</button>
          </div>

        </form>
        </div>
    </div>
  </body>

<script type="text/javascript">
  $(document).ready(function(){
    $('.select-option').select2();

    $("#form").submit(function(e){
    e.preventDefault();
    var me = $(this);
    $("#submit").prop('disabled',true).html('Loading...');
    $.ajax({
          url             : me.attr('action'),
          type            : 'post',
          data            :  new FormData(this),
          contentType     : false,
          cache           : false,
          dataType        : 'JSON',
          processData     :false,
          success:function(json){
            if (json.success==true) {
              $(".loading-keyboard").show();
              // $("#submit").prop('disabled',false)
              //             .html('build module');
              //
              setTimeout(function(){
                          // $(".loading-keyboard").hide();
                          window.location.href="<?=url('m_crud_generator')?>";
                        }, 3000);
              //
            }else {
              $("#submit").prop('disabled',false)
                          .html('build module');
              $(".loading-keyboard").hide();
              swal(json.msg, {
                icon:"error"
              });
            }
          }
        });
    });


    $('#table').on('change', function() {
        var table = $(this).val();
        $("#content-crud").html("");
        $('.loading').show();
        $.ajax({
                url: BASE_URL + '/mcrud/getTable/' + table,
                type: 'POST',
                dataType: 'JSON',
            }).done(function(json){
              $('.loading').hide();
              $("#content-crud").html(json.list);
              $("#title").val(json.title);
              $("#controllers").val(json.controllers);


               $(document).find('.card-content .form_type').each(function() {
                    updateRulesValidation($(this));
                });

               for (var selector in config) {
                   $(selector).chosen(config[selector]);
               }


            });
  });



  $(document).on('change', '.form_type', function(){
    updateRulesValidation($(this));
  });

  function updateRulesValidation(target)
  {
    var validation_group = target.find('option:selected').attr('title');
    var custom_value = target.find('option:selected').attr('opsi');
    var custom_option_container = target.parents('.card-content').find('.box-container-option');
    var custom_option_relation = target.parents('.card-content').find('.box-container-relation');
    var options = $('.rules-validation option.'+validation_group).clone().filter(function(index, elem) {
         return elem;
       });

   if (custom_value == "custom-value") {
     custom_option_container.slideDown("normal", function() {
         custom_option_container.show();
     });
   }else {
     custom_option_container.slideUp("normal", function() {
         custom_option_container.hide();
     });
   }

   if (custom_value == "custom-relation") {
     custom_option_relation.slideDown("normal", function() {
         custom_option_relation.show();
     });
   }else {
     custom_option_relation.slideUp("normal", function() {
         custom_option_relation.hide();
     });
   }

   target.parents('.card-content').find('.rules_validation').html(options).trigger('chosen:updated');

  }


     var config = {
          '.chosen-select': {
              search_contains: true,
              search_contains: true,
              parser_config: {
                  copy_data_attributes: true
              }
          },
          '.chosen-select-deselect': {
              allow_single_deselect: true,
              search_contains: true,
              parser_config: {
                  copy_data_attributes: true
              }
          },
          '.chosen-select-no-single': {
              disable_search_threshold: 10
          },
          '.chosen-select-no-results': {
              no_results_text: 'Oops, nothing found!'
          },
          '.chosen-select-width': {
              width: "100%"
          }
      }

      for (var selector in config) {
          $(selector).chosen(config[selector]);
      }

      $(document).on('click', '.card-content a.add-option', function(){
        var field_name = $(this).parents('.forms').find('#field_name').val();
        var sort = $(this).parents('.forms').find('#sort').val();
        var time_in_ms = Date.now();
        var element = `<div class="box-option-item box-option-item-`+time_in_ms+`">
                        <div class="box">
                          <label for="">label</label>
                          <input type="text" name="mcrud[`+sort+`][`+field_name+`][option][`+time_in_ms+`][label]">
                        </div>
                        <div class="box">
                          <label for="">value</label>
                          <input type="text" name="mcrud[`+sort+`][`+field_name+`][option][`+time_in_ms+`][value]">
                        </div>
                        <a class="text-danger delete-option"><i class="fa fa-trash"></i></a>
                      </div>`;
        $(this).parents('.card-content').find('.box-option').append(element);
    		$('.box-option-item-'+time_in_ms).hide().slideDown();
      });

      $(document).on('click', '.card-content a.delete-option', function(){
        $(this).parents('.box-option-item').slideUp("normal", function() {
            $(this).remove();
        });
    		return;
    	});


      $(document).on('change', '.card-content .relation_table', function(){
  		var relation_value = $(this).parents('.card-content').find('.relation_value');
  		var relation_label = $(this).parents('.card-content').find('.relation_label');
  		var table_name = $(this).val();

  		relation_value.parents('.form-group').show();
  		relation_label.parents('.form-group').show();

  		$.get(BASE_URL + '/mcrud/get_list_field/' + table_name, function(data) {
  			var res = (data);

  				relation_value.html(res);
  				relation_value.trigger('chosen:updated');

  				relation_label.html(res);
  				relation_label.trigger('chosen:updated');

  		}).fail(function() {
        swal("Error getting data", {
          icon:"error"
        });
  		})


  		$.get(BASE_URL + '/mcrud/get_list_field/' + table_name + '/1', function(data) {
  			var res = (data);
  				relation_label.html(res);
  				relation_label.trigger('chosen:updated');
  		}).fail(function() {
        swal("Error getting data", {
          icon:"error"
        });
  		});

  	});

    });

</script>

</html>
