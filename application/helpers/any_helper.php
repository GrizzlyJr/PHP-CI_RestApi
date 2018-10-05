<?php 


	function strip_replacer($string)
	{
		$string = $string ;
		return preg_replace('/\s+/', '-', $string) ;
	}

	function isWeekend($date) {
		return (date('N', $date) >= 5);
	}

	function current_url2()
	{
	    $CI =& get_instance();

	    $url = $CI->config->site_url($CI->uri->uri_string());
	    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}

	function login_check_admin($index='all') {

		if (!isset($_SESSION['sign_in_admin_session_id_user'])) {
			header('location: '.base_url('admin/login')) ;
		} else {
			$CI =& get_instance();
			$CI->db->where('id_user_admin', $_SESSION['sign_in_admin_session_id_user']);
			$db_user_admin = $CI->db->get('user_admin');
			if ($index == 'all') {
				return $db_user_admin->row();
			} else {
				return $db_user_admin->row()->$index ;
			}
			
		}
		
	}


	function login_check_agen($index='all') {
		if (!isset($_SESSION['sign_in_agen_session_id_user'])) {
			header('location: '.base_url('agen/login')) ;
		} else {
			$CI =& get_instance();
			$CI->db->where('id_user_admin', $_SESSION['sign_in_agen_session_id_user']);
			$db_user_admin = $CI->db->get('user_admin');
			if ($index == 'all') {
				return $db_user_admin->row();
			} else {
				return $db_user_admin->row()->$index ;
			}	
		}
	}

	function time_lapse($create_date, $pickup_time)
	{
		$diff = $pickup_time-$create_date ;
		$return_data = array() ;

		if ($diff < 86400) { # < 7 jam
			$return_data['code'] = 'U1' ;
			$return_data['label'] = '< 24 Jam' ;
		}else
		if ($diff < 172800){ # < 24 jam
			$return_data['code'] = 'U2' ;
			$return_data['label'] = '< 48 Jam' ;
		}else
		if ($diff < 604800){ # < 7 hari
			$return_data['code'] = 'I' ;
			$return_data['label'] = '< 7 Hari' ;
		}else{ # > 7 hari
			$return_data['code'] = 'P' ;
			$return_data['label'] = '> 7 Hari' ;
		}

		return $return_data ;

	}