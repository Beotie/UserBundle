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
 * @category Exception
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\UserBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;

/**
 * Unvalidated role DTO
 *
 * This class is used to represent an unvalidated role dto exception
 *
 * @category Exception
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UnvalidatedRoleDto extends \RuntimeException
{
    /**
     * Violations
     *
     * This property store the violations of the given DTO
     *
     * @var ConstraintViolationListInterface
     */
    private $violations;

    /**
     * DTO
     *
     * This property store the original DTO that lead violations
     *
     * @var RoleDTO
     */
    private $dto;

    /**
     * Construct
     *
     * The default UnvalidatedRoleDto constructor
     *
     * @param ConstraintViolationListInterface $violations The violations leaded by the DTO
     * @param RoleDTO                          $dto        The original DTO that lead violations
     * @param string                           $message    The exception message
     * @param mixed                            $code       The exception code
     * @param \Exception                       $previous   The previous exception
     *
     * @return void
     */
    public function __construct(
        ConstraintViolationListInterface $violations = null,
        RoleDTO $dto = null,
        string $message = '',
        $code = 0,
        $previous = null
    ) {
        $this->violations = $violations;
        $this->dto = $dto;

        $violationMessages = '';
        if (!empty($violations)) {
            $violationMessages = [];
            foreach ($violations as $violation) {
                $violationMessages[] = $this->violationToString($violation);
            }
        }

        parent::__construct(sprintf('%s [%s]', $message, implode(', ', $violationMessages)), $code, $previous);
    }

    /**
     * Get violations
     *
     * This method return the violations leaded by the given DTO
     *
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * Get DTO
     *
     * This method return the original DTO that lead the violations
     *
     * @return RoleDTO
     */
    public function getDto()
    {
        return $this->dto;
    }

    /**
     * Violation to string
     *
     * This method convert a violation to it's string representation
     *
     * @param ConstraintViolationInterface $violation The violation to convert
     *
     * @return                                      string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) This method is used as callback by constructor
     */
    private function violationToString(ConstraintViolationInterface $violation)
    {
        return $violation->getMessage();
    }
}
