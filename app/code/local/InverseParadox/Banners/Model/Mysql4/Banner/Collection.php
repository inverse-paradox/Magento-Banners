<?php
class InverseParadox_Banners_Model_Mysql4_Banner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('ipbanners/banner');
	}

	/**
	 * Init collection select
	 *
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	*/
	protected function _initSelect()
	{
		$this->getSelect()->from(array('main_table' => $this->getMainTable()));

		return $this;
	}

	/**
	 * Filter the collection by a group ID
	 *
	 * @param int $groupId
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	 */
	public function addGroupIdFilter($groupId)
	{
		return $this->addFieldToFilter('group_id', $groupId);
	}

	/**
	 * Filter the collection by enabled banners
	 *
	 * @param int $isEnabled = true
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	 */
	public function addIsEnabledFilter($isEnabled = true)
	{
		$this->addFieldToFilter('is_enabled', $isEnabled ? 1 : 0);
		return $this;
	}

	public function addPublishDateFilter()
	{
		$publish_start_null = array('null' => true);
		$publish_start_after = array('lteq' => Mage::getModel('core/date')->date('Y-m-d H:i:s', time()));
		$this->addFieldToFilter('publish_start', array($publish_start_null, $publish_start_after));
		$publish_end_null = array('null' => true);
		$publish_end_after = array('gteq' => Mage::getModel('core/date')->date('Y-m-d H:i:s', time()));
		$this->addFieldToFilter('publish_end', array($publish_end_null, $publish_end_after));
		return $this;
	}

	/**
	 * Add a random order to the banners
	 *
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	*/
	public function addOrderByRandom($dir = 'ASC')
	{
		$this->getSelect()->order('RAND() ' . $dir);
		return $this;
	}

	/**
	 * Add order by sort order
	 *
	 * @return InverseParadox_Banners_Model_Mysql4_Banner_Collection
	*/
	public function addOrderBySortOrder($dir = 'ASC')
	{
		$this->getSelect()->order('sort_order ' . $dir);
		return $this;
	}
}
