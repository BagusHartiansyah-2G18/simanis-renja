<?php
class Mdinas extends CI_Model {

     
    public function all() {
        $this->db->select('*,
            CASE 
                WHEN pagu = 0 THEN 0 
                ELSE CONCAT(ROUND((realisasi / pagu) * 100, 0), "%") 
            END as persen
        ');
        $this->db->from('dinasview');
        return $this->db->get()->result();
    } 
    public function upd($id, $data) {
        $this->db->where('kdDinas', $id); 
        $updated = $this->db->update('dinasview', $data);
        if ($updated) {
            return $this->all(); // Return all data after successful update
        } else {
            return false; // Return false if update failed
        }

    }

}
