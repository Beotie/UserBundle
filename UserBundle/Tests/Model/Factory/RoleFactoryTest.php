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
namespace Tests\Model\Factory;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\UserBundle\Model\Factory\RoleFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;
use Beotie\UserBundle\Model\Builder\RoleBuilderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Beotie\UserBundle\Model\Builder\RoleBuilder;
use Beotie\UserBundle\Model\Role;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Beotie\UserBundle\Exception\UnvalidatedRoleDto;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Role factory test
 *
 * This class is used to validate the RoleFactory methods
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleFactoryTest extends TestCase
{
    /**
     * Provide validator
     *
     * This method provide a set of validator with it's validation state result
     *
     * @return [[\PHPUnit_Framework_MockObject_MockObject, bool]]
     */
    public function provideValidator()
    {
        return [
            [$this->getValidator(0), true],
            [$this->getValidator(1), false]
        ];
    }

    /**
     * Test isValid
     *
     * This method validate the RoleFactory::isValid method
     *
     * @param \PHPUnit_Framework_MockObject_MockObject $validator The validator instance
     * @param bool                                     $result    The validator instance validation state result
     *
     * @return       void
     * @dataProvider provideValidator
     */
    public function testIsValid(\PHPUnit_Framework_MockObject_MockObject $validator, bool $result)
    {
        $instance = new RoleFactory($validator);

        $this->assertEquals($result, $instance->isValid(new RoleDTO()));
    }

    /**
     * Test getBuilder
     *
     * This method validate the RoleFactory::getRoleBuilder method
     *
     * @return void
     */
    public function testGetBuilder()
    {
        $validator = $this->createMock(ValidatorInterface::class);

        $instance = new RoleFactory($validator);
        $this->assertInstanceOf(RoleBuilderInterface::class, $instance->getRoleBuilder());

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $instance = new RoleFactory($validator, $cache);
        $roleBuilder = $instance->getRoleBuilder();
        $this->assertInstanceOf(RoleBuilderInterface::class, $roleBuilder);

        $reflex = new \ReflectionProperty(RoleBuilder::class, 'cachePool');
        $reflex->setAccessible(true);

        $this->assertSame($cache, $reflex->getValue($roleBuilder));
    }

    /**
     * Provide role dto
     *
     * This method return a set of initializator and constraints to build and validate
     * the RoleFactory::buildRole method
     *
     * @return [[array, array]]
     */
    public function provideRoleDto()
    {
        $date = new \DateTime();

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
                    'getDeletionDate' => $this->isNull()
                ]
            ],
            [
                [
                    'label' => 'My label',
                    'longLabel' => 'My long label',
                    'description' => 'My description',
                    'deletionDate' => $date
                ],
                [
                    'getLabel' => $this->equalTo('My label'),
                    'getLongLabel' => $this->equalTo('My long label'),
                    'getDescription' => $this->equalTo('My description'),
                    'getDeletionDate' => $this->identicalTo($date)
                ]
            ]
        ];
    }

    /**
     * Test buildRole
     *
     * This method validate the RoleFactory::buildRole method
     *
     * @param array $initializator The RoleDTO initialisation array
     * @param array $constraints   The Role validation constraints
     *
     * @dataProvider provideRoleDto
     * @return       void
     */
    public function testBuildRole(array $initializator, array $constraints)
    {
        $instance = new RoleFactory($this->getValidator(0));

        $dto = new RoleDTO();
        foreach ($initializator as $property => $value) {
            $dto->{$property} = $value;
        }

        $role = $instance->buildRole($dto);

        $this->assertInstanceOf(Role::class, $role);

        foreach ($constraints as $method => $constraint) {
            $this->assertThat($role->{$method}(), $constraint);
        }
    }

    /**
     * Test buildRole error
     *
     * This method validate the RoleFactory::buildRole method with unvalid RoleDTO
     *
     * @return void
     */
    public function testBuildRoleError()
    {
        $this->expectException(UnvalidatedRoleDto::class);
        $this->expectExceptionMessage('The given role dto is not valid');

        $violation = $this->createMock(ConstraintViolationInterface::class);
        $violation->expects($this->once())
            ->method('getMessage')
            ->willReturn('Violation message');

        $violationIterator = new \ArrayIterator([$violation]);

        $violationList = $this->createMock(ConstraintViolationList::class);
        $violationList->expects($this->once())
            ->method('count')
            ->willReturn(1);
        $violationList->expects($this->once())
            ->method('getIterator')
            ->willReturn($violationIterator);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->willReturn($violationList);

        $instance = new RoleFactory($validator);

        $instance->buildRole($this->createMock(RoleDTO::class));
    }

    /**
     * Get validator
     *
     * This method return a mock instance of validator
     *
     * @param int $errorCount The validation error count
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getValidator(int $errorCount = 0)
    {
        $violationList = $this->createMock(ConstraintViolationListInterface::class);
        $violationList->expects($this->once())
            ->method('count')
            ->willReturn($errorCount);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->willReturn($violationList);

        return $validator;
    }
}
