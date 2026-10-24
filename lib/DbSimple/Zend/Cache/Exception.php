<?php
/**
 * Minimal replacement of Zend_Cache_Exception for the Zend_Cache copy bundled with DbSimple.
 * Loaded only when the application does not provide its own Zend_Cache_Exception
 * (in Zend Framework 1 it extends Zend_Exception, which is not bundled here).
 */
class Zend_Cache_Exception extends Exception
{
}
