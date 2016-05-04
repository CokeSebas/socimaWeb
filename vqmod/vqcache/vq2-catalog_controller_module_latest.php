<?php
class ControllerModuleLatest extends Controller {
	protected function index($setting) {
		$this->language->load('module/latest');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
				
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();

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
	$image_width='width: '.$setting['image_width'].'px;';
                        
		
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
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
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}

			if ($this->config->get('appsname_status')) {
				if (strlen($result['name']) > $this->config->get('apps_fbl_name_limit')) {
					$apple_name = substr(strip_tags($result['name']),0,$this->config->get('apps_fbl_name_limit')) . " ...";
				} else {
					$apple_name = $result['name'];
				}
			} else {
				$apple_name = $result['name'];
			}
			
			
			if(strlen($result['name'])>15){
				$name = utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_name_limit')) . '...';
			}else{
				$name = strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
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
                        
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $name,
				'price'   	 => $price,

			'apple_name' => $apple_name,
			
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/latest.tpl';
		} else {
			$this->template = 'default/template/module/latest.tpl';
		}

		$this->render();
	}
}
?>