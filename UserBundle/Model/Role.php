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
namespace Beotie\UserBundle\Model;

/**
 * Role
 *
 * This class is used to store the user role's informations.
 *
 * @category Model
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class Role
{
    /**
     * Id
     *
     * This property store the Role's id
     *
     * @var string
     */
    private $id;

    /**
     * Label
     *
     * This property store the Role's label
     *
     * @var string
     */
    protected $label;

    /**
     * Long label
     *
     * This property store the Role's human readable label
     *
     * @var string
     */
    protected $longLabel;

    /**
     * Description
     *
     * This property store the Role's human readable description
     *
     * @var string
     */
    protected $description;

    /**
     * Locale
     *
     * This property store the Role's translation locale
     *
     * @var string
     */
    protected $locale;

    /**
     * Creation date
     *
     * This property store the Role's creation date
     *
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * Deletion date
     *
     * This property store the Role's deletion date
     *
     * @var \DateTime
     */
    protected $deletionDate;

    /**
     * Last update date
     *
     * This property store the Role's last update date
     *
     * @var \DateTime
     */
    protected $lastUpdateDate;

    /**
     * Construct
     *
     * The default Role constructor
     *
     * @return void
     */
    protected function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * This method return the Role's id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get label
     *
     * This method return the Role's label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get long label
     *
     * This method return the Role's human readable label
     *
     * @return string
     */
    public function getLongLabel()
    {
        return $this->longLabel;
    }

    /**
     * Get description
     *
     * This method return the Role's human readable description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get locale
     *
     * This method return the Role's locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get creation date
     *
     * This method return the Role's creation date
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Get deletion date
     *
     * This method return the Role's deletion date
     *
     * @return \DateTime
     */
    public function getDeletionDate()
    {
        return $this->deletionDate;
    }

    /**
     * Get last update date
     *
     * This method return the Role's last update date
     *
     * @return \DateTime
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
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
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
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
    public function setLongLabel(string $longLabel)
    {
        $this->longLabel = $longLabel;
        return $this;
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
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set locale
     *
     * This method allow to set the locale of the Role instance.
     *
     * @param string $locale The locale of the instance
     *
     * @return $this
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Set deletionDate
     *
     * This method allow to set the deletion date of the Role instance.
     *
     * @param \DateTime $deletionDate The deletion date of the instance
     *
     * @return $this
     */
    public function setDeletionDate(\DateTime $deletionDate)
    {
        $this->deletionDate = $deletionDate;
        return $this;
    }
}
