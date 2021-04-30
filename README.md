<p align="center"><a href="https://github.com/wavevision"><img alt="Wavevision s.r.o." src="https://wavevision.com/images/wavevision-logo.png" width="120" /></a></p>
<h1 align="center">Namespace Translator</h1>

[![Build Status](https://travis-ci.org/wavevision/namespace-translator.svg?branch=master)](https://travis-ci.org/wavevision/namespace-translator)
[![Coverage Status](https://coveralls.io/repos/github/wavevision/namespace-translator/badge.svg?branch=master)](https://coveralls.io/github/wavevision/namespace-translator?branch=master)
[![PHPStan](https://img.shields.io/badge/style-level%20max-brightgreen.svg?label=phpstan)](https://github.com/phpstan/phpstan)

Translations manager for Nette framework using [contributte/translation](https://github.com/contributte/translation). It allows you
to have your translation files located where they are really used (e.g. next to a component or a model). 

**No more global translations mess!** 💪

## Installation

Via [Composer](https://getcomposer.org)

```bash
composer require wavevision/namespace-translator
```

> **Note**: This will automatically install `contributte/translation` too.

## Usage

Register required extensions in your project config:

```neon
extensions:
	translation: Contributte\Translation\DI\TranslationExtension
	namespaceTranslator: Wavevision\NamespaceTranslator\DI\Extension
```

You can configure `namespaceTranslator` as follows *(default values)*:

```neon
namespaceTranslator:
    dirNames: # names of dirs in which namespace translations will reside
        - translations
        - Translations
    loaders: # namespace translations loaders
        neon: Wavevision\NamespaceTranslator\Loaders\Neon
        php: Wavevision\NamespaceTranslator\Loaders\TranslationClass
        flatJson: Wavevision\NamespaceTranslator\Loaders\FlatJson
```
> **Note:** Refer to [Contributte docs](https://contributte.org/packages/contributte/translation.html#configuration) 
> for further info about configuring `translation`.

With this setup, you can start managing your translations like a boss 🤵.

The best thing is the translator keeps full backwards compatibility with `contributte/translation` setup, 
so you can still use your translations as you are used to and migrate to namespaces step-by-step.
Any translation not found by namespace translator will fallback to `translation` resources.

### Translated components

Your components (or presenters) can use `Wavevision\NamespaceTranslator\TranslatedComponent` trait.

**Make sure your component has `inject` allowed.**

The trait will provide your component class / template with `$translator` property / variable. 
The translator will look for resources in configured dir names inside component's namespace.

> **Note**: The `translate` macro in component templates will, of course, work too.

### Translated models

Even your services can use the translator. Simply use `Wavevision\NamespaceTranslator\NamespaceTranslator`.

**Make sure your service is registered with `inject: true` in your config.**

After that, it works the same as with your components.

## Loaders

There are three resource loaders included by default:

- [Neon](./src/NamespaceTranslator/Loaders/Neon.php) – loads translations from `neon` files
- [TranslationClass](./src/NamespaceTranslator/Loaders/TranslationClass.php) – loads translations from PHP classes
- [FlatJson](./src/NamespaceTranslator/Loaders/FlatJson.php) - loads translations from flat (no nesting) `json` files

Using PHP classes is useful when you want to refer to your translations using constants so changes in your resources get propagated throughout the whole project.

**Classes containing translations must implement `Wavevision\NamespaceTranslator\Resources\Translation`.**

You can also create and register your own loader, just make sure it implements `Wavevision\NamespaceTranslator\Loaders\Loader`.

## Export \ Import

For exporting \ importing translations to \ from CSV or GoogleSheet (or both) update configuration file

```neon
namespaceTranslator:
	transfer:
		google:
			credentials: credentials.json
			sheetId: googleSheetId
			parts:
				- directory: %vendorDir%/../App/AdminModule
				  tabName: admin-module
		csv:
			parts:
				- directory: %vendorDir%/../App/FrontModule
				  filename: %vendorDir%/../temp/front-module.csv
```

Set locales whitelist from [contributte/translation](https://contributte.org/packages/contributte/translation.html#configuration). Whitelist is used for creating translation columns in export.

Run command to export translations

```bash
php {bin/console} namespace-translator:export
``` 

Update translations, then run command to import them

```bash
php {bin/console} namespace-translator:import
``` 

### Google Sheet

For accessing Google sheet you will need [server-to-server API key](https://developers.google.com/sheets/api/guides/authorizing?authuser=1#APIKey) and [sheet ID](https://support.asinzen.com/article/516-how-do-i-get-my-google-spreadsheet-id).
 

### Export example

From files

```neon
# file translations/en.neon
hello: Hello %name%
```
```neon
# file translations/de.neon
hello: Hallo %name%
```
```php
<?php declare(strict_types=1); //file Translations/Cs.php

use Wavevision\NamespaceTranslator\Resources\Translation;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\Message;

class Cs implements Translation
{
    public const HELLO = 'hello';

    public const NAME = 'name';

    public static function define() : array
    {
        return [self::HELLO => Message::create('Hello %s', self::NAME)]; 
    }
}
```

export should look like this

```csv

file,           key,          en,                  de,                  format
/translations/, hello,        Hello %name%,        Hallo %name%,        neon
/Translations/, c:self-HELLO, Hello {c:self-Name}, ,                    php
```

columns `file`, `key` and `format` shouldn't be modified. 

For details see example [export.csv](./tests/NamespaceTranslatorTests/Transfer/Export/Writters/export.csv).

### Limitation of TranslationClass

* Define function must have only one statement (`return [...]`)
* Array keys must be strings or class constants
* Array values must be arrays, strings or `Message::create()` function calls
* Php files should be linted after import

## Examples

See [tests](./tests/NamespaceTranslatorTests/App) for example app implementation.
