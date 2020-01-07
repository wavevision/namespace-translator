# Wavevision Namespace Translator

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

There are two resource loaders included by default:

- [Neon](./src/NamespaceTranslator/Loaders/Neon.php) – loads translations from `neon` files
- [TranslationClass](./src/NamespaceTranslator/Loaders/TranslationClass.php) – loads translations from PHP classes

Using PHP classes is useful when you want to refer to your translations using constants so changes in your resources get propagated throughout the whole project.

**Classes containing translations must implement `Wavevision\NamespaceTranslator\Resources\Translation`.**

You can also create and register your own loader, just make sure it implements `Wavevision\NamespaceTranslator\Loaders\Loader`.

## Examples

See [tests](./tests/NamespaceTranslatorTests/App) for example app implementation.
