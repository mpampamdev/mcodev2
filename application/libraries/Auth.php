<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * mpampam.com
 */
class Auth
{
  private $CI;

  private $group_id = null;
  private $user_id = null;


  function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->model("core/Core_model");
  }


  function is_allowed($params)
  {
    $allowed = false;
    $group_id = profile('id_group');

    if ($group_id == 1) {
      $allowed = true;
    }else {
      $perms = $this->CI->model->get_data("auth_permission",["permission"=>$params]);
      $perms_id = $perms->row()->id;

      $cek_permission_to_group = $this->CI->model->get_data("auth_permission_to_group", ['group_id' => $group_id, 'permission_id' => $perms_id]);
      if ($cek_permission_to_group->num_rows() > 0) {
        $allowed = true;
      }else {
        $allowed = false;
      }

    }

    return $allowed;

  }

  function created_permission($params)
  {
    $perms = $this->CI->model->get_data("auth_permission",["permission"=>$params]);
    if ($perms->num_rows() < 1 ) {
        $perm_tmp_arr = explode('_', $params);
        $save = ["permission" => $params,
                 "definition" => "Module ".$perm_tmp_arr[0]
                ];
        $this->CI->db->insert("auth_permission", $save);
        return $this->CI->db->insert_id();
    }else {
        return false;
    }
  }

  function is_logged($is_redirect = false)
  {
    $ID_USER = $this->CI->session->id_user;
    $STATUS_LOG = $this->CI->session->login_status;

    if ($STATUS_LOG) {
      if ($this->_user_db($ID_USER)) {
        return true;
      }else {
        if ($is_redirect) {
          redirect(site_url("logout"));
        }
        return false;
      }
    }else {
      if ($is_redirect) {
        redirect(site_url("logout"));
      }
      return false;
    }
  }


  function _user_db($ID_USER)
  {
    $qry = $this->CI->db->where("auth_user.id_user",$ID_USER)
                        ->where("auth_user.is_active","1")
                        ->where("auth_user.is_delete","0")
                        ->get("auth_user");

    if ($qry->num_rows() > 0) {
      return true;
    }else {
      return false;
    }
  }

}
