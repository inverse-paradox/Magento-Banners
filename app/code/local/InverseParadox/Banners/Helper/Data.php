<?php

class InverseParadox_Banners_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Determine whether the extension is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return Mage::getStoreConfig('ipbanners/settings/enabled');
	}

    public function getNextSortOrder($group_id)
    {
        $table = Mage::getSingleton('core/resource')->getTableName('ipbanners/banner');
        $query = 'SELECT MAX(sort_order) FROM ' . $table . ' WHERE group_id = ' . $group_id;
        $max = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchOne($query);
        if ($max != null) {
            $max = (int) $max;
            $max = $max + 1;
            return $max;
        } else {
            return 0;
        }
    }
}
