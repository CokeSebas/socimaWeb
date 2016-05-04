<?php
class ControllerProductCategory extends Controller {  
public function AJAXGetMasonryProducts(){
	    $this->language->load('product/category');
	    $this->load->model('catalog/category');
	    $this->load->model('catalog/product');
	    $this->load->model('tool/image');
	    
	    if (isset($this->request->get['filter'])) {
		$filter = $this->request->get['filter'];
	    } else {
		$filter = '';
	    }

	    if (isset($this->request->get['sort'])) {
		$sort = $this->request->get['sort'];
	    } else {
		$sort = 'p.sort_order';
	    }

	    if (isset($this->request->get['order'])) {
		$order = $this->request->get['order'];
	    } else {
		$order = 'ASC';
	    }

	    if (isset($this->request->get['p'])) {
		$page = $this->request->get['p'] + 1;
	    } else { 
		$page = 1;
	    }
	    
	    if (isset($this->request->get['limit'])) {
		$limit = $this->request->get['limit'];
	    } else { 
		$limit = $this->config->get('config_catalog_limit');
	    }
	    
	    $this->data['button_cart'] = $this->language->get('button_cart');
	    $this->data['button_wishlist'] = $this->language->get('button_wishlist');
	    $this->data['button_compare'] = $this->language->get('button_compare');
	    $this->data['text_tax'] = $this->language->get('text_tax');
	    
	    if($this->config->get('masonry_category_theme') == 1) {
		$this->data['masonry_category_sort_option'] = ($this->config->get('masonry_category_sort_option') == 1) ? true : false;
		$this->data['masonry_category_limit_option'] = ($this->config->get('masonry_category_limit_option') == 1) ? true : false;
		$this->data['masonry_category_price_option'] = ($this->config->get('masonry_category_price_option') == 1) ? true : false;
		$this->data['masonry_category_add_wishlist'] = ($this->config->get('masonry_category_add_wishlist') == 1) ? true : false;
		$this->data['masonry_category_add_compare'] = ($this->config->get('masonry_category_add_compare') == 1) ? true : false;
	    }
	    
	    $this->data['products'] = array();

	    $data = array(
		    'filter_category_id' => $this->request->get['category_id'],
		    'filter_filter'      => $filter, 
		    'sort'               => $sort,
		    'order'              => $order,
		    'start'              => $page - 1,
		    'limit'              => $limit
	    );
	    
	    $results = $this->model_catalog_product->getProducts($data);
	    
	    foreach ($results as $result) {
		if ($result['image']) {
			$image = $this->model_tool_image->onesize($result['image'], $this->config->get('masonry_category_size_width'));
		} else {
			$image = $this->model_tool_image->onesize('no_image.jpg', $this->config->get('masonry_category_size_width'));
		}

		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
		} else {
			$price = false;
		}

		if ((float)$result['special']) {
			$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
		} else {
			$special = false;
		}	

		if ($this->config->get('config_tax')) {
			$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
		} else {
			$tax = false;
		}				

		if ($this->config->get('config_review_status')) {
			$rating = (int)$result['rating'];
		} else {
			$rating = false;
		}
		
		$description = strip_tags(html_entity_decode($result['meta_description'], ENT_QUOTES, 'UTF-8'));
		//var_dump($description);
		if(strlen($description)>15){
			$description = substr($description, 0, 30) . '...';
		}else{
			$description = $description;
		}
		
		$this->data['products'][] = array(
		    'product_id'  => $result['product_id'],
		    'thumb'       => $image,
		    'name'        => $result['name'],
		    //'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 30) . '..',
			'description' => $description,
		    'price'       => $price,
		    'special'     => $special,
		    'tax'         => $tax,
		    'rating'      => $result['rating'],
		    'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
		    'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			'quantity'	  => $result['quantity'],
			'StockInicial' => $result['StockInicial']
		);
				
	    }
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/categorymasonrywidget.tpl')) {
		$this->template = $this->config->get('config_template') . '/template/product/categorymasonrywidget.tpl';
	    } else {
		$this->template = 'default/template/product/masonrywidget.tpl';
	    }
	    
	   $this->response->setOutput($this->render());
	}
	
	public function index() { 
		if(isset($_SESSION['token'])){
			$this->language->load('product/category');

			$this->load->model('catalog/category');

			$this->load->model('catalog/product');

			$this->load->model('tool/image'); 

			if (isset($this->request->get['filter'])) {
				$filter = $this->request->get['filter'];
			} else {
				$filter = '';
			}

			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.sort_order';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else { 
				$page = 1;
			}	

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_catalog_limit');
			}

