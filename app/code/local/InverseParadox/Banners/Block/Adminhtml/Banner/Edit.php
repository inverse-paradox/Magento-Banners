<?php

class InverseParadox_Banners_Block_Adminhtml_Banner_Edit  extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();

		$this->_controller = 'adminhtml_banner';
		$this->_blockGroup = 'ipbanners';
		$this->_headerText = $this->_getHeaderText();

		$this->_addButton('save_and_edit_button', array(
			'label'     => Mage::helper('catalog')->__('Save and Continue Edit'),
			'onclick'   => 'editForm.submit(\''.$this->getSaveAndContinueUrl().'\')',
			'class' => 'save'
		));
	}

	/**
	 * Retrieve the URL used for the save and continue link
	 * This is the same URL with the back parameter added
	 *
	 * @return string
	 */
	public function getSaveAndContinueUrl()
	{
		return $this->getUrl('*/*/save', array(
			'_current'   => true,
			'back'       => 'edit',
		));
	}

	public function getBackUrl()
    {
    	if ($this->getRequest()->getParam($this->_objectId)) {
			$group_id = Mage::getModel('ipbanners/banner')->load($this->getRequest()->getParam($this->_objectId))->getGroupId();
			return $this->getUrl('*/adminhtml_group/edit/', array('id' => $group_id));
		} else {
        	return $this->getUrl('*/adminhtml_group/');
        }
    }

    /**
     * Retrieve the header text
     * If splash page exists, use name
     *
     * @return string
     */
	protected function _getHeaderText()
	{
		if ($banner = Mage::registry('ipbanners_banner')) {
			if ($displayName = $banner->getTitle()) {
				return $displayName;
			}
		}

		return $this->__('Edit Banner');
	}
}
