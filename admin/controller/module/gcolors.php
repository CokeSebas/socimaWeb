<?php

//==============================================================================
// Gsearch Plugin
// 
// Author: Onjection Solutions
// E-mail: gaurav@onjection.com
// Website: http://www.onjection.com
//==============================================================================

class ControllerModuleGcolors extends Controller {

	private $error = array();
	public function index() {
	    $this->load->language('module/gcolors');
		$this->document->setTitle($this->language->get('heading_title'));
	    $this->load->model('setting/setting');
	    
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
	
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('gcolors', $this->request->post);				
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['choose_color_id'] = $this->language->get('choose_color_id');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		
		$this->data['color_status'] = $this->language->get('color_status');		
		
			
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_history'] = $this->language->get('button_history');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_delete'] = $this->language->get('button_delete');
		
		$this->data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->request->post['color_id'])) {
			$this->data['color_id'] = $this->request->post['color_id'];
		} else {
			$this->data['color_id'] = $this->config->get('color_id');
		}
		
	
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['partnerid'])) {
			$this->data['error_color_id'] = $this->error['partnerid'];
		} else {
			$this->data['error_color_id'] = '';
		}
	

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['gshistory'] = $this->url->link('module/gcolors/gshistory', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cart_button'] = $this->url->link('module/gcolors/gs_chart', 'token=' . $this->session->data['token'], 'SSL');
		
		
		if (isset($this->request->post['gcolors_status'])) {
			$this->data['gcolors_status'] = $this->request->post['gcolors_status'];
		} else {
			$this->data['gcolors_status'] = $this->config->get('gcolors_status');
		}
		
		
		
		$this->template = 'module/gcolors.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		//$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		$this->response->setOutput($this->render());
	}
	

	public function install() {

       $this->load->model('catalog/gsearch');
       $this->model_catalog_gsearch->create_history(); 

    
    }

   
	private function validate() {
		
		if (!$this->request->post['color_id']) {
			$this->error['partnerid'] = $this->language->get('error_color_id');
		}
		

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	public function gshistory(){
					$this->document->setTitle("gSearch History");
					 $this->load->model('catalog/gsearch');
						 $total_search = $this->model_catalog_gsearch->total_search();
					$total_search=$total_search['count(*)'];
					
					if (isset($this->request->get['page'])) {
							$page = $this->request->get['page'];
						} else {
							$page = 1;
						}

					$url = '';

					if (isset($this->request->get['page'])) {
						$url .= '&page=' . $this->request->get['page'];
						$page_no=$this->request->get['page'];
					}
					else{
					$page_no=null;
					}
					
						$this->data['search_history'] = array();
						/////////////////

					 $data = array(
						'start' => ($page - 1) * $this->config->get('config_admin_limit'),
						'limit' => $this->config->get('config_admin_limit')
					);
						$total_search1 = $this->model_catalog_gsearch->total_search();
						$total_search = $total_search1['count(*)'];
						$item=$this->model_catalog_gsearch->get_history($data);	
						$this->data['search_history'] = $item;
		
						/////////////////////////////
	
						$this->data['breadcrumbs'] = array();

						$this->data['breadcrumbs'][] = array(
							'text'      => $this->language->get('text_home'),
							'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => false
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'Module',
							'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
							'separator' => ' :: '
						);
						
						$this->data['breadcrumbs'][] = array(
							'text'      => 'gSearch',
							'href'      => $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'gSearch_history',
							'href'      => $this->url->link('module/gcolors/gshistory', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);
						$this->data['delete_history'] = $this->url->link('module/gcolors/delete_history&page='.$page_no, 'token=' . $this->session->data['token'], 'SSL');
							$this->data['back'] = $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL');
						$this->template = 'module/gshistory.tpl';
						$this->children = array(
							'common/header',	
							'common/footer'	
						);
						
						$pagination = new Pagination();
						$pagination->total = $total_search;
						$pagination->page = $page;
						$pagination->limit = $this->config->get('config_admin_limit');
						$pagination->text = $this->language->get('text_pagination');
						$pagination->url = $this->url->link('module/gcolors/gshistory', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

						$this->data['pagination'] = $pagination->render();
						//$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
						$this->response->setOutput($this->render());
		
	
	}
	
	public function delete_history(){

				$delete_id= $_GET['delete_id'];
		$this->load->model('catalog/gsearch');
		$this->model_catalog_gsearch->delete_history($delete_id);

				
				
				$this->gshistory();
	}
	
	
	public function gs_chart(){

				$this->data['more_k_chart'] = $this->url->link('module/gcolors/gs_morek_chart', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['more_p_chart'] = $this->url->link('module/gcolors/gs_morep_chart', 'token=' . $this->session->data['token'], 'SSL');
		$this->load->model('catalog/gsearch');
		$item=$this->model_catalog_gsearch->gs_keyword_chart();
		$this->data['get_keyword_chart']=$item;
		$item1=$this->model_catalog_gsearch->gs_product_chart();
		$this->data['get_product_chart']=$item1;
				$this->template = 'module/chart.tpl';
						$this->children = array(
							'common/header',	
							'common/footer'	
						);
						$this->response->setOutput($this->render());
				
				}
	
	public function gs_morek_chart(){

		
				
		$this->load->model('catalog/gsearch');
		$item1=$this->model_catalog_gsearch->gs_morekeyword_chart();
		$this->data['back'] = $this->url->link('module/gcolors/gs_chart', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['breadcrumbs'] = array();

						$this->data['breadcrumbs'][] = array(
							'text'      => $this->language->get('text_home'),
							'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => false
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'Module',
							'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
							'separator' => ' :: '
						);
						
						$this->data['breadcrumbs'][] = array(
							'text'      => 'gSearch',
							'href'      => $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'gschart',
							'href'      => $this->url->link('module/gcolors/gs_chart', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);
		
		$this->data['get_morekeyword_chart']=$item1;
				$this->template = 'module/more_k_chart.tpl';
						$this->children = array(
							'common/header',	
							'common/footer'	
						);
						$this->response->setOutput($this->render());
				
				}
				
				
				public function gs_morep_chart(){
		
		$this->load->model('catalog/gsearch');
		$item1=$this->model_catalog_gsearch->gs_moreproduct_chart();
		$this->data['back'] = $this->url->link('module/gcolors/gs_chart', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['breadcrumbs'] = array();

						$this->data['breadcrumbs'][] = array(
							'text'      => $this->language->get('text_home'),
							'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => false
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'Module',
							'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
							'separator' => ' :: '
						);
						
						$this->data['breadcrumbs'][] = array(
							'text'      => 'gSearch',
							'href'      => $this->url->link('module/gcolors', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);

						$this->data['breadcrumbs'][] = array(
							'text'      => 'gschart',
							'href'      => $this->url->link('module/gcolors/gs_chart', 'token=' . $this->session->data['token'], 'SSL'),
							'separator' => ' :: '
						);
		
		$this->data['get_morekeyword_chart']=$item1;
				$this->template = 'module/more_p_chart.tpl';
						$this->children = array(
							'common/header',	
							'common/footer'	
						);
						$this->response->setOutput($this->render());
				
				}
}
?>
