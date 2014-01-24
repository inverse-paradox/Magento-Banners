<?php

class InverseParadox_Banners_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Retrieve Additional Element Types
	 *
	 * @return array
	*/
	protected function _getAdditionalElementTypes()
	{
		return array(
			'image' => Mage::getConfig()->getBlockClassName('ipbanners/adminhtml_banner_helper_image')
		);
	}

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');

		$this->setForm($form);

		$fieldset = $form->addFieldset('banner_general', array('legend'=> $this->__('General Information')));

		$this->_addElementTypes($fieldset);

		if ($this->getRequest()->getParam('groupid')) {
			$fieldset->addField('group_id', 'select', array(
				'name'			=> 'group_id',
				'label'			=> $this->__('Group'),
				'title'			=> $this->__('Group'),
				'required'		=> true,
				'class'			=> 'required-entry',
				'values'		=> $this->_getGroups(),
				'value'         => $this->getRequest()->getParam('groupid'),
			));
		} else {
			$fieldset->addField('group_id', 'select', array(
				'name'			=> 'group_id',
				'label'			=> $this->__('Group'),
				'title'			=> $this->__('Group'),
				'required'		=> true,
				'class'			=> 'required-entry',
				'values'		=> $this->_getGroups(),
			));
		}

		$fieldset->addField('title', 'text', array(
			'name' 		=> 'title',
			'label' 	=> $this->__('Title'),
			'title' 	=> $this->__('Title'),
			'required'	=> true,
			'class'		=> 'required-entry',
		));

		$fieldset->addField('url', 'text', array(
			'name' 		=> 'url',
			'label' 	=> $this->__('URL'),
			'title' 	=> $this->__('URL')
		));

		$fieldset->addField('html', 'editor', array(
			'name' 		=> 'html',
			'label' 	=> $this->__('HTML'),
			'title' 	=> $this->__('HTML'),
			'style'		=> 'height: 120px; width: 98%;',
		));

		$fieldset->addField('image', 'image', array(
			'name' 		=> 'image',
			'label' 	=> $this->__('Image'),
			'title' 	=> $this->__('Image'),
			'required'	=> true,
			'class'		=> 'required-entry',
		));

		$fieldset->addField('med_image', 'image', array(
			'name' 		=> 'med_image',
			'label' 	=> $this->__('Medium Image'),
			'title' 	=> $this->__('Medium Image'),
		));

		$fieldset->addField('small_image', 'image', array(
			'name' 		=> 'small_image',
			'label' 	=> $this->__('Small Image'),
			'title' 	=> $this->__('Small Image'),
		));

		$fieldset->addField('publish_start', 'date', array(
			'name' 		=> 'publish_start',
			'label' 	=> $this->__('Publish Start Date'),
			'title' 	=> $this->__('Publish Start Date'),
			'image' => $this->getSkinUrl('images/grid-cal.gif'),
			'time' => true,
			'format' => Zend_Date::YEAR.'-'.Zend_Date::MONTH.'-'.Zend_Date::DAY.' '.Zend_Date::HOUR.':'.Zend_Date::MINUTE.':'.Zend_Date::SECOND
		));

		$fieldset->addField('publish_end', 'date', array(
			'name' 		=> 'publish_end',
			'label' 	=> $this->__('Publish End Date'),
			'title' 	=> $this->__('Publish End Date'),
			'image' => $this->getSkinUrl('images/grid-cal.gif'),
			'time' => true,
			'format' => Zend_Date::YEAR.'-'.Zend_Date::MONTH.'-'.Zend_Date::DAY.' '.Zend_Date::HOUR.':'.Zend_Date::MINUTE.':'.Zend_Date::SECOND
		));

		$fieldset->addField('sort_order', 'text', array(
			'name' 		=> 'sort_order',
			'label' 	=> $this->__('Sort Order'),
			'title' 	=> $this->__('Sort Order'),
			'class'		=> 'validate-digits',
		));

		$fieldset->addField('is_enabled', 'select', array(
			'name' => 'is_enabled',
			'title' => $this->__('Enabled'),
			'label' => $this->__('Enabled'),
			'required' => true,
			'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value' => '1'
		));

		if ($banner = Mage::registry('ipbanners_banner')) {
			$form->setValues($banner->getData());
		}

		return parent::_prepareForm();
	}

	/**
	 * Retrieve an array of all of the stores
	 *
	 * @return array
	 */
	protected function _getGroups()
	{
		$groups = Mage::getResourceModel('ipbanners/group_collection');
		$options = array('' => $this->__('-- Please Select --'));

		foreach($groups as $group) {
			$options[$group->getId()] = $group->getTitle();
		}

		return $options;
	}
}
