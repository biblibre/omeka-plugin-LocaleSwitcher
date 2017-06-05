<?php 

$locales = get_option('locale_switcher_locales');
if ($locales) {
    $locales = unserialize($locales);
}

$files = scandir(BASE_DIR . '/application/languages');
foreach ($files as $file) {
    if (strpos($file, '.mo') !== false) {
        $code = str_replace('.mo', '', $file);
        $codes[$code] = locale_description($code) . " ($code)";
    }
}
$codes['en_US'] = ucfirst( Zend_Locale::getTranslation('en_US', 'language') ) . " (en_US)";
asort($codes);

?>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Languages'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The languages to use for your site. Some parts of the site might not have been translated into your language yet. To learn more about contributing to translations, <a href='http://omeka.org/codex/Translate_Omeka'>read this</a>."); ?> </p>
        <div class="input-block">
            <?php echo get_view()->formMultiCheckbox('locales', $locales, null, $codes);   ?> 
        </div>
    </div>
</div>
