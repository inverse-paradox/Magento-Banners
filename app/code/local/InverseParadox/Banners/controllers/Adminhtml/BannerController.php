<?php

class InverseParadox_Banners_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('cms/ipbanners');
		$this->renderLayout();
	}

	/**
	 * Display the banner grid
	 *
	 */
	public function gridAction()
	{
		$this->getResponse()
			->setBody($this->getLayout()->createBlock('ipbanners/adminhtml_banner_grid')->toHtml());
	}

	/**
	 * Forward to the edit action so the user can add a new banner
	 *
	 */
	public function newAction()
	{
		$this->_forward('edit');
	}

	/**
	 * Display the edit/add form
	 *
	 */
	public function editAction()
	{
		$banner = $this->_initBannerModel();
		$this->loadLayout();

		if ($headBlock = $this->getLayout()->getBlock('head')) {
			$titles = array('Banner Blocks');

			if ($banner) {
				array_unshift($titles, $banner->getTitle());
			}
			else {
				array_unshift($titles, 'Create a Banner');
			}

			$headBlock->setTitle(implode(' - ', $titles));
		}

		$this->renderLayout();
	}

	/**
	 * Save the banner
	 *
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost('banner')) {
			$banner = Mage::getModel('ipbanners/banner')
				->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {

				$this->_handleImageUpload($banner);

				$banner->save();
				$this->_getSession()->addSuccess($this->__('Banner was saved'));
			}
			catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				Mage::logException($e);
			}

			if ($this->getRequest()->getParam('back') && $banner->getId()) {
				$this->_redirect('*/*/edit', array('id' => $banner->getId()));
				return;
			}
		}
		else {
			$this->_getSession()->addError($this->__('There was no data to save'));
		}

		$this->_redirect('*/adminhtml_group/edit', array('id' => $banner->getGroupId()));
	}

	/**
	 * Upload an image and assign it to the model
	 *
	 * @param InverseParadox_Banners_Model_Banner $banner
	 * @param string $field = 'image'
	 */
	protected function _handleImageUpload(InverseParadox_Banners_Model_Banner $banner, $fields = array('image', 'med_image', 'small_image'))
	{
		foreach ($fields as $field) {

			$data = $banner->getData($field);

			if (isset($data['value'])) {
				$banner->setData($field, $data['value']);
			}

			if (isset($data['delete']) && $data['delete'] == '1') {
				$banner->setData($field, '');
			}

			if ($filename = Mage::helper('ipbanners/image')->uploadImage($field)) {
				$banner->setData($field, $filename);
			}

		}
	}

	/**
	 * Delete a ipbanners banner
	 *
	 */
	public function deleteAction()
	{
		if ($bannerId = $this->getRequest()->getParam('id')) {
			$banner = Mage::getModel('ipbanners/banner')->load($bannerId);

			if ($banner->getId()) {
				try {
					$banner->delete();
					$this->_getSession()->addSuccess($this->__('The banner was deleted.'));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}

		$this->_redirect('*/adminhtml_group/edit', array('id' => $bannerId));
	}

	/**
	 * Delete multiple ipbanners banners in one go
	 *
	 */
	public function massDeleteAction()
	{
		$bannerIds = $this->getRequest()->getParam('banner');

		if (!is_array($bannerIds)) {
			$this->_getSession()->addError($this->__('Please select some banners.'));
		}
		else {
			if (!empty($bannerIds)) {
				try {
					foreach ($bannerIds as $bannerId) {
						$banner = Mage::getSingleton('ipbanners/banner')->load($bannerId);

						Mage::dispatchEvent('ipbanners_controller_banner_delete', array('ipbanners_banner' => $banner));

						$banner->delete();
					}

					$this->_getSession()->addSuccess($this->__('Total of %d record(s) have been deleted.', count($bannerIds)));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}

		$this->_redirect('*/*');
	}

	/**
	 * Initialise the banner model
	 *
	 * @return null|InverseParadox_IPBanners_Model_Banner
	 */
	protected function _initBannerModel()
	{
		if ($bannerId = $this->getRequest()->getParam('id')) {
			$banner = Mage::getModel('ipbanners/banner')->load($bannerId);

			if ($banner->getId()) {
				Mage::register('ipbanners_banner', $banner);
			}
		}

		return Mage::registry('ipbanners_banner');
	}
}