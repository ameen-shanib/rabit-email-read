<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Common_model extends CI_Model {

       public function __construct() {
            $this->load->database();
            parent::__construct();
       }
       
       function getSettings($key = '') {

            $this->db->select('*')->from(TABLE_PREFIX . 'settings');
            if (!empty($key)) {
                 return $this->db->where('set_key', $key)->get()->row_array();
            } else {
                 return $this->db->get()->result_array();
            }
       }
  }