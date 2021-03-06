<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Wellcome <?=$this->config->item("app"); ?> Instalation</title>

    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/ti-icons/css/themify-icons.css">
    <link href="<?=base_url()?>_temp/backend/css/icons.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/css/vendor.bundle.base.css">

    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/jquery-toast-plugin/jquery.toast.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>_temp/backend/css/custom.css">


    <link rel="shortcut icon" href="<?=base_url()?>_temp/backend/images/favicon.png" />


    <script src="<?=base_url()?>_temp/backend/vendors/js/vendor.bundle.base.js"></script>

    <script src="<?=base_url()?>_temp/backend/vendors/sweetalert/sweetalert.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/select2/select2.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/jquery-steps/jquery.steps.min.js"></script>
    <script src="<?=base_url()?>_temp/backend/vendors/sweetalert/sweetalert.min.js"></script>


    <style media="screen">
      select{
        color:#2f2f2f!important;
      }

      #wizard ul.features{
        list-style: none;
      }

      #wizard ul.features li i{
        color:#cb2626;
      }

      #wizard ul.sosmed{
        list-style: none;
      }

      .steps1{
        margin:10px!important;
      }

      table.table-step2{
        width: 100%!important;
      }

      table.table-step2 tr th{
        padding: 5px!important;
        background: #1891e8;
        color:#fff;
      }

      table.table-step2 tr td{
        padding: 4px!important;
      }

      .select2-container{
        width: 100%!important;
      }

      .select2-selection--single{
        padding: 0.875rem 0.375rem!important;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow b{
        top:80%!important;
      }

      #loading{
        text-align: center;
        background-color: rgba(0, 0, 0, 1);
        opacity: 0.6;
        z-index:999;
        position: fixed;
        width:100%;
        height:100%;
        display: none;
        transition-property: width;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
      }

      #loading .spinner-grow{
        color:#009cff;
        width: 100px;
        height: 100px;
        margin-top: 100px;
      }

      #loading .ld{
        color:#009cff;
        font-weight: bold;
        font-size: 16px;
      }

    </style>
  </head>
  <body>

    <div class="container-scroller">
      <div id="loading">
        <div class="spinner-grow spinner-grow-lg" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <p class="ld">Loading...</p>
      </div>
      <!-- partial -->
      <div class="main-panel" style="width:100%!important;min-height:650px!important">
        <div class="content-wrapper">

          <div class="row">
            <div class="col-lg-10 mx-auto">
              <div class="card">
                <div class="card-header">
                  <?=ucfirst($this->config->item("app")); ?> Instalation
                </div>
                <div class="card-body">
                  <form id="wizard" action="#">
                    <div>
                      <?php $this->load->view("welcome") ?>

                      <?php $this->load->view("system_requirement") ?>

                      <!-- <?php $this->load->view("database_configuration") ?> -->

                      <?php $this->load->view("system_configuration") ?>

                      <?php $this->load->view("app") ?>

                      <?php $this->load->view("complate") ?>


                    </div>
                  </form>


                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- js -->

    <script src="<?=base_url()?>_temp/backend/js/off-canvas.js"></script>
    <script src="<?=base_url()?>_temp/backend/js/hoverable-collapse.js"></script>
    <script src="<?=base_url()?>_temp/backend/js/template.js"></script>
    <script src="<?=base_url()?>_temp/backend/js/settings.js"></script>
    <script src="<?=base_url()?>_temp/backend/js/todolist.js"></script>

    <script type="text/javascript">
    (function($) {
      'use strict';
      var wizard = $("#wizard");
      wizard.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        stepsOrientation: "vertical",
        onStepChanging: function (event, currentIndex, newIndex){


          var bol = false;
          if(currentIndex==0){
            if (currentIndex < newIndex) {
              bol = true;
            }
          }


          else if (currentIndex==1) {
            if (currentIndex < newIndex) {
              let data = new FormData();
              data.append("php_version", $("#php_version").val());
              $('.file-dir').each(function(i){
                  data.append('dir_file_permission[]', $(this).val()); // change this to value
              });
              $.ajax({
                url:"<?=base_url()?>wizard/wizard/system_requirement",
                type:"post",
                dataType: 'json',
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                success:function(json){
                  if (json.success == true) {
                    bol = true;
                  }else {
                    swal(json.msg, {
                      icon:"error"
                    })
                  }
                }
              });
            }else {
              return true;
            }

          }





          else if (currentIndex==2) {
            if (currentIndex < newIndex) {
              let data = new FormData();
              data.append("url_suffix", $("#url_suffix").val());
              data.append("encryption_key", $("#encryption_key").val());
              data.append("encryption_url", $("#encryption_url").val());
              data.append("time_zone", $("#time_zone").val());
              data.append("max_upload", $("#max_upload").val());
              $.ajax({
                url:"<?=base_url()?>wizard/wizard/system_configuration",
                type:"post",
                dataType: 'json',
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                success:function(json){
                  if (json.success == true) {
                    bol = true;
                  }else {
                    swal(json.msg, {
                      icon:"error"
                    })
                  }
                }
              });
            }else {
              bol = true;
            }
          }


          else if (currentIndex==3) {
            if (currentIndex < newIndex) {
              let data = new FormData();
              data.append("db_host", $("#db_host").val());
              data.append("db_name", $("#db_name").val());
              data.append("db_username", $("#db_username").val());
              data.append("db_password", $("#db_password").val());
              data.append("url_suffix", $("#url_suffix").val());
              data.append("encryption_key", $("#encryption_key").val());
              data.append("encryption_url", $("#encryption_url").val());
              data.append("time_zone", $("#time_zone").val());
              data.append("max_upload", $("#max_upload").val());
              data.append("app_name", $("#app_name").val());
              data.append("dev_name", $("#dev_name").val());
              data.append("email", $("#email").val());
              data.append("password", $("#password").val());
              $.ajax({
                url:"<?=base_url()?>wizard/wizard/app_configuration",
                type:"post",
                dataType: 'json',
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                success:function(json){
                  if (json.success == true) {
                    $("#content-complate").html(json.content);
                    bol = true;
                  }else {
                    swal(json.msg, {
                      icon:"error"
                    })
                  }
                }
              });
            }else {
              bol = true;
            }
          }else if (currentIndex==4) {
            bol = true;
          }

          return bol;
        },
        onFinished: function(event, currentIndex) {
          $.ajax({
            url:"<?=base_url()?>wizard/wizard/finish",
            type:"post",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            success:function(json){
              if (json.success == true) {
                window.location.reload();
              }
            }
          });
        }
      });


      if ($(".select-option").length) {
          $(".select-option").select2();
        }


      })(jQuery);
    </script>
  </body>
</html>
