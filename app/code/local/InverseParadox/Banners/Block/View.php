<?php

class InverseParadox_Banners_Block_View
	extends Mage_Core_Block_Template
	implements Mage_Widget_Block_Interface
{

	/**
	 * Determine whether a valid group is set
	 *
	 * @return bool
	 */
	public function hasValidGroup()
	{
		if ($this->helper('ipbanners')->isEnabled()) {
			return is_object($this->getGroup());
		}

		return false;
	}

	/**
	 * Set the group code
	 * The group code is validated before being set
	 *
	 * @param string $code
	 */
	public function setGroupCode($code)
	{

		$currentGroupCode = $this->getGroupCode();

		if ($currentGroupCode != $code || !$this->hasValidGroup()) {
			$this->setGroup(null);
			$this->setData('group_code', null);

			$group = Mage::getModel('ipbanners/group')->loadByCode($code);

			if ($group->getId() && $group->getIsEnabled()) {
				if (in_array($group->getStoreId(), array(0, Mage::app()->getStore()->getId()))) {
					$this->setGroup($group);
					$this->setData('group_code', $code);
				}
			}
		}

		return $this;
	}

	/**
	 * Retrieve a collection of banners
	 *
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	 */
	public function getBanners()
	{
		return $this->getGroup()->getBannerCollection();
	}

	/**
	 * If a template isn't passed in the XML, set the default template
	 *
	 * @return InverseParadox_Banners_Block_View
	 */
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();

		if (!$this->hasValidGroup() && $this->getData('group_code')) {
			$this->setGroupCode($this->getData('group_code'));
		}

		if (!$this->getTemplate()) {
			$this->setTemplate('ipbanners/default.phtml');
		}

		return $this;
	}

}
