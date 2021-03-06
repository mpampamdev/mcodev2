<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_mpampam extends CI_Migration {


  public function up()
   {
     //table setting
     $this->dbforge->add_field(array(
             'id_setting' => array(
                     'type' => 'INT',
                     'constraint' => 11,
             ),
             'group' => array(
                     'type' => 'VARCHAR',
                     'constraint' => '50'
             ),
             'options' => array(
                     'type' => 'VARCHAR',
                     'constraint' => '100'
             ),
             'value' => array(
                     'type' => 'VARCHAR',
                     'null' => TRUE,
                     'constraint' => '255'
             ),

     ));
     $this->dbforge->add_key('id_setting', TRUE);
     $this->dbforge->create_table('setting');
    $insert_setting = [
      [ "id_setting"  =>1 ,"group" => "general", "options" => "web_name" , "value" => "M-CODE CRUD GEBERATOR CODEIGNITER" ],
      [ "id_setting"  =>2 ,"group" => "general", "options" => "web_domain" , "value" => "www.m-code.dev" ],
      [ "id_setting"  =>3 ,"group" => "general", "options" => "web_owner" , "value" => "mpampam.dev/programmer_jalanan" ],
      [ "id_setting"  =>4 ,"group" => "general", "options" => "email" , "value" => "mpampam@dev.com" ],
      [ "id_setting"  =>5 ,"group" => "general", "options" => "telepon" , "value" => "085288888888" ],
      [ "id_setting"  =>6 ,"group" => "general", "options" => "address" , "value" => "-" ],
      [ "id_setting"  =>7 ,"group" => "general", "options" => "logo" , "value" => "231120043259_logos1.png" ],
      [ "id_setting"  =>8 ,"group" => "general", "options" => "logo_mini" , "value" => "231120051100_logo_mini.png" ],
      [ "id_setting"  =>9 ,"group" => "general", "options" => "favicon" , "value" => "231120051803_favicon.ico" ],
      [ "id_setting"  =>50 ,"group" => "sosmed", "options" => "facebook" , "value" => "https://facebook.com/mpampam" ],
      [ "id_setting"  =>51 ,"group" => "general", "options" => "instagram" , "value" => "https://instagram/mpampam" ],
      [ "id_setting"  =>52 ,"group" => "sosmed", "options" => "youtube" , "value" => "https://www.youtube.com/channel/UC1TlTaxRNdwrCqjBJ5zh6TA" ],
      [ "id_setting"  =>53 ,"group" => "sosmed", "options" => "twitter" , "value" => "https://twitter/m_pampam" ],
      [ "id_setting"  =>60 ,"group" => "config", "options" => "maintenance_status" , "value" => "N" ],
      [ "id_setting"  =>61 ,"group" => "config", "options" => "user_log_status" , "value" => "N" ]
    ];

    $this->db->insert_batch("setting", $insert_setting);
    //End table setting

    // auth_user
    $this->dbforge->add_field(array(
            'id_user' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
            ),
            'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'photo' => array(
                    'type' => 'VARCHAR',
                    'null' => TRUE,
                    'constraint' => '100'
            ),
            'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'token' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'last_login' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
            ),
            'ip_address' => array(
                    'type' => 'VARCHAR',
                    'null' => TRUE,
                    'constraint' => '50'
            ),
            'is_active' => array(
                    'type' => 'ENUM("0","1")',
                    'default' => "1"
            ),
            'created' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
            ),
            'modified' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE
            ),
            'is_delete' => array(
                    'type' => 'ENUM("0","1")',
                    'default' => "0"
            ),

    ));
    $this->dbforge->add_key('id_user', TRUE);
    $this->dbforge->create_table('auth_user');
    $this->db->query("INSERT INTO `auth_user` (`id_user`, `name`, `photo`, `email`, `password`, `token`, `last_login`, `ip_address`, `is_active`, `created`, `modified`, `is_delete`) VALUES
                      (1, 'Developer', '', 'mpampam@dev.com', '$2y$10$0uNl2k9rRVQLEvXnwNZa3eiqhY7e1LE/uaXsRBnYZZhOY7aWGEgG.', 'wg9sBvrdm03cPfnTYrba5b4mGWEErioH', '2020-11-25 13:11:00', '::1', '1', '2020-02-14 00:01:19', '2020-11-24 04:25:27', '0')");
    //end table auth_user



    // table auth group
    $this->dbforge->add_field(array(
            'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
            ),
            'group' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'definition' => array(
                    'type' => 'TEXT',
                    'null' => TRUE
            ),

    ));
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('auth_group');

   $this->db->query("INSERT INTO `auth_group` (`id`, `group`, `definition`) VALUES
                    (1, 'xadmin', 'Admin Master')");
  //end table auth_group

  // table auth_user_to_group
  $this->dbforge->add_field(array(
          'id_user' => array(
                  'type' => 'INT',
                  'constraint' => 11
          ),
          'id_group' => array(
                  'type' => 'INT',
                  'constraint' => 11
          ),

  ));
  $this->dbforge->create_table('auth_user_to_group');

 $this->db->query("INSERT INTO `auth_user_to_group` (`id_user`, `id_group`) VALUES
                                                     (1, 1)");
  //end auth_user_to_group


  // table auth_permission
  $this->dbforge->add_field(array(
          'id' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'auto_increment' => TRUE
          ),
          'permission' => array(
                  'type' => 'VARCHAR',
                  'constraint' => '100'
          ),
          'definition' => array(
                  'type' => 'TEXT',
                  'null' => TRUE,
                  'default' => Null
          ),

  ));
  $this->dbforge->add_key('id', TRUE);
  $this->dbforge->create_table('auth_permission');
  //
  $this->db->query("INSERT INTO `auth_permission` (`id`, `permission`, `definition`) VALUES
                    (Null, 'config_view_default', 'Module config'),
                    (Null, 'config_view_logo', 'Module config'),
                    (Null, 'config_view_sosmed', 'Module config'),
                    (Null, 'config_view_core', 'Module config'),
                    (Null, 'config_update_web_name', 'Module config'),
                    (Null, 'config_update_web_domain', 'Module config'),
                    (Null, 'config_update_web_owner', 'Module config'),
                    (Null, 'config_update_email', 'Module config'),
                    (Null, 'config_update_telepon', 'Module config'),
                    (Null, 'config_update_address', 'Module config'),
                    (Null, 'config_update_logo', 'Module config'),
                    (Null, 'config_update_logo_mini', 'Module config'),
                    (Null, 'config_update_favicon', 'Module config'),
                    (Null, 'config_update_facebook', 'Module config'),
                    (Null, 'config_update_instagram', 'Module config'),
                    (Null, 'config_update_youtube', 'Module config'),
                    (Null, 'config_update_twitter', 'Module config'),
                    (Null, 'config_update_language', 'Module config'),
                    (Null, 'config_update_time_zone', 'Module config'),
                    (Null, 'config_update_max_upload', 'Module config'),
                    (Null, 'config_update_route_admin', 'Module config'),
                    (Null, 'config_update_route_login', 'Module config'),
                    (Null, 'config_update_encryption_key', 'Module config'),
                    (Null, 'config_update_encryption_url', 'Module config'),
                    (Null, 'config_update_url_suffix', 'Module config'),
                    (Null, 'config_update_user_log_status', 'Module config'),
                    (Null, 'config_update_maintenance_status', 'Module config'),
                    (Null, 'menu_list', 'Module menu'),
                    (Null, 'menu_add', 'Module menu'),
                    (Null, 'menu_update', 'Module menu'),
                    (Null, 'menu_delete', 'Module menu'),
                    (Null, 'menu_drag_positions', 'Module menu'),
                    (Null, 'user_list', 'Module user'),
                    (Null, 'user_add', 'Module user'),
                    (Null, 'user_update', 'Module user'),
                    (Null, 'user_detail', 'Module user'),
                    (Null, 'user_delete', 'Module user'),
                    (Null, 'groups_list', 'Module groups'),
                    (Null, 'groups_add', 'Module groups'),
                    (Null, 'groups_access', 'Module groups'),
                    (Null, 'groups_update', 'Module groups'),
                    (Null, 'groups_delete', 'Module groups'),
                    (Null, 'permission_list', 'Module permission'),
                    (Null, 'permission_add', 'Module permission'),
                    (Null, 'permission_update', 'Module permission'),
                    (Null, 'permission_delete', 'Module permission'),
                    (Null, 'dashboard__view_profile_user', 'Module dashboard'),
                    (Null, 'dashboard_view_total_user', 'Module dashboard'),
                    (Null, 'dashboard_view_total_group', 'Module dashboard'),
                    (Null, 'dashboard_view_total_permission', 'Module dashboard'),
                    (Null, 'dashboard_view_total_filemanager', 'Module dashboard'),
                    (Null, 'filemanager_list', 'Module filemanager'),
                    (Null, 'filemanager_add', 'Module filemanager'),
                    (Null, 'filemanager_delete', 'Module filemanager'),
                    (Null, 'sidebar_view_dashboard', 'Module sidebar'),
                    (Null, 'sidebar_view_auth', 'Module sidebar'),
                    (Null, 'sidebar_view_user', 'Module sidebar'),
                    (Null, 'sidebar_view_groups', 'Module sidebar'),
                    (Null, 'sidebar_view_permission', 'Module sidebar'),
                    (Null, 'sidebar_view_config', 'Module sidebar'),
                    (Null, 'sidebar_view_system', 'Module sidebar'),
                    (Null, 'sidebar_view_management_menu', 'Module sidebar'),
                    (Null, 'sidebar_view_file_manager', 'Module sidebar'),
                    (Null, 'sidebar_view_m-crud_generator', 'Module Sidebar'),
                    (Null, 'crud_generator_list', 'Module crud generator'),
                    (Null, 'crud_generator_add', 'Module crud generator'),
                    (Null, 'crud_generator_delete', 'Module crud generator')");
//end table auth_permission

  // table auth_permission_to_group
  $this->dbforge->add_field(array(
          'permission_id' => array(
                  'type' => 'INT',
                  'constraint' => 11
          ),
          'group_id' => array(
                  'type' => 'INT',
                  'constraint' => 11
          )

  ));
  $this->dbforge->create_table('auth_permission_to_group');
// end table auth_permission_to_group

  // table main menu
  $this->dbforge->add_field(array(
          'id_menu' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'auto_increment' => TRUE
          ),
          'is_parent' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'null' => TRUE
          ),
          'menu' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 100,
                  'null' => TRUE
          ),
          'slug' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 100,
                  'null' => TRUE
          ),
          'type' => array(
                  'type' => 'ENUM("controller","url")',
                  'null' => TRUE
          ),
          'controller' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'null' => TRUE
          ),
          'target' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 20,
                  'null' => TRUE
          ),
          'icon' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 50,
                  'null' => TRUE
          ),
          'is_active' => array(
                  'type' => 'ENUM("0","1")',
                  'null' => TRUE
          ),
          'sort' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'null' => TRUE
          ),
          'created' => array(
                  'type' => 'DATETIME',
                  'null' => TRUE
          ),
          'modified' => array(
                  'type' => 'DATETIME',
                  'null' => TRUE
          )


  ));
  $this->dbforge->add_key('id_menu', TRUE);
  $this->dbforge->create_table('main_menu');
  $this->db->query("INSERT INTO `main_menu` (`id_menu`, `is_parent`, `menu`, `slug`, `type`, `controller`, `target`, `icon`, `is_active`, `sort`, `created`, `modified`) VALUES
  (3, 7, 'management menu', 'management-menu', 'controller', 'main_menu', '', '', '1', 8, '2020-02-15 06:48:31', '2020-11-02 13:33:26'),
  (7, 0, 'configuration', 'configuration', 'controller', '', '', 'fa fa-cogs', '1', 6, '2020-02-26 06:42:29', '2020-11-23 05:20:01'),
  (34, 7, 'settings', 'settings', 'controller', 'setting', '', '', '1', 7, '2020-10-19 00:25:57', '2020-11-23 05:20:11'),
  (36, 0, 'dashboard', 'dashboard', 'controller', 'dashboard', '', 'mdi mdi-laptop', '1', 1, '2020-10-27 08:18:55', '2020-11-09 23:07:13'),
  (37, 0, 'auth', 'auth', NULL, '', NULL, 'mdi mdi-account-settings-variant', '1', 2, '2020-10-27 08:45:17', NULL),
  (38, 37, 'user', 'user', 'controller', 'user', NULL, 'mdi mdi-account-star', '1', 3, '2020-10-27 08:46:10', '2020-10-27 09:38:05'),
  (39, 37, 'groups', 'groups', 'controller', 'group', NULL, '', '1', 4, '2020-10-27 08:48:28', '2020-10-27 20:24:12'),
  (40, 37, 'permission', 'permission', 'controller', 'permission', NULL, '', '1', 5, '2020-10-27 08:49:49', '2020-10-29 22:47:10'),
  (48, 0, 'm-crud generator', 'm-crud-generator', 'controller', 'm_crud_generator', '', 'mdi mdi-xml', '1', 11, '2020-11-01 12:23:11', '2020-11-22 00:06:35'),
  (54, 7, 'file manager', 'file-manager', 'controller', 'filemanager', '', 'mdi mdi-folder-multiple-image', '1', 9, '2020-11-08 00:44:38', NULL);");
  //end table main menu

  // table filemanager
  $this->dbforge->add_field(array(
          'id' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'auto_increment' => TRUE
          ),
          'file_name' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'null' => TRUE
          ),
          'ket' => array(
                  'type' => 'TEXT',
                  'null' => TRUE
          ),
          'created' => array(
                  'type' => 'DATETIME',
                  'null' => TRUE
          ),
          'update' => array(
                  'type' => 'DATETIME',
                  'null' => TRUE
          )


  ));
  $this->dbforge->add_key('id', TRUE);
  $this->dbforge->create_table('filemanager');
  $this->db->query("INSERT INTO `filemanager` (`id`, `file_name`, `ket`, `created`, `update`) VALUES
                  (Null, '231120043259_logos1.png', 'LOGO APLIKASI', '2020-11-23 04:32:59', NULL),
                  (Null, '231120051100_logo_mini.png', 'LOGO MINI', '2020-11-23 05:11:00', NULL),
                  (Null, '231120051803_favicon.ico', 'FAVICON', '2020-11-23 05:18:03', NULL)");
  // end filemanager


  // table ci_log
  $this->dbforge->add_field(array(
            'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
            ),
            'user' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE
            ),
            'ip_address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => TRUE
            ),
            'controller' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE
            ),
            'url' => array(
                    'type' => 'TEXT',
                    'null' => TRUE
            ),
            'data' => array(
                    'type' => 'TEXT',
                    'null' => TRUE
            ),
            'created_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE
            )


  ));
  $this->dbforge->add_key('id', TRUE);
  $this->dbforge->create_table('ci_user_log');
  // end_ci_log


  // table modules crud generator
  $this->dbforge->add_field(array(
          'id' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'auto_increment' => TRUE
          ),
          'module' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'null' => TRUE
          ),
          'module_name' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'null' => TRUE
          ),
          'table' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'null' => TRUE
          ),
          'created_at' => array(
                  'type' => 'DATETIME',
                  'null' => TRUE
          )
  ));
  $this->dbforge->add_key('id', TRUE);
  $this->dbforge->create_table('modules_crud_generator');
}



   public function down()
   {
     $tables = $this->db->query('SHOW TABLES FROM '.$this->db->database)->result();
            foreach ($tables as $table) {
                $tab = array_values((array)$table)[0];
                $this->dbforge->drop_table($tab);
            }
   }
}
