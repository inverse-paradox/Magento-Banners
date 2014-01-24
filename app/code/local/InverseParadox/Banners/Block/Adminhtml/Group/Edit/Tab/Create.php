<?php
class InverseParadox_Banners_Block_Adminhtml_Group_Edit_Tab_Create extends Mage_Adminhtml_Block_Widget_Form
{

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('ipbanners/banner/quickadd.phtml');
    }

}  
?>