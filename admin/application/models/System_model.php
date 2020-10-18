<?php
class System_model extends CI_Model{




    // function for get all sub_menus
    public function get_sub_menus(){
        return $this->db->get('sub_menu');
    }



    // get system permissions
    public function get_system_permissions_by_id ($subid) {
        return $this->db->select('*')->from('access_permissions')->where('is_view',0)->where('sub_menu_idsub_menu',$subid)->get();
    }


}