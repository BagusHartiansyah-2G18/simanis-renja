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
    // public function all($kdBidang ="") {
    //     $this->db->select('*');
    //     $this->db->from('sop');
    //     if($kdBidang!=""){
    //         $this->db->where('kdBidang', $kdBidang);
    //     }
    //     return $this->db->get()->result();
    // }
    public function all($kdBidang = "") {
        $this->db->select('sop.*, dinas_bidang.nmBidang'); // Sesuaikan kolom yang ingin diambil
        $this->db->from('sop');
        $this->db->join('dinas_bidang', 'dinas_bidang.kdDBidang = sop.kdBidang', 'left');
        if ($kdBidang != "") {
            $this->db->where('sop.kdBidang', $kdBidang);
        }
        return $this->db->get()->result();
    }

    public function cbKategori($kdBidang = "") {
        $this->db->select('kategori as value, kategori AS valueName');
        $this->db->from('sop');
        $this->db->group_by('kategori');
        if ($kdBidang != "") {
            $this->db->where('kdBidang', $kdBidang);
        }

        return $this->db->get()->result();
    }
    public function del($id) {
        return $this->db->delete('sop', array('id' => $id));
    }


}
