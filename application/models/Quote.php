<?php
class Quote extends CI_Model {

function get_quotes_by_user_id($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('fav_list', 'fav_list.user_id=users.id');
        $this->db->join('quotes', 'fav_list.quote_id = quotes.id');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result_array();
    }
function get_quotes_except_fav($user_id)
    {
        return $this->db->query("SELECT * FROM users JOIN quotes ON users.id = quotes.users_id
        WHERE quotes.id NOT IN ( SELECT fav_list.quote_id FROM fav_list
        JOIN quotes ON fav_list.quote_id = quotes.id
        WHERE fav_list.user_id = {$user_id}) ")->result_array();
    }
function add_quote($quote)
    {
        $query = "INSERT INTO quotes (text, author, maker, created_at, updated_at, users_id) VALUES(?,?,?,?,?,?)";
        $values = array($quote['text'], $quote['author'], $quote['maker'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"), $quote['users_id']);
        return $this->db->query($query, $values);
    }
function add_item_to_fav($join)
    {
        $query = "INSERT INTO fav_list (user_id, quote_id) VALUES(?,?)";
        $values = array($join['user_id'], $join['quote_id']);
        return $this->db->query($query, $values);
    }
function remove_fav_list($id)
    {
        $query = "DELETE FROM fav_list WHERE user_id = ? AND quote_id = ?";
        $where = array($id['user_id'], $id['quote_id']);
        return $this->db->query($query, $where);
    }
    function get_items_by_name($item)
    {
        return $this->db->query("SELECT * FROM items WHERE item = ?", array($item))->row_array();
    }
    function get_item_by_item_id($item_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_has_items', 'users_has_items.users_id=users.id');
        $this->db->join('items', 'users_has_items.items_id = items.id');
        $this->db->where('items_id', $item_id);
        return $this->db->get()->result_array();
    }


    function all_quotes_of_user_id($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('quotes', 'users.id = quotes.users_id');
        $this->db->where('users_id', $user_id);
        return $this->db->get()->result_array();
    }

    function delete_item($id)
    {
        $query1 = "DELETE FROM users_has_items WHERE items_id = ?";
        $where1 = array($id);
        $this->db->query($query1, $where1);
        $query2 = "DELETE FROM items WHERE id = ?";
        $where2 = array($id);
        return $this->db->query($query2, $where2);
    }
}
