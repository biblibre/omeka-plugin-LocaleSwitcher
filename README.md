Locale Switcher (plugin for Omeka)
==================================

[Locale Switcher] provides a language switcher view helper to be used in themes.
Furthermore, the switcher can be included automatically in the user bar in the
admin back-end.

It uses [flag-icon-css] for flags icons.


Installation
------------

Uncompress files and rename plugin folder `LocaleSwitcher`.

Then install it like any other Omeka plugin and follow the config instructions.


Usage
-----

The configuration is simple.

- Set if you want the switcher to be automatically displayed in the header.
- Set which languages you would like to appear in the language switcher in
  public front-end.
- Set which languages you would like to appear in the language switcher in
  admin back-end.

If you didn’t choose to append the switcher automatically, put the following
code in your theme file `common/header.php` (or any other file):

```php
<?php echo $this->localeSwitcher(); ?>
```


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [plugin issues] page on GitHub.


License
-------

### Plugin

This plugin is published under [GNU/GPL v3].

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

### Libraries

The flag icons are released under the MIT license.


Copyright
---------

* Copyright 2017 BibLibre (see [BibLibre] on Github)
* Copyright Daniel Berthereau, 2018 (see [Daniel-KM] on GitHub)


[Locale Switcher]: https://github.com/Daniel-KM/Omeka-plugin-LocaleSwitcher
[Omeka]: https://omeka.org
[flag-icon-css]: http://flag-icon-css.lip.is/
[plugin issues]: https://github.com/Daniel-KM/Omeka-plugin-LocaleSwitcher/issues
[GNU/GPL v3]: https://www.gnu.org/licenses/gpl-3.0.html
[BibLibre]: https://github.com/BibLibre
[Daniel-KM]: https://github.com/Daniel-KM "Daniel Berthereau"
