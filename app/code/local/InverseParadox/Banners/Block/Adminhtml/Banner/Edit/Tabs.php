<?php

class InverseParadox_Banners_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('ipbanners_banner_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->__('Banners / Banner'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('general',
			array(
				'label' => $this->__('General'),
				'title' => $this->__('General'),
				'content' => $this->getLayout()->createBlock('ipbanners/adminhtml_banner_edit_tab_form')->toHtml(),
			)
		);

		return parent::_beforeToHtml();
	}
}
