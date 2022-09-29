Rollbar for Symfony 5+
=====================

|codecov| |Build Status| |Software License|

Rollbar full-stack error tracking for Symfony 5+

Description
-----------

Rollbar collects errors that happen in your application, notifies you,
and analyzes them so you can debug and fix them.

This plugin integrates Rollbar into your Symfony 5+ installation.

Find out `how Rollbar can help you decrease development and maintenance
costs`_.

See `real companies improving their development workflow thanks to
Rollbar`_.

Requirements
------------

This bundle depends on `symfony/monolog-bundle`_.

Installation
------------

1. Add ``Rollbar for Symfony`` with composer:
   ``composer require rollbar/rollbar-php-symfony-bundle``

2. Register Bundel: Only if you do NOT use Symfony Flex
   Register ``Rollbar\Symfony\RollbarBundle\RollbarBundle::class => ['all' => true],`` in
   ``config/bundles.php`` **after** registering the
   ``MonologBundle``
   (``Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],``).

3. Configure Rollbar and Monolog in your ``config/packages/[*]/rollbar.yml or monolog.yaml`.

.. code:: yaml


    rollbar:
      access_token: YourAccessToken
      environment: YourEnvironmentName
        
    monolog:
      handlers:
        rollbar:
          type: service
          id: Rollbar\Monolog\Handler\RollbarHandler
        

Usage
-----

Exception reporting
~~~~~~~~~~~~~~~~~~~

Symfony exceptions will be reported to Rollbar automatically after you
install and configure the bundle.

Manual reporting
~~~~~~~~~~~~~~~~

This bundle injects itself into the Monolog loggers. Thanks to this, all
of the Monolog logs will be automatically passed to Rollbar as well.

All you need to do is obtain the ``LoggerInterface`` implementation from
the service container.

\```php

namespace AppBundle:raw-latex:`\Controller`;

use
Sensio:raw-latex:`\Bundle`:raw-latex:`\FrameworkExtraBundle`:raw-latex:`\Configuration`:raw-latex:`\Route`;
use
Symfony:raw-latex:`\Bundle`:raw-latex:`\FrameworkBundle`:raw-latex:`\Controller`:raw-latex:`\Controller`;
use
Symfony:raw-latex:`\Component`:raw-latex:`\HttpFoundation`:raw-latex:`\Request`;
use Psr:raw-latex:`\Log`:raw-latex:`\LoggerInterface`;

class DefaultController extends Controller { /*\* \* @Route(“/”,
name=“homepage”) \*/ public function indexAction(Request $request,
LoggerInterface $logger) { $logger->error(‘Test info with person data’);

::

          // replace this example code with whatever you need
          return $this->rende

.. _how Rollbar can help you decrease development and maintenance costs: https://rollbar.com/features/
.. _real companies improving their development workflow thanks to Rollbar: https://rollbar.com/customers/
.. _symfony/monolog-bundle: https://github.com/symfony/monolog-bundle

.. |codecov| image:: https://codecov.io/gh/rollbar/rollbar-php-symfony-bundle/branch/master/graph/badge.svg
   :target: https://codecov.io/gh/rollbar/rollbar-php-symfony-bundle
.. |Build Status| image:: https://travis-ci.org/rollbar/rollbar-php-symfony-bundle.svg?branch=master
   :target: https://travis-ci.org/rollbar/rollbar-php-symfony-bundle
.. |Software License| image:: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
   :target: LICENSE