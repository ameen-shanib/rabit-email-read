<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SmtpEmail extends App_Controller
{

     // public $mailConfig = array(
     //      'protocol' => 'smtp',
     //      'smtp_host' => 'ssl://smtp.googlemail.com',
     //      'smtp_port' => 465,
     //      'smtp_user' => 'harveyspect60@gmail.com',
     //      'smtp_pass' => 'zwukybktspqnzwqk#',
     //      'mailtype' => 'html',
     //      'charset' => 'utf-8'
     // );

     private $server = 'ssl://smtp.googlemail.com';
     private $user   = 'harveyspect60@gmail.com';
     private $pass   = 'zwukybktspqnzwqk';
     private $port   = 465;

     public function __construct()
     {
          parent::__construct();
          $this->body_class[] = 'skin-blue';
          $this->load->model('emailList_model', 'emailList');
     }

     function connect()
     {
          // $this->load->library('email', $this->mailConfig);
          // $conf = {imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX
          // @imap_open("{".$imap_host.$imap_flags."}INBOX",$imap_user,$imap_pass);
          $this->conn =  @imap_open('{smtp.googlemail.com:993/imap/ssl/novalidate-cert}INBOX', $this->user, $this->pass);
     }

     function fetchfrmsmtp()
     {
          $this->connect();
          $this->msg_cnt = imap_num_msg($this->conn);
          $inbox = array();
          for ($i = 1; $i <= $this->msg_cnt; $i++) {
               $inbox[] = array(
                    'index'     => $i,
                    'header'    => imap_headerinfo($this->conn, $i),
                    'body'      => imap_body($this->conn, $i),
                    'structure' => imap_fetchstructure($this->conn, $i)
               );
          }
          $this->emailList->emailToDb($inbox);
          $this->index();
     }

     function index($id = NULL)
     {
          $search = isset($_GET['search']) ? $_GET['search'] : "";
          $limit =  isset($_GET['limit']) ? $_GET['limit'] :  10;
          $offset = isset($_GET['offset']) ? $_GET['offset'] :  0;
          $inbox = $this->emailList->readEmials($id, $search, $limit, $offset);
          $count = $this->emailList->emailListCount();
          $get = isset($_GET['page']) ? 1 : 0;
          if ($get) {
               $draw = isset($_GET['draw']) ? $_GET['draw'] : NULL;
               $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $count,
                    "iTotalDisplayRecords" => count($inbox),
                    "aaData" => $inbox,
                    "start" => $offset,
                    "length" => $limit,
               );
               echo json_encode($response);
               exit;
          }
          $this->render_page(strtolower(__CLASS__) . '/index', array('inbox' => $inbox, 'count' => $count));
     }

     function deleteEmail($id)
     {
          $this->connect();
          $mbox =  $this->conn; //@imap_open('{smtp.googlemail.com:993/imap/ssl/novalidate-cert}INBOX', $this->user, $this->pass);
          $check = imap_mailboxmsginfo($this->conn);
          imap_delete($mbox, $id);
          $this->emailList->deleteEmail($id);
          $this->index();
     }
}
