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

use Beotie\UserBundle\Model\Builder\RoleBuilderInterface;
use Beotie\UserBundle\Model\Role;
use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;
use Beotie\UserBundle\Exception\UnvalidatedRoleDto;

/**
 * Role factory interface
 *
 * This interface define the base RoleFactory methods
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RoleFactoryInterface
{
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
    public function buildRole(RoleDTO $roleDto) : Role;

    /**
     * Is valid
     *
     * This method validate a RoleDTO before building a Role instance
     *
     * @param RoleDTO $roleDto The role DTO to validate
     *
     * @return bool
     */
    public function isValid(RoleDTO $roleDto) : bool;

    /**
     * Get RoleBuilder
     *
     * This method return a RoleBuilder instance
     *
     * @return RoleBuilderInterface
     */
    public function getRoleBuilder() : RoleBuilderInterface;
}
