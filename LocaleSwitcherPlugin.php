<?php

require_once __DIR__ . '/helpers/functions.php';

class LocaleSwitcherPlugin extends Omeka_Plugin_AbstractPlugin
{
    public $_hooks = array(
        'install',
        'uninstall',
        'config',
        'config_form',
        'define_routes',
        'public_head',
    );

    public $_filters = array(
        'locale',
    );

    protected $_options = array(
        // The value is: serialize(array('en_US'))
        'locale_switcher_locales' => 'a:1:{i:0;s:5:"en_US";}',
    );

    public function hookInstall()
    {
        $this->_installOptions();
    }

    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    public function hookConfigForm()
    {
        $view = get_view();

        $locales = get_option('locale_switcher_locales');
        $locales = $locales ? unserialize($locales) : array();

        $files = scandir(BASE_DIR . '/application/languages');
        foreach ($files as $file) {
            if (strpos($file, '.mo') !== false) {
                $code = str_replace('.mo', '', $file);
                $codes[$code] = locale_description($code) . " ($code)";
            }
        }
        $codes['en_US'] = ucfirst( Zend_Locale::getTranslation('en_US', 'language') ) . " (en_US)";
        asort($codes);

        echo $view->partial('plugins/locale-switcher-config-form.php', array(
            'locales' => $locales,
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
                    'action' => 'setlocale',
                )
            )
        );
    }

    public function hookPublicHead()
    {
        queue_css_file('locale-switcher');
        queue_css_file('flag-icon-css/css/flag-icon.min');
    }

    public function filterLocale($value)
    {
        $enabled_locales = unserialize(get_option('locale_switcher_locales'));

        // Make sure the session has been configured properly
        Zend_Registry::get('bootstrap')->bootstrap('Session');

        $session = new Zend_Session_Namespace('locale');

        if ($session->locale && in_array($session->locale, $enabled_locales)) {
            return $session->locale;
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languages = array_map(function($l) {
                list($locale, $q) = array_pad(explode(';', $l), 2, null);
                return str_replace('-', '_', trim($locale));
            }, explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']));

            foreach ($languages as $language) {
                if (in_array($language, $enabled_locales)) {
                    return $language;
                }
            }
        }

        return $value;
    }
}
