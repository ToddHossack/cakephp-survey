CakePHP Surveys Plugin
=======================

[![Build Status](https://travis-ci.org/QoboLtd/cakephp-survey.svg?branch=master)](https://travis-ci.org/QoboLtd/cakephp-survey)
[![Latest Stable Version](https://poser.pugx.org/qobo/cakephp-survey/v/stable)](https://packagist.org/packages/qobo/cakephp-survey)
[![Total Downloads](https://poser.pugx.org/qobo/cakephp-survey/downloads)](https://packagist.org/packages/qobo/cakephp-survey)
[![Latest Unstable Version](https://poser.pugx.org/qobo/cakephp-survey/v/unstable)](https://packagist.org/packages/qobo/cakephp-survey)
[![License](https://poser.pugx.org/qobo/cakephp-survey/license)](https://packagist.org/packages/qobo/cakephp-survey)
[![codecov](https://codecov.io/gh/QoboLtd/cakephp-survey/branch/master/graph/badge.svg)](https://codecov.io/gh/QoboLtd/cakephp-survey)
[![BCH compliance](https://bettercodehub.com/edge/badge/QoboLtd/cakephp-survey?branch=master)](https://bettercodehub.com/)


About
-----

Template for building CakePHP 3 plugins.

This plugin is developed by [Qobo](https://www.qobo.biz) for [Qobrix](https://qobrix.com).  It can be used as standalone CakePHP plugin, or as part of the [project-template-cakephp](https://github.com/QoboLtd/project-template-cakephp) installation.

Usage
-----

Pull the template code into your plugin:

```
composer require qobo/cakephp-survey
```


Setup
-----

Load plugin

```
bin/cake plugin load --bootstrap --routes Qobo/Survey
```

or manually add it to `config/bootstrap.php`:

```
Plugin::load('Qobo/Survey', ['routes' => true, 'bootstrap' => true]);
```

Survey plugin also uses `ADmad/cakephp-sequence` plugin for Questions/Answers ordering as part of `qobo/cakephp-utils` setup.
In order to enable that feature don't forget to load it in `APP/config/bootstrap.php`:

```php
Plugin::load('ADmad/Sequence');
```

In order for the plugin to work correctly, you should also run DB migrations:

```bash
./bin/cake migrations migrate --plugin Qobo/Survey
```

Surveys plugin is designed for the systems, that use authorised users, so you might run into few glitches on a plain CakePHP installation if you don't have native `AuthComponent` enabled.

We use `qobo/cakephp-utils` plugin as a generic toolset provider. It contains `CakeDC/Users` plugin to handle [authentication/authorisation for the users](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md).

The plugin was designed with AdminLTE theme in mind, so you can enable it as well using:

```php
//inside config/bootstrap.php add:
Plugin::load('AdminLTE', ['bootstrap' => true, 'routes' => true]);
```

```php
//in your AppController.php:
public function beforeFilter(Event $event)
{
  $this->viewBuilder()->theme('AdminLTE');
  $this->viewBuilder()->layout('adminlte'); // copy adminlte.ctp to your src/Template/Layout/ directory from the plugin.
}
```

**Note:** Qobo provides `qobo/project-template-cakephp` [repository](https://github.com/QoboLtd/project-template-cakephp) where you can find some of the company plugins already pre-configured and used.


Support
------
For bugs and feature requests, please use the [issues](https://github.com/QoboLtd/cakephp-survey/issues) section of this repository.
