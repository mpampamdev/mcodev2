<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once APPPATH . 'modules/mcrud/controllers/Dicoba.php';

class Mcrud extends Backend{

  protected $title = "M-Crud Generator";
  // protected $data;

  public function __construct()
  {
    parent::__construct();
    $this->load->model("m_crud_generator/M_crud_generator_model","model");
  }

  function index()
  {
    $this->is_allowed('crud_generator_add');
    $rm = array("modules_crud_generator","setting","main_menu","ci_user_login","ci_user_log","ci_sessions","auth_user","auth_user_to_group","auth_permission","auth_permission_to_group","auth_group","main_menu","filemanager","migrations");
    $table = $this->db->list_tables();
    $getTable = array_diff($table, $rm);
    $this->data['title'] = $this->title;
    $this->data['table'] = $getTable;
    $this->data['groups'] = $this->form_type_group();
    $this->load->view("index",$this->data);
  }

  function getTable($table)
  {
    $this->attr['table'] = $table;
    $this->attr['form_type'] = $this->form_type();
    $this->data['controllers'] = ucfirst($table);
    $this->data['title'] = ucwords(str_replace("_"," ", $table));
    $this->data['list'] = $this->load->view("list_data_field",$this->attr, true);
    $this->data['success'] = true;

		echo json_encode($this->data);
  }

  function action()
  {
    if ($this->input->is_ajax_request()) {
      if (!is_allowed('crud_generator_add')) {
        show_error("Access Permission", 403,'403::Access Not Permission');
        exit();
      }

      $json         = array('success' => false, 'msg' => array());
      $table        = $this->input->post('table');
      $primary_key  = $this->input->post('primary_key');
      $title        = $this->input->post('title');
      $controllers  = ucfirst($this->input->post('controllers'));

      $this->form_validation->set_rules('table', 'Table - ', 'trim|required');
      $this->form_validation->set_rules('title', 'Title - ', 'trim|required');
      $this->form_validation->set_rules('controllers', 'Controllers - ', 'trim|alpha_underscores|required|callback__cek_dir');
      $this->form_validation->set_error_delimiters('* ','');


      if ($this->form_validation->run()) {
        $this->load->library("Mcrud_build",[
        'mcrud' => $_POST['mcrud']
        ]);
        $this->load->helper(array('file','mcrud'));
        $this->load->library('parser');
      $validate = $this->mcrud_build->validate();

      if ($validate->isError()) {
        $json['msg'] = $validate->getErrorMessage();
      }else {


        $module_folder = strtolower($controllers);
        $view_path = APPPATH . '/modules/'.$module_folder.'/views/';
  			$controller_path = APPPATH . '/modules/'.$module_folder.'/controllers/backend/';
  			$model_path = APPPATH . '/modules/'.$module_folder.'/models/';

        $dir_modules[] = APPPATH.'/modules/'.$module_folder;
        $dir_modules[] = APPPATH.'/modules/'.$module_folder.'/models';
        $dir_modules[] = APPPATH.'/modules/'.$module_folder.'/views';
        $dir_modules[] = APPPATH.'/modules/'.$module_folder.'/controllers';
        $dir_modules[] = APPPATH.'/modules/'.$module_folder.'/controllers/backend';
        foreach ($dir_modules as $dir) {
            	if (!is_dir($dir)) {
								mkdir($dir);
							}
            }


      $data = [
				'php_open_tag' 				=> '<?php',
				'php_close_tag' 			=> '?>',
				'php_open_tag_echo' 	=> '<?=',
				'table_name'				  => $table,
        'primary_key'				  => $primary_key,
				'title'				        => $title,
				'controller'					=> $controllers
			];


      $template_crud_path = 'mcrud/';

			$builder_controller = $this->parser->parse($template_crud_path.'build_controller', $data, true);
			write_file($controller_path.$controllers.'.php', $builder_controller);

      $builder_model = $this->parser->parse($template_crud_path.'build_model', $data, true);
			write_file($model_path.$controllers.'_model.php', $builder_model);

      $builder_index = $this->parser->parse($template_crud_path.'build_index', $data, true);
			write_file($view_path.'index.php', $builder_index);
      $insert_role_access[] = array('permission' => strtolower($controllers)."_list",
                                      'definition' =>"Module ".strtolower($controllers)
                                    );


    //   $show_in_filter = $this->mcrud_build->showInFilter();
    //   if (count($show_in_filter) > 0) {
    //   $builder_filter = $this->parser->parse($template_crud_path.'build_filter', $data, true);
		// 	write_file($view_path.'filter.php', $builder_filter);
    //   $insert_role_access[] = array('permission' => strtolower($controllers)."_filter",
    //                                 'definition' =>"Module ".strtolower($controllers)
    //                               );
    // }

      $show_in_view = $this->mcrud_build->showInView();
      if (count($show_in_view) > 0) {
        $builder_view = $this->parser->parse($template_crud_path.'build_view', $data, true);
        write_file($view_path.'view.php', $builder_view);
        $insert_role_access[] = array('permission' => strtolower($controllers)."_detail",
                                      'definition' =>"Module ".strtolower($controllers)
                                    );
      }

      $show_in_add = $this->mcrud_build->showInAdd();
      if (count($show_in_add) > 0) {
        $builder_add = $this->parser->parse($template_crud_path.'build_add', $data, true);
  			write_file($view_path.'add.php', $builder_add);
        $insert_role_access[] = array('permission' => strtolower($controllers)."_add",
                                      'definition' =>"Module ".strtolower($controllers)
                                      );
      }

      $show_in_update = $this->mcrud_build->showInUpdate();
      if (count($show_in_update) > 0) {
        $builder_update = $this->parser->parse($template_crud_path.'build_update', $data, true);
  			write_file($view_path.'update.php', $builder_update);
        $insert_role_access[] = array('permission' => strtolower($controllers)."_update",
                                      'definition' =>"Module ".strtolower($controllers)
                                      );
      }

        $insert = array('module' => $controllers,
                        'module_name' => $title,
                        'table' => $table,
                        'created_at' => date('Y-m-d H:i')
                      );
        $this->db->insert('modules_crud_generator',$insert);

        $insert_role_access[] = array('permission' => strtolower($controllers)."_delete",
                                            'definition' => "Module ".strtolower($controllers)
                                      );

        $this->db->insert_batch('auth_permission', $insert_role_access);

        set_message('success', 'build Module success');
        $json['success'] = true;
      }



      }else {
        $json['msg'] = validation_errors();
      }

      echo json_encode($json);
    }

  }


