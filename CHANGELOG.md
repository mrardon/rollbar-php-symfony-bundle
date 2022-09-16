## [v5.0.0] - 2019-01-02
* Added Symfony 6 support, and update tests by @art-cg in #73
* Added GitHub actions by @art-cg in #74
* Feature/remove unused language version by @Chris53897 in #77
* Fixed failing CI by @danielmorell in #78
* Fixed #51 To make catch statement broader by @danielmorell in #80
* Added CHANGELOG.md by @danielmorell in #81

## [v4.0.0] - 2020-02-15
* Update to symfony5 #61

## [v3.1.2] - 2019-01-02
* #39 Person data not loaded TokenStorage as documented

## [v3.1.1] - 2018-12-16
* #38: phpunit exits with a non-zero status
* Update README.md

## [v3.1.0] - 2018-10-16
* #34 Change the name of the report to rollbar-php-symfony-bundle
* #24 Point docs from README to Rollbar's site
* #37 Remove exception listeners, rely on Symfony...::logKernelException() to log uncaught exceptions
* readme updates

## [v3.0.0] - 2018-10-10
* Update README.md by @jessewgibbs in #30
* Add Symfony 4 support and ability to configure all Rollbar parameters by @javer in #27

## [v2.0.0] - 2018-04-17
* Major refactoring of the directory structure following Symfony's [best practices](http://symfony.com/doc/3.4/bundles/best_practices.html).
* Updated the `rollbar/rollbar` dependency to use the latest release.
* Added support for manual logging through the `LoggerInterface` injected logger.
* Utilized Symfony's Monolog Bundle to tap into Symfony's common logging mechanism.
* Updated `README.md` and `Resources/doc/index.rst`.
* Added Symfony's logged in user tracking by default.
* Added support for `person_fn` for modifying the user tracking data.
* Refactored the configuration options structure for `app/config/config.yml`.
* Added passing Rollbar's default config values as they are defined in `rollbar/rollbar` dependency instead of redefining them in the bundle.

## [v1.0.2] - 2018-02-16
* update: allow to work with php7

## [v1.0.1] - 2017-08-09
* Update ExceptionListener.php fix function access level

## [v1.0.0] - 2017-05-08
* coverage


[v5.0.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v4.0.0...v5.0.0
[v4.0.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v3.1.2...v4.0.0
[v3.1.2]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v3.1.1...v3.1.2
[v3.1.1]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v3.1.0...v3.1.1
[v3.1.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v3.0.0...v3.1.0
[v3.0.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v2.0.0...v3.0.0
[v2.0.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v1.0.2...v2.0.0
[v1.0.2]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/rollbar/rollbar-php-symfony-bundle/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/rollbar/rollbar-php-symfony-bundle/releases/tag/v1.0.0