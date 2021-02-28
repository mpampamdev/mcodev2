{php_open_tag} defined('BASEPATH') OR exit('No direct script access allowed');
<?php
  $show_in_filter = $this->mcrud_build->showInFilter();
  $show_in_table = $this->mcrud_build->showInTable();
  $show_in_select= $this->mcrud_build->selectTable();
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


class {controller}_model extends MY_Model{

  private $table        = "<?=$table_name?>";
  private $primary_key  = "<?=$primary_key?>";
  private $column_order = array('<?= implode("', '", $show_in_table); ?>');
  private $order        = array('<?=$table_name?>.<?=$primary_key?>'=>"DESC");
  private $select       = "<?=$table_name?>.<?=$primary_key?>,<?=implode(",", $show_in_select)?>";

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
<?php if ($cek_relation): ?>
      $this->_get_join();
<?php endif; ?>
<?php if (count($show_in_filter) > 0): ?>
<?php foreach ($show_in_filter as $field): ?>

    if($this->input->post("<?=$field?>"))
        {
<?php if (formType($field) == "datetime" OR formType($field) == "timestamp"): ?>
          $this->db->like("<?=$table_name?>.<?=$field?>", date('Y-m-d H:i',strtotime($this->input->post("<?=$field?>"))));
<?php elseif(formType($field) == "date"): ?>
          $this->db->like("<?=$table_name?>.<?=$field?>", date('Y-m-d',strtotime($this->input->post("<?=$field?>"))));
<?php elseif(formType($field) == "time"): ?>
          $this->db->like("<?=$table_name?>.<?=$field?>", date('H:i',strtotime($this->input->post("<?=$field?>"))));
<?php else: ?>
          $this->db->like("<?=$table_name?>.<?=$field?>", $this->input->post("<?=$field?>"));
<?php endif; ?>
        }
<?php endforeach; ?>
<?php endif; ?>

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
<?php if ($cek_relation): ?>
      $this->_get_join();
<?php endif; ?>
      return $this->db->count_all_results();
    }

<?php if ($cek_relation): ?>
    public function _get_join()
    {
<?php foreach ($show_in_table as $field): ?>
<?php if (formType($field) == "select_relation" OR formType($field) == "option_relation"): ?>
<?php $table_relation = optionRelation($field, "relation_table");
  $value = optionRelation($field, "relation_value");
  $label = optionRelation($field, "relation_label");?>
      $this->db->select("<?=$table_relation?>.<?=$label?>");
      $this->db->join("<?=$table_relation?>","<?=$table_relation?>.<?=$value?> = <?=$table_name?>.<?=$field?>","left");
<?php endif; ?>
<?php endforeach; ?>
    }
<?php endif; ?>

<?php if ($cek_relation): ?>
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
<?php endif; ?>

}

/* End of file {controller}_model.php */
/* Location: ./application/modules/<?=strtolower($controller)?>/models/{controller}_model.php */
