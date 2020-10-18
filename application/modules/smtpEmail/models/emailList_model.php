<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class emailList_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_emaillist =  'emailes';
          $this->tbl_history =  'history';
     }


     public function emailToDb($mails)
     {
          if (!empty($mails) && count($mails) > 0) {
               foreach ($mails as $mail) {
                    $emailData = array(
                         'date' => $mail['header']->date,
                         'emil_index' => $mail['index'],
                         'headder' => $mail['header']->Subject,
                         'from' => $mail['header']->fromaddress,
                         'content' => $mail['body'],
                         'status' => ACTIVE,
                         'data' => json_encode($mail),
                    );
                    $this->db->where('emil_index', $mail['index']);
                    $q = $this->db->get($this->tbl_emaillist);
                    if ($q->num_rows() > 0) {
                         // $this->db->where('emil_index', $mail['index']);
                         // $this->db->update($this->tbl_emaillist, $emailData);
                    } else {
                         $this->db->insert($this->tbl_emaillist, $emailData);
                    }
                    $emailHist = array(
                         'date' => date('Y-m-d H:i:s'),
                         'data' => json_encode($mail),
                         'action' => SYNCH
                    );
                    $this->db->insert($this->tbl_history, $emailHist);
               }
          }
     }

     public function deleteEmail($id)
     {
          if (!empty($id)) {
               $this->db->where('emil_index', $id);
               $this->db->set('status', DELETED);
               $this->db->update($this->tbl_emaillist);

               $emailHist = array(
                    'date' => date('Y-m-d H:i:s'),
                    'data' => NULL,
                    'action' => SYNCH
               );
               $this->db->insert($this->tbl_history, $emailHist);
               return true;
          } else {
               return false;
          }
     }

     public function readEmials($id, $search = "", $limit = 10, $offset = 0)
     {
          $return = array();
          if (!empty($id)) {
               $return  =  $this->db->get_where($this->tbl_emaillist, array('id' => $id))->row_array();
          }
          $this->db->from($this->tbl_emaillist);
          $this->db->where($this->tbl_emaillist . ".status =" . ACTIVE);
          if ($search != "") {
               $this->db->like('content', $search, 'both');
          }
          $this->db->limit($limit, $offset);
          $result = $this->db->get();
          if ($result !== FALSE && $result->num_rows() > 0) {
               $return =  $result->result();
          }
          // print_r($this->db->last_query());exit;
          if ($search != "") {
               $emailHist = array(
                    'date' => date('Y-m-d H:i:s'),
                    'data' => $search,
                    'action' => SEARCH
               );
               $this->db->insert($this->tbl_history, $emailHist);
          }
          return $return;
     }

     public function emailListCount()
     {
          $count = $this->db->get_where($this->tbl_emaillist, array('status' => ACTIVE))->num_rows();
          return $count;
     }
}
