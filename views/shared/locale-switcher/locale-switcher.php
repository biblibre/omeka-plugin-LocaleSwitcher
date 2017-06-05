<?php $locales = get_option('locale_switcher_locales'); ?>
<?php if ($locales): ?>
    <?php $currentLocale = Zend_Registry::get('bootstrap')->getResource('Locale')->toString(); ?>
    <?php $locales = unserialize($locales); ?>
    <ul class="locale-switcher">
        <?php foreach ($locales as $locale): ?>
            <?php $country = $this->localeToCountry($locale); ?>
            <?php $language = Zend_Locale::getTranslation(substr($locale, 0, 2), 'language'); ?>
            <li>
                <?php if ($currentLocale == $locale): ?>
                    <span class="active flag-icon flag-icon-<?php echo strtolower($country); ?>"></span>
                <?php else: ?>
                    <?php $url = url('setlocale', array('locale' => $locale, 'redirect' => current_url($_GET))); ?>
                    <a href="<?php echo $url ; ?>" title="<?php echo locale_description($locale); ?>"><span class="flag-icon flag-icon-<?php echo strtolower($country); ?>"></span></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
