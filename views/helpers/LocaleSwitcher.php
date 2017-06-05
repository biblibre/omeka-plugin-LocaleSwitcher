<?php

class LocaleSwitcher_View_Helper_LocaleSwitcher extends Zend_View_Helper_Abstract
{
    public function localeSwitcher()
    {
        return $this->view->partial('locale-switcher/locale-switcher.php');
    }
}
