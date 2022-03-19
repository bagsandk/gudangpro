<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_order_model extends CI_Model
{
    public function update($table, $data, $where)
    {
        $data['rec_update'] = date('Y-m-d H:i:s');
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
}
