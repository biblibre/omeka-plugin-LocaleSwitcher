<?php

require_once __DIR__ . '/helpers/functions.php';

class LocaleSwitcherPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'install',
        'uninstall',
        'upgrade',
        'config',
        'config_form',
        'define_routes',
        'admin_head',
        'public_head',
        'public_header',
    );

    protected $_filters = array(
        'locale',
        'admin_navigation_global',
    );

    protected $_options = array(
        'locale_switcher_append_header' => true,
        // The value is: serialize(array('en'))
        'locale_switcher_locales' => 'a:1:{i:0;s:2:"en";}',
        'locale_switcher_locales_admin' => 'a:1:{i:0;s:2:"en";}',
    );

    public function hookInstall()
    {
        $this->_installOptions();
    }

    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    public function hookUpgrade($args)
    {
        $oldVersion = $args['old_version'];
        $newVersion = $args['new_version'];

        if (version_compare($oldVersion, '0.3.0', '<')) {
            set_option('locale_switcher_locales_admin', $this->_options['locale_switcher_locales_admin']);
        }
    }

    public function hookConfigForm()
    {
        $view = get_view();

        $locales = get_option('locale_switcher_locales');
        $locales = $locales ? unserialize($locales) : array();

        $localesAdmin = get_option('locale_switcher_locales_admin');
        $localesAdmin = $localesAdmin ? unserialize($localesAdmin) : array();

        $files = scandir(BASE_DIR . '/application/languages');
        foreach ($files as $file) {
            if (strpos($file, '.mo') !== false) {
                $code = str_replace('.mo', '', $file);
                $codes[$code] = locale_description($code) . " ($code)";
            }
        }
        // Set default "en" and instead of "en_US" to avoid issues.
        $codes['en'] = ucfirst(Zend_Locale::getTranslation('en', 'language')) . ' (en)';
        asort($codes);

        echo $view->partial('plugins/locale-switcher-config-form.php', array(
            'locales' => $locales,
            'localesAdmin' => $localesAdmin,
            'codes' => $codes,
        ));
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        foreach ($this->_options as $optionKey => $optionValue) {
            if (isset($post[$optionKey])) {
                switch ($optionKey) {
                    case 'locale_switcher_locales':
                    case 'locale_switcher_locales_admin':
                        $post[$optionKey] = serialize($post[$optionKey]);
                        break;
                }
                set_option($optionKey, $post[$optionKey]);
            }
        }
    }

    public function hookDefineRoutes($args)
    {
        $router = $args['router'];
        $router->addRoute(
            'locale-switcher-changelanguage',
            new Zend_Controller_Router_Route(
                'setlocale',
                array(
                    'module' => 'locale-switcher',
                    'controller' => 'setlocale',
                    'action' => 'index',
                )
            )
        );
    }

    public function hookAdminHead()
    {
        $enabledLocales = unserialize(get_option('locale_switcher_locales_admin'));
        if ($enabledLocales) {
            queue_css_file('locale-switcher');
            queue_css_file('flag-icon-css/css/flag-icon.min');
        }
    }

    public function hookPublicHead()
    {
        queue_css_file('locale-switcher');
        queue_css_file('flag-icon-css/css/flag-icon.min');
    }

    public function hookPublicHeader($args)
    {
        if (get_option('locale_switcher_append_header')) {
            echo $args['view']->localeSwitcher();
        }
    }

    public function filterLocale($value)
    {
        $enabledLocales = is_admin_theme()
            ? unserialize(get_option('locale_switcher_locales_admin'))
            : unserialize(get_option('locale_switcher_locales'));

        if (empty($enabledLocales)) {
            return $value;
        }

        // Make sure the session has been configured properly
        Zend_Registry::get('bootstrap')->bootstrap('Session');

        $session = new Zend_Session_Namespace('locale');

        if ($session->locale && in_array($session->locale, $enabledLocales)) {
            return $session->locale;
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languages = array_map(function($l) {
                list($locale, $q) = array_pad(explode(';', $l), 2, null);
                return str_replace('-', '_', trim($locale));
            }, explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']));

            foreach ($languages as $language) {
                if (in_array($language, $enabledLocales)) {
                    return $language;
                }
            }
        }

        return $value;
    }

    public function filterAdminNavigationGlobal($nav)
    {
        $enabledLocales = unserialize(get_option('locale_switcher_locales_admin'));
        if (empty($enabledLocales)) {
            return $nav;
        }

        $currentLocale = Zend_Registry::get('bootstrap')->getResource('Locale')->toString();
        $currentUrl = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $view = get_view();

        foreach ($enabledLocales as $locale) {
            $language = Zend_Locale::getTranslation(substr($locale, 0, 2), 'language');
            $country = $view->localeToCountry($locale);

            $url = url('setlocale', array('locale' => $locale, 'redirect' => $currentUrl));
            $title = locale_description($locale);
            $class = 'flag-icon flag-icon-' . strtolower($country);
            if ($locale === $currentLocale) {
                $class .= ' active';
            }
            $link = array(
                'label' => null,
                'uri' => $url,
                'class' => $class,
                'title' => $title,
            );
            $nav[] = $link;
        }

        return $nav;
    }
}
