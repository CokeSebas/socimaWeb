<?php 
class ControllerProductManufacturer extends Controller {  
	public function index() { 
		$this->language->load('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');		

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_index'] = $this->language->get('text_index');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_continue'] = $this->language->get('button_continue');

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

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_brand'),
			'href'      => $this->url->link('product/manufacturer'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['categories'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($this->data['manufacturers'][$key])) {
				$this->data['categories'][$key]['name'] = $key;
			}

			$this->data['categories'][$key]['manufacturer'][] = array(
				'name' => $result['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/manufacturer_list.tpl';
		} else {
			$this->template = 'default/template/product/manufacturer_list.tpl';
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

	public function info() {
		$this->language->load('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('catalog/product');

		$this->load->model('tool/image'); 

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
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

		$this->data['breadcrumbs'][] = array( 
			'text'      => $this->language->get('text_brand'),
			'href'      => $this->url->link('product/manufacturer'),
			'separator' => $this->language->get('text_separator')
		);

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

		if ($manufacturer_info) {
			$this->document->setTitle($manufacturer_info['name']);
			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

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
				'text'      => $manufacturer_info['name'],
				'href'      => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $manufacturer_info['name'];

				if( $manufacturer_info['image'] ) {
					$this->data['manufacturer_image'] = $this->model_tool_image->resize($manufacturer_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
				} else {
					$this->data['manufacturer_image'] = false;
				}
			

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

			$this->data['compare'] = $this->url->link('product/compare');

			$this->data['products'] = array();

			$data = array(
				'filter_manufacturer_id' => $manufacturer_id, 
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($data);

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
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
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', '&manufacturer_id=' . $result['manufacturer_id'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url)
			); 

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC' . $url)
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

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
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}

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

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url . '&page={page}');

			$this->data['pagination'] = $pagination->render();

			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/manufacturer_info.tpl';
			} else {
				$this->template = 'default/template/product/manufacturer_info.tpl';
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

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
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
	}
}
?>