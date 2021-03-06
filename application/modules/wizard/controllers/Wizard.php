<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wizard extends CI_Controller{

  private $db_name = "m_code";


  public function __construct()
  {
    parent::__construct();
    if (DEFAULT_CONTROLLER !="wizard") {
      show_404();
      die();
    }
    $this->load->config("app");
    $this->load->helper("file");
    $this->load->library(array("parser","form_validation"));
  }

  function index()
  {
    $directory_permission = [
			'_temp/uploads',
			'_temp/uploads/tmp',
			'application',
			'application/config',
			'application/modules',
			'application/config/database.php',
			'application/config/config.php',
      'application/config/app.php',
      'application/config/app.cfg',
			'application/migrations/001_mpampam.php',
		];


    $data['directory_permission'] = $directory_permission;
    $data['php_version'] = phpversion() >= 5.6 ? TRUE : FALSE;
    $data['mysql_version']= $this->mysql_version() >= 4.3 ? TRUE : FALSE;
    $data['time_zone'] = $this->time_zone();
    $this->load->view("index",$data);

  }

  function system_requirement()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success' => false, "msg" => array());
      $this->form_validation->set_rules("php_version","* PHP Version","trim|required|callback__cek_php_version");
      $this->form_validation->set_rules("dir_file_permission[]","* Directory & File Permission","trim|required|callback__cek_dir");
      $this->form_validation->set_error_delimiters('','');
      if ($this->form_validation->run()) {
        $this->load->library('migration');
        if ($this->migration->version(1) === false) {
          $json['msg'] = "error migration";
        }else {
          $json['success'] = true;
        }
      }else {
        $json['msg'] = validation_errors();
      }

      echo json_encode($json);
    }
  }

  // function database_configuration()
  // {
  //   if ($this->input->is_ajax_request()) {
  //     $json = array('success' => false, "msg" => array());
  //
  //     $this->form_validation->set_rules("db_name","* Database Name","trim|required");
  //     $this->form_validation->set_rules("db_host","* Database Host","trim|required");
  //     $this->form_validation->set_rules("db_username","* Username","trim|required");
  //     $this->form_validation->set_rules("db_password","* Password","trim");
  //     $this->form_validation->set_error_delimiters('','');
  //
  //     if ($this->form_validation->run()) {
  //        $list_table = $this->db->list_tables();
  //       if ($this->check_connection()) {
  //         $hostname 	= $this->input->post('db_host');
  //         $username 	= $this->input->post('db_username');
  //         $password 	= $this->input->post('db_password');
  //         $dbname 	  = $this->input->post('db_name');
  //
  //         $arr = array("open_php" => "<?php",
  //                      'db_name' => $dbname,
  //                      'db_host' => $hostname,
  //                      'db_username' => $username,
  //                      'db_password' => $password,
  //                     );
  //
  //         $this->set_db($arr);
  //
  //         $this->load->library('migration');
  //         if ($this->migration->version(1) === false) {
  //           $json['msg'] = "error migration";
  //         }else {
  //           $json['success'] = true;
  //         }
  //       }else {
  //         $json['msg'] = "Unable to connect the database";
  //       }
  //     }else {
  //       $json['msg'] = validation_errors();
  //     }
  //
  //     echo json_encode($json);
  //   }
  // }

  function system_configuration()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success' => false, "msg" => array());
      $this->form_validation->set_rules("url_suffix","* Url Suffix","trim|max_length[5]|callback__cek_url_suffix");
      $this->form_validation->set_rules("encryption_key","* encryption_key","trim|required");
      $this->form_validation->set_rules("encryption_url","* encryption_url","trim|required");
      $this->form_validation->set_rules("time_zone","* time_zone","trim|required");
      $this->form_validation->set_rules("max_upload","* max_upload","trim|required|numeric");
      // $this->form_validation->set_rules("time_zone","time_zone","trim|required");
      $this->form_validation->set_error_delimiters('','');

      if ($this->form_validation->run()) {
        $this->set_config();
        $this->set_autoload();
        $json['success'] = true;
      }else {
        $json['msg'] = validation_errors();
      }
      echo json_encode($json);
    }
  }

  function app_configuration()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success' => false, "msg" => array());
      $this->form_validation->set_rules("app_name","* App/Web name","trim|required");
      $this->form_validation->set_rules("dev_name","* Developer Name","trim|required");
      $this->form_validation->set_rules("email","* Email","trim|required|valid_email");
      $this->form_validation->set_rules("password","* Password","trim|required|min_length[6]");
      $this->form_validation->set_error_delimiters('','');

      if ($this->form_validation->run()) {
        //update name website
        // $this->db->update('setting', ['value'=>$this->input->post("app_name")], ['options' => 'web_name']);
        // $this->db->update('setting', ['value'=> site_url()], ['options' => 'web_domain']);
        // $this->db->update('setting', ['value'=>$this->input->post("dev_name")], ['options' => 'web_owner']);
        // $this->db->update('setting', ['value'=>$this->input->post("email")], ['options' => 'email']);

        $update_setting = [
            ['value'=>$this->input->post("app_name"), 'options' => 'web_name'],
            ['value'=> site_url() ,'options' => 'web_domain'],
            ['value'=>$this->input->post("dev_name"), 'options' => 'web_owner'],
            ['value'=>$this->input->post("email"), 'options' => 'email']
        ];

        $this->db->update_batch('setting', $update_setting, 'options');

        // update users
        $this->load->library(array("Encryption","My_encrypt"));
        $this->load->helper(array("app","sct"));
        $token = randomKey();
        $update_user = array(
                        'name' => $this->input->post("dev_name"),
                        'email' => $this->input->post("email"),
                        'token' => $token,
                        'password' => pass_encrypt($token,$this->input->post('password')),
                        'created' => date("Y-m-d H:i")
                      );
        $this->db->where("id_user",1);
        $this->db->update("auth_user",$update_user);



        $json['content'] = $this->content_complate();
        $json['success'] = true;
      }else {
        $json['msg'] = validation_errors();
      }
      echo json_encode($json);
    }
  }


  function mysql_version()
  {
    $mysql_info = explode(' ', mysqli_get_client_info());
		$mysql_version = isset($mysql_info[1]) ? $mysql_info[1] : false;
		$mysql_version_number = explode('-', $mysql_version)[0];

		if ($mysql_version_number) {
			return $mysql_version_number;
		} else if (isset($mysql_info[0])) {
			return (int)substr($mysql_info[0], 0, 3);
		}

		return 5;
  }



  function set_config()
  {
    $config = array('php_tag_open' 	=> '<?php',
                    'time_zone' => $this->input->post("time_zone"),
                    'language' =>   "english",
                    'encryption_key' => $this->input->post("encryption_key"),
                    'encryption_url' => $this->input->post("encryption_url"),
                    'url_suffix' => $this->input->post("url_suffix"),
                    'max_upload' => $this->input->post("max_upload")
                    );
   $config_template = $this->parser->parse('core/config_template.txt', $config, TRUE);
   write_file(FCPATH . '/application/config/config.php', $config_template);
  }


  function set_autoload()
  {
    $autoload = array('php_tag_open' 	=> '<?php',);
    $autoload_template = $this->parser->parse('core/autoload.tmp', $autoload, TRUE);
    write_file(FCPATH . '/application/config/autoload.php', $autoload_template);
  }

  function set_constants()
  {
    $constants = array('php_tag_open' 	=> '<?php',
                        'route_default' => 'login/backend/login',
                        'route_admin' => ADMIN_ROUTE,
                        'route_login' => LOGIN_ROUTE,
                        );
    $constants_template = $this->parser->parse('core/constants_template.txt', $constants, TRUE);
    write_file(FCPATH . '/application/config/constants.php', $constants_template);
  }


  function set_db($arr = array())
  {

    $db_template = $this->parser->parse('wizard/core/db.tmp', $arr, TRUE);
    write_file(APPPATH . 'config/database.php', $db_template);
  }

  function content_complate(){
    $hostname_db 	= $this->input->post('db_host');
    $username_db 	= $this->input->post('db_username');
    $password_db 	= $this->input->post('db_password');
    $name_db 	  = $this->input->post('db_name');
    $time_zone = $this->input->post("time_zone");
    $encryption_key = $this->input->post("encryption_key");
    $encryption_url = $this->input->post("encryption_url");
    $url_suffix = $this->input->post("url_suffix");
    $max_upload = $this->input->post("max_upload");
    $app_name = $this->input->post("app_name");
    $dev_name = $this->input->post("dev_name");
    $email = $this->input->post("email");
    $password = $this->input->post("password");

    $str = '';
    $str.='<h5>Database Configuration</h5>';
    $str.='<table class="table table-striped table-bordered table-step2">
              <tr>
                <td width="150">Hostname</td>
                <td>'.$hostname_db.'</td>
              </tr>

              <tr>
                <td>Username</td>
                <td>'.$username_db .'</td>
              </tr>

              <tr>
                <td>Password</td>
                <td>'.$password_db.'</td>
              </tr>

              <tr>
                <td>Database Name</td>
                <td>'.$name_db.'</td>
              </tr>

          </table>';

          $str.='<h5 class="mt-3">System Configuration</h5>';
          $str.='<table class="table table-striped table-bordered table-step2">
                    <tr>
                      <td width="150">url_suffix</td>
                      <td>'.$url_suffix.'</td>
                    </tr>

                    <tr>
                      <td>time_zone</td>
                      <td>'.$time_zone .'</td>
                    </tr>

                    <tr>
                      <td>encryption_key</td>
                      <td>'.$encryption_key.'</td>
                    </tr>

                    <tr>
                      <td>encryption_url</td>
                      <td>'.$encryption_url.'</td>
                    </tr>

                    <tr>
                      <td>max_upload</td>
                      <td>'.$max_upload.' Kb</td>
                    </tr>

                </table>';

          $str.='<h5 class="mt-3">Site & User Configuration</h5>';
          $str.='<table class="table table-striped table-bordered table-step2">
                    <tr>
                      <td width="150">App/Web Name</td>
                      <td>'.$app_name.'</td>
                    </tr>

                    <tr>
                      <td width="150">Developer Name</td>
                      <td>'.$dev_name.'</td>
                    </tr>

                    <tr>
                      <td>Email</td>
                      <td>'.$email .'</td>
                    </tr>

                    <tr>
                      <td>Password</td>
                      <td>'.$password.'</td>
                    </tr>

                </table>';
    $str.='<a href="'.site_url("wizard/download_info").'" class="mt-3 btn btn-sm btn-primary">Download Information</a>';
    $str.='<p class="mt-5 finish">*********** Please DO NOT change the information on the file ***************</p>';
    $str.='<p class="mt-5 finish">Please click finish if the data you enter is correct.</p>';

    $style = '<style>.table{border-collapse:collapse}.table tr td{padding:5px;border:1px dotted #505050}a,p.finish{display:none}</style>';
    $dt = $style.$str.'<p style="margin-top:15px">location:'.site_url().'</p><p>Generate By M-code & Crud Generator</p>';
    write_file(FCPATH.'/info_website.html', $dt);

    return $str;
  }

  function download_info()
  {
    $this->load->helper('download');
    force_download(FCPATH.'/info_website.html',null);
  }

  function finish()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success' => false, "msg" => array());
      $constants = array('php_tag_open' 	=> '<?php',
                          'route_default' => 'login/backend/login',
                          'route_admin' => ADMIN_ROUTE,
                          'route_login' => LOGIN_ROUTE,
                          );
      $constants_template = $this->parser->parse('core/constants_template.txt', $constants, TRUE);
      write_file(FCPATH . '/application/config/constants.php', $constants_template);

      if (file_exists(FCPATH.'/info_website.html')) {
        unlink(FCPATH.'/info_website.html');
      }

      $json['success'] = true;
      echo json_encode($json);
    }
  }

  function time_zone()
  {
  	$timezones = [];
  	foreach(timezone_abbreviations_list() as $abbr => $timezone){
  					foreach($timezone as $val){
  									if(isset($val['timezone_id'])){
  												$timezones[$val['timezone_id']] = $val['timezone_id'];
  									}
  					}
  	}

  	 return $timezones;
  }


  public function check_connection()
	{
				$hostname 	= $this->input->post('db_host');
        $username 	= $this->input->post('db_username');
        $password 	= $this->input->post('db_password');
        $dbname 	  = $this->input->post('db_name');

        try {
            $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $dbh-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $status =  true;
        } catch (PDOException $e) {
            $status =  false;
        }

        return $status;
	}

  function _cek_php_version($str)
  {
    if ($str == "0") {
      $this->form_validation->set_message("_cek_php_version", "%s Not Support");
      return false;
    }else {
      return true;
    }
  }

  function _cek_dir($str)
  {
    $strs = $this->input->post("dir_file_permission[]");
    if (in_array("0",$strs , TRUE)) {
      $this->form_validation->set_message("_cek_dir", "%s not eligible. Please cek directory or file.");
      return false;
    }else {
      return true;
    }
  }


  function _cek_url_suffix($str)
  {
      if (!empty($str)) {
        $post = strpos($str, ".");
        if ($post !== false) {
          if ($post != 0) {
            $this->form_validation->set_message("_cek_url_suffix", "%s (.) at the beginning of the character");
            return false;
          }

          if (substr_count($str, ".") > 1) {
            $this->form_validation->set_message("_cek_url_suffix", "%s (.) at the beginning of the character");
            return false;
          }

          return true;
        }else {
          $this->form_validation->set_message("_cek_url_suffix", "%s (.) at the beginning of the character");
          return false;
        }
      }

      return true;

  }


}
