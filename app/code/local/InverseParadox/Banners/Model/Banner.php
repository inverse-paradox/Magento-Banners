<?php

class InverseParadox_Banners_Model_Banner extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		$this->_init('ipbanners/banner');
	}

	/**
	 * Retrieve the group model associated with the banner
	 *
	 * @return InverseParadox_Banners_Model_Group|false
	 */
	public function getGroup()
	{
		if (!$this->hasGroup()) {
			$this->setGroup($this->getResource()->getGroup($this));
		}

		return $this->getData('group');
	}

	/**
	 * Determine whether the banner has a valid URL
	 *
	 * @return bool
	 */
	public function hasUrl()
	{
		return strlen($this->getUrl()) > 1;
	}

	/**
	 * Retrieve the image URL
	 *
	 * @return string
	 */
	public function getImageUrl()
	{
		if (!$this->hasImageUrl()) {
			$this->setImageUrl(Mage::helper('ipbanners/image')->getImageUrl($this->getImage()));
		}

		return $this->getData('image_url');
	}

	/**
	 * Retrieve the medium image URL
	 *
	 * @return string
	 */
	public function getMedImageUrl()
	{
		if (!$this->hasMedImageUrl()) {
			$this->setMedImageUrl(Mage::helper('ipbanners/image')->getImageUrl($this->getMedImage()));
		}

		return $this->getData('med_image_url');
	}

	/**
	 * Retrieve the small image URL
	 *
	 * @return string
	 */
	public function getSmallImageUrl()
	{
		if (!$this->hasSmallImageUrl()) {
			$this->setSmallImageUrl(Mage::helper('ipbanners/image')->getImageUrl($this->getSmallImage()));
		}

		return $this->getData('small_image_url');
	}

	/**
	 * Retrieve the URL
	 * This converts relative URL's to absolute
	 *
	 * @return string
	 */
	public function getUrl()
	{
		if ($this->_getData('url')) {
			if (strpos($this->_getData('url'), 'http://') === false && strpos($this->_getData('url'), 'https://') === false) {
				$this->setUrl(Mage::getBaseUrl() . ltrim($this->_getData('url'), '/ '));
			}
		}

		return $this->_getData('url');
	}
}
