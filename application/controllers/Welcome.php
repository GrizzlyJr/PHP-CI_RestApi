<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	#GET__REQUEST
	public function getProduct(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => TRUE,
		    CURLOPT_SSL_VERIFYPEER, false,
		    CURLOPT_URL => '127.0.0.1/PHP-CI_RestApi/api/product/dataProduct'
		));
		$resp = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
	
		var_dump($resp);
		var_dump($httpcode);
	}

	#GET__REQUEST
	public function getProductWithHeaders(){
		$headers = array(
			'apikey:kmzway87aa',
		);

		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => TRUE,
		    CURLOPT_SSL_VERIFYPEER, false,
			CURLOPT_HTTPHEADER => $headers,
		    CURLOPT_URL => '127.0.0.1/PHP-CI_RestApi/api/product/dataProductWithHeaders'
		));
		$resp = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
	
		var_dump($resp);
		var_dump($httpcode);
	}

	#POST__REQUEST
	public function addProduct(){
		// $auth = array(
		// 	'username' => 'doni',
		// 	'password' => 'doni123',
		// ) ;

		$url = 'http://127.0.0.1/PHP-CI_RestApi/api/product/insertProduct';

		$data_input = array(
			'productName'=>'newP',
			'productPrice'=>'20000'
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_input));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($curl, CURLOPT_USERPWD, $auth['username'].":".$auth['password']);
		$resp = curl_exec ($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close ($curl);

		var_dump($resp);
		var_dump($httpcode);
	}


	#PUT__REQUEST
	public function updateProduct(){
		$url = 'http://127.0.0.1/PHP-CI_RestApi/api/product/updateProduct';
		
		$data = array(
			'productId'=>'1',
			'productPrice'=>'21500'
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
  		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  		// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  		// curl_setopt($curl, CURLOPT_HEADER, TRUE);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);     
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		var_dump($result);
		var_dump($httpcode);
	}


	#DELETE__REQUEST
	public function deleteProduct(){
		$url = 'http://127.0.0.1/PHP-CI_RestApi/api/product/delProduct';
		
		$data = array(
			'productId'=>'6'
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
  		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  		// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  		// curl_setopt($curl, CURLOPT_HEADER, TRUE);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);     
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		var_dump($result);
		var_dump($httpcode);
	}

}