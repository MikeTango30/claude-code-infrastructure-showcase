<?php
/**
 * Acme_Example module registration
 *
 * @category  Acme
 * @package   Acme_Example
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Acme_Example',
    __DIR__
);