$this->document->addScript('catalog/view/javascript/jquery/masonry/masonry.pkgd.js');
		$this->document->addScript('catalog/view/javascript/jquery/masonry/imagesloaded.pkgd.js');
		$this->document->addScript('catalog/view/javascript/jquery/masonry/jquery.infinitescroll.js');
		$this->document->addScript('catalog/view/javascript/jquery/masonry/masonrysettings.js');
		$this->document->addStyle('catalog/view/javascript/jquery/masonry/masonrysettings.css');
	
			$this->data['breadcrumbs'] = array();

		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/discount_tags.css'))
        	$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template'). '/stylesheet/discount_tags.css');

	if ($this->config->get('config_use_discount_tags')) {

		$use_discount_tags = $this->config->get('config_use_discount_tags');
	} else {
		$use_discount_tags = 0;
	}
	if ($use_discount_tags){
		if ($this->config->get('config_discount_text_'.$this->config->get('config_language'))) {
			$text_discount_tag = $this->config->get('config_discount_text_'.$this->config->get('config_language'));
		} else {
			$text_discount_tag = '-@1%';
		}

		if ($this->config->get('config_tag_count')) {
			$discount_count = $this->config->get('config_tag_count');
		} else {
			$discount_count = 5;
		}
		if ($this->config->get('config_tag_each')) {
			$discount_each = $this->config->get('config_tag_each');
			if ($discount_each==0)
				$discount_each = 10;
		} else {
				$discount_each = 10;
		}
		if ($this->config->get('config_discount_from')) {
			$discount_from = $this->config->get('config_discount_from');
		} else {
			$discount_from = 0;
		}
		if ($this->config->get('config_discount_image')) {
			$discount_image = $this->config->get('config_discount_image');
			if (file_exists(DIR_IMAGE . $discount_image) && is_file(DIR_IMAGE . $discount_image)){
				$discount_image = 'image/'.$discount_image;
				$discount_size = getimagesize($discount_image);
				if (isset($discount_size) && $discount_count!=0) {
					$discount_width=(int)($discount_size[0]/$discount_count);
					$discount_height=$discount_size[1];
				}
				else{
					$discount_width=0;
					$discount_height=0;
				}
			}					
			else{
				$discount_image = '';
				$discount_width=0;
				$discount_height=0;
			}
		} else {
			$discount_image = '';
			$discount_width=0;
			$discount_height=0;
		}
		$discount_width_text='style="width: '.$discount_width.'px;"';
	}
	if ($this->config->get('config_use_stock_tags')) {
		$use_stock_tags = $this->config->get('config_use_stock_tags');
	} else {
		$use_stock_tags = 0;
	}
	if ($use_stock_tags){
		if ($this->config->get('config_stock_in_text_'.$this->config->get('config_language'))) {
			$text_stock_in = $this->config->get('config_stock_in_text_'.$this->config->get('config_language'));
		} else {
			$text_stock_in = 'In stock';
		}
		if ($this->config->get('config_stock_out_text_'.$this->config->get('config_language'))) {
			$text_stock_out = $this->config->get('config_stock_out_text_'.$this->config->get('config_language'));
		} else {
			$text_stock_out = 'Out of stock';
		}
		if ($this->config->get('config_stock_new_text_'.$this->config->get('config_language'))) {
			$text_stock_new = $this->config->get('config_stock_new_text_'.$this->config->get('config_language'));
		} else {
			$text_stock_new = 'New';
		}
		if ($this->config->get('config_stock_left_text_'.$this->config->get('config_language'))) {
			$text_stock_left = $this->config->get('config_stock_left_text_'.$this->config->get('config_language'));
		} else {
			$text_stock_left = 'Only @1 left';
		}
		if ($this->config->get('config_stock_in')) {
			$stock_in = $this->config->get('config_stock_in');
		} else {
			$stock_in = 0;
		}
		if ($this->config->get('config_stock_out')) {
			$stock_out = $this->config->get('config_stock_out');
		} else {
			$stock_out = 0;
		}
		if ($this->config->get('config_stock_new')) {
			$stock_new = $this->config->get('config_stock_new');
		} else {
			$stock_new = 0;
		}
		if ($this->config->get('config_stock_left')) {
			$stock_left = $this->config->get('config_stock_left');
		} else {
			$stock_left = 0;
		}
		if ($this->config->get('config_stock_image')) {
			$stock_image = $this->config->get('config_stock_image');
			if (file_exists(DIR_IMAGE . $stock_image) && is_file(DIR_IMAGE . $stock_image)){
				$stock_image = 'image/'.$stock_image;
				$stock_size = getimagesize($stock_image);
				if (isset($stock_size)) {
					$stock_width=(int)($stock_size[0]/4);
					$stock_height=$stock_size[1];
				}
				else{
					$stock_width=0;
					$stock_height=0;
				}
			} else {
				$stock_image = '';
				$stock_width=0;
				$stock_height=0;
			}
		} else {
			$stock_image = '';
			$stock_width=0;
			$stock_height=0;
		}
		$stock_width_text='style="width: '.$stock_width.'px;"';
	}
	$image_width='width: '.$this->config->get('config_image_product_width').'px;';
                        

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);

			if (isset($this->request->get['path'])) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}	

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$path = '';

				$parts = explode('_', (string)$this->request->get['path']);

				$category_id = (int)array_pop($parts);

				foreach ($parts as $path_id) {
					if (!$path) {
						$path = (int)$path_id;
					} else {
						$path .= '_' . (int)$path_id;
					}

					$category_info = $this->model_catalog_category->getCategory($path_id);

					if ($category_info) {
						$this->data['breadcrumbs'][] = array(
							'text'      => $category_info['name'],
							'href'      => $this->url->link('product/category', 'path=' . $path . $url),
							'separator' => $this->language->get('text_separator')
						);
					}
				}
			} else {
				$category_id = 0;
			}

