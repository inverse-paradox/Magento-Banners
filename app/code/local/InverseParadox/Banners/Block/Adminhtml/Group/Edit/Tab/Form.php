<?php

class InverseParadox_Banners_Block_Adminhtml_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('group_');
        $form->setFieldNameSuffix('group');

		$this->setForm($form);

		$fieldset = $form->addFieldset('group_general', array('legend'=> $this->__('General Information')));

		$fieldset->addField('title', 'text', array(
			'name' 		=> 'title',
			'label' 	=> $this->__('Title'),
			'title' 	=> $this->__('Title'),
			'required'	=> true,
			'class'		=> 'required-entry',
		));

		$fieldset->addField('code', 'text', array(
			'name' 		=> 'code',
			'label' 	=> $this->__('Code'),
			'title' 	=> $this->__('Code'),
			'note'		=> $this->__('This is a unique identifier that is used to inject the banner group via XML'),
			'required'	=> true,
			'class'		=> 'required-entry validate-code',
		));

		$fieldset->addField('is_enabled', 'select', array(
			'name' => 'is_enabled',
			'title' => $this->__('Enabled'),
			'label' => $this->__('Enabled'),
			'required' => true,
			'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value' => 1
		));

		$fieldset->addField('store_id', 'select', array(
			'name'		=> 'store_id',
			'label'		=> $this->__('Store'),
			'title'		=> $this->__('Store'),
			'required'	=> true,
			'class'		=> 'required-entry',
			'values'	=> $this->_getStores()
		));

		if ($group = Mage::registry('ipbanners_group')) {
			$form->setValues($group->getData());
		}

		return parent::_prepareForm();
	}

	/**
	 * Retrieve an array of all of the stores
	 *
	 * @return array
	 */
	protected function _getStores()
	{
		$stores = Mage::getResourceModel('core/store_collection');
		$options = array(0 => $this->__('Global'));

		foreach($stores as $store) {
			$options[$store->getId()] = $store->getWebsite()->getName() . ': ' . $store->getName();
		}

		return $options;
	}
}
