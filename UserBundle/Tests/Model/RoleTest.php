<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Tests\Model;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use PHPUnit\Framework\Constraint\Constraint;
use Beotie\UserBundle\Model\Role;

/**
 * Role test
 *
 * This class is used to validate the Role model
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleTest extends TestCase
{
    /**
     * Role instance
     *
     * This property store the role instance to be used in the tests
     *
     * @var Role
     */
    private $roleInstance;

    /**
     * Set up
     *
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $roleReflection = new \ReflectionClass(Role::class);
        $this->roleInstance = $roleReflection->newInstanceWithoutConstructor();
    }

    /**
     * Test constructor
     *
     * This method validate the protected state of the Role::__construct() method
     *
     * @return void
     */
    public function testConstructor()
    {
        $roleReflection = new \ReflectionClass(Role::class);
        $this->assertTrue(
            $roleReflection->getMethod('__construct')->isProtected(),
            'Role::__construct() is expected to be protected'
        );
    }

    /**
     * Initial content provider
     *
     * This method return the validation  constraint to validate the initial Role content
     *
     * @return [[string, PHPUnit\Framework\Constraint\IsNull|PHPUnit\Framework\Constraint\IsInstanceOf]]
     */
    public function initialContentProvider()
    {
        return [
            ['id', $this->isNull()],
            ['label', $this->isNull()],
            ['longLabel', $this->isNull()],
            ['description', $this->isNull()],
            ['locale', $this->isNull()],
            ['deletionDate', $this->isNull()],
            ['creationDate', $this->isNull()],
            ['lastUpdateDate', $this->isNull()]
        ];
    }

    /**
     * Test initial content
     *
     * This method validate the initial content of the Role class
     *
     * @param string     $property   The property name to validate
     * @param Constraint $constraint The validation constraint
     *
     * @dataProvider initialContentProvider
     * @return       void
     */
    public function testInitialContent(string $property, Constraint $constraint)
    {
        $this->assertThat(
            $this->getObjectAttribute($this->roleInstance, $property),
            $constraint,
            sprintf('Role::%s is expected to be in agreement with the given constraint', $property)
        );
    }

    /**
     * Getter provider
     *
     * This method provide a set of fixture to validate the Role getter methods
     *
     * @return [[string, string|\DateTime, string]]
     */
    public function getterProvider()
    {
        return [
            ['getId', 'aze-rty-uio', 'id'],
            ['getId', 'pqs-dfg-hjk', 'id'],
            ['getLabel', 'ROLE_LABEL', 'label'],
            ['getLabel', 'ROLE_USER', 'label'],
            ['getLongLabel', 'base role label', 'longLabel'],
            ['getLongLabel', 'base role user', 'longLabel'],
            ['getDescription', 'base role label description', 'description'],
            ['getDescription', 'base role user description', 'description'],
            ['getLocale', 'en_en', 'locale'],
            ['getLocale', 'de_de', 'locale'],
            ['getDeletionDate', new \DateTime(), 'deletionDate'],
            ['getDeletionDate', new \DateTime('-1 week'), 'deletionDate'],
            ['getCreationDate', new \DateTime(), 'creationDate'],
            ['getCreationDate', new \DateTime('-1 week'), 'creationDate'],
            ['getLastUpdateDate', new \DateTime(), 'lastUpdateDate'],
            ['getLastUpdateDate', new \DateTime('-1 week'), 'lastUpdateDate']
        ];
    }

    /**
     * Test getter
     *
     * This method validate the Role getter methods.
     *
     * @param string $method   The method used as getter
     * @param mixed  $value    The value to inject in the instance
     * @param string $property The property name to set
     *
     * @return       void
     * @dataProvider getterProvider
     */
    public function testGetter(string $method, $value, string $property)
    {
        $label = new \ReflectionProperty(Role::class, $property);
        $label->setAccessible(true);
        $label->setValue($this->roleInstance, $value);

        $this->assertEquals(
            $value,
            $this->roleInstance->$method(),
            sprintf('Role::%s() is expected to return the Role::%s content', $method, $property)
        );
    }

    /**
     * Setter provider
     *
     * This method provide a set of fixture to validate the Role setter methods
     *
     * @return [[string, string|\DateTime, string]]
     */
    public function setterProvider()
    {
        return [
            ['setLabel', 'ROLE_LABEL', 'label'],
            ['setLabel', 'ROLE_USER', 'label'],
            ['setLongLabel', 'base role label', 'longLabel'],
            ['setLongLabel', 'base role user', 'longLabel'],
            ['setDescription', 'base role label description', 'description'],
            ['setDescription', 'base role user description', 'description'],
            ['setLocale', 'en_en', 'locale'],
            ['setLocale', 'de_de', 'locale'],
            ['setDeletionDate', new \DateTime(), 'deletionDate'],
            ['setDeletionDate', new \DateTime('-1 week'), 'deletionDate']
        ];
    }

    /**
     * Test setter
     *
     * This method validate the Role setter methods.
     *
     * @param string $method   The method to use as setter
     * @param mixed  $value    The value to set in the instance
     * @param string $property The property where the value must be injected
     *
     * @return       void
     * @dataProvider setterProvider
     */
    public function testSetter(string $method, $value, string $property)
    {
        $this->assertSame(
            $this->roleInstance,
            $this->roleInstance->$method($value),
            sprintf('Role::%s() is expected to be fluent', $method)
        );

        $this->assertSame(
            $value,
            $this->getObjectAttribute($this->roleInstance, $property),
            sprintf('Role::%s() is expected to update the Role::%s property', $method, $property)
        );
    }

    /**
     * Unexisting method provider
     *
     * This method return a set of method name that must not exist for security purpose
     *
     * @return [[string]]
     */
    public function unexistingMethodProvider()
    {
        return [['setId', 'setCreationDate', 'setLastUpdateDate']];
    }

    /**
     * Test method not exist
     *
     * This method validate that a method does not exist
     *
     * @param string $method The method name to validate
     *
     * @return       void
     * @dataProvider unexistingMethodProvider
     */
    public function testSetterNotExist(string $method)
    {
        $this->assertFalse(
            method_exists($this->roleInstance, $method),
            sprintf('The Role::%s() is not expected to exist', $method)
        );
    }

    /**
     * Provide setter type
     *
     * This method return a set of types to validate the Role setter type hint
     *
     * @return [[string, bool, mixed]]
     */
    public function provideSetterType()
    {
        $types = ['string', 124, true, false, null, new \stdClass(), new \DateTime()];
        $errors = [
            [false, true, true, true, true, true, true],
            [false, true, true, true, true, true, true],
            [false, true, true, true, true, true, true],
            [false, true, true, true, true, true, true],
            [true, true, true, true, true, true, false]
        ];
        $setters = ['setLabel', 'setLongLabel', 'setDescription', 'setLocale', 'setDeletionDate'];

        $result = [];
        $typeCount = count($types);
        foreach ($setters as $index => $setter) {
            for ($iteration = 0; $iteration < $typeCount; $iteration++) {
                $result[] = [$setter, $errors[$index][$iteration], $types[$iteration]];
            }
        }

        return $result;
    }

    /**
     * Test setter type
     *
     * This method validate the Role setter type hint.
     *
     * @param string $method The method to validate
     * @param bool   $error  The expected error state
     * @param mixed  $value  The setter argument value
     *
     * @return       void
     * @dataProvider provideSetterType
     */
    public function testSetterType(string $method, bool $error, $value)
    {
        if ($error) {
            $this->expectException(\TypeError::class);
        }

        $this->roleInstance->$method($value);

        $this->assertFalse($error, sprintf('The Role::%s() is expected to throw exception', $method));
    }
}
