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
namespace Beotie\UserBundle\Tests\Exception;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\UserBundle\Exception\UnvalidatedRoleDto;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;

/**
 * UnvalidatedRoleDto test
 *
 * This class is used to validate the UnvalidatedRoleDto methods
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnvalidatedRoleDtoTest extends TestCase
{
    /**
     * Provide arguments
     *
     * This method provide a set of UnvalidatedRoleDto constructor arguments
     *
     * @return [[\PHPUnit_Framework_MockObject_MockObject, \PHPUnit_Framework_MockObject_MockObject, string]]
     */
    public function provideArguments()
    {
        $violation = $this->createMock(ConstraintViolationInterface::class);
        $violation->expects($this->once())
            ->method('getMessage')
            ->willReturn('Violation message');

        $violationIterator = new \ArrayIterator([$violation]);

        $violationList = $this->createMock(ConstraintViolationList::class);
        $violationList->expects($this->once())
            ->method('getIterator')
            ->willReturn($violationIterator);

        $dto = $this->createMock(RoleDTO::class);

        return [
            [$violationList, $dto, ' [Violation message]']
        ];
    }

    /**
     * Test exception
     *
     * This method validate the UnvalidatedRoleDto construction
     *
     * @param \PHPUnit_Framework_MockObject_MockObject $violationList The mocked violation list
     * @param \PHPUnit_Framework_MockObject_MockObject $dto           The mocked original DTO
     * @param string                                   $message       The expected message result
     *
     * @dataProvider provideArguments
     * @return       void
     */
    public function testException(
        \PHPUnit_Framework_MockObject_MockObject $violationList,
        \PHPUnit_Framework_MockObject_MockObject $dto,
        string $message
    ) {
        $instance = new UnvalidatedRoleDto($violationList, $dto);

        $this->assertEquals($message, $instance->getMessage());
        $this->assertSame($violationList, $instance->getViolations());
        $this->assertSame($dto, $instance->getDto());
    }
}
