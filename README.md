# PHP-CI_RestApi


-- SQL Patch
DROP TABLE IF EXISTS `rest_product`;
CREATE TABLE `rest_product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `create_date` decimal(15,0) NOT NULL,
  `update_date` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rest_product` (`id_product`, `product_name`, `price`, `create_date`, `update_date`) VALUES
(1,	'Buku',	10000.00,	1538721311,	0),
(2,	'Pensil',	5000.00,	1538721311,	0);



 ====================================================================================================================


-- Sample GET
 # URL Request  YourLocation/PHP-CI_RestApi/api/product/dataProduct?id=1
 
-- Sample GET with Headers
 # URL Request YourLocation/PHP-CI_RestApi/api/product/dataProductWithHeaders?id=1
 # Headers apikey:kmzway87aa


-- Sample POST
 # URL Request PHP-CI_RestApi/api/product/insertProduct
 # productName:Kunci
 # productPrice:20000

-- Sample PUT 
	#	x-www-form-urlencoded
 # URL Request PHP-CI_RestApi/api/product/updateProduct
 # productId:1
 # productPrice:12500

 -- Sample DELETE
	#	x-www-form-urlencoded
 # URL Request PHP-CI_RestApi/api/product/delProduct_delete
 # productId:6