<?php
namespace ZfcRbacTest\Service;

use ZfcRbac\Service\RbacOptions;

/**
 * @coversDefaultClass \ZfcRbac\Service\RbacOptions
 */
class RbacOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function getDefaults()
    {
        return array(
            'anonymousRole' => 'anonymous',
            'firewallRoute' => false,
            'firewallController' => true,
            'template' => 'error/403',
            'identityProvider' => 'Zend\Authentication\AuthenticationService',
            'enableLazyProviders' => true,
            'firewalls' => array(),
            'providers' => array()
        );
    }

    public function getDefaultsOverwrites()
    {
        return array(
            'anonymousRole' => 'testdata',
            'firewallRoute' => true,
            'firewallController' => false,
            'template' => 'testtemplate/403',
            'identityProvider' => 'Mynamespace\Authentication\AuthenticationService',
            'enableLazyProviders' => false,
            'firewalls' => array(
                'foo' => 'bar'
            ),
            'providers' => array(
                'bat' => 'baz'
            )
        );
    }

    /**
     * @covers ::getAnonymousRole
     * @covers ::getFirewallRoute
     * @covers ::getFirewallController
     * @covers ::getTemplate
     * @covers ::getIdentityProvider
     * @covers ::getEnableLazyProviders
     * @covers ::getFirewalls
     * @covers ::getProviders
     */
    public function testSaneDefaultsAreProperlyLoaded()
    {
        $defaults    = $this->getDefaults();
        $rbacOptions = new RbacOptions();

        $this->assertEquals($defaults['anonymousRole'], $rbacOptions->getAnonymousRole());
        $this->assertEquals($defaults['firewallRoute'], $rbacOptions->getFirewallRoute());
        $this->assertEquals($defaults['firewallController'], $rbacOptions->getFirewallController());
        $this->assertEquals($defaults['template'], $rbacOptions->getTemplate());
        $this->assertEquals($defaults['identityProvider'], $rbacOptions->getIdentityProvider());
        $this->assertEquals($defaults['enableLazyProviders'], $rbacOptions->getEnableLazyProviders());
        $this->assertEquals($defaults['firewalls'], $rbacOptions->getFirewalls());
        $this->assertEquals($defaults['providers'], $rbacOptions->getProviders());
    }

    /**
     * @covers ::getAnonymousRole
     * @covers ::getFirewallRoute
     * @covers ::getFirewallController
     * @covers ::getTemplate
     * @covers ::getIdentityProvider
     * @covers ::getEnableLazyProviders
     * @covers ::getFirewalls
     * @covers ::getProviders
     * @covers ::setAnonymousRole
     * @covers ::setFirewallRoute
     * @covers ::setFirewallController
     * @covers ::setTemplate
     * @covers ::setIdentityProvider
     * @covers ::setEnableLazyProviders
     * @covers ::setFirewalls
     * @covers ::setProviders
     */
    public function testSetterWillOverwriteDefaults()
    {
        $overwrites  = $this->getDefaultsOverwrites();
        $rbacOptions = new RbacOptions();
        $rbacOptions->setAnonymousRole($overwrites['anonymousRole']);
        $rbacOptions->setFirewallRoute($overwrites['firewallRoute']);
        $rbacOptions->setFirewallController($overwrites['firewallController']);
        $rbacOptions->setTemplate($overwrites['template']);
        $rbacOptions->setIdentityProvider($overwrites['identityProvider']);
        $rbacOptions->setEnableLazyProviders($overwrites['enableLazyProviders']);
        $rbacOptions->setFirewalls($overwrites['firewalls']);
        $rbacOptions->setProviders($overwrites['providers']);

        $this->assertEquals($overwrites['anonymousRole'], $rbacOptions->getAnonymousRole());
        $this->assertEquals($overwrites['firewallRoute'], $rbacOptions->getFirewallRoute());
        $this->assertEquals($overwrites['firewallController'], $rbacOptions->getFirewallController());
        $this->assertEquals($overwrites['template'], $rbacOptions->getTemplate());
        $this->assertEquals($overwrites['identityProvider'], $rbacOptions->getIdentityProvider());
        $this->assertEquals($overwrites['enableLazyProviders'], $rbacOptions->getEnableLazyProviders());
        $this->assertEquals($overwrites['firewalls'], $rbacOptions->getFirewalls());
        $this->assertEquals($overwrites['providers'], $rbacOptions->getProviders());
    }

    /**
     * @covers ::__construct
     * @covers ::getAnonymousRole
     * @covers ::getFirewallRoute
     * @covers ::getFirewallController
     * @covers ::getTemplate
     * @covers ::getIdentityProvider
     * @covers ::getEnableLazyProviders
     * @covers ::getFirewalls
     * @covers ::getProviders
     * @covers ::setAnonymousRole
     * @covers ::setFirewallRoute
     * @covers ::setFirewallController
     * @covers ::setTemplate
     * @covers ::setIdentityProvider
     * @covers ::setEnableLazyProviders
     * @covers ::setFirewalls
     * @covers ::setProviders
     */
    public function testDefaultsCanBeOverwrittenFromConstructor()
    {
        $overwrites  = $this->getDefaultsOverwrites();
        $rbacOptions = new RbacOptions($overwrites);

        $this->assertEquals($overwrites['anonymousRole'], $rbacOptions->getAnonymousRole());
        $this->assertEquals($overwrites['firewallRoute'], $rbacOptions->getFirewallRoute());
        $this->assertEquals($overwrites['firewallController'], $rbacOptions->getFirewallController());
        $this->assertEquals($overwrites['template'], $rbacOptions->getTemplate());
        $this->assertEquals($overwrites['identityProvider'], $rbacOptions->getIdentityProvider());
        $this->assertEquals($overwrites['enableLazyProviders'], $rbacOptions->getEnableLazyProviders());
        $this->assertEquals($overwrites['firewalls'], $rbacOptions->getFirewalls());
        $this->assertEquals($overwrites['providers'], $rbacOptions->getProviders());
    }

    /**
     * @covers ::setAnonymousRole
     * @covers ::setFirewallRoute
     * @covers ::setFirewallController
     * @covers ::setTemplate
     * @covers ::setIdentityProvider
     * @covers ::setEnableLazyProviders
     * @covers ::setFirewalls
     * @covers ::setProviders
     */
    public function testFluentInterface()
    {
        $overwrites  = $this->getDefaultsOverwrites();
        $rbacOptions = new RbacOptions();

        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setAnonymousRole($overwrites['anonymousRole'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setFirewallRoute($overwrites['firewallRoute'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setFirewallController($overwrites['firewallController'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setTemplate($overwrites['template'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setIdentityProvider($overwrites['identityProvider'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setEnableLazyProviders($overwrites['enableLazyProviders'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setFirewalls($overwrites['firewalls'])
        );
        $this->assertInstanceOf(
            'ZfcRbac\Service\RbacOptions',
            $rbacOptions->setProviders($overwrites['providers'])
        );
    }
}
