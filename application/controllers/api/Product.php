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
		),201);
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
			),403);
		}

		if(getallheaders()['apikey']!='kmzway87aa'){
			$this->response(array(
				'status' => false,
				'statusCode' => 403,
				'info' => "Error",
				'data' => "forbidden access"
			),403);
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
		),201);
	}

	# URL Request PHP-CI_RestApi/api/product/insertProduct
	# productName:Kunci
	# productPrice:20000
	public function insertProduct_post(){
		$name = $this->input->post('productName');
		$price = $this->input->post('productPrice');

		$errorMsg='';
		if(trim($name)=='' || $name==null){
			$errorMsg.=' Complete product name. ';
		}
		if(trim($price)=='' || $price==null){
			$errorMsg.=' Complete product price. ';
		}

		if($errorMsg!=''){
			$this->response(array(
				'status' => false,
				'statusCode' => 500,
				'info' => "Error",
				'data' => $errorMsg
			),201);
		}

		$checkName = $this->db->get_where('rest_product',array("product_name"=>$name))->num_rows();
		if($checkName>0){
			$this->response(array(
				'status' => false,
				'statusCode' => 500,
				'info' => "Error",
				'data' => 'Duplicate ProductName'
			),201);
		}

		$dataInsert = $this->addNewProduct($name,$price);
		if($dataInsert==true){
			$status=true;
			$statusCode=200;
			$info="Success";
		}
		else{
			$status=false;
			$statusCode=500;
			$info="Error";
		}

		$this->response(array(
			'status' => $status, 
			'statusCode' => $statusCode,
			'info' => $info
		),201);
	}

	# URL Request PHP-CI_RestApi/api/product/updateProduct
	# productId:1
	# productPrice:12500
	public function updateProduct_put(){
		$id = $this->put('productId');
		$price = $this->put('productPrice');

		$errorMsg='';
		if(trim($id)=='' || $id==null){
			$errorMsg.=' Complete product id. ';
		}
		if(trim($price)=='' || $price==null){
			$errorMsg.=' Complete product price. ';
		}

		if($errorMsg!=''){
			$this->response(array(
				'status' => false,
				'statusCode' => 500,
				'info' => "Error",
				'data' => $errorMsg
			),201);
		}

		$dataUpdate = $this->updateDataProduct($id,$price);
		if($dataUpdate==true){
			$status=true;
			$statusCode=200;
			$info="Success";
		}
		else{
			$status=false;
			$statusCode=500;
			$info="Error";
		}

		$this->response(array(
			'status' => $status, 
			'statusCode' => $statusCode,
			'info' => $info
		),201);

	}

#	x-www-form-urlencoded
# 	productId:6
	public function delProduct_delete(){
		$id = $this->delete('productId');

		$this->db->where('id_product', $id);
		$this->db->delete('rest_product'); 

		if($this->db->affected_rows() >=0){
		  	$status=true;
			$statusCode=200;
			$info="Success";
		}else{
		  	$status=false;
			$statusCode=500;
			$info="Error";
		}

		$this->response(array(
			'status' => $status, 
			'statusCode' => $statusCode,
			'info' => $info
		),201);
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

	private function addNewProduct($name,$price){
		$dataProduct = array(
			 'product_name' => $name,
			 'price' => $price,
			 'create_date' => time()
		);
		$this->db->insert("rest_product",$dataProduct);
		$save_point = $this->db->insert_id();

		if($save_point>0){
			return true;
		}
		else{
			return false;
		}
	}

	private function updateDataProduct($id,$price){
		$data = array(
			 'price' => $price
		);
		$this->db->where('id_product', $id);
		$this->db->update('rest_product', $data);

		if($this->db->affected_rows() >=0){
		  	return true;
		}else{
		  	return false;
		}
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