if($this->config->get('masonry_category_theme') == 1) {
				$this->data['category_id'] = $category_id;
			    }
	

            //For Filter Range - Filter products based on slider price range
            $isAjax = false;
            if((isset($this->session->data['category_id']))&&($this->session->data['category_id']==$category_id))
            {
            if (isset($this->request->get['lower']))
	    {
		$isAjax = true;        
                $this->session->data['lower']=$this->request->get['lower'];
                $this->session->data['higher']=$this->request->get['higher'];
            }    
            }
            else {	    
           unset ($this->session->data['lower']);
           unset ($this->session->data['higher']);
            $this->session->data['category_id']=$category_id;        
            }
//End  Filter Range - Filter products based on slider price range
            
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$this->document->setTitle($category_info['name']);
				$this->document->setDescription($category_info['meta_description']);
				$this->document->setKeywords($category_info['meta_keyword']);
				$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

				$this->data['heading_title'] = $category_info['name'];

				$this->data['text_refine'] = $this->language->get('text_refine');
				$this->data['text_empty'] = $this->language->get('text_empty');			
				$this->data['text_quantity'] = $this->language->get('text_quantity');
				$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
				$this->data['text_model'] = $this->language->get('text_model');
				$this->data['text_price'] = $this->language->get('text_price');
				$this->data['text_tax'] = $this->language->get('text_tax');
				$this->data['text_points'] = $this->language->get('text_points');
				$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$this->data['text_display'] = $this->language->get('text_display');
				$this->data['text_list'] = $this->language->get('text_list');
				$this->data['text_grid'] = $this->language->get('text_grid');
				$this->data['text_sort'] = $this->language->get('text_sort');
				$this->data['text_limit'] = $this->language->get('text_limit');

				$this->data['button_cart'] = $this->language->get('button_cart');
				$this->data['button_wishlist'] = $this->language->get('button_wishlist');
				$this->data['button_compare'] = $this->language->get('button_compare');
				$this->data['button_continue'] = $this->language->get('button_continue');

				// Set the last category breadcrumb		
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}	

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$this->data['breadcrumbs'][] = array(
					'text'      => $category_info['name'],
					'href'      => $this->url->link('product/category', 'path=' . $this->request->get['path']),
					'separator' => $this->language->get('text_separator')
				);

				if ($category_info['image']) {
					$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				} else {
					$this->data['thumb'] = '';
				}

				$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				$this->data['compare'] = $this->url->link('product/compare');

				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}	

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}	

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$this->data['categories'] = array();

				$results = $this->model_catalog_category->getCategories($category_id);

				foreach ($results as $result) {
					$data = array(
						'filter_category_id'  => $result['category_id'],
						'filter_sub_category' => true
					);

					$product_total = $this->model_catalog_product->getTotalProducts($data);				
					if($product_total !='0'){
						$this->data['categories'][] = array(
							'name'  => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
							'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
						);
					}
				}

				$this->data['products'] = array();

				$data = array(
					'filter_category_id' => $category_id,
					'filter_filter'      => $filter, 
					'sort'               => $sort,
					'order'              => $order,
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				);

				$product_total = $this->model_catalog_product->getTotalProducts($data); 

				$results = $this->model_catalog_product->getProducts($data);
				//var_dump(count($results));

				foreach ($results as $result) {
				//var_dump($result['image']);
				//var_dump(urldecode($result['image']));
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						//$image = false;
						$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));;
					}
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}	

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}				

					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}

			if ($this->config->get('appsname_status')) {
				if (strlen($result['name']) > $this->config->get('apps_cat_limit')) {
					$apple_name = substr(strip_tags($result['name']),0,$this->config->get('apps_cat_limit')) . " ...";
				} else {
					$apple_name = $result['name'];
				}
			} else {
				$apple_name = $result['name'];
			}
			
					
					/*if(strlen($result['name'])>15){
						$name = utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_name_limit')) . '...';
					}else{
						$name = strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
					}*/
					
					$descriptionM2 = strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')) .' '.strip_tags(html_entity_decode($result['meta_description'], ENT_QUOTES, 'UTF-8'));
					
					if(strlen($descriptionM2)>15){
						$descriptionM = substr($descriptionM2, 0, 30) . '...';
					}else{
						$descriptionM = $descriptionM2;
					}
					
					$name = strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
									
					$description = strip_tags(html_entity_decode($result['meta_description'], ENT_QUOTES, 'UTF-8'));
					//var_dump($description);
					if(strlen($description)>15){
						$description = substr($description, 0, 30) . '...';
					}else{
						$description = $description;
					}
					
					/*var_dump($name);
					var_dump($description);
					var_dump($descriptionM2);*/
					
								
	if ($use_discount_tags && isset($result['special'])){
		$discount_tag_text=100-(((float)$result['special']/(float)$result['price'])*100);
		$index=($discount_tag_text-$discount_from)/$discount_each;
		if ($index>=$discount_count)
			$index=$discount_count-1;
		if ($discount_tag_text>=$discount_from){
			$discount_tag_text=str_replace("@1", (int)$discount_tag_text, $text_discount_tag);
			$tag_1=((int)($index))*$discount_width;
			$discount_tag='background-image: url('.$discount_image.');'.'background-position: -'.$tag_1.'px 0px;width: '.$discount_width.'px;height: '.$discount_height.'px;';
		}
		else{
			$discount_tag=NULL;	
			$discount_tag_text=NULL;
		}
	}	
	else{
		$discount_tag=NULL;	
		$discount_tag_text=NULL;
	}
	$stock_tag = NULL;
	$stock_tag_text = NULL;
	if ($use_stock_tags){
		$stock_tag_x = 0;
		$stock_quantity=$result['quantity'];
		if ($stock_quantity <= $stock_out) {
			$stock_tag_text = $text_stock_out;		
		}
		elseif ($stock_new>0) {
			$diff=ceil((strtotime($result['date_available']."+ ".$stock_new." days")-time())/60/60/24);
			if ($diff>0){
				$stock_tag_text = str_replace("@1", $stock_quantity, $text_stock_new);
				$stock_tag_x = $stock_width;
			}		
		}
		if($stock_tag_text==NULL){
			if ($stock_quantity <= $stock_left && $stock_quantity>0){
				$stock_tag_text = str_replace("@1", $stock_quantity, $text_stock_left);
				$stock_tag_x = $stock_width*2;
			}
			elseif ($stock_quantity >= $stock_in){
				$stock_tag_text = str_replace("@1", $stock_quantity, $text_stock_in);
				$stock_tag_x = $stock_width*3;
			}
		}
		if ($stock_tag_text!=NULL)
			$stock_tag='background-image: url('.$stock_image.');'.'background-position: -'.$stock_tag_x.'px 0px;width: '.$stock_width.'px;height: '.$stock_height.'px;';
	}
