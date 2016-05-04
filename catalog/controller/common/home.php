<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		$this->load->model('catalog/category');
		
		$bannersC = $this->model_catalog_category->getBannerC();
		
		$this->data['bannersC'] = $bannersC;
		
		$bannersP = $this->model_catalog_category->getBannerP();
		$this->data['bannersP'] = $bannersP;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			//$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
			$this->template = $this->config->get('config_template') . '/template/common/home2.tpl';
		} else {
			//$this->template = 'default/template/common/home.tpl';
			$this->template = 'default/template/common/home2.tpl';
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
?>