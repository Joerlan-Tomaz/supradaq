<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table_model
 *
 * @author herisson.c.silva
 */
class Table_model extends CI_Model {

    public function populate($data) {
        foreach ($data as $key => $item) {
            if (!empty($item) && $item !== '2,0 < ICPF < 4,0') {
                $this->$key = $item;
            } else {
                $this->$key = NULL;
            }
        }
        return;
    }

    public function save() {
        $pk = $this->db->primary($this->table);

        if (!isset($this->$pk)) {

            $this->db->set($this);
            $return = $this->db->insert($this->table);
            $this->$pk = $this->db->insert_id();
            return $return;
        } else {
            $pk_value = $this->$pk;
            $this->db->where($pk, $this->$pk);
            unset($this->$pk);
            $this->db->set($this);
            $return = $this->db->update($this->table);
            $this->$pk = $pk_value;
            return $return;
        }
    }

    public function getAll() {
        $this->db->from($this->table);
        return $this->db->get()->result_array();
    }

    public function delete($id_element = null) {
        $pk = $this->db->primary($this->table);

        if (!is_null($id_element))
            $this->$pk = $id_element;

        $this->db->where($pk, $this->$pk);
        $return = $this->db->delete($this->table);
        unset($this->$pk);
        return $return;
    }

    public function get($id_element = null) {
        if (is_array($id_element)) {
            $this->db->from($this->table);
            $this->db->where(key($id_element), current($id_element));
            return $this->db->get()->row_array();
        } else {
            $pk = $this->db->primary($this->table);

            if (!is_null($id_element))
                $this->$pk = $id_element;

            $this->db->from($this->table);
            $this->db->where($pk, $this->$pk);
            return $this->db->get()->row_array();
        }
    }

}