if($this->config->get('masonry_category_theme') == 1) {
				if ($result['image']) {
			$image = $this->model_tool_image->onesize($result['image'], $this->config->get('masonry_category_size_width'));
		} else {
			$image = $this->model_tool_image->onesize('no_image.jpg', $this->config->get('masonry_category_size_width'));
		}
			    }
	
	$this->data['products'][] = array(
				'stock' 		=> $stock_tag,
				'stock_text' 		=> $stock_tag_text,
				'stock_width'		=> $stock_width_text,
				'discount'              => $discount_tag,
				'discount_text'         => $discount_tag_text,
				'discount_width'	=> $discount_width_text,
				'image_width' 		=> $image_width,
                        
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $name,
						//'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 30) . '..',
						'description' => $description,
						'price'       => $price,

			'apple_name' => $apple_name,
			
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $result['rating'],
						'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
						'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
						'quantity'	  => $result['quantity'],
						'StockInicial' => $result['StockInicial'],
						'descripcionM' => $descriptionM
					);
				}

				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$this->data['sorts'] = array();

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
				); 

				if (!$this->config->get('config_review_status')) {
					$this->data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_desc'),
						'value' => 'rating-DESC',
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
					); 

					$this->data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_asc'),
						'value' => 'rating-ASC',
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
					);
				}

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_asc'),
					'value' => 'p.model-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_desc'),
					'value' => 'p.model-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
				);

				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				$this->data['limits'] = array();

				$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

				sort($limits);

				foreach($limits as $value){
					$this->data['limits'][] = array(
						'text'  => $value,
						'value' => $value,
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
					);
				}

				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

				$this->data['pagination'] = $pagination->render();

				$this->data['sort'] = $sort;
				$this->data['order'] = $order;
				$this->data['limit'] = $limit;

				$this->data['continue'] = $this->url->link('common/home');

