<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : mpampamdev  */
/*| version : V.0.0.2 */
/*| facebook : https://web.facebook.com/mpampam */
/*| fanspage : https://web.facebook.com/programmerjalanan */
/*| instagram : https://www.instagram.com/programmer_jalanan */
/*| youtube : https://www.youtube.com/channel/UC1TlTaxRNdwrCqjBJ5zh6TA */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 26/02/2021 15:43*/
/*| Please DO NOT modify this information*/


class Testing extends Backend{

private $title = "Testing";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Testing_model","model");
}

function index()
{
  $this->is_allowed('testing_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('testing_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    foreach ($list as $row) {
        $rows = array();
                $rows[] = $row->title;
                $rows[] = $row->desc;
                $rows[] = $row->name;
                $rows[] = $row->file_name;
                $rows[] = $row->status;
                $rows[] = $row->created_at != "" ? date("d-m-Y H:i",  strtotime($row->created_at)) : "";
                $rows[] = $row->update_at != "" ? date("d-m-Y H:i",  strtotime($row->update_at)) : "";
        
        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="'.url("testing/detail/".enc_url($row->id)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="'.url("testing/update/".enc_url($row->id)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="'.url("testing/delete/".enc_url($row->id)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                        <i class="ti-trash"></i>
                      </a>
                    </div>
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

function filter()
{
  if(!is_allowed('testing_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}

function detail($id)
{
  $this->is_allowed('testing_detail');
    if ($row = $this->model->get_detail(dec_url($id))) {
    $this->template->set_title("Detail ".$this->title);
    $data = array(
          "title" => $row->title,
          "desc" => $row->desc,
          "id_user" => $row->name,
          "id_image" => $row->file_name,
          "status" => $row->status,
          "created_at" => $row->created_at,
          "update_at" => $row->update_at,
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}

function add()
{
  $this->is_allowed('testing_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("testing/add_action"),
                  'title' => set_value("title"),
                  'desc' => set_value("desc"),
                  'id_user' => set_value("id_user"),
                  'id_image' => set_value("id_image"),
                  'status' => set_value("status"),
                  'created_at' => set_value("created_at"),
                  );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('testing_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("title","* Title","trim|xss_clean");
    $this->form_validation->set_rules("desc","* Desc","trim|xss_clean");
    $this->form_validation->set_rules("id_user","* Id user","trim|xss_clean");
    $this->form_validation->set_rules("id_image","* Id image","trim|xss_clean");
    $this->form_validation->set_rules("status","* Status","trim|xss_clean");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['title'] = $this->input->post('title',true);
      $save_data['desc'] = $this->input->post('desc',true);
      $save_data['id_user'] = $this->input->post('id_user',true);
      $save_data['id_image'] = $this->input->post('id_image',true);
      $save_data['status'] = $this->input->post('status',true);
      $save_data['created_at'] = date("Y-m-d H:i");

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("testing");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function update($id)
{
  $this->is_allowed('testing_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("testing/update_action/$id"),
                  'title' => set_value("title", $row->title),
                  'desc' => set_value("desc", $row->desc),
                  'id_user' => set_value("id_user", $row->id_user),
                  'id_image' => set_value("id_image", $row->id_image),
                  'status' => set_value("status", $row->status),
                  'update_at' => date("Y-m-d H:i"),
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('testing_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("title","* Title","trim|xss_clean");
    $this->form_validation->set_rules("desc","* Desc","trim|xss_clean");
    $this->form_validation->set_rules("id_user","* Id user","trim|xss_clean");
    $this->form_validation->set_rules("id_image","* Id image","trim|xss_clean");
    $this->form_validation->set_rules("status","* Status","trim|xss_clean");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['title'] = $this->input->post('title',true);
      $save_data['desc'] = $this->input->post('desc',true);
      $save_data['id_user'] = $this->input->post('id_user',true);
      $save_data['id_image'] = $this->input->post('id_image',true);
      $save_data['status'] = $this->input->post('status',true);
      $save_data['update_at'] = date("Y-m-d H:i");

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("testing");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function delete($id)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('testing_delete')) {
      return $this->response([
        'type_msg' => "error",
        'msg' => "do not have permission to access"
      ]);
    }

      $this->model->remove(dec_url($id));
      $json['type_msg'] = "success";
      $json['msg'] = cclang("notif_delete");


    return $this->response($json);
  }
}


}

/* End of file Testing.php */
/* Location: ./application/modules/testing/controllers/backend/Testing.php */
