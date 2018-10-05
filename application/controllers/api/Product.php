<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Valid.php';

class Product extends REST_Controller {

	# URL Request PHP-CI_RestApi/api/product/dataProduct?id=1
	public function dataProduct_get(){
		$id = $this->input->get('id') ;
		if($id==null){
			$dataSearch = $this->getProductAll();
		}
		else{
			$dataSearch = $this->getProductRow($id);
		}

		$this->response(array(
			'status' => true,
			'statusCode' => (count($dataSearch)<1) ? 404 : 200,
			'info' => "Success",
			'data' => $dataSearch
		));
	}

	# URL Request PHP-CI_RestApi/api/product/dataProductWithHeaders?id=1
	# Headers apikey:kmzway87aa
	public function dataProductWithHeaders_get(){
		if(!isset(getallheaders()['apikey'])){
			$this->response(array(
				'status' => false,
				'statusCode' => 403,
				'info' => "Error",
				'data' => "forbidden access"
			));
		}

		if(getallheaders()['apikey']!='kmzway87aa'){
			$this->response(array(
				'status' => false,
				'statusCode' => 403,
				'info' => "Error",
				'data' => "forbidden access"
			));
		}
		
		$id = $this->input->get('id') ;
		if($id==null){
			$dataSearch = $this->getProductAll();
		}
		else{
			$dataSearch = $this->getProductRow($id);
		}

		$this->response(array(
			'status' => true,
			'statusCode' => (count($dataSearch)<1) ? 404 : 200,
			'info' => "Success",
			'data' => $dataSearch
		));
	}


	private function getProductAll(){
		$sql = " 
			SELECT *
			FROM rest_product
		";
    	$dataSearch = $this->db->query($sql)->result_array();
		$dataSearch = $this->newIndexingArray($dataSearch,'id_product');

		return $dataSearch;
	}

	private function getProductRow($id){
		$sql = " 
			SELECT *
			FROM rest_product
			WHERE id_product = ?
        ";
    	$dataSearch = $this->db->query($sql,array($id))->row_array();

		return $dataSearch;
	}

	private function newIndexingArray($array,$newIndex){
		$newArray=array(); $i=0;
		foreach ($array as $key => $value) {
			$newArray[$value[$newIndex]]=$value;
			$i++;
		}
		return $newArray;
	}
}
