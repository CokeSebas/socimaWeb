<?php 
class ControllerCommonMasonrySettings extends Controller {
    
    private $error = array();
    
    public function index() {

	if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
		$this->data['base'] = HTTPS_SERVER;
	} else {
		$this->data['base'] = HTTP_SERVER;
	}
	
	$this->document->addStyle('view/stylesheet/masonrysettings.css');
	$this->document->addStyle('view/stylesheet/jquery.switchButton.css');
	$this->document->addScript('view/javascript/jquery.switchButton.js');

	$this->language->load('common/masonrysettings');

	$this->document->setTitle($this->language->get('heading_title'));
	
	$this->data['heading_title'] = $this->language->get('heading_title');
	
	$this->load->model('setting/setting');

	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	    
	    $this->model_setting_setting->editSetting('masonry_settings', $this->request->post);

	    $this->session->data['success'] = $this->language->get('text_success');

	    $this->redirect($this->url->link('common/masonrysettings', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	$this->data['tab_general'] = $this->language->get('tab_general');
	
	$this->data['text_search_page'] = $this->language->get('text_search_page');
	$this->data['text_category_page'] = $this->language->get('text_category_page');
	$this->data['text_theme'] = $this->language->get('text_theme');
	$this->data['text_sort_option'] = $this->language->get('text_sort_option');
	$this->data['text_limit_option'] = $this->language->get('text_limit_option');
	$this->data['text_image_size'] = $this->language->get('text_image_size');
	$this->data['text_price_option'] = $this->language->get('text_price_option');
	$this->data['text_add_wishlist'] = $this->language->get('text_add_wishlist');
	$this->data['text_add_compare'] = $this->language->get('text_add_compare');
	$this->data['button_masonry_settings'] = $this->language->get('button_masonry_settings');
	
	$this->data['action'] = $this->url->link('common/masonrysettings', 'token=' . $this->session->data['token'], 'SSL');
	
	$this->data['breadcrumbs'] = array();

	$this->data['breadcrumbs'][] = array(
	    'text'      => $this->language->get('text_home'),
	    'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
	    'separator' => false
	);
	
	$this->data['breadcrumbs'][] = array(
	    'text'      => $this->language->get('heading_title'),
	    'href'      => $this->url->link('common/masonrysettings', 'token=' . $this->session->data['token'], 'SSL'),
	    'separator' => ' :: '
	);
	
	if (isset($this->session->data['success'])) {
	    $this->data['success'] = $this->session->data['success'];

	    unset($this->session->data['success']);
	} else {
	    $this->data['success'] = '';
	}
	
	if (isset($this->error['warning'])) {
	    $this->data['error_warning'] = $this->error['warning'];
	} else {
	    $this->data['error_warning'] = '';
	}
	
	if (isset($this->error['search_imagesize'])) {
	    $this->data['masonry_search_image_size_error'] = $this->error['search_imagesize'];
	} else {
	    $this->data['masonry_search_image_size_error'] = '';
	}
	
	if (isset($this->error['category_imagesize'])) {
	    $this->data['masonry_category_image_size_error'] = $this->error['category_imagesize'];
	} else {
	    $this->data['masonry_category_image_size_error'] = '';
	}
	
	// Data for Search Page Settings
	$this->data['masonry_search_theme'] = 0;
	if (isset($this->request->post['masonry_search_theme'])) {
	    $this->data['masonry_search_theme'] = $this->request->post['masonry_search_theme'];
	} else if (!isset($this->request->post['masonry_search_theme']) && $this->config->get('masonry_search_theme')){
	    $this->data['masonry_search_theme'] = $this->config->get('masonry_search_theme');
	} else {
	    $this->data['masonry_search_theme'] = 0;
	}
	
	$this->data['masonry_search_sort_option'] = 0;
	if (isset($this->request->post['masonry_search_sort_option'])) {
	    $this->data['masonry_search_sort_option'] = $this->request->post['masonry_search_sort_option'];
	} else if (!isset($this->request->post['masonry_search_sort_option']) && $this->config->get('masonry_search_sort_option')){
	    $this->data['masonry_search_sort_option'] = $this->config->get('masonry_search_sort_option');
	} else {
	    $this->data['masonry_search_sort_option'] = 0;
	}
	
	$this->data['masonry_search_limit_option'] = 0;
	if (isset($this->request->post['masonry_search_limit_option'])) {
	    $this->data['masonry_search_limit_option'] = $this->request->post['masonry_search_limit_option'];
	} else if (!isset($this->request->post['masonry_search_limit_option']) && $this->config->get('masonry_search_limit_option')){
	    $this->data['masonry_search_limit_option'] = $this->config->get('masonry_search_limit_option');
	} else {
	    $this->data['masonry_search_limit_option'] = 0;
	}
	
	if (isset($this->request->post['masonry_search_size_width'])) {
	    $this->data['masonry_search_size_width'] = $this->request->post['masonry_search_size_width'];
	} else if (!isset($this->request->post['masonry_search_size_width']) && $this->config->get('masonry_search_size_width')){
	    $this->data['masonry_search_size_width'] = $this->config->get('masonry_search_size_width');
	} else {
	    $this->data['masonry_search_size_width'] = "125";
	}
	
//	if (isset($this->request->post['masonry_search_size_height'])) {
//	    $this->data['masonry_search_size_height'] = $this->request->post['masonry_search_size_height'];
//	} else if (!isset($this->request->post['masonry_search_size_height']) && $this->config->get('masonry_search_size_height')){
//	    $this->data['masonry_search_size_height'] = $this->config->get('masonry_search_size_height');
//	} else {
//	    $this->data['masonry_search_size_height'] = "125";
//	}
	
	$this->data['masonry_search_price_option'] = 1;
	if (isset($this->request->post['masonry_search_price_option'])) {
	    $this->data['masonry_search_price_option'] = $this->request->post['masonry_search_price_option'];
	} else if (!isset($this->request->post['masonry_search_price_option']) && $this->config->get('masonry_search_price_option')){
	    $this->data['masonry_search_price_option'] = $this->config->get('masonry_search_price_option');
	} else {
	    $this->data['masonry_search_price_option'] = 0;
	}
	
	$this->data['masonry_search_add_wishlist'] = 1;
	if (isset($this->request->post['masonry_search_add_wishlist'])) {
	    $this->data['masonry_search_add_wishlist'] = $this->request->post['masonry_search_add_wishlist'];
	} else if (!isset($this->request->post['masonry_search_add_wishlist']) && $this->config->get('masonry_search_add_wishlist')){
	    $this->data['masonry_search_add_wishlist'] = $this->config->get('masonry_search_add_wishlist');
	} else {
	    $this->data['masonry_search_add_wishlist'] = 0;
	}
	
	
	$this->data['masonry_search_add_compare'] = 1;
	if (isset($this->request->post['masonry_search_add_compare'])) {
	    $this->data['masonry_search_add_compare'] = $this->request->post['masonry_search_add_compare'];
	} else if (!isset($this->request->post['masonry_search_add_compare']) && $this->config->get('masonry_search_add_compare')){
	    $this->data['masonry_search_add_compare'] = $this->config->get('masonry_search_add_compare');
	} else {
	    $this->data['masonry_search_add_compare'] = 0;
	}
	
	// Data for Category Page Settings
	$this->data['masonry_category_theme'] = 0;
	if (isset($this->request->post['masonry_category_theme'])) {
	    $this->data['masonry_category_theme'] = $this->request->post['masonry_category_theme'];
	} else if(!isset($this->request->post['masonry_category_theme']) && $this->config->get('masonry_category_theme')) {
	    $this->data['masonry_category_theme'] = $this->config->get('masonry_category_theme');
	}
	
	$this->data['masonry_category_sort_option'] = 0;
	if (isset($this->request->post['masonry_category_sort_option'])) {
	    $this->data['masonry_category_sort_option'] = $this->request->post['masonry_category_sort_option'];
	} else if (!isset($this->request->post['masonry_category_sort_option']) && $this->config->get('masonry_category_sort_option')){
	    $this->data['masonry_category_sort_option'] = $this->config->get('masonry_category_sort_option');
	} else {
	    $this->data['masonry_category_sort_option'] = 0;
	}
	
	$this->data['masonry_category_limit_option'] = 0;
	if (isset($this->request->post['masonry_category_limit_option'])) {
	    $this->data['masonry_category_limit_option'] = $this->request->post['masonry_category_limit_option'];
	} else if (!isset($this->request->post['masonry_category_limit_option']) && $this->config->get('masonry_category_limit_option')){
	    $this->data['masonry_category_limit_option'] = $this->config->get('masonry_category_limit_option');
	} else {
	    $this->data['masonry_category_limit_option'] = 0;
	}
	
	if (isset($this->request->post['masonry_category_size_width'])) {
	    $this->data['masonry_category_size_width'] = $this->request->post['masonry_category_size_width'];
	} else if (!isset($this->request->post['masonry_category_size_width']) && $this->config->get('masonry_category_size_width')){
	    $this->data['masonry_category_size_width'] = $this->config->get('masonry_category_size_width');
	} else {
	    $this->data['masonry_category_size_width'] = "125";
	}
	
//	if (isset($this->request->post['masonry_category_size_height'])) {
//	    $this->data['masonry_category_size_height'] = $this->request->post['masonry_category_size_height'];
//	} else if (!isset($this->request->post['masonry_category_size_height']) && $this->config->get('masonry_category_size_height')){
//	    $this->data['masonry_category_size_height'] = $this->config->get('masonry_category_size_height');
//	} else {
//	    $this->data['masonry_category_size_height'] = "125";
//	}
	
	$this->data['masonry_category_price_option'] = 1;
	if (isset($this->request->post['masonry_category_price_option'])) {
	    $this->data['masonry_category_price_option'] = $this->request->post['masonry_category_price_option'];
	} else if (!isset($this->request->post['masonry_category_price_option']) && $this->config->get('masonry_category_price_option')){
	    $this->data['masonry_category_price_option'] = $this->config->get('masonry_category_price_option');
	} else {
	    $this->data['masonry_category_price_option'] = 0;
	}
	
	$this->data['masonry_category_add_wishlist'] = 1;
	if (isset($this->request->post['masonry_category_add_wishlist'])) {
	    $this->data['masonry_category_add_wishlist'] = $this->request->post['masonry_category_add_wishlist'];
	} else if (!isset($this->request->post['masonry_category_add_wishlist']) && $this->config->get('masonry_category_add_wishlist')){
	    $this->data['masonry_category_add_wishlist'] = $this->config->get('masonry_category_add_wishlist');
	} else {
	    $this->data['masonry_category_add_wishlist'] = 0;
	}
	
	$this->data['masonry_category_add_compare'] = 1;
	if (isset($this->request->post['masonry_category_add_compare'])) {
	    $this->data['masonry_category_add_compare'] = $this->request->post['masonry_category_add_compare'];
	} else if (!isset($this->request->post['masonry_category_add_compare']) && $this->config->get('masonry_category_add_compare')){
	    $this->data['masonry_category_add_compare'] = $this->config->get('masonry_category_add_compare');
	} else {
	    $this->data['masonry_category_add_compare'] = 0;
	}
	
	
	$this->template = 'common/masonrysettings.tpl';
	$this->children = array(
		'common/header',
		'common/footer'
	);

	$this->response->setOutput($this->render());

    }
    
    protected function validate() {
	
	if (!$this->user->hasPermission('modify', 'common/masonrysettings')) {
	    $this->error['warning'] = $this->language->get('error_permission');
	}

	if (isset($this->request->post['masonry_search_theme']) && ($this->request->post['masonry_search_size_width'] == '' || $this->request->post['masonry_search_size_width'] == 0)) {
	    $this->error['search_imagesize'] = $this->language->get('error_image_size');
	}
	
	if (isset($this->request->post['masonry_category_theme']) && ($this->request->post['masonry_category_size_width'] == '' || $this->request->post['masonry_category_size_width'] == 0)) {
	    $this->error['category_imagesize'] = $this->language->get('error_image_size');
	}

	if (!$this->error) {
	    return true;
	} else {
	    return false;
	}
    }
}
?>