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


class Testing_model extends MY_Model{

  private $table        = "testing";
  private $primary_key  = "id";
  private $column_order = array('title', 'desc', 'id_user', 'id_image', 'status', 'created_at', 'update_at');
  private $order        = array('testing.id'=>"DESC");
  private $select       = "testing.id,testing.title,testing.desc,testing.id_user,testing.id_image,testing.status,testing.created_at,testing.update_at";

public function __construct()
	{
		$config = array(
      'table' 	      => $this->table,
			'primary_key' 	=> $this->primary_key,
		 	'select' 	      => $this->select,
      'column_order' 	=> $this->column_order,
      'order' 	      => $this->order,
		 );

		parent::__construct($config);
	}

  private function _get_datatables_query()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);
      $this->_get_join();

    if($this->input->post("title"))
        {
          $this->db->like("testing.title", $this->input->post("title"));
        }

    if($this->input->post("desc"))
        {
          $this->db->like("testing.desc", $this->input->post("desc"));
        }

    if($this->input->post("id_user"))
        {
          $this->db->like("testing.id_user", $this->input->post("id_user"));
        }

    if($this->input->post("id_image"))
        {
          $this->db->like("testing.id_image", $this->input->post("id_image"));
        }

    if($this->input->post("status"))
        {
          $this->db->like("testing.status", $this->input->post("status"));
        }

      if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }

    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
      $this->db->select($this->select);
      $this->db->from("$this->table");
      $this->_get_join();
      return $this->db->count_all_results();
    }

    public function _get_join()
    {
      $this->db->select("auth_user.name");
      $this->db->join("auth_user","auth_user.id_user = testing.id_user","left");
      $this->db->select("filemanager.file_name");
      $this->db->join("filemanager","filemanager.id = testing.id_image","left");
    }

    public function get_detail($id)
    {
        $this->db->select("".$this->table.".*");
        $this->db->from($this->table);
        $this->_get_join();
        $this->db->where("".$this->table.'.'.$this->primary_key,$id);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
          return $query->row();
        }else{
          return FALSE;
        }
    }

}

/* End of file Testing_model.php */
/* Location: ./application/modules/testing/models/Testing_model.php */
