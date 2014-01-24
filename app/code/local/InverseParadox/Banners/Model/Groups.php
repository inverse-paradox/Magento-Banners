<?php
class InverseParadox_Banners_Model_Groups
{

    public function toOptionArray()
    {
        $options = array(
            array('value' => 'brands', 'label' => 'Brands'),
            array('value' => 'hero', 'label' => 'Home Page Main'),
            array('value' => 'categories', 'label' => 'Shop by Category')
        );
        return $options;
    }

}