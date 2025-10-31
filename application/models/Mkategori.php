<?php
class Mkategori extends CI_Model {

    public function add($values) {
        $this->db->insert('kategoriumum', $values);
        return $this->db->insert_id();
    }

    public function cari_satuan($keyword) {
        $this->db->like('nama', $keyword);
        return $this->db->get('satuan')->result();
    }
    public function cb() {
        $this->db->select('id AS value, nmKate AS valueName');
        $this->db->from('kategoriumum');
        return $this->db->get()->result();
    }

}
