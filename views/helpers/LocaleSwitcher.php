<?php

class LocaleSwitcher_View_Helper_LocaleSwitcher extends Zend_View_Helper_Abstract
{
    public function localeSwitcher()
    {
        $locales = is_admin_theme()
            ? unserialize(get_option('locale_switcher_locales_admin'))
            : unserialize(get_option('locale_switcher_locales'));
        return $this->view->partial('common/locale-switcher.php', array(
            'locales' => $locales,
        ));
    }
}
