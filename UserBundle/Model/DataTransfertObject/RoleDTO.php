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
namespace Beotie\UserBundle\Model\DataTransfertObject;

/**
 * Role DTO
 *
 * This class is used to store the user role's informations as data transfert object.
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleDTO
{
    /**
     * Id
     *
     * This property store the Role's id
     *
     * @var string
     */
    public $id;

    /**
     * Label
     *
     * This property store the Role's label
     *
     * @var string
     */
    public $label;

    /**
     * Long label
     *
     * This property store the Role's human readable label
     *
     * @var string
     */
    public $longLabel;

    /**
     * Description
     *
     * This property store the Role's human readable description
     *
     * @var string
     */
    public $description;

    /**
     * Creation date
     *
     * This property store the Role's creation date
     *
     * @var \DateTime
     */
    public $creationDate;

    /**
     * Deletion date
     *
     * This property store the Role's deletion date
     *
     * @var \DateTime
     */
    public $deletionDate;

    /**
     * Last update date
     *
     * This property store the Role's last update date
     *
     * @var \DateTime
     */
    public $lastUpdateDate;
}
