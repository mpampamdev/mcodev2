<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* dev : mpampam*/
/* fb : https://facebook.com/mpampam*/
/* fanspage : https://web.facebook.com/programmerjalanan*/
/* web : www.mpampam.com*/
/* Generate By M-CRUD Generator 10/11/2020 14:51*/
/* Please DO NOT modify this information */


class Core extends Backend{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Core_model","model");
  }

  function index()
  {
    redirect(url("pagenotfound"),"refresh");
  }

  function reset_password()
  {
    $this->template->view("form_reset_password",array(),false);
  }


  function reset_password_action()
  {
    if ($this->input->is_ajax_request()) {
          $json = array('success'=>false, 'alert'=>array());
          $this->form_validation->set_rules("password","Password","trim|xss_clean|required|callback__cek_password");
          $this->form_validation->set_rules("password_baru","New password","trim|xss_clean|required|min_length[6]");
          $this->form_validation->set_rules("konfirmasi_password","Password confirm","trim|xss_clean|matches[password_baru]");
          $this->form_validation->set_error_delimiters('<span class="error text-danger" style="font-size:11px">','</span>');
          if ($this->form_validation->run()) {
            $token = randomKey();
            $update = array(
                            'token' => $token,
                            'password' => pass_encrypt($token,$this->input->post('konfirmasi_password')),
                          );

            $this->model->get_update("auth_user",$update,["id_user" => sess("id_user")]);

            $json['alert'] = "Change password successfully";
            $json['success'] =  true;
          }else {
            foreach ($_POST as $key => $value)
              {
                $json['alert'][$key] = form_error($key);
              }
          }
          return $this->response($json);
      }
  }


  function icon()
  {
    $this->template->view("icon",array(),false);
  }

  function notPermission()
  {
    $this->template->set_title("Error 403 - do not have permission");
    $this->template->view("error403");
  }

  function pagenotfound()
  {
    $this->template->set_title("Error 404 - Page Not Found");
    $this->template->view("error404");
  }


  function maintenance()
  {
    $this->template->set_title("Maintenance");
    $this->template->view("maintenance");
  }

  // function backupdatabase($params = null)
  // {
  //     $this->load->helper('file');
  //     $this->load->dbutil();
  //     $date = date("d-m-Y_His");
  //     $dir = APPPATH."migrations/database/".$date;
  //
  //
  //      $prefs = array(
  //        'format' => 'sql',
  //        'filename' => 'mcode-on-backup_'.$date.'.sql'
  //      );
  //      $backup  = $this->dbutil->backup($prefs);
  //      $db_name = 'mcode-on-backup_'.$date.'.sql'; // file name
  //      if ($params == 1) {
  //        $this->download($db_name, $backup);
  //      }elseif($params == 2) {
  //        if (!is_dir($dir)) {
  //          mkdir($dir);
  //        }
  //        write_file($dir ."/". $db_name, $backup);
  //        set_message("success", "Save database on list restore success");
  //        redirect(url('setting/database'),"refresh");
  //      }else {
  //          if (!is_dir($dir)) {
  //            mkdir($dir);
  //          }
  //          write_file($dir ."/". $db_name, $backup);
  //          $this->download($db_name, $backup);
  //      }
  // }
  //
  // function download($db_name, $backup = null)
  // {
  //   $this->load->helper('download');
  //   force_download($db_name, $backup);
  // }
  //
  // function restroDelete($params = "z")
  // {
  //   $this->is_allowed('config_database_delete');
  //   $this->load->helper("file"); // load the helper
  //   $path = APPPATH ."migrations/database/".dec_url($params);
  //   if (is_dir($path)) {
  //     delete_files($path, true);
  //     rmdir($path);
  //     set_message("success", cclang("notif_delete"));
  //   }else {
  //     set_message("error", cclang("notif_delete_failed"));
  //   }
  //   redirect(url("setting/restoreDatabase"),"refresh");
  // }
  //
  // function restoreDatabase($params)
  // {
  //   if ($this->input->is_ajax_request()) {
  //     // code...
  //
  //     echo json_encode($json);
  //   }
  // }
  //
  // function downloadDatabase($params)
  // {
  //   $this->is_allowed('config_database_download');
  //   $this->load->helper('download');
  //   $name = str_replace("\'","",dec_url($params));
  //   $file = APPPATH ."migrations/database/$name/mcode-on-backup_$name.sql";
  //   if (file_exists($file)) {
  //     force_download($file, null);
  //   }else {
  //     set_message("error","Download Failed");
  //     redirect(url("setting/database"),"refresh");
  //   }
  // }






}
