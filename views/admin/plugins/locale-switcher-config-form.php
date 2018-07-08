<div class="field">
    <div class="two columns alpha">
        <?php echo $this->formLabel('locale_switcher_append_header',
            __('Automatically append to header')); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('If checked, the switcher will be automatically displayed via the hook "public_header", else you need to put it in your theme.'); ?></p>
        <?php echo $this->formCheckbox('locale_switcher_append_header', true,
            array('checked' => (boolean) get_option('locale_switcher_append_header'))); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <?php echo $this->formLabel('locale_switcher_locales',
            __('Languages')); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('The languages to use for your site. Some parts of the site might not have been translated into your language yet. To learn more about contributing to translations, <a href="http://omeka.org/codex/Translate_Omeka">read this</a>.'); ?> </p>
        <div class="input-block">
            <?php echo $this->formMultiCheckbox('locale_switcher_locales', $locales, null, $codes); ?>
        </div>
    </div>
</div>
