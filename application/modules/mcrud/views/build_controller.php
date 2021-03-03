{php_open_tag} defined('BASEPATH') OR exit('No direct script access allowed');
<?php
$show_in_table = $this->mcrud_build->showInTable();
$show_in_filter = $this->mcrud_build->showInFilter();
$show_in_view = $this->mcrud_build->showInView();
$show_in_add = $this->mcrud_build->showInAdd();
$show_in_update = $this->mcrud_build->showInUpdate();
$cek_relation = $this->mcrud_build->checkoptionRelation();
?>
/*| --------------------------------------------------------------------------*/
/*| dev : <?=$this->config->item('author')?>  */
/*| version : <?=$this->config->item('version')?> */
/*| facebook : <?=$this->config->item('facebook')?> */
/*| fanspage : <?=$this->config->item('fanspage')?> */
/*| instagram : <?=$this->config->item('instagram')?> */
/*| youtube : <?=$this->config->item('youtube')?> */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator <?=date('d/m/Y H:i')?>*/
/*| Please DO NOT modify this information*/


class {controller} extends Backend{

private $title = "{title}";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("{controller}_model","model");
}

function index()
{
  $this->is_allowed('<?=strtolower($controller)?>_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('<?=strtolower($controller)?>_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    foreach ($list as $row) {
        $rows = array();
        <?php foreach ($show_in_table as $field): ?>
<?php if(formType($field) == "upload_image"): ?>
        $rows[] = is_image($row-><?=$field?>);
<?php elseif (formType($field) == "date"): ?>
        $rows[] = date("d-m-Y",  strtotime($row-><?=$field?>));
<?php elseif(formType($field) == "time"): ?>
        $rows[] = date("H:i",  strtotime($row-><?=$field?>));
<?php elseif(formType($field) == "datetime"): ?>
        $rows[] = date("d-m-Y H:i",  strtotime($row-><?=$field?>));
<?php elseif(formType($field) == "timestamp"): ?>
        $rows[] = $row-><?=$field?> != "" ? date("d-m-Y H:i",  strtotime($row-><?=$field?>)) : "";
<?php elseif (formType($field) == "select_relation" OR formType($field) == "option_relation"): ?>
        $rows[] = $row-><?=optionRelation($field, "relation_label")?>;
<?php else: ?>
        $rows[] = $row-><?=$field?>;
<?php endif; ?>
        <?php endforeach; ?>

        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
<?php if (count($show_in_view) > 0): ?>
                      <a href="'.url("<?=strtolower($controller)?>/detail/".enc_url($row-><?=$primary_key?>)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
<?php endif; ?>
<?php if (count($show_in_update) > 0): ?>
                      <a href="'.url("<?=strtolower($controller)?>/update/".enc_url($row-><?=$primary_key?>)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
<?php endif; ?>
                      <a href="'.url("<?=strtolower($controller)?>/delete/".enc_url($row-><?=$primary_key?>)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
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

<?php if (count($show_in_filter) > 0): ?>
function filter()
{
  if(!is_allowed('<?=strtolower($controller)?>_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}
<?php endif; ?>

<?php if (count($show_in_view) > 0): ?>
function detail($id)
{
  $this->is_allowed('<?=strtolower($controller)?>_detail');
<?php if ($cek_relation): ?>
    if ($row = $this->model->get_detail(dec_url($id))) {
<?php else: ?>
    if ($row = $this->model->find(dec_url($id))) {
<?php endif; ?>
    $this->template->set_title("Detail ".$this->title);
    $data = array(
<?php foreach ($show_in_view as $field): ?>
<?php if (formType($field) == "select_relation" OR formType($field) == "option_relation"): ?>
          "<?=$field?>" => $row-><?=optionRelation($field, "relation_label")?>,
<?php else: ?>
          "<?=$field?>" => $row-><?=$field?>,
<?php endif; ?>
<?php endforeach; ?>
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}
<?php endif; ?>

<?php if (count($show_in_add) > 0): ?>
function add()
{
  $this->is_allowed('<?=strtolower($controller)?>_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("<?=strtolower($controller)?>/add_action"),
  <?php foreach ($show_in_add AS $field): ?>
                '<?=$field?>' => set_value("<?=$field?>"),
  <?php endforeach; ?>
                );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('<?=strtolower($controller)?>_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
<?php foreach ($show_in_add as $field): ?>
<?php if (formType($field) != "timestamp"): ?>
    $this->form_validation->set_rules("<?=$field?>","* <?=label($field)?>","trim|xss_clean<?=showRules($field)?>");
<?php endif; ?>
<?php endforeach; ?>
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
<?php foreach ($show_in_add AS $field): ?>
<?php if (formType($field) == "date"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "time"): ?>
      $save_data['<?=$field?>'] = date("H:i",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "datetime"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d H:i",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "timestamp"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d H:i");
<?php elseif(formType($field) == "upload_image"): ?>
      $save_data['<?=$field?>'] = $this->imageCopy($this->input->post('<?=$field?>',true),$_POST['file-dir-<?=$field?>']);
<?php else: ?>
      $save_data['<?=$field?>'] = $this->input->post('<?=$field?>',true);
<?php endif; ?>
<?php endforeach; ?>

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("<?=strtolower($controller)?>");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}
<?php endif; ?>

<?php if (count($show_in_update) > 0): ?>
function update($id)
{
  $this->is_allowed('<?=strtolower($controller)?>_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("<?=strtolower($controller)?>/update_action/$id"),
<?php foreach ($show_in_update AS $field): ?>
<?php if (formType($field) == "date"): ?>
                  '<?=$field?>' => $row-><?=$field?> == "" ? "":date("Y-m-d",  strtotime($row-><?=$field?>)),
<?php elseif(formType($field) == "time"): ?>
                  '<?=$field?>' => $row-><?=$field?> == "" ? "":date("H:i",  strtotime($row-><?=$field?>)),
<?php elseif(formType($field) == "datetime"): ?>
                  '<?=$field?>' => $row-><?=$field?> == "" ? "":date("Y-m-d",  strtotime($row-><?=$field?>))."T".date("H:i",  strtotime($row-><?=$field?>)),
<?php else: ?>
                  '<?=$field?>' => set_value("<?=$field?>", $row-><?=$field?>),
<?php endif; ?>
<?php endforeach; ?>
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('<?=strtolower($controller)?>_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
<?php foreach ($show_in_update as $field): ?>
<?php if (formType($field) != "timestamp"): ?>
    $this->form_validation->set_rules("<?=$field?>","* <?=label($field)?>","trim|xss_clean<?=showRules($field)?>");
<?php endif; ?>
<?php endforeach; ?>
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
<?php foreach ($show_in_update AS $field): ?>
<?php if (formType($field) == "date"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "time"): ?>
      $save_data['<?=$field?>'] = date("H:i",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "datetime"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d H:i",  strtotime($this->input->post('<?=$field?>', true)));
<?php elseif(formType($field) == "timestamp"): ?>
      $save_data['<?=$field?>'] = date("Y-m-d H:i");
<?php elseif(formType($field) == "upload_image"): ?>
      $save_data['<?=$field?>'] = $this->imageCopy($this->input->post('<?=$field?>',true),$_POST['file-dir-<?=$field?>']);
<?php else: ?>
      $save_data['<?=$field?>'] = $this->input->post('<?=$field?>',true);
<?php endif; ?>
<?php endforeach; ?>

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("<?=strtolower($controller)?>");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}
<?php endif; ?>

function delete($id)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('<?=strtolower($controller)?>_delete')) {
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

/* End of file {controller}.php */
/* Location: ./application/modules/<?=strtolower($controller)?>/controllers/backend/{controller}.php */
