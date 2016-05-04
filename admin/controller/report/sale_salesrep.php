<?php
class ControllerReportSaleSalesRep extends Controller {
	public function index() {     
		$this->load->language('report/sale_salesrep');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}	
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/sale_salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/sale');
		
		$this->data['sale_reps'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
				
		$salesrep_total = $this->model_report_sale->getTotalOrdersSR($data); 
		
		$results = $this->model_report_sale->getOrdersSR($data);
		
		foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/salesrep/update', 'token=' . $this->session->data['token'] . '&salesrep_id=' . $result['salesrep_id'] . $url, 'SSL')
			);
						
			$this->data['salesreps'][] = array(
				'salesrep'       => $result['salesrep'],
				'email'          => $result['email'],
				'area' => $result['area'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'customers'         => $result['customers'],
				'orders'         => $result['orders'],
				'products'       => $result['products'],
				'total'          => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'action'         => $action
			);
		}
		 
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		
		$this->data['column_salesrep'] = $this->language->get('column_salesrep');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_area'] = $this->language->get('column_area');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_customers'] = $this->language->get('column_customers');
		$this->data['column_orders'] = $this->language->get('column_orders');
		$this->data['column_products'] = $this->language->get('column_products');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $salesrep_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_order_status_id'] = $filter_order_status_id;
				 
		$this->template = 'report/sale_salesrep.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
}
?>