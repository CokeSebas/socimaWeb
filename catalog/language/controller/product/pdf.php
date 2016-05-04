<?php
class ControllerProductPdf extends Controller {
	public function index() {
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);

		if ($product_info) {
			$this->load->library('mpdf/mpdf');

			$this->load->language('product/product');

			$this->data['text_attributes'] = $this->language->get('text_attributes');
			$this->data['text_price'] = $this->language->get('text_tax');

			$this->data['product_info'] = $product_info;

			$this->data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

			$this->data['price'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);

			if ($this->config->get('config_tax')) {
				$this->data['tax'] = $this->currency->format($this->tax->calculate($product_info['special'] ? $product_info['special'] : $product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$this->data['tax'] = false;
			}

			$this->data['images'] = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			$this->data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);


			$headerHTML = '
				<div style="float: left; width: 180px">
					<img width="180" src="' . HTTPS_SERVER . 'image/' . $this->config->get('config_logo') . '">
				</div>
				<div style="float: right; width: 340px; text-align: right; color: #808180">
					' . nl2br($this->config->get('config_address')) . '<br/><br/>
					tel.: ' . $this->config->get('config_telephone') . '<br/><br/>
					' . $this->config->get('config_email') . ' | ' . HTTPS_SERVER . '
				</div>
				<div class="clear"></div>
			';

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/pdf.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/pdf.tpl';
			} else {
				$this->template = 'default/template/product/pdf.tpl';
			}

			$mpdf = new mPDF('utf-8', 'A4', 7, 'Helvetica', 32, 31, 45, 35);
			$mpdf->name = $product_info['name'] . '.pdf';
			$mpdf->SetHTMLHeader($headerHTML);
			$mpdf->WriteHTML($this->render());
			$mpdf->Output();
		}
	}
}
?>