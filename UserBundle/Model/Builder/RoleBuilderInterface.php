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
namespace Beotie\UserBundle\Model\Builder;

use Beotie\UserBundle\Model\Role;

/**
 * Role builder interface
 *
 * This interface define the base RoleBuilder methods
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RoleBuilderInterface
{
    /**
     * Set label
     *
     * This method set the label of the role instance
     *
     * @param string $label The label to set
     *
     * @return $this
     */
    public function setLabel(string $label);

    /**
     * Set long label
     *
     * This method set the long label of the role instance
     *
     * @param string $longLabel The long label to set
     *
     * @return $this
     */
    public function setLongLabel(string $longLabel);

    /**
     * Set description
     *
     * This method set the description of the role instance
     *
     * @param string $description The description of the role.
     *
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Remove
     *
     * This method remove the role instance. It set the deletion date to now.
     *
     * @param \DateTime $deletionDate [optional] The deletion date. If null, the current date time is used.
     *
     * @return $this
     */
    public function remove(\DateTime $deletionDate = null) : RoleBuilderInterface;

    /**
     * Restore
     *
     * This method restore the role instance. It set the deletion date to null.
     *
     * @return $this
     */
    public function restore() : RoleBuilderInterface;

    /**
     * Get label
     *
     * This method return the label of the builded instance
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get long label
     *
     * This method return the long label of the builded instance
     *
     * @return string
     */
    public function getLongLabel();

    /**
     * Get description
     *
     * This method return the description of the builded instance
     *
     * @return string
     */
    public function getDescription();

    /**
     * Is deleted
     *
     * This method return the deletion state of the builded instance
     *
     * @return bool
     */
    public function isDeleted() : bool;

    /**
     * Get role
     *
     * This method return the role accordingly with given values
     *
     * @return Role
     */
    public function getRole() : Role;
}
