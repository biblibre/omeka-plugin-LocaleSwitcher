# Locale Switcher plugin for Omeka

This plugin provides a language switcher view helper to be used in themes.

It uses [flag-icon-css](http://flag-icon-css.lip.is/) (MIT License) for flags
icons

## Usage

1. Install the plugin
2. Configure the plugin:
  - Set if you want the switcher to be automatically displayed in the header.
  - Set which languages you would like to appear in the language switcher.
3. If you didn’t choose to append the switcher automatically, put the following
  code in your theme file `common/header.php` (or any other file): `<?php echo $this->localeSwitcher(); ?>`
