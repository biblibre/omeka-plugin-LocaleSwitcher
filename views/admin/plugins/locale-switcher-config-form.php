<p class="explanation">
    <?php echo __('Some parts of the site might not have been translated into your language yet.'); ?>
    <?php echo __('To learn more about contributing to translations, %sread this%s.', '<a href="https://omeka.org/codex/Translate_Omeka">', '</a>.'); ?> </p>
</p>

<fieldset id="fieldset-locale-switcher-public"><legend><?php echo __('Public front-end'); ?></legend>

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
        <p class="explanation"><?php echo __('The languages to use for the public front-end.'); ?></p>
        <div class="input-block">
            <?php echo $this->formMultiCheckbox('locale_switcher_locales', $locales, null, $codes); ?>
        </div>
    </div>
</div>

</fieldset>

<fieldset id="fieldset-locale-switcher-admin"><legend><?php echo __('Admin back-end'); ?></legend>

<div class="field">
    <div class="two columns alpha">
        <?php echo $this->formLabel('locale_switcher_locales_admin',
            __('Admin languages')); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('The languages to use for the admin back-end.'); ?></p>
        <div class="input-block">
            <?php echo $this->formMultiCheckbox('locale_switcher_locales_admin', $localesAdmin, null, $codes); ?>
        </div>
    </div>
</div>

</fieldset>
