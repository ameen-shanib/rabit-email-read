<?php

  $CI = get_instance();

  /**
   * Function for crop image with jcrop
   * @param array $upload_data
   * @param array $postDatas
   * @return boolean
   */
  function crop($upload_data, $postDatas) {
       $CI = & get_instance();

       $x1 = $postDatas['x1'];
       $x1 = isset($x1['0']) ? $x1['0'] : '';

       $x2 = $postDatas['x2'];
       $x2 = isset($x2['0']) ? $x2['0'] : '';

       $y1 = $postDatas['y1'];
       $y1 = isset($y1['0']) ? $y1['0'] : '';

       $y2 = $postDatas['y2'];
       $y2 = isset($y2['0']) ? $y2['0'] : '';

       $w = $postDatas['w'];
       $w = isset($w['0']) ? $w['0'] : '';

       $h = $postDatas['h'];
       $h = isset($h['0']) ? $h['0'] : '';

       $CI->load->library('image_lib');

       $image_config['image_library'] = 'gd2';
       $image_config['source_image'] = $upload_data["file_path"] . $upload_data["file_name"];
       $image_config['new_image'] = $upload_data["file_path"] . $upload_data["file_name"];
       $image_config['quality'] = "100%";
       $image_config['maintain_ratio'] = FALSE;
       $image_config['x_axis'] = $x1;
       $image_config['y_axis'] = $y1;
       $image_config['width'] = $w;
       $image_config['height'] = $h;

       $CI->image_lib->initialize($image_config);
       $CI->image_lib->crop();
       $CI->image_lib->clear();

       /* Second size */
       $configSize2['image_library'] = 'gd2';
       $configSize2['source_image'] = $upload_data["file_path"] . $upload_data["file_name"];
       $configSize2['create_thumb'] = TRUE;
       $configSize2['maintain_ratio'] = TRUE;
       $width = get_settings_by_key('thumbnail_width');
       $height = get_settings_by_key('thumbnail_height');
       $configSize2['width'] = !empty($width) ? $width : DEFAULT_THUMB_W;
       $configSize2['height'] = !empty($height) ? $height : DEFAULT_THUMB_H;
       $configSize2['new_image'] = 'thumb_' . $upload_data["file_name"];

       $CI->image_lib->initialize($configSize2);
       $CI->image_lib->resize();
       $CI->image_lib->clear();

       return true;
  }

  function get_options($array, $parent = 0, $indent = "") {
       $return = array();
       foreach ($array as $key => $val) {
            if ($val["parent_category_id"] == $parent) {
                 $return["x" . $val["category_id"]] = $indent . $val["category_name"];
                 $return = array_merge($return, get_options($array, $val["category_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"));
            }
       }
       return $return;
  }

  function getCategories() {
       global $CI;
       $CI->load->model('home_model');
       return $CI->home_model->getCategories();
  }

  function getParentCategories() {
       global $CI;
       $CI->load->model('home_model');
       return $CI->home_model->getParentCategories();
  }

  function debug($array = array(), $exit = 1) {
       echo '<pre>';
       print_r($array);
       if ($exit == 1)
            exit;
  }

  function getCaptcha() {
       $number1 = rand(1, 9999);
       $number2 = rand(1, 9999);
       return $number1 + $number2;
  }

  function getPaginationDesign() {
       $config['full_tag_open'] = '<ul class="page">';
       $config['full_tag_close'] = '</ul>';
       $config['prev_link'] = 'Previous';
       $config['prev_tag_open'] = '<li>';
       $config['prev_tag_close'] = '</li>';
       $config['next_link'] = 'Next';
       $config['next_tag_open'] = '<li>';
       $config['next_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="current">';
       $config['cur_tag_close'] = '</li>';
       $config['num_tag_open'] = '<li>';
       $config['num_tag_close'] = '</li>';

       $config['first_tag_open'] = '<li>';
       $config['first_tag_close'] = '</li>';
       $config['last_tag_open'] = '<li>';
       $config['last_tag_close'] = '</li>';

       $config['first_link'] = '&laquo;';
       $config['last_link'] = '&raquo;';
       return $config;
  }

  function get_state_province($id = '') {
       global $CI;
       $CI->db->order_by('stat_long_name');
       return $CI->db->select('*')->get('gtech_state_province')->result_array();
  }

  function get_country_list($id = '') {
       global $CI;
       $CI->db->order_by('ctr_country');
       return $CI->db->select('*')->get('gtech_country')->result_array();
  }

  function get_hashed_password($pass) {
       if ($pass) {
            return base64_encode(base64_encode(base64_encode($pass)));
       }
  }

  function check_login() {

       global $CI;
       $userdata = $CI->session->userdata('gtech_logged_user');

       if (isset($userdata) &&
               !empty($userdata)) {
            return true;
       } else {
            return false;
       }
  }

  function get_logged_user($key = '') {
       if (check_login()) {
            global $CI;
            $CI->load->model('user/user_model');
            $userdata = $CI->session->userdata('gtech_logged_user');
            $id = $userdata['id'];
            if (empty($key)) {
                 return $CI->user_model->getUser($id);
            } else {
                 $userdata = $CI->user_model->getUser($id);
                 return isset($userdata[$key]) ? $userdata[$key] : '';
            }
       } else {
            return null;
       }
  }

  /* Settings */

  function get_settings_by_key($key) {
       if ($key) {
            global $CI;
            $CI->load->model('common_model');
            $settings = $CI->common_model->getSettings($key);
            return isset($settings['set_value']) ? $settings['set_value'] : '';
       } else {
            return false;
       }
  }

  if (!function_exists('translate')) {

       function translate($text, $d = '') {
            $s = 'en';
            if ($d == '') {
                 $d = 'en';
            }
            if ($d != 'en') {
                 $lang_pair = urlencode($s . '|' . $d);
                 $q = rawurlencode($text);
                 // Google's API translator URL
                 $url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=" . $q . "&langpair=" . $lang_pair;
                 // Make sure to set CURLOPT_REFERER because Google doesn't like if you leave the referrer out
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_URL, $url);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_REFERER, "http://www.yoursite.com/translate.php");
                 $body = curl_exec($ch);
                 curl_close($ch);
                 $json = json_decode($body, true);
                 $tranlate = $json['responseData']['translatedText'];
                 echo $tranlate;
            } else {
                 echo $text;
            }
       }

  }

  if (!function_exists('get_url_string')) {

       function get_url_string($text) {
            $text = trim(strtolower($text));
            $text = str_replace(' ', '-', $text);
            $text = str_replace('/', '-', $text);
            $text = str_replace('---', '-', $text);
            $text = str_replace('--', '-', $text);
            return $text;
       }

  }

  if (!function_exists('get_filter_type')) {

       function get_filter_type($id = '') {
            global $CI;
            $CI->load->model('products/products_model');
            return $CI->products_model->getCategories();
       }

  }

  if (!function_exists('get_footer_categories')) {

       function get_footer_categories() {
            global $CI;
            $CI->load->model('products/products_model');
            return $CI->products_model->getFooterCategories();
       }

  }

  if (!function_exists('get_original_password')) {

       function get_original_password($hash) {
            if ($hash) {
                 return base64_decode(base64_decode(base64_decode($hash)));
            }
       }

  }
  /* Settings */
  
  /*Get snippet text*/
  function get_snippet($str, $wordCount = 10) {
       $str = strip_tags($str);
       return implode(
               '', array_slice(
                       preg_split(
                               '/([\s,\.;\?\!]+)/', $str, $wordCount * 2 + 1, PREG_SPLIT_DELIM_CAPTURE
                       ), 0, $wordCount * 2 - 1
               )
       );
  } 
?>