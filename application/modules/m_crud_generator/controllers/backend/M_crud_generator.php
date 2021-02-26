<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : mpampamdev  */
/*| version : V.0.0.2 */
/*| facebook : https://web.facebook.com/mpampam */
/*| fanspage : https://web.facebook.com/programmerjalanan */
/*| instagram : https://www.instagram.com/programmer_jalanan */
/*| youtube : https://www.youtube.com/channel/UC1TlTaxRNdwrCqjBJ5zh6TA */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 27/01/2021 03:56*/
/*| Please DO NOT modify this information*/


class M_crud_generator extends Backend{

private $title = "M crud Generator";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("M_crud_generator_model","model");
}

function index()
{
  $this->is_allowed('crud_generator_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('crud_generator_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    foreach ($list as $row) {
        $rows = array();
                $rows[] = "<a href='#'>".$row->module_name."</a>";
                $rows[] = "<a href='#'>../modules/".$row->module."</a>";
                $rows[] = $row->table;
                $rows[] = date("d-m-Y H:i",  strtotime($row->created_at));

        $rows[] = '
                      <a href="'.url("$row->module").'" target="_blank" class="btn btn-primary" title="'.cclang("view").'">
                        <i class="ti-file"></i>
                      </a>

                        <a href="'.url("m_crud_generator/delete/".enc_url($row->id)."/".enc_url($row->module)).'" target="_blank" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                          <i class="ti-trash"></i>
                        </a>
                 ';

        $data[] = $rows;
    }

    $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model->count_all(),
                    "recordsFiltered" => $this->model->count_filtered(),
                    "data" => $data,
            );
    //output to json format
    return $this->response($output);
  }
}


function about()
{
  $this->template->view("about",[],false);
}


function delete($id,$modules)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('crud_generator_delete')) {
      return $this->response([
        'type_msg' => "error",
        'msg' => "do not have permission to access"
      ]);
    }

      $this->load->helper('file'); // Load codeigniter file helper

      $folderName = dec_url($modules);
      $dir_path  = APPPATH.'modules/'.strtolower($folderName);  // For check folder exists
      $del_path  = APPPATH.'modules/'.strtolower($folderName).'/'; // For Delete folder

      if (is_dir($dir_path)) {
        delete_files($del_path, true); // Delete files into the folder
        rmdir($del_path); // Delete the folder
        }
        $this->model->remove(dec_url($id));

        $remove = array(strtolower($folderName)."_list",
                  strtolower($folderName)."_add",
                  strtolower($folderName)."_update",
                  strtolower($folderName)."_detail",
                  strtolower($folderName)."_delete",
                  strtolower($folderName)."_filter");

        $this->db->where_in('permission', $remove);
        $this->db->delete('auth_permission');

        $json['type_msg'] = "success";
        $json['msg'] = "Delete Module Success";


    return $this->response($json);
  }
}


}

/* End of file M_crud_generator.php */
/* Location: ./application/modules/m_crud_generator/controllers/backend/M_crud_generator.php */
