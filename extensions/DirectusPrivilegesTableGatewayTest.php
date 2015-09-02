<?php

use Directus\Db\TableGateway\DirectusPrivilegesTableGateway;
use Directus\Bootstrap;

class DirectusPrivilegesTableGatewayTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        define('DIRECTUS_ENV', '');
    }

    public function testFillable()
    {
        /**
         * @var \Zend\Db\Adapter
         */
        $ZendDb = Bootstrap::get('ZendDb');

        /**
         * @var \Directus\Acl
         */
        $acl = Bootstrap::get('acl');
        $privileges = new DirectusPrivilegesTableGateway($acl, $ZendDb);

        $data = $privileges->getFillableFields(array('group_id', 'alter_view', 'Foo_Bar'));
        $this->assertCount(2, $data);
        $this->assertContains(array('group_id', 'alter_view'), $data);
    }
}