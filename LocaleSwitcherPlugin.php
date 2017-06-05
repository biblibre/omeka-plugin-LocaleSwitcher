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

    public function hookInstall()
    {
        set_option('locale_switcher_locales', serialize(array('en_US')));
    }

    public function hookUninstall()
    {
        delete_option('locale_switcher_locales');
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        set_option('locale_switcher_locales', serialize($post['locales']));
    }

    public function hookConfigForm()
    {
        include 'config_form.php';
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
        $session = new Zend_Session_Namespace('locale');
        if ($session->locale) {
            return $session->locale;
        }
    }
}