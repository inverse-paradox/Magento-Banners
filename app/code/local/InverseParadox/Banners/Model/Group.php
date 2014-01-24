<?php
class InverseParadox_Banners_Model_Group extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		$this->_init('ipbanners/group');
	}

	/**
	 * Load the model based on the code field
	 *
	 * @param string $code
	 * @return InverseParadox_Banners_Model_Group
	 */
	public function loadByCode($code)
	{
		return $this->load($code, 'code');
	}

	/**
	 * Determine whether the group is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->getIsEnabled();
	}

	/**
	 * Retrieve a collection of banners associated with this group
	 *
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Group
	 */
	public function getBannerCollection()
	{
		if (!$this->hasBannerCollection()) {
			$this->setBannerCollection($this->getResource()->getBannerCollection($this));
		}

		return $this->_getData('banner_collection');
	}

	/**
	 * Retrieve the amount of banners in this group
	 *
	 * @return int
	 */
	public function getBannerCount()
	{
		if (!$this->hasBannerCount()) {
			$this->setBannerCount($this->getBannerCollection()->count());
		}

		return $this->_getData('banner_count');
	}

}
