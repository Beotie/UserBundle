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
namespace Beotie\UserBundle\Model\Builder;

use Beotie\UserBundle\Model\Role;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Role builder
 *
 * This class is used to build new role instances
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleBuilder extends Role implements RoleBuilderInterface
{
    /**
     * Cache pool
     *
     * This property store the builder cache pool used by property accessor to speed up generation
     *
     * @var CacheItemPoolInterface
     */
    private $cachePool = null;

    /**
     * Properties
     *
     * This property store the properties to apply as Role property
     *
     * @var array
     */
    private $properties = [];

    /**
     * Construct
     *
     * The default RoleBuilder constructor
     *
     * @param CacheItemPoolInterface $cachePool The cache pool to use as accessor cache pool
     *
     * @return void
     */
    public function __construct(CacheItemPoolInterface $cachePool = null)
    {
        $this->cachePool = $cachePool;
    }

    /**
     * Set label
     *
     * This method allow to set the label of the Role instance.
     * If you want to update the translations, consider using manager.
     *
     * @param string $label The label of the instance
     *
     * @return $this
     */
    public function setLabel(string $label) : RoleBuilderInterface
    {
        return $this->setProperty('label', $label);
    }

    /**
     * Set long label
     *
     * This method allow to set the human readable label of the Role instance.
     * If you want to update the translations, consider using manager.
     *
     * @param string $longLabel The long label of the instance
     *
     * @return $this
     */
    public function setLongLabel(string $longLabel) : RoleBuilderInterface
    {
        return $this->setProperty('longLabel', $longLabel);
    }

    /**
     * Set description
     *
     * This method allow to set the description of the Role instance.
     * If you want to update the translations, consider using manager.
     *
     * @param string $description The description of the instance
     *
     * @return $this
     */
    public function setDescription(string $description) : RoleBuilderInterface
    {
        return $this->setProperty('description', $description);
    }

    /**
     * Restore
     *
     * This method restore the role instance. It set the deletion date to null.
     *
     * @return $this
     */
    public function restore() : RoleBuilderInterface
    {
        return $this->setProperty('deletionDate', null);
    }

    /**
     * Remove
     *
     * This method remove the role instance. It set the deletion date to now.
     *
     * @return $this
     */
    public function remove() : RoleBuilderInterface
    {
        return $this->setProperty('deletionDate', new \DateTime());
    }

    /**
     * Get label
     *
     * This method return the label of the builded instance
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getProperty('label');
    }

    /**
     * Is deleted
     *
     * This method return the deletion state of the builded instance
     *
     * @return bool
     */
    public function isDeleted() : bool
    {
        return $this->getProperty('deletionDate') !== null;
    }

    /**
     * Get long label
     *
     * This method return the long label of the builded instance
     *
     * @return string
     */
    public function getLongLabel()
    {
        return $this->getProperty('longLabel');
    }

    /**
     * Get description
     *
     * This method return the description of the builded instance
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getProperty('description');
    }

    /**
     * Get role
     *
     * This method return the role accordingly with given values
     *
     * @return Role
     */
    public function getRole() : Role
    {
        $role = new Role();
        $accessor = new PropertyAccessor(false, true, $this->cachePool);

        foreach ($this->properties as $propertyName => $propertyValue) {
            if (!$accessor->isWritable($role, $propertyName)) {
                throw new \LogicException(sprintf('Property %s is not writable', $propertyName));
            }

            $accessor->setValue($role, $propertyName, $propertyValue);
        }

        return $role;
    }

    /**
     * Set property
     *
     * This method set a property value into the properties store and return the current instance
     *
     * @param string $property The property name to set
     * @param mixed  $value    The property value to set
     *
     * @return $this
     */
    private function setProperty(string $property, $value) : RoleBuilderInterface
    {
        $this->properties[$property] = $value;
        return $this;
    }

    /**
     * Get property
     *
     * This method return a stored property value or null
     *
     * @param string $property The property name
     *
     * @return mixed|NULL
     */
    private function getProperty(string $property)
    {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }

        return null;
    }
}
