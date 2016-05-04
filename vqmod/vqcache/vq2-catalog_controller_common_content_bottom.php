<?php  
class ControllerCommonContentBottom extends Controller {
	protected function index() {
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/information');

		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		$layout_id = 0;

		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$path = explode('_', (string)$this->request->get['path']);

			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));			
		}

		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		}

		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		}

		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		}

		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$module_data = array();

		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getExtensions('module');		

		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');

			if ($modules) {
				foreach ($modules as $module) {

// madimar mod
					if ($extension['code'] == "salesrep") {
						$module['status'] = 0; // generally disables salesrep modules as first step
						// user logged and with salesrep assigned or admin module
						if ($this->customer->isLogged()) {
							$this_salesrep_id = $this->customer->getSalesRepId();						
							if ((isset($this_salesrep_id) && $module['salesrep_id'] == $this_salesrep_id) || $module['salesrep_id'] == 0) {
								$module['status'] = 1 ;
							}
							// user not logged
						} else {
							if (isset($this->request->get['slrptrk'])) {
								$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesrep WHERE code = '" . $this->request->get['slrptrk'] . "'");
								if ($query->num_rows > 0) {
									$salesrep_info = $query->row;
									setcookie('slrptrk', $this->request->get['slrptrk'], time() + 3600 * 24 * 1000, '/');									
									if (isset($salesrep_info) && $module['salesrep_id'] == $salesrep_info['salesrep_id']) $module['status'] = 1 ;
								}						
							}	
/*							
							if (isset($this->request->cookie['slrptrk'])) {
								$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesrep WHERE code = '" . $this->request->cookie['slrptrk'] . "'");
								if ($query->num_rows > 0) {
									$salesrep_info = $query->row;
									if (isset($salesrep_info) && $module['salesrep_id'] == $salesrep_info['salesrep_id']) $module['status'] = 1 ;
								}
							} 
*/
						}
					}	
// madimar mod end
            
					if ($module['layout_id'] == $layout_id && $module['position'] == 'content_bottom' && $module['status']) {
						$module_data[] = array(
							'code'       => $extension['code'],
							'setting'    => $module,
							'sort_order' => $module['sort_order']
						);				
					}
				}
			}
		}

		$sort_order = array(); 

		foreach ($module_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $module_data);

		$this->data['modules'] = array();

		foreach ($module_data as $module) {
			$module = $this->getChild('module/' . $module['code'], $module['setting']);

			if ($module) {
				$this->data['modules'][] = $module;
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/content_bottom.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/content_bottom.tpl';
		} else {
			$this->template = 'default/template/common/content_bottom.tpl';
		}

		$this->render();
	}
}
?>