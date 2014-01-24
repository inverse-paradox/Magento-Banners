<?php

class InverseParadox_Banners_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('ipbanners_group_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->__('Banners / Group'));
	}

	protected function _beforeToHtml()
	{

		if ($this->getRequest()->getParam('id') != null) {
			$content = $this->getLayout()->createBlock('ipbanners/adminhtml_group_edit_tab_form')->toHtml()
				     . $this->getLayout()->createBlock('ipbanners/adminhtml_group_edit_tab_create')->toHtml()
				     . $this->getLayout()->createBlock('ipbanners/adminhtml_group_edit_tab_banners')->toHtml();
		} else {
			$content = $this->getLayout()->createBlock('ipbanners/adminhtml_group_edit_tab_form')->toHtml();
		}

		$this->addTab('general',
			array(
				'label' => $this->__('General'),
				'title' => $this->__('General'),
				'content' => $content,
			)
		);

		return parent::_beforeToHtml();
	}
}
