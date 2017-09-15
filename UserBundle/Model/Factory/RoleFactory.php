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
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\UserBundle\Model\Factory;

use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;
use Beotie\UserBundle\Model\Builder\RoleBuilder;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Beotie\UserBundle\Model\Builder\RoleBuilderInterface;
use Beotie\UserBundle\Exception\UnvalidatedRoleDto;
use Beotie\UserBundle\Model\Role;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Role factory
 *
 * This class is used to build a new role instance from a role dto
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleFactory implements RoleFactoryInterface
{
    /**
     * Validator
     *
     * This property store the validator, in order to validate the given DTOs.
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Cache pool
     *
     * This property store the optional cache pool, to speed up Role creation.
     *
     * @var CacheItemPoolInterface
     */
    private $cachePool = null;

    /**
     * Construct
     *
     * The default RoleFactory constructor
     *
     * @param ValidatorInterface     $validator The validator used to validate the given DTOs
     * @param CacheItemPoolInterface $cachePool The cache pool used to speed up the Role building
     *
     * @return void
     */
    public function __construct(ValidatorInterface $validator, CacheItemPoolInterface $cachePool = null)
    {
        $this->validator = $validator;
        $this->cachePool = $cachePool;
    }

    /**
     * Is valid
     *
     * This method validate a RoleDTO before building a Role instance
     *
     * @param RoleDTO $roleDto The role DTO to validate
     *
     * @return bool
     */
    public function isValid(RoleDTO $roleDto) : bool
    {
        return $this->validateDto($roleDto)->count() === 0;
    }

    /**
     * Get RoleBuilder
     *
     * This method return a RoleBuilder instance
     *
     * @return RoleBuilderInterface
     */
    public function getRoleBuilder() : RoleBuilderInterface
    {
        return new RoleBuilder($this->cachePool);
    }

    /**
     * Build role
     *
     * This method build a new Role instance and return it
     *
     * @param RoleDTO $roleDto The role DTO to build Role from
     *
     * @return Role
     * @throws UnvalidatedRoleDto
     */
    public function buildRole(RoleDTO $roleDto) : Role
    {
        $violations = $this->validateDto($roleDto);

        if ($violations->count() !== 0) {
            throw new UnvalidatedRoleDto(
                $violations,
                $roleDto,
                'The given role dto is not valid'
            );
        }

        $roleBuilder = $this->getRoleBuilder();

        if ($roleDto->deletionDate !== null) {
            $roleBuilder->remove($roleDto->deletionDate);
        }

        $map = [
            'description' => 'setDescription',
            'label' => 'setLabel',
            'longLabel' => 'setLongLabel'
        ];

        foreach ($map as $dtoProperty => $builderSetter) {
            call_user_func([$roleBuilder, $builderSetter], $roleDto->{$dtoProperty});
        }

        return $roleBuilder->getRole();
    }

    /**
     * Validate DTO
     *
     * This method validate and return the DTO violation list
     *
     * @param RoleDTO $roleDto The role DTO to validate
     *
     * @return ConstraintViolationListInterface
     */
    private function validateDto(RoleDTO $roleDto)
    {
        return $this->validator->validate($roleDto, null, 'create');
    }
}
