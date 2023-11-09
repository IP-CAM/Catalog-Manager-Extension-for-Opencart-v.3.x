<?php

/**
 * Catalog Manager
 * @author Antonis Kazantzis
 * @link https://github.com/AntonisKazantzis/Catalog-Manager-Opencart3
 * @version 1.0
 */

class ControllerCommonDeveloper extends Controller
{
	public function index()
	{
		$this->load->language('common/developer');

		$data['user_token'] = $this->session->data['user_token'];

		$data['developer_theme'] = $this->config->get('developer_theme');
		$data['developer_sass'] = $this->config->get('developer_sass');

		$eval = false;

		$eval = '$eval = true;';

		eval($eval);

		if ($eval === true) {
			$data['eval'] = true;
		} else {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('developer', array('developer_theme' => 1), 0);

			$data['eval'] = false;
		}

		$this->response->setOutput($this->load->view('common/developer', $data));
	}

	public function edit()
	{
		$this->load->language('common/developer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('developer', $this->request->post, 0);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function theme()
	{
		$this->load->language('common/developer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$directories = glob(DIR_CACHE . '/template/*', GLOB_ONLYDIR);

			if ($directories) {
				foreach ($directories as $directory) {
					$files = glob($directory . '/*');

					foreach ($files as $file) {
						if (is_file($file)) {
							unlink($file);
						}
					}

					if (is_dir($directory)) {
						rmdir($directory);
					}
				}
			}

			$json['success'] = sprintf($this->language->get('text_cache'), $this->language->get('text_theme'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function sass()
	{
		$this->load->language('common/developer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			// Before we delete we need to make sure there is a sass file to regenerate the css
			$file = DIR_APPLICATION  . 'view/stylesheet/bootstrap.css';

			if (is_file($file) && is_file(DIR_APPLICATION . 'view/stylesheet/sass/_bootstrap.scss')) {
				unlink($file);
			}

			$files = glob(DIR_CATALOG  . 'view/theme/*/stylesheet/sass/_bootstrap.scss');

			foreach ($files as $file) {
				$file = substr($file, 0, -21) . '/bootstrap.css';

				if (is_file($file)) {
					unlink($file);
				}
			}

			$json['success'] = sprintf($this->language->get('text_cache'), $this->language->get('text_sass'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clear()
	{
		$this->load->language('common/developer');

		$json = array();

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/filter');
		$this->load->model('catalog/attribute');
		$this->load->model('catalog/attribute_group');
		$this->load->model('catalog/option');
		$this->load->model('catalog/manufacturer');

		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_description`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_filter`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_to_store`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_to_layout`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_to_category`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "seo_url`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "coupon_category`");

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_attribute`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_description`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_discount`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_filter`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_image`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_option`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_option_value`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_related`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_related`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_reward`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_special`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_to_category`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_to_download`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_to_layout`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_to_store`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_recurring`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "review`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "seo_url`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "coupon_product`");

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_group`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_group_description`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_description`");

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_description`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_group`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_group_description`");

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_description`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value_description`");

			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "manufacturer`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "manufacturer_to_store`");
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "seo_url`");

			$json['success'] = sprintf($this->language->get('text_clear_catalog'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function fill()
	{
		$this->load->language('common/developer');

		$json = array();

		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {

			for ($i = 1; $i <= 10; $i++) {
				$categoryName = 'Category ' . $i;

				$this->db->query("INSERT INTO " . DB_PREFIX . "category (`image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES ('Category_Image_$i.jpg', 0, 0, 1, 1, 1, NOW(), NOW())");

				$categoryId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "category_description (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ($categoryId, 1, '$categoryName', 'Category Description $i', 'Meta Title $i', 'Meta Description $i', 'Meta Keyword $i')");

				$model = 'Product ' . $i;
				$price = rand(10, 2000);
				$points = rand(10, 100);
				$viewed = rand(0, 10000);
				$sku = rand(1000, 100000);
				$upc = rand(1000, 100000);
				$ean = rand(1000, 100000);
				$jan = rand(1000, 100000);
				$isbn = rand(1000, 100000);
				$mpn = rand(1000, 100000);
				$quantity = rand(10, 100);
				$weight = rand(1, 10);
				$length = rand(1, 10);
				$width = rand(1, 10);
				$height = rand(10, 100);
				$tax_class_id = rand(9, 10);
				$stock_status_id = rand(6, 8);

				$this->db->query("INSERT INTO " . DB_PREFIX . "product (model, sku, upc, ean, jan, isbn, mpn, location, quantity, stock_status_id, image, manufacturer_id, price, points, tax_class_id, date_available, weight, weight_class_id, length, width, height, length_class_id, sort_order, status, viewed, date_added, date_modified) VALUES ('$model', $sku, $upc, $ean, $jan, $isbn, $mpn, 'Warehouse $i', $quantity, $stock_status_id, 'Product_Image_$i.jpg', 1, $price, $points, $tax_class_id, NOW(), $weight, 1, $length, $width, $height, 1, 1, 1, $viewed, NOW(), NOW())");

				$product_id = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_description (product_id, language_id, name, description, tag, meta_title, meta_description, meta_keyword) VALUES ($product_id, 1, 'Product Name $product_id', 'Product Description $product_id', 'Tag $product_id', 'Meta Title $product_id', 'Meta Description $product_id', 'Meta Keyword $product_id')");

				$filterGroupName = 'Filter Group ' . $i;

				$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group (`sort_order`) VALUES ($i)");

				$filterGroupId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description (`filter_group_id`, `language_id`, `name`) VALUES ($filterGroupId, 1, '$filterGroupName')");

				$groupName = 'Attribute Group ' . $i;
				$attributeName = 'Attribute ' . $i;

				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group (`sort_order`) VALUES ($i)");

				$attributeGroupId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description (`attribute_group_id`, `language_id`, `name`) VALUES ($attributeGroupId, 1, '$groupName')");

				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute (`attribute_group_id`, `sort_order`) VALUES ($attributeGroupId, $i)");

				$attributeId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description (`attribute_id`, `language_id`, `name`) VALUES ($attributeId, 1, '$attributeName')");

				$optionName = 'Option ' . $i;
				$optionValueName = 'Option Value ' . $i;

				$this->db->query("INSERT INTO " . DB_PREFIX . "option (`type`) VALUES ('select')");

				$optionId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "option_description (`option_id`, `language_id`, `name`) VALUES ($optionId, 1, '$optionName')");

				$this->db->query("INSERT INTO " . DB_PREFIX . "option_value (`option_id`, `sort_order`) VALUES ($optionId, $i)");

				$optionValueId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description (`option_value_id`, `language_id`, `name`) VALUES ($optionValueId, 1, '$optionValueName')");

				$manufacturerName = 'Manufacturer ' . $i;

				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer (`name`) VALUES ('$manufacturerName')");

				$manufacturerId = $this->db->getLastId();

				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store (`manufacturer_id`, `store_id`) VALUES ($manufacturerId, 0)");
			}

			$json['success'] = sprintf($this->language->get('text_fill_catalog'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