  function change_form_group($params = null)
  {
    echo $this->form_group_rules($params);
  }


  function get_list_field($table, $params = 0)
  {
    $str ="";
    $i = 0;
    foreach ($this->db->list_fields($table) as $field) {
      if ($params == 1) {
        $selected = ($i == 1) ? "selected":"";
        $str .='<option '.$selected.' value="'.$field.'">'.$field.'</option>';
      }else {
        $str .='<option value="'.$field.'">'.$field.'</option>';
      }
      $i++;
    }
    echo $str;
  }



  function form_type()
  {
    $form_type = array(
                array('type' => "text",
                      'opsi' => "0"
                    ),
                array('type' => "textarea",
                      'opsi' => "0"
                    ),

                array('type' => "number",
                      'opsi' => "0"
                    ),

                array('type' => "upload_image",
                      'opsi' => "0"
                    ),

                array('type' => "text_editor",
                      'opsi' => "0"
                    ),

                array('type' => "select",
                      'opsi' => "custom-value"
                    ),

                array('type' => "select_relation",
                      'opsi' => "custom-relation"
                    ),

                array('type' => "option",
                      'opsi' => "custom-value"
                    ),

                array('type' => "option_relation",
                      'opsi' => "custom-relation"
                    ),

                array('type' => "date",
                      'opsi' => "0"
                    ),

                array('type' => "time",
                      'opsi' => "0"
                    ),

                array('type' => "datetime",
                      'opsi' => "0"
                    ),

                array('type' => "timestamp",
                      'opsi' => "0"
                    ),
    );

    return $form_type;
  }


  function form_type_group()
  {
    $group = array(
      array(
        "validation" => "required",
        "group"      => "text,textarea,select,password,text_editor,upload_image,select,option,select_relation,option_relation,date,time,datetime,number"
      ),

      array(
        "validation" => "htmlspecialchars",
        "group"      => "text,textarea,select,password,text_editor,upload_image,select,option,select_relation,option_relation"
      ),

      array(
        "validation" => "alpha",
        "group"      => "text,textarea,select,password,text_editor,select,option,select_relation,option_relation"
      ),

      array(
        "validation" => "alpha_numeric",
        "group"      => "text,textarea,select,password,text_editor,select,option,select_relation,option_relation"
      ),

      array(
            'validation' => "alpha_numeric_spaces",
            'group' => "text,textarea,select,password,text_editor,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "alpha_dash",
            'group' => "text,textarea,select,password,text_editor,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "alpha_underscores",
            'group' => "text,textarea,select,password,text_editor,select,option,select_relation,option_relation"
          ),

     array(
            'validation' => "numeric",
            'group' => "text,textarea,select,number,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "valid_email",
            'group' => "text,textarea,select,text_editor,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "valid_emails",
            'group' => "text,textarea,select,text_editor,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "valid_url",
            'group' => "text,textarea,select,option,select_relation,option_relation"
          ),

      array(
            'validation' => "valid_ip",
            'group'      => "text,textarea,select,option,select_relation,option_relation"
          ),

    );

    return $group;
  }


  function _cek_dir($str)
  {
    $this->load->helper('file');
    $dir_path  = APPPATH.'modules/'.strtolower($str);
    if (is_dir($dir_path)) {
      $this->form_validation->set_message('_cek_dir', '%s module already exists!');
      return false;
    }
    return true;
  }




}
