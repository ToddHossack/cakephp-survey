CakePHP Surveys Plugin
=======================

[![Build Status](https://travis-ci.org/QoboLtd/cakephp-survey.svg?branch=master)](https://travis-ci.org/QoboLtd/cakephp-survey)
[![Latest Stable Version](https://poser.pugx.org/qobo/cakephp-survey/v/stable)](https://packagist.org/packages/qobo/cakephp-survey)
[![Total Downloads](https://poser.pugx.org/qobo/cakephp-survey/downloads)](https://packagist.org/packages/qobo/cakephp-survey)
[![Latest Unstable Version](https://poser.pugx.org/qobo/cakephp-survey/v/unstable)](https://packagist.org/packages/qobo/cakephp-survey)
[![License](https://poser.pugx.org/qobo/cakephp-survey/license)](https://packagist.org/packages/qobo/cakephp-survey)
[![codecov](https://codecov.io/gh/QoboLtd/cakephp-survey/branch/master/graph/badge.svg)](https://codecov.io/gh/QoboLtd/cakephp-survey)


About
-----

Template for building CakePHP 3 plugins.

Developed by [Qobo](https://www.qobo.biz), used in [Qobrix](https://qobrix.com).

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

```
Plugin::load('ADmad/Sequence');
```

Support
------
For bugs and feature requests, please use the [issues](https://github.com/QoboLtd/cakephp-survey/issues) section of this repository.
