<?php
class User_model extends CI_Model{

    public function log_user($email,$password){
        $resobj = $this->db->get_where('user',array('email'=>$email));
        if (isset($resobj) && $resobj->num_rows()) {
            $hash = $resobj->row()->password;
            if (password_verify($password, $hash)) {
                $_SESSION['user_data'] = array(
                    'id' => $resobj->row()->iduser,
                    'first_name'=>$resobj->row()->first_name,
                    'last_name'=>$resobj->row()->last_name,
                    'email'=>$resobj->row()->email,
                    'login_type'=>$resobj->row()->login_type_idlogin_type
                );
                return true;
            } else {
                return array('form_err'=>array('password'=>'Password is wrong!','email'=>""));
            }
        } else {
            return array('form_err'=>array('email'=>'No such email in the system!','password'=>""));
        }
    }

    // user access validation function
    public function validate_user_access($access_code){
        if(!isset($_SESSION['user_data'])) {
            return false;
        } else {
            $user_type = $this->db->select('l_types')
                                ->from('user')
                                ->join('login_type','login_type_idlogin_type = idlogin_type')
                                ->where('iduser',$_SESSION['user_data']['id'])
                                ->get()->row()->l_types;
            
            if ($user_type == 'admin') {
                return true;
            } else {
                $access_id = $this->db->get_where('access_permissions',array('access_code'=>$access_code))->row()->idaccess_permissions;
                $result = $this->db->select('*')
                            ->from('user_permissions')
                            ->where('access_permissions_idaccess_permissions',$access_id)
                            ->where('user_iduser',$_SESSION['user_data']['id'])
                            ->get()->num_rows();
                if ($result > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    // function for get user data from database
    public function get_user_data($sp) {

        // if paramiter == all returns all users
        if($sp == 'all') {
            $users = $this->db->select('*')
                                ->from('user')
                                ->join('login_type','login_type_idlogin_type = idlogin_type')
                                ->get();
            return $users;
        } else { // if paramitter not == all then returns specific user data
            $users = $this->db->select('*')
                                ->from('user')
                                ->join('login_type','login_type_idlogin_type = idlogin_type')
                                ->where('iduser',$sp)
                                ->get();
            return $users;
        }
    }

    // function for get user types
    public function get_user_types() {
        return $this->db->get('login_type');
    }

    // function for create user
    public function create_user($user){
        if ($this->db->insert('user',$user)) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete user
    public function delete_user($id) {
        if($this->db->delete('user', array('iduser' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    // function for update user
    public function update_user($user,$id){
        if ($this->db->where('iduser',$id)->update('user',$user)) {
            return true;
        } else {
            return false;
        }
    }

    // function for get user allowed views by view and user id
    public function get_user_allowed_view_by_id($user_id,$sub_id) {
        return $this->db->select('*')
                        ->from('sub_menu')
                        ->join('access_permissions','access_permissions.sub_menu_idsub_menu = sub_menu.idsub_menu')
                        ->join('user_menu','user_menu.sub_menu_idsub_menu = sub_menu.idsub_menu')
                        ->join('user_permissions','user_permissions.access_permissions_idaccess_permissions = access_permissions.idaccess_permissions')
                        ->where('user_menu.user_iduser',$user_id)
                        ->where('user_permissions.user_iduser',$user_id)
                        ->where('sub_menu.idsub_menu',$sub_id)
                        ->where('access_permissions.is_view',1)
                        ->get();
    }

    // insert user menu and set permission for user view
    public function insert_user_menu($userid,$subid) {
        $main_menu_id = $this->db->select('*')->from('sub_menu')->where('idsub_menu',$subid)->get()->row()->main_menu_idmain_menu;

        
        $this->db->trans_begin();

            // insert user menu
            $this->db->insert('user_menu',array('sub_menu_idsub_menu'=>$subid, 'user_iduser'=>$userid, 'main_menu_idmain_menu'=>$main_menu_id));
            // get relevant access permission id
            $permission_id = $this->db->select('*')->from('access_permissions')->where('sub_menu_idsub_menu',$subid)->where('is_view','1')->get();
            // insert user permission
            $this->db->insert('user_permissions',array('user_iduser' => $userid, 'access_permissions_idaccess_permissions'=>$permission_id->row()->idaccess_permissions));
            
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // remove user menu and remove permission of user view
    public function remove_user_menu($userid,$subid) {
        
        $this->db->trans_begin();

            // remove user menu
            $this->db->where('sub_menu_idsub_menu',$subid)->where('user_iduser',$userid)->delete('user_menu');
            // get relevant access permission id
            $permission_id = $this->db->select('*')->from('access_permissions')->where('access_permissions.sub_menu_idsub_menu',$subid)->where('access_permissions.is_view',1)->get()->row()->idaccess_permissions;
            // delete user permission
            $this->db->where('access_permissions_idaccess_permissions',$permission_id)->where('user_iduser',$userid)->delete('user_permissions');
            
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // get user allowed permissions by id and sub menu
    public function get_user_allowed_permission_by_id ($user_id,$permission_id) {
        return $this->db->select('*')->from('user_permissions')->where('user_iduser',$user_id)->where('access_permissions_idaccess_permissions',$permission_id)->get();
    }

    // set permission for user
    public function set_permission($user_id,$permission) {
        $data = array (
            'user_iduser' => $user_id,
            'access_permissions_idaccess_permissions' => $permission
        );
        if ($this->db->insert('user_permissions', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // set permission for user
    public function remove_permission($user_id,$permission) {
        if ($this->db->where('user_iduser', $user_id)->where('access_permissions_idaccess_permissions',$permission)->delete('user_permissions')) {
            return true;
        } else {
            return false;
        }
    }
}