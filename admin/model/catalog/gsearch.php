<?php

class ModelCatalogGsearch extends model{

				public function create_history(){
				
								$this->db->query("CREATE TABLE IF NOT EXISTS gsearch_history(id int (255) NOT NULL AUTO_INCREMENT , keyword varchar (255), product_id varchar (255), records integer (255),customer_id int (255),search_time TIMESTAMP,ip varchar (255),PRIMARY KEY(id))");
								}

				public function get_history($data){
				
								//$result=$this->db->query("select * from gsearch_history");
								
							// $sql = "SELECT * from gsearch_history ";
					$sql="SELECT CONCAT(gc.firstname ,' ', gc.lastname) as customer_name ,gh.* from gsearch_history gh ";
								$sql.="LEFT join " . DB_PREFIX . "customer gc on (gh.customer_id = gc.customer_id )";
								if (isset($data['start']) || isset($data['limit'])) {
										if ($data['start'] < 0) {
											$data['start'] = 0;
										}				
										if ($data['limit'] < 1) {
											$data['limit'] = 20;
										}	
										$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
									}
								/* 	echo $data['start'];
									echo '<br>';
 */									$result = $this->db->query($sql);
/* 									echo $sql;
									echo '<br>';
									print_r($result);
 */										
								 return $result->rows;
								}

								public function total_search(){
								
								 $total_search=$this->db->query("select count(*) from gsearch_history");
							 //print_r($total_search->row);
						 
								
								
								 return $total_search->row;
								
				}
				
				public function delete_history($delete_id){
				
				$this->db->query("delete from gsearch_history where id=".$delete_id);
				}
				
				public function gs_keyword_chart(){
				
				$res=$this->db->query("SELECT keyword, count(*) as num_search FROM gsearch_history group by keyword order by num_search desc limit 5");
				
				return $res->rows;
				}
				
				public function gs_product_chart(){
				
				
				$res1=$this->db->query("SELECT pd.name as product ,count(pd.name) as num
										FROM gsearch_history gh
										INNER JOIN ".DB_PREFIX."product_description pd ON ( gh.product_id = pd.product_id ) group by pd.name order by num desc limit 5");
				return $res1->rows;
				}
				
				public function gs_moreKeyword_chart(){
				
				$res2=$this->db->query("SELECT keyword, count(*) as num_search FROM gsearch_history group by keyword order by num_search desc ");
				
				return $res2->rows;
				}
				public function gs_moreProduct_chart(){
				
				$res1=$this->db->query("SELECT pd.name as product_name ,count(pd.name) as num
										FROM gsearch_history gh
										INNER JOIN ".DB_PREFIX."product_description pd ON ( gh.product_id = pd.product_id ) group by pd.name order by num desc");
				return $res1->rows;
				}
				
				}
?>