<?php
      //===========================================//
     // Total-Based Shipping                      //
    // Author: Joel Reeds                        //
   // Company: OpenCart Addons                  //
  // Website: http://opencartaddons.com        //
 // Contact: webmaster@opencartaddons.com     //
//===========================================//

class ControllerShippingOCATBS extends Controller { 
	private $error = array();
	private $version = '7.1';
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
	
	public function index() { 
		
		$this->data['extension'] = $this->extension;
		$this->data['ocversion'] = $this->getVersion();
		
		$this->data = array_merge($this->data, $this->load->language($this->extensionType . '/' . $this->extension));
		$this->document->addStyle('view/stylesheet/oca_stylesheet.css');
		
		$this->data['text_contact'] = sprintf($this->data['text_contact'], $this->version);
			
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$post_data = $this->request->post;
			if ($this->getVersion() <= 150) {
				foreach ($post_data as $key => $value) {
					if (is_array($value)) {
						$post_data[$key] = serialize($value);
					}
				}
			}
			$this->model_setting_setting->editSetting($this->extension, $post_data);	

			if (isset($this->request->get['apply'])) {
				$this->session->data['success'] = $this->language->get('text_success');
				$this->redirect($this->getLink($this->extensionType, $this->extension)); 
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
				$this->redirect($this->getLink('extension', $this->extensionType));
			}
		}
		
		$this->load->model('localisation/weight_class');
		if ($this->config->get('config_weight_class_id')) {
			$weight_class = $this->model_localisation_weight_class->getWeightClass($this->config->get('config_weight_class_id'));
			$weight_units = isset($weight_class['unit']) ? $weight_class['unit'] : $this->config->get('config_weight_class_id');
		} else {
			$weight_class = $this->model_localisation_weight_class->getWeightClass($this->config->get('config_weight_class'));
			$weight_units = isset($weight_class['unit']) ? $weight_class['unit'] : $this->config->get('config_weight_class');
		}
		
		$this->load->model('localisation/length_class');
		if ($this->config->get('config_length_class_id')) {
			$length_class = $this->model_localisation_length_class->getLengthClass($this->config->get('config_length_class_id')); 
			$length_units = isset($length_class['unit']) ? $length_class['unit'] : $this->config->get('config_length_class_id');
		} else { 
			$length_class = $this->model_localisation_length_class->getLengthClass($this->config->get('config_length_class'));
			$length_units = isset($length_class['unit']) ? $length_class['unit'] : $this->config->get('config_length_class');
		}
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $this->config->get('config_currency') . "'");
		$currency_symbol = !empty($query->row['symbol_left']) ? $query->row['symbol_left'] : $query->row['symbol_right'];
		
		$this->data['entry_weight'] = sprintf($this->data['entry_weight'], $weight_units);
		$this->data['entry_shipping_factor'] = sprintf($this->data['entry_shipping_factor'], $length_units, $weight_units);
		$this->data['entry_volume'] = sprintf($this->data['entry_volume'], $length_units);
		$this->data['entry_length'] = sprintf($this->data['entry_length'], $length_units);
		$this->data['entry_width'] = sprintf($this->data['entry_width'], $length_units);
		$this->data['entry_height'] = sprintf($this->data['entry_height'], $length_units);
		$this->data['entry_quantity'] = sprintf($this->data['entry_quantity'], '#');
		$this->data['entry_total'] = sprintf($this->data['entry_total'], $currency_symbol);
		
		$this->data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : '';
		unset($this->session->data['success']);
		$this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

  		$breadcrumbs = array();

   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->getLink('common', 'home'),
      		'separator' => false
   		);

   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('text_' . $this->extensionType),
			'href'      => $this->getLink('extension', $this->extensionType),
      		'separator' => ' :: '
   		);
		
   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('text_name'),
			'href'      => $this->getLink($this->extensionType, $this->extension),
      		'separator' => ' :: '
   		);
		
		$fields = array('status', 'title', 'sort_order', 'sort_quotes', 'display_weight', 'rate');
		
		foreach ($fields as $field) {
			$key = $this->extension . '_' . $field;
			$value = isset($this->request->post[$key]) ? $this->request->post[$key] : $this->config->get($key);
			if ($value) {
				$this->data[$key] = $this->getField($value);
			} else {
				$this->data[$key] = '';
			}
		}
		
		$this->data['sort_quotes'] = array(array('id' => 0, 'name' => $this->data['sort_quotes_0']), array('id' => 1, 'name' => $this->data['sort_quotes_1']));
		$this->data['multirates'] = array(array('id' => 0, 'name' => $this->data['multirates_0']), array('id' => 1, 'name' => $this->data['multirates_1']), array('id' => 2, 'name' => $this->data['multirates_2']), array('id' => 3, 'name' => $this->data['multirates_3']), array('id' => 4, 'name' => $this->data['multirates_4']));
		$this->data['cost_settings'] = array(array('id' => 0, 'name' => $this->data['cost_settings_0']), array('id' => 1, 'name' => $this->data['cost_settings_1']));
		$this->data['category_settings'] = array(array('id' => 0, 'name' => $this->data['category_settings_0']), array('id' => 1, 'name' => $this->data['category_settings_1']), array('id' => 2, 'name' => $this->data['category_settings_2']));
		$this->data['final_costs'] = array(array('id' => 0, 'name' => $this->data['final_costs_0']), array('id' => 1, 'name' => $this->data['final_costs_1']));	
		$this->data['postal_code_types'] = array(array('id' => 0, 'name' => $this->data['postal_code_types_0']), array('id' => 1, 'name' => $this->data['postal_code_types_1']));
		
		$this->data['display_weight_option'] = false;
		$this->data['display_shipping_factor'] = false;
		
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		$this->load->model('localisation/geo_zone');
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();				

		$this->template = $this->extensionType . '/' . $this->extension . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		$this->data['action'] = $this->getLink($this->extensionType, $this->extension);
		$this->data['cancel'] = $this->getLink('extension', $this->extensionType); 
		
		if ($this->getVersion() < 150) {
			$this->document->title = $this->language->get('text_name');
			$this->document->breadcrumbs = $breadcrumbs;
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		} else {
			$this->document->setTitle($this->language->get('text_name'));
			$this->data['breadcrumbs'] = $breadcrumbs;
			$this->response->setOutput($this->render());
		}
	}
	
	private function getLink($a, $b) {
		$route = $a . '/' . $b;
		if ($this->getVersion() >= 150) {
			return $this->url->link($route, 'token=' . $this->session->data['token'], 'SSL');
		} else {
			return HTTPS_SERVER . 'index.php?route=' . $route . '&token=' . $this->session->data['token']; 
		}
	}
	
	private function getField($value) {
		if (is_string($value) && strpos($value, 'a:') === 0) {
			$value = unserialize($value);
		}
		
		return $value;
	}
		
	private function validate() {		
		if (!$this->user->hasPermission('modify', $this->extensionType . '/' . $this->extension)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>