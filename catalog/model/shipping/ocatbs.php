<?php 
      //===========================================//
     // Total-Based Shipping                      //
    // Author: Joel Reeds                        //
   // Company: OpenCart Addons                  //
  // Website: http://opencartaddons.com        //
 // Contact: webmaster@opencartaddons.com     //
//===========================================//

class ModelShippingOCATBS extends Model {  
	private $extension = 'ocatbs';
	private $extensionType = 'shipping';
	
	private function getVersion() {
		if (defined('VERSION') && VERSION < 1.5) {
			$oc = 140;
		} elseif (defined('VERSION') && strpos(VERSION, '1.5.0') === 0) {
			$oc = 150;
		} elseif (defined('VERSION') && strpos(VERSION, '1.5.1') === 0) {
			$oc = 151;
		} else {
			$oc = '';
		}
		if (defined('VERSION') && VERSION >= 1.5 && !$oc) {
			$oc = 152;
		}
		return $oc;
	}

  	public function getQuote($address) {
	
		if ($this->getField('status') && $this->getField('rate')) {
			
			$quote_data = array();
			$method_data = array();
			
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = 0;
			}
			
			$language_id = isset($this->session->data['language']) ? $this->session->data['language'] : $this->config->get('config_language');
			
			$rates = $this->getField('rate');
			
			$quote_data = array();
			
			$sum_data = array();
			$avg_data = array();
			$low_data = array();
			$high_data = array();
			
			$rate_row = 1;
			
			foreach ($rates as $rate) {
			
				if ($rate['status']) {
				
					$status = true;
					
					if ($this->config->get('config_weight_class_id')) {
						$length_class = 'length_class_id';
						$weight_class = 'weight_class_id';
					} else {
						$length_class = 'length_class';
						$weight_class = 'weight_class';
					}
			
					$total = $this->getTotal();
					$quantity = $this->getQuantity();
					$weight = $this->getWeight();
					$volume = $this->getVolume($rate['length_add'], $rate['width_add'], $rate['height_add']);
					
					$categories = isset($rate['categories']) ? $rate['categories'] : array();
					
					if ($rate['cost_setting'] == 1 && !in_array(0, $categories)) {
						$exclude_categories = $categories;
					} else {
						$exclude_categories = false;
					}
					
					if ($exclude_categories) {
						$exclude_products_info = $this->excludeProduct($exclude_categories);
						$total -= $exclude_products_info['total'];
						$quantity -= $exclude_products_info['quantity'];
						$weight -= $exclude_products_info['weight'];
						$volume -= $exclude_products_info['volume'];
					}
			
					$rate_types = array('quantity', 'total', 'weight', 'volume');
					
					foreach ($rate_types as $rate_type) {
						if ($rate[$rate_type . '_add']) {
							if (strpos($rate[$rate_type . '_add'], '%')) {
								${$rate_type} += ${$rate_type} * ($rate[$rate_type . '_add'] / 100);
							} else {
								${$rate_type} += $rate[$rate_type . '_add'];
							}
						}
					}
					
					foreach ($rate_types as $rate_type) {
						if ($rate[$rate_type . '_min']) {
							if (${$rate_type} < $rate[$rate_type . '_min']) {
								$status = false;
								break;
							}
						}
						
						if ($rate[$rate_type . '_max']) {
							if (${$rate_type} > $rate[$rate_type . '_max']) {
								$status = false;
								break;
							}
						}
					}
					
					if (!$rate['rates']) {
						$status = false;
					}
					
					$stores = isset($rate['stores']) ? $rate['stores'] : array();
					$customer_groups = isset($rate['customer_groups']) ? $rate['customer_groups'] : array();
					
					if (!in_array((int)$this->config->get('config_store_id'), $stores)) {
						$status = false;
					}
					
					if (!in_array((int)$customer_group_id, $customer_groups)) {
						$status = false;
					}
					
					if ($status) {
						foreach ($this->cart->getProducts() as $product) {
							if ($product['shipping']) {	
							
								$dim_types = array('length', 'width', 'height');
					
								foreach ($dim_types as $dim_type) {
									if ($rate[$dim_type . '_add']) {
										if (strpos($rate[$dim_type . '_add'], '%')) {
											${$dim_type} = $this->length->convert($product[$dim_type], $product[$length_class], $this->config->get('config_' . $length_class)) * ($rate[$dim_type . '_add'] / 100);
										} else {
											${$dim_type} = $this->length->convert($product[$dim_type], $product[$length_class], $this->config->get('config_' . $length_class)) + $rate[$dim_type . '_add'];
										}
									} else {
										${$dim_type} = $this->length->convert($product[$dim_type], $product[$length_class], $this->config->get('config_' . $length_class));
									}
								}
								
								foreach ($dim_types as $dim_type) {
									if ($rate[$dim_type . '_min']) {
										if (${$dim_type} < $rate[$dim_type . '_min']) {
											$status = false;
											break;
										}
									}
									
									if ($rate[$dim_type . '_max']) {
										if (${$dim_type} > $rate[$dim_type . '_max']) {
											$status = false;	
											break;
										}
									}
								}
							}
						}
					}
					
					if ($categories && $status && !in_array(0, $categories)) {
						$this->load->model('catalog/product');
						
						foreach ($this->cart->getProducts() as $product) {
							$product_categories = $this->model_catalog_product->getCategories($product['product_id']);
							$cat_status = false;
							if ($product_categories) {
								foreach ($product_categories as $product_category) {
									if (in_array($product_category['category_id'], $categories)) {
										$cat_status = true;
										break;
									}
								}
								if ($cat_status) {
									if ($rate['category_setting'] == 1) {
										break;
									} elseif ($rate['category_setting'] == 2) {
										$status = false;
										break;
									}
								} else {
									if ($rate['category_setting'] == 0) {
										$status = false;
										break;
									}
								}
							}
						}
						if (!$cat_status && $rate['category_setting'] == 1) {
							$status = false;
						}
					} elseif (in_array(0, $categories) && $rate['category_setting'] == 2) {
						$status = false;
					}
					
					if ($rate['postal_codes'] && $status) {
						$postcode_status = false;
						$postcode_ranges = explode(',', $rate['postal_codes']);
						
						$customer_postcode = preg_replace('/\s/', '',strtoupper($address['postcode']));
						
						foreach ($postcode_ranges as $postcode_range) {
							$postcode_range_data = explode(':', $postcode_range);
							if (isset($postcode_range_data[0]) && isset($postcode_range_data[1])) {
								$postcode_start = trim(strtoupper($postcode_range_data[0]), ' ');
								$postcode_end = trim(strtoupper($postcode_range_data[1]), ' ');
								if (strlen($postcode_start) > strlen($postcode_end)) {
									$x = strlen($postcode_start);
								} else {
									$x = strlen($postcode_end);
								}
								
								if ($rate['postal_code_type'] == 'UK') {
									if ($x < 2) {
										$postcode = substr($customer_postcode, 0, 1);
									} elseif ($x == 2) {
										$postcode = substr($customer_postcode, 0, 2);
									} else {
										$postcode = (strlen($customer_postcode) > 6) ? substr($customer_postcode, 0, 4) : substr($customer_postcode, 0, 3);
									}
								} else {
									$postcode = substr($customer_postcode, 0, $x);
								}
								
								if ($this->validatePostCode($postcode_start, $postcode, $x)) {
									if (strnatcmp($postcode_start, $postcode) <= 0 && strnatcmp($postcode_end, $postcode) >= 0) {
										$postcode_status = true;
										break;
									}
								}
							}
						}
						if (!$postcode_status) {
							$status = false;
						}
					}
					
					if ($status) {					
						$geo_zones = isset($rate['geo_zones']) ? $rate['geo_zones'] : array();
						
						$zone_status = false;
						$zone_found = false;
						
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
						foreach ($query->rows as $result) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
							if ($query->num_rows) {
								$zone_found = true;
								if (in_array($result['geo_zone_id'], $geo_zones)) {
									$zone_status = true;
									break;
								}
							}
						}
						
						if (!$zone_found) {
							if (!in_array(0, $geo_zones)) {
								$status = false;
							}
						} elseif (!$zone_status) {
							$status = false;
						}
					}
					
					if ($status) {
					
						$this->load->language($this->extensionType . '/' . $this->extension);
				
						$cost = '';
						
						$value = $total;
						
						if ($rate['final_cost'] == 0) {
							$cost = $this->getRateSingle($rate['rates'], $value, $total);
						} else if ($rate['final_cost'] == 1) {
							$cost = $this->getRateCumulative($rate['rates'], $value, $total);
						} else {
							$cost = $this->getRateSingle($rate['rates'], $value, $total);
						}
						
						if ((string)$cost != '') { 
						
							if ($rate['cost_min']) {
								if ($cost < $rate['cost_min']) {
									$cost = $rate['cost_min'];
								}
							}
							
							if ($rate['cost_max']) {
								if ($cost > $rate['cost_max']) {
									$cost = $rate['cost_max'];
								}
							}
							
							if ($rate['cost_add']) {
								if (strpos($rate['cost_add'], '%')) {
									$cost += $cost * ($rate['cost_add'] / 100);
								} else {
									$cost += $rate['cost_add'];
								}
							}
							
							if ($rate['freight_fee']) {
								if (strpos($rate['freight_fee'], '%')) {
									$cost += $cost * ($rate['freight_fee'] / 100);
								} else {
									$cost += $rate['freight_fee'];
								}
							}
							
							$name = !empty($rate['name'][$language_id]) ? $rate['name'][$language_id] : $this->language->get('text_name');
							
							if ($this->getField('display_weight')) {
								if ($rate['rate_type'] == 2 || $rate['rate_type'] == 4) {
									$name = $name . ' (' . $this->weight->format($weight, $this->config->get('config_' . $weight_class)) . ')';
								}
							}
							
							$key = $rate['sort_order'];
							
							if ($rate['multirate'] == 0) {
								$quote_data[$this->extension . '_' . $rate_row] = $this->getQuoteData($rate_row, $name, $cost, $rate['tax_class_id'], $rate['sort_order']);
							} else if ($rate['multirate'] == 1) {
								if (isset($sum_data[$key])) {
									$sum_data[$key]['title'] = $name;
									$sum_data[$key]['tax_class_id'] = $rate['tax_class_id'];
									$sum_data[$key]['cost'] += $cost;
								} else {
									$sum_data[$key] = array(
										'title' 		=> $name,
										'sort_order' 	=> $key,
										'tax_class_id' 	=> $rate['tax_class_id'],
										'cost'			=> $cost
									);
								}
							} else if ($rate['multirate'] == 2) {
								if (isset($avg_data[$key])) {
									$avg_data[$key]['title'] = $name;
									$avg_data[$key]['tax_class_id'] = $rate['tax_class_id'];
									$avg_data[$key]['count']++;
								} else {
									$avg_data[$key] = array(
										'title' 		=> $name,
										'sort_order' 	=> $key,
										'tax_class_id' 	=> $rate['tax_class_id'],
										'cost'			=> $cost,
										'count'			=> 1
									);
								}
							} else if ($rate['multirate'] == 3) {
								if (isset($low_data[$key])) {
									if ($low_data[$key]['cost'] > $cost) {
										$low_data[$key]['title'] = $name;
										$low_data[$key]['tax_class_id'] = $rate['tax_class_id'];
										$low_data[$key]['cost'] = $cost;
									}
								} else {
									$low_data[$key] = array(
										'title' 		=> $name,
										'sort_order' 	=> $key,
										'tax_class_id' 	=> $rate['tax_class_id'],
										'cost'			=> $cost
									);
								}
							} else if ($rate['multirate'] == 4) {
							if (isset($high_data[$key])) {
									if ($high_data[$key]['cost'] < $cost) {
										$high_data[$key]['title'] = $name;
										$high_data[$key]['tax_class_id'] = $rate['tax_class_id'];
										$high_data[$key]['cost'] = $cost;
									}
								} else {
									$high_data[$key] = array(
										'title' 		=> $name,
										'sort_order' 	=> $key,
										'tax_class_id' 	=> $rate['tax_class_id'],
										'cost'			=> $cost
									);
								}
							} else {
								$quote_data[$this->extension . '_' . $rate_row] = $this->getQuoteData($rate_row, $name, $cost, $rate['tax_class_id'], $rate['sort_order']);
							}
						}
					}
				}
				$rate_row++;
			}
			
