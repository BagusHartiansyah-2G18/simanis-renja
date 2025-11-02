<?php
class Msop extends CI_Model {

    public function add($values) {
        
        $this->db->insert('sop', $values);
        return $this->db->insert_id();
    }

    public function cari_satuan($keyword) {
        $this->db->like('nama', $keyword);
        return $this->db->get('satuan')->result();
    }
    public function all($kdBidang ="") {
        $this->db->select('*');
        $this->db->from('sop');
        if($kdBidang!=""){
            $this->db->where('kdBidang', $kdBidang);
        }
        return $this->db->get()->result();
    }
    public function cbKategori() {
        $this->db->select('kategori as value, kategori AS valueName');
        $this->db->from('sop');
        $this->db->group_by('kategori');

        return $this->db->get()->result();
    }
    public function del($id) {
        return $this->db->delete('sop', array('id' => $id));
    }


}
