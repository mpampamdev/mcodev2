<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Backend{

  private $title = "Setting";

  public function __construct()
  {
    $config = array(
      'title' => $this->title,
     );
    parent::__construct($config);
    $this->load->model("Setting_model","model");
  }

  function index()
  {
    // $this->is_allowed('config_view_default');
    $this->template->set_title(cclang("setting"));
    $this->template->view("index",);
  }

  function logo()
  {
    // $this->is_allowed('config_view_logo');
    $this->template->set_title(cclang("setting"));
    $this->template->view("logo",);
  }

  function sosmed()
  {
    // $this->is_allowed('config_view_sosmed');
    $this->template->set_title(cclang("setting"));
    $this->template->view("sosmed",);
  }

  function core()
  {
    // $this->is_allowed('config_view_core');
    $this->template->set_title(cclang("setting"));
    $data['time_zone'] = $this->time_zone();
    $this->template->view("core",$data);
  }

  // function database()
  // {
  //   $this->is_allowed('config_view_database');
  //   $this->template->set_title(cclang("setting"));
  //   $this->template->view("database");
  // }
  //
  // function restoreDatabase()
  // {
  //   $this->is_allowed('config_database_restore');
  //   $this->template->set_title(cclang("setting"));
  //   $this->load->helper('directory');
  //   $map = directory_map(APPPATH.'migrations/database',1);
  //   rsort($map);
  //   $data['dir'] = $map;
  //   $this->template->view("core/restore",$data);
  // }


    function update_action()
    {
      if ($this->input->is_ajax_request()) {
        $enc_url = $this->config->item("encryption_url") ? "TRUE":"FALSE";
        $config = array('php_tag_open' 	=> '<?php',
                        'time_zone' => $this->config->item("time_zone"),
                        'language' => $this->config->item("language"),
                        'encryption_key' => $this->config->item("encryption_key"),
                        'encryption_url' => $enc_url,
                        'url_suffix' => $this->config->item("url_suffix"),
                        'max_upload' => $this->config->item("max_upload")
                        );

        $constants = array('php_tag_open' 	=> '<?php',
                            'route_default' => 'backend/login',
                            'route_admin' => ADMIN_ROUTE,
                            'route_login' => LOGIN_ROUTE,
                            );

        $pk = $this->input->post("pk", true);
        $name = $this->input->post("name", true);
        $value = htmlspecialchars($this->input->post("value", true));

        $json = array('success'=>false, 'msg'=>array());
        if (!is_allowed("config_update_".strtolower($name))) {
          return $this->response([
            'success' => false,
            'msg' => "Do not have permission to update"
          ]);
        }

        if ($name == "email") {
          $this->form_validation->set_rules("value","* ","trim|xss_clean|required|valid_email");
        }elseif($name == "max_upload"){
          $this->form_validation->set_rules("value","* ","trim|xss_clean|required|numeric");
        }elseif ($name == "route_admin") {
          $this->form_validation->set_rules("value","* ","trim|xss_clean|alpha_numeric|required|callback__cek_route_admin");
        }elseif($name == "route_login"){
          $this->form_validation->set_rules("value","* ","trim|xss_clean|alpha_numeric|required|callback__cek_route_login");
        }elseif ($name == "logo" or $name == "logo_mini" or $name == "favicon") {
          $this->form_validation->set_rules("value","* ","trim|xss_clean|required");
        }elseif ($name == "url_suffix") {
          $this->form_validation->set_rules("value","* ","trim|xss_clean|max_length[5]|callback__cek_url_suffix");
        }else {
          $this->form_validation->set_rules("value","* ","trim|xss_clean|htmlspecialchars|required");
        }
        $this->form_validation->set_error_delimiters('','');

        if ($this->form_validation->run()) {

          if ($pk == "999") {
            $this->load->library("parser");
            $this->load->helper("file");
            $config[$name] = $value;
            $config_template = $this->parser->parse('core/config_template.txt', $config, TRUE);
  			    write_file(FCPATH . '/application/config/config.php', $config_template);
          }elseif ($pk == "998") {
            $this->load->library("parser");
            $this->load->helper("file");
            $constants[$name] = strtolower($value);
            $constants_template = $this->parser->parse('core/constants_template.txt', $constants, TRUE);
  			    write_file(FCPATH . '/application/config/constants.php', $constants_template);
          }else {
            $update = array("value" => $value);
            $this->model->get_update("setting", $update ,["id_setting"=>$pk]);
          }

          $json['value'] = strtolower($value);
          $json['success'] = true;
        }else {
          $json['msg'] = form_error("value");
        }
        return $this->response($json);

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

  	 foreach ($timezones as $tmzid) {
  		 $json[] = array("value" => $tmzid,
                        "text" => $tmzid
                      );
  	}

    sort($json);
  	return json_encode($json);
  }

  function _cek_route_admin($str)
  {
      if ($str == LOGIN_ROUTE) {
        $this->form_validation->set_message('_cek_route_admin', $str.' characters may not be used.');
        return FALSE;
      }else {
        return true;
      }
  }

  function _cek_route_login($str)
  {
    if ($str == "backend" OR $str == ADMIN_ROUTE) {
        $this->form_validation->set_message('_cek_route_login', $str.' characters may not be used.');
        return FALSE;
      }else {
        return true;
      }

  }

  function _cek_url_suffix($str)
  {
    $params = substr($str, 0,1);
    if ($str != "") {
      if ($params != ".") {
        $this->form_validation->set_message('_cek_url_suffix', ' character must start with (dot).');
        return FALSE;
      }
    }
    return TRUE;
  }

}