			if (!empty($sum_data)) {
				foreach ($sum_data as $key => $value) {
					$quote_data[$this->extension . '_sum' . $key] = $this->getQuoteData('sum' . $key, $value['title'], $value['cost'], $value['tax_class_id'], $key);
				}
			}
			
			if (!empty($avg_data)) {
				foreach ($avg_data as $key => $value) {
					$avg_cost = $value['cost'] / $value['count'];
					$quote_data[$this->extension . '_avg' . $key] = $this->getQuoteData('avg' . $key, $value['title'], $avg_cost, $value['tax_class_id'], $key);
				}
			}
			
			if (!empty($low_data)) {
				foreach ($low_data as $key => $value) {
					$quote_data[$this->extension . '_low' . $key] = $this->getQuoteData('low' . $key, $value['title'], $value['cost'], $value['tax_class_id'], $key);
				}
			}
			
			if (!empty($high_data)) {
				foreach ($high_data as $key => $value) {
					$quote_data[$this->extension . '_high' . $key] = $this->getQuoteData('high' . $key, $value['title'], $value['cost'], $value['tax_class_id'], $key);
				}
			}
			
			$title = $this->getField('title');
			$title = !empty($title[$language_id]) ? $title[$language_id] : $this->language->get('text_title');
						
			if ($quote_data) {
			
				foreach ($quote_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
					$sort_cost[$key] = $value['cost'];
				}
			
				if ($this->getField('sort_quotes') == 0) {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				} else if ($this->getField('sort_quotes') == 1) {
					array_multisort($sort_cost, SORT_ASC, $quote_data);
				} else {
					array_multisort($sort_order, SORT_ASC, $quote_data);
				}
				
				if ($this->getVersion() >= 150) {
					$method_data = array(
						'code'       => $this->extension,
						'title'      => $title,
						'quote'      => $quote_data,
						'sort_order' => $this->getField('sort_order'),
						'error'      => false
					);
				} else {
					$method_data = array(
						'id'         => $this->extension,
						'title'      => $title,
						'quote'      => $quote_data,
						'sort_order' => $this->getField('sort_order'),
						'error'      => false
					);
				}
			}

