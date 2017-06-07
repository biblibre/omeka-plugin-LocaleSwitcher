<?php

class LocaleSwitcher_SetlocaleController extends Zend_Controller_Action
{
    public function setlocaleAction()
    {
        $locale = $this->getParam('locale');

        if (Zend_Locale::isLocale($locale)) {
            $session = new Zend_Session_Namespace('locale');
            $session->locale = $this->getParam('locale');
        }

        $referer = $this->getRequest()->getHeader('Referer');
        $url = $this->getParam('redirect', $referer);
        $url = $url ?: '/';
        $this->getHelper('Redirector')->setPrependBase(false)->goToUrl($url);
    }
}
