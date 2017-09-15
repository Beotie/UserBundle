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
 * @category DependencyInjection
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\UserBundle\Tests\Model\Builder;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\UserBundle\Model\Builder\RoleBuilder;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Role builder test
 *
 * This class is used to validate the RoleBuilder methods
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleBuilderTest extends TestCase
{
    /**
     * Provide setter arguments
     *
     * This method returna set of method, property and value to validate the RoleBuilder setters
     *
     * @return [[string]]
     */
    public function provideSetterArguments()
    {
        return [
            ['setLabel', 'label', 'My label'],
            ['setLongLabel', 'longLabel', 'My long label'],
            ['setDescription', 'description', 'My description'],
            ['remove', 'deletionDate', new \DateTime()]
        ];
    }

    /**
     * Test setter
     *
     * This method validate the RoleBuilder setters
     *
     * @param string $method   The method name
     * @param string $property The storage proeprty name
     * @param mixed  $value    The value to use as setter argument
     *
     * @dataProvider provideSetterArguments
     * @return       void
     */
    public function testSetter(string $method, string $property, $value = null)
    {
        $instance = new RoleBuilder();

        $instance->$method($value);

        $reflexStore = new \ReflectionProperty(RoleBuilder::class, 'properties');
        $reflexStore->setAccessible(true);

        $properties = $reflexStore->getValue($instance);

        $msg = 'The RoleBuilder::$properties is expected to be array after RoleBuilder::%s call';
        $this->assertTrue(is_array($properties), sprintf($msg, $method));

        $msg = 'The RoleBuilder::$properties is expected to have key "%s" after RoleBuilder::%s call';
        $this->assertArrayHasKey($property, $properties, sprintf($msg, $property, $method));

        $msg = 'The RoleBuilder::$properties[%s] is expected to store the RoleBuilder::%s argument';
        $this->assertSame($value, $properties[$property], sprintf($msg, $property, $method));
    }

    /**
     * Test deletion
     *
     * This method validate the RoleBuilder deletion feature
     *
     * @return void
     */
    public function testDeletion()
    {
        $instance = new RoleBuilder();

        $reflexStore = new \ReflectionProperty(RoleBuilder::class, 'properties');
        $reflexStore->setAccessible(true);
        $properties = $reflexStore->getValue($instance);

        $this->assertArrayNotHasKey(
            'deletionDate',
            $properties,
            'RoleBuilder::$properties["deletionDate"] is expected to not be set'
        );

        $instance->remove();
        $properties = $reflexStore->getValue($instance);
        $this->assertArrayHasKey(
            'deletionDate',
            $properties,
            'RoleBuilder::$properties["deletionDate"] is expected to be set'
        );
        $this->assertInstanceOf(
            \DateTime::class,
            $properties['deletionDate'],
            'RoleBuilder::$properties["deletionDate"] is expected to be an instance of \dateTime'
        );

        $instance->restore();
        $properties = $reflexStore->getValue($instance);
        $this->assertArrayHasKey(
            'deletionDate',
            $properties,
            'RoleBuilder::$properties["deletionDate"] is expected to be set'
        );
        $this->assertNull(
            $properties['deletionDate'],
            'RoleBuilder::$properties["deletionDate"] is expected to be null'
        );
    }

    /**
     * RoleBuilder getter provider
     *
     * This method return a set of initialisation property, method and constraint to validate RoleBuilder getter
     *
     * @return [[array, string, Constraint]]
     */
    public function roleBuilderGetterProvider()
    {
        return [
            [['deletionDate' => new \DateTime()], 'isDeleted', $this->isTrue()],
            [['deletionDate' => null], 'isDeleted', $this->isFalse()],
            [[], 'isDeleted', $this->isFalse()],
            [[], 'getLabel', $this->isNull()],
            [['label' => 'My label'], 'getLabel', $this->equalTo('My label')],
            [[], 'getLongLabel', $this->isNull()],
            [['longLabel' => 'My long label'], 'getLongLabel', $this->equalTo('My long label')],
            [[], 'getDescription', $this->isNull()],
            [['description' => 'My description'], 'getDescription', $this->equalTo('My description')]
        ];
    }

    /**
     * Test getter
     *
     * This method validate the RoleBuilder getters
     *
     * @param array      $properties The property initializer
     * @param string     $method     The getter method name
     * @param Constraint $validator  The getter result constraint
     *
     * @dataProvider roleBuilderGetterProvider
     * @return       void
     */
    public function testGetter(array $properties, string $method, Constraint $validator)
    {
        $instance = new RoleBuilder();

        $reflexStore = new \ReflectionProperty(RoleBuilder::class, 'properties');
        $reflexStore->setAccessible(true);
        $reflexStore->setValue($instance, $properties);

        $this->assertThat(
            call_user_func([$instance, $method]),
            $validator,
            sprintf(
                'The RoleBuilder::%s is expected to return a value, accordingly with the given constraint',
                $method
            )
        );
    }

    /**
     * Role result provider
     *
     * This method return a set of property initializer and getter expectation to validate the RoleBuilder::getRole
     * method
     *
     * @return [[array, array]]
     */
    public function roleResultProvider()
    {
        return [
            [
                [
                    'label' => 'My label',
                    'longLabel' => 'My long label',
                    'description' => 'My description'
                ],
                [
                    'getLabel' => $this->equalTo('My label'),
                    'getLongLabel' => $this->equalTo('My long label'),
                    'getDescription' => $this->equalTo('My description'),
                    'getCreationDate' => $this->isInstanceOf(\DateTime::class),
                    'getDeletionDate' => $this->isNull()
                ]
            ],
            [
                [
                    'label' => 'My label',
                    'longLabel' => 'My long label',
                    'description' => 'My description',
                    'deletionDate' => new \DateTime()
                ],
                [
                    'getLabel' => $this->equalTo('My label'),
                    'getLongLabel' => $this->equalTo('My long label'),
                    'getDescription' => $this->equalTo('My description'),
                    'getCreationDate' => $this->isInstanceOf(\DateTime::class),
                    'getDeletionDate' => $this->isInstanceOf(\DateTime::class)
                ]
            ]
        ];
    }

    /**
     * Test getRole
     *
     * This method validate the RoleBuilder::getRole method
     *
     * @param array $properties  The properties initializer
     * @param array $constraints The role getter constraints
     *
     * @dataProvider roleResultProvider
     * @return       void
     */
    public function testGetRole(array $properties, array $constraints)
    {
        $instance = new RoleBuilder();

        $reflexStore = new \ReflectionProperty(RoleBuilder::class, 'properties');
        $reflexStore->setAccessible(true);
        $reflexStore->setValue($instance, $properties);

        $role = $instance->getRole();

        foreach ($constraints as $getter => $constraint) {
            $this->assertThat(
                call_user_func([$role, $getter]),
                $constraint,
                sprintf(
                    'The RoleBuilder::%s is expected to return a value, accordingly with the given constraint',
                    $getter
                )
            );
        }
    }

    /**
     * Role error properties provider
     *
     * This method return a set of property initializer to validate RoleBuilder::getRole method in case
     * of unwritable property
     *
     * @return [[array]]
     */
    public function roleErrorPropertiesProvider()
    {
        return [
            [['unkownProperty' => false]],
            [['id' => 'false']]
        ];
    }

    /**
     * Test getRole error
     *
     * This method validate the RoleBuilder::getRole in case of unwritable property
     *
     * @param array $properties The properties initializer
     *
     * @dataProvider roleErrorPropertiesProvider
     * @return       void
     */
    public function testGetRoleError(array $properties)
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(sprintf('Property %s is not writable', array_keys($properties)[0]));
        $instance = new RoleBuilder();

        $reflexStore = new \ReflectionProperty(RoleBuilder::class, 'properties');
        $reflexStore->setAccessible(true);
        $reflexStore->setValue($instance, $properties);

        $instance->getRole();
    }
}
