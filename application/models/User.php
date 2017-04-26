<?php
class User extends CI_Model {
    function get_user_by_email($email)
    {
        return $this->db->query("SELECT * FROM users WHERE email = ?", array($email))->row_array();
    }
    function get_user_by_id($id)
    {
        return $this->db->query("SELECT * FROM users WHERE id = ?", array($id))->row_array();
    }
    function add_user($user)
    {
        $query = "INSERT INTO users (name, alias, email, password, salt, date_birth, created_at, updated_at) VALUES(?,?,?,?,?,?,?,?)";
        $values = array($user['name'], $user['alias'], $user['email'], $user['password'], $user['salt'], $user['date_birth'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
        return $this->db->query($query, $values);
    }
    function get_users_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_has_items', 'users_has_items.users_id=users.id');
        $this->db->join('items', 'users_has_items.items_id = items.id');
        $this->db->where('items_id', $id);
        return $this->db->get()->row_array();
    }
}

 ?>