			return $method_data;
		}
	}
	
	private function getQuantity() {
		$quantity = 0;
	
    	foreach ($this->cart->getProducts() as $product) {
			if ($product['shipping']) {
				$quantity += $product['quantity'];
			}
		}
	
		return $quantity;
	}
	
	private function getTotal () {
		$total_data = array();					
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		if ($this->getVersion() >= 150) {
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$this->load->model('setting/extension');
				
				$sort_order = array(); 
				
				$results = $this->model_setting_extension->getExtensions('total');
				
				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}
				
				array_multisort($sort_order, SORT_ASC, $results);
				
				foreach ($results as $result) {
					if ($result['code'] == 'shipping') {
						break;
					} else {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}
				}
			}
		} else {
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('checkout/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_checkout_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($result['key'] == 'shipping') {
					break;
				} else {
					$this->load->model('total/' . $result['key']);

					$this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
				}
			}
		}
		
		return $total;
	}
	
	private function getVolume($length_add, $width_add, $height_add) {
		$volume = 0;
		
		if ($this->config->get('config_weight_class_id')) {
			$length_class = 'length_class_id';
			$weight_class = 'weight_class_id';
		} else {
			$length_class = 'length_class';
			$weight_class = 'weight_class';
		}
	
    	foreach ($this->cart->getProducts() as $product) {
			if ($product['shipping']) {
      			$length = $this->length->convert($product['length'], $product[$length_class], $this->config->get('config_' . $length_class));
				$width = $this->length->convert($product['width'], $product[$length_class], $this->config->get('config_' . $length_class));
				$height = $this->length->convert($product['height'], $product[$length_class], $this->config->get('config_' . $length_class));
				
				if ($length_add) {
					if (strpos($length_add, '%')) {
						$length += $length * ($length_add / 100);
					} else {
						$length += $length_add;
					}
				}
				if ($width_add) {
					if (strpos($width_add, '%')) {
						$width += $width * ($width_add / 100);
					} else {
						$width += $width_add;
					}
				}
				if ($height_add) {
					if (strpos($height_add, '%')) {
						$height += $height * ($height_add / 100);
					} else {
						$height += $height_add;
					}
				}
				
				$volume += ($length * $width * $height) * $product['quantity'];
			}
		}
	
		return $volume;
	}
	
	private function getWeight() {
		$weight = 0;
		
		if ($this->config->get('config_weight_class_id')) {
			$weight_class = 'weight_class_id';
		} else {
			$weight_class = 'weight_class';
		}
	
    	foreach ($this->cart->getProducts() as $product) {
			if ($product['shipping']) {
				if ($this->getVersion() >= 150) {
					$weight += $this->weight->convert($product['weight'], $product[$weight_class], $this->config->get('config_' . $weight_class));
				} else {
					$weight += $this->weight->convert($product['weight'], $product[$weight_class], $this->config->get('config_' . $weight_class)) * $product['quantity'];
				}
			}
		}
	
		return $weight;
	}
	
	private function excludeProduct($exclude_categories) {
		
		$total = 0;	
		$quantity = 0;
		$weight = 0;
		$volume = 0;
		
		if ($this->config->get('config_weight_class_id')) {
			$length_class = 'length_class_id';
			$weight_class = 'weight_class_id';
		} else {
			$length_class = 'length_class';
			$weight_class = 'weight_class';
		}
		
		$this->load->model('catalog/product');
		
		foreach ($this->cart->getProducts() as $product) {
			if ($product['shipping']) {
				$product_info = $this->model_catalog_product->getProduct($product['product_id']);				
				$exclude_product = false;
				
				if ($exclude_categories) {
					$product_categories = $this->model_catalog_product->getCategories($product['product_id']);
					$cat_status = false;
					if ($product_categories) {
						foreach ($product_categories as $product_category) {
							if (in_array($product_category['category_id'], $exclude_categories)) {
								$cat_status = true;
								break;
							}
						}
					} 
					if (!$cat_status) {
						$exclude_product = true;
					}
				}
				if ($exclude_product) {
					$prod_length = $this->length->convert($product['length'], $product[$length_class], $this->config->get('config_' . $length_class));
					$prod_width = $this->length->convert($product['width'], $product[$length_class], $this->config->get('config_' . $length_class));
					$prod_height = $this->length->convert($product['height'], $product[$length_class], $this->config->get('config_' . $length_class));
					if ($this->getVersion() >= 150) {
						$prod_weight = $this->weight->convert($product['weight'], $product[$weight_class], $this->config->get('config_' . $weight_class));
					} else {
						$prod_weight = ($this->weight->convert($product['weight'], $product[$weight_class], $this->config->get('config_' . $weight_class))) * $product['quantity'];
					}
					$prod_volume = $prod_length * $prod_width * $prod_height;
					
					$total += $product['total'];
					$quantity += $product['quantity'];
					$weight += $prod_weight;
					$volume += $prod_volume;
				}
			}
		}
		return array(
			'total'		=> $total,
			'quantity'	=> $quantity,
			'weight'	=> $weight,
			'volume'	=> $volume
		);
	}
	
	private function getRateSingle($rates, $value, $total) {
		
		$cost = '';
		$rates = explode(',', $rates);
	
		foreach ($rates as $rate) {
			$data = explode(':', $rate);
			
			if (isset($data[0]) && $data[0] >= $value) {
				if (isset($data[1])) {
					if (strpos($data[1], '/')) {
						$per = explode('/', $data[1]);
						if (isset($per[0]) && isset($per[1]) && $per[1] > 0) {
							if (strpos($per[0], '%')) {
								$cost = ceil($value / $per[1]) * ($total * ($per[0] / 100));
							} else {
								$cost = ceil($value / $per[1]) * $per[0];
							}
						}
						break;
					} else {
						if(strpos($data[1], '%')) {
							$cost = ($total * ($data[1] / 100));
						} else {
							$cost = $data[1];
						}
					}
				}
				break;
			}
		}
		return $cost;
	}
			
	private function getRateCumulative($rates, $value, $total) {
		
		$cost = '';
		$rates = explode(',', $rates);
		$prev = 0;
	
		foreach ($rates as $rate) {
			$data = explode(':', $rate);
			
			if (isset($data[0]) && $data[0] < $value) {
				if (isset($data[1])) {
					if (strpos($data[1], '/')) {
						$per = explode('/', $data[1]);
						if (isset($per[0]) && isset($per[1]) && $per[1] > 0) {
							if (strpos($per[0], '%')) {
								$cost += ceil(($data[0]-$prev) / $per[1]) * ($total * ($per[0] / 100));
							} else {
								$cost += ceil(($data[0]-$prev) / $per[1]) * $per[0];
							}
						}
					} else {
						if (strpos($data[1], '%')) {
							$cost += ($total * ($data[1] / 100));
						} else {
							$cost += $data[1];
						}
					}
				}
				
				$prev = $data[0];

			} elseif (isset($data[0]) && $data[0] >= $value) {
				if (isset($data[1])) {
					if (strpos($data[1], '/')) {
						$per = explode('/', $data[1]);
						if (isset($per[0]) && isset($per[1]) && $per[1] > 0) {
							if (strpos($per[0], '%')) {
								$cost += ceil(($value-$prev) / $per[1]) * ($total * ($per[0] / 100));
							} else {
								$cost += ceil(($value-$prev) / $per[1]) * $per[0];
							}
						}
					} else {
						if (strpos($data[1], '%')) {
							$cost += ($total * ($data[1] / 100));
						} else {
							$cost += $data[1];
						}
					}
				}
				
				break;
			}
		}
		return $cost;
	}
	
	private function getQuoteData ($code, $name, $cost, $tax_class_id, $sort_order) {
		if ($this->getVersion() >= 150) {
			return array(
				'code'         => $this->extension . '.' . $this->extension . '_' . $code,
				'title'        => $name,
				'cost'         => $cost,
				'tax_class_id' => $tax_class_id,
				'text'         => $this->currency->format($this->tax->calculate($cost, $tax_class_id, $this->config->get('config_tax'))),
				'sort_order'   => $sort_order
			);
		} else {
			return array(
				'id'           => $this->extension . '.' . $this->extension . '_' . $code,
				'title'        => $name,
				'cost'         => $cost,
				'tax_class_id' => $tax_class_id,
				'text'         => $this->currency->format($this->tax->calculate($cost, $tax_class_id, $this->config->get('config_tax'))),
				'sort_order'   => $sort_order
			);
		}
	}
	
	private function getField($field) {
		$key = $this->config->get($this->extension . '_' . $field);
		if (is_string($key) && strpos($key, 'a:') === 0) {
			$value = unserialize($key);
		} else {
			$value = $key;
		}
		
		return $value;
	}	
	
	private function validatePostCode($postcode_start = 0, $customer_postcode = 0, $x = 0) {
		$postcode_start = str_split($postcode_start);
		$customer_postcode = str_split($customer_postcode);
		$i = 0;
		
		$status = false;
		
		if ($postcode_start && $customer_postcode && $x) {
		
			while ($i <= ($x - 1)) {
				$postcode_start = isset($postcode_start[$i]) ? $postcode_start[$i] : 0;
				$customer_postcode = isset($customer_postcode[$i]) ? $customer_postcode[$i] : 0;
				
				if (is_numeric($postcode_start) && is_numeric($customer_postcode)) {
					$status = true;
				} elseif (!is_numeric($postcode_start) && !is_numeric($customer_postcode)) {
					$status = true;
				} else {
					$status = false;
					break;
				}
				$i ++;
			}
			
		}
		return $status;
	}	
}
?>