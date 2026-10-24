<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sib
 * Date: 14.10.13
 * Time: 17:40
 * To change this template use File | Settings | File Templates.
 */

class CacherImpl implements Zend_Cache_Backend_Interface {

    protected mixed $callback;

    public function __construct($callback) {
        if ( is_callable($callback) ) {
            $this->callback = $callback;
        } else {
            $this->callback = array($this, 'callbackDummy');
        }
    }

    // Parameters are left untyped and only return types are declared, so the class
    // stays compatible both with the typed Zend_Cache_Backend_Interface bundled here
    // and with an untyped one (Zend Framework 1) loaded by the application before us.

    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {}

    public function remove($id): bool
    {
        return false;
    }

    public function test($id): int|false
    {
        return false;
    }

    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        return call_user_func($this->callback, $id, $data);
    }

    public function load($id, $doNotTestCacheValidity = false): string|false
    {
        $data = call_user_func($this->callback, $id);
        return is_string($data) ? $data : false;
    }

    public function setDirectives($directives) {}

    protected function callbackDummy($k, $v = null)
    {
        return null;
    }

} // CacherImpl class