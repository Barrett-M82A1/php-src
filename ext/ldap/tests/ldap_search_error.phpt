--TEST--
ldap_search() - operation that should fail
--CREDITS--
Davide Mendolia <idaf1er@gmail.com>
Belgian PHP Testfest 2009
--SKIPIF--
<?php require_once __DIR__ .'/skipif.inc'; ?>
<?php require_once __DIR__ .'/skipifbindfailure.inc'; ?>
--FILE--
<?php
include "connect.inc";

$link = ldap_connect($host, $port);

$dn = "dc=not-found,$base";
$filter = "(dc=*)";

$result = ldap_search($link, $dn, $filter);
var_dump($result);

$result = ldap_search($link, $dn, $filter, array(1 => 'top'));
var_dump($result);

try {
    ldap_search(array(), $dn, $filter, array('top'));
} catch (ValueError $exception) {
    echo $exception->getMessage() . "\n";
}

try {
    ldap_search(array($link, $link), array($dn), $filter, array('top'));
} catch (ValueError $exception) {
    echo $exception->getMessage() . "\n";
}

try {
    ldap_search(array($link, $link), $dn, array($filter), array('top'));
} catch (ValueError $exception) {
    echo $exception->getMessage() . "\n";
}

?>
--EXPECTF--
Warning: ldap_search(): Search: No such object in %s on line %d
bool(false)

Warning: ldap_search(): Array initialization wrong in %s on line %d
bool(false)
ldap_search(): Argument #1 ($link_identifier) cannot be empty
ldap_search(): Argument #2 ($base_dn) must have the same number of elements as the links array
ldap_search(): Argument #3 ($filter) must have the same number of elements as the links array
