<?php

class InverseParadox_Banners_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();

		$this->_controller = 'adminhtml_banner';
		$this->_blockGroup = 'ipbanners';
		$this->_headerText = $this->__('Banners / Banner');
	}
}