if($this->config->get('masonry_category_theme') == 1) {
			    $this->data['masonry_category_sort_option'] = ($this->config->get('masonry_category_sort_option') == 1) ? true : false;
			    $this->data['masonry_category_limit_option'] = ($this->config->get('masonry_category_limit_option') == 1) ? true : false;
			    $this->data['masonry_category_price_option'] = ($this->config->get('masonry_category_price_option') == 1) ? true : false;
			    $this->data['masonry_category_add_wishlist'] = ($this->config->get('masonry_category_add_wishlist') == 1) ? true : false;
			    $this->data['masonry_category_add_compare'] = ($this->config->get('masonry_category_add_compare') == 1) ? true : false;

			    $url = '';

			    if (isset($this->request->get['path'])) {
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = (int)array_pop($parts);

				$url .= '&category_id=' . $category_id;
			    }

			    if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			    }

			    if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			    }	

			    if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			    }

			    if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			    } else {
				$url .= '&limit=' . $this->config->get('config_catalog_limit');;
			    }

			    $url .= '&p=2';

			    $this->data['masonry_url'] = $this->url->link('product/category/AJAXGetMasonryProducts',$url);
			}
	
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
					if($this->config->get('masonry_category_theme') == 1) {
				$this->template = $this->config->get('config_template') . '/template/product/categorymasonry.tpl';
			    } else {
				$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
			    }
	
				} else {
					if($this->config->get('masonry_category_theme') == 1) {
				$this->template = 'default/template/product/categorymasonry.tpl';
			    } else {
				$this->template = 'default/template/product/category.tpl';
			    }
	
				}

				$this->children = array(
					'common/column_left',
					'common/column_right',
					'common/content_top',
					'common/content_bottom',
					'common/footer',
					'common/header'
				);

				$this->response->setOutput($this->render());										
			} else {
				$url = '';

				if (isset($this->request->get['path'])) {
					$url .= '&path=' . $this->request->get['path'];
				}

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$this->data['breadcrumbs'][] = array(
					'text'      => $this->language->get('text_error'),
					'href'      => $this->url->link('product/category', $url),
					'separator' => $this->language->get('text_separator')
				);

				$this->document->setTitle($this->language->get('text_error'));

				$this->data['heading_title'] = $this->language->get('text_error');

				$this->data['text_error'] = $this->language->get('text_error');

				$this->data['button_continue'] = $this->language->get('button_continue');

				$this->data['continue'] = $this->url->link('common/home');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
				} else {
					$this->template = 'default/template/error/not_found.tpl';
				}

				$this->children = array(
					'common/column_left',
					'common/column_right',
					'common/content_top',
					'common/content_bottom',
					'common/footer',
					'common/header'
				);

				$this->response->setOutput($this->render());
			}
		}else{
			//var_dump('No tiene permisos para ver esta pagina');		
			header('Location: http://socimagestion.com/Movil/error.php');
		}
	}
}
?>