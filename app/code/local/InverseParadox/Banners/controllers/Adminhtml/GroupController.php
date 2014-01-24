<?php

class InverseParadox_Banners_Adminhtml_GroupController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('cms/ipbanners');
		$this->renderLayout();
	}

	/**
	 * Display the group grid
	 *
	 */
	public function gridAction()
	{
		$this->getResponse()
			->setBody($this->getLayout()->createBlock('ipbanners/adminhtml_group_grid')->toHtml());
	}

	/**
	 * Forward to the edit action so the user can add a new group
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
		$group = $this->_initGroupModel();

		$this->loadLayout();

		if ($headBlock = $this->getLayout()->getBlock('head')) {
			$titles = array('Banner Blocks');

			if ($group) {
				array_unshift($titles, $group->getTitle());
			}
			else {
				array_unshift($titles, 'Create a Group');
			}

			$headBlock->setTitle(implode(' - ', $titles));
		}

		$this->renderLayout();
	}

	/**
	 * Save the group
	 *
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost('group')) {
			$group = Mage::getModel('ipbanners/group')
				->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {
				$group->save();
				$this->_getSession()->addSuccess($this->__('Banner Group was saved'));
			}
			catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				Mage::logException($e);
			}

			if ($this->getRequest()->getParam('back') && $group->getId()) {
				$this->_redirect('*/*/edit', array('id' => $group->getId()));
				return;
			}
		}
		else {
			$this->_getSession()->addError($this->__('There was no data to save'));
		}

		$this->_redirect('*/*');
	}

	/**
	 * Delete a ipbanners group
	 *
	 */
	public function deleteAction()
	{
		if ($groupId = $this->getRequest()->getParam('id')) {
			$group = Mage::getModel('ipbanners/group')->load($groupId);

			if ($group->getId()) {
				try {
					$group->delete();
					$this->_getSession()->addSuccess($this->__('The banner group was deleted.'));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}

		$this->_redirect('*/*');
	}

	/**
	 * Delete multiple ipbanners groups in one go
	 *
	 */
	public function massDeleteAction()
	{
		$groupIds = $this->getRequest()->getParam('group');

		if (!is_array($groupIds)) {
			$this->_getSession()->addError($this->__('Please select some groups.'));
		}
		else {
			if (!empty($groupIds)) {
				try {
					foreach ($groupIds as $groupId) {
						$group = Mage::getSingleton('ipbanners/group')->load($groupId);

						Mage::dispatchEvent('ipbanners_controller_group_delete', array('ipbanners_group' => $group));

						$group->delete();
					}

					$this->_getSession()->addSuccess($this->__('Total of %d record(s) have been deleted.', count($groupIds)));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}

		$this->_redirect('*/*');
	}

	/**
	 * Initialise the group model
	 *
	 * @return null|InverseParadox_IPBanners_Model_Group
	 */
	protected function _initGroupModel()
	{
		if ($groupId = $this->getRequest()->getParam('id')) {
			$group = Mage::getModel('ipbanners/group')->load($groupId);

			if ($group->getId()) {
				Mage::register('ipbanners_group', $group);
			}
		}

		return Mage::registry('ipbanners_group');
	}
}