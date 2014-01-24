<?php

class InverseParadox_Banners_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('ipbanners/banner', 'banner_id');
	}

	/**
	 * Logic performed before saving the model
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @return InverseParadox_Banners_Model_Mysql4_Banner
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{
		if (!$object->getGroupId()) {
			$object->setGroupId(null);
		}

		if (!$object->getSortOrder()) {
			$object->setSortOrder(Mage::helper('ipbanners')->getNextSortOrder($object->getGroupId()));
		}

		return parent::_beforeSave($object);
	}

	/**
	 * Retrieve the group model associated with the banner
	 *
	 * @param InverseParadox_Banners_Model_Banner $banner
	 * @return InverseParadox_Banners_Model_Group
	 */
	public function getGroup(InverseParadox_Banners_Model_Banner $banner)
	{
		if ($banner->getGroupId()) {
			$group = Mage::getModel('ipbanners/group')->load($banner->getGroupId());

			if ($group->getId()) {
				return $group;
			}
		}

		return false;
	}
}
