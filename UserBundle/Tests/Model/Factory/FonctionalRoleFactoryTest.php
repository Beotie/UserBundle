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
namespace Beotie\UserBundle\Tests\Model\Factory;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\UserBundle\Model\Factory\RoleFactory;
use Symfony\Component\Validator\Validation;
use Beotie\UserBundle\Model\DataTransfertObject\RoleDTO;
use Beotie\UserBundle\Exception\UnvalidatedRoleDto;
use Symfony\Component\Config\FileLocator;

/**
 * Functional role factory test
 *
 * This class is used to validate the RoleFactory methods
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FonctionalRoleFactoryTest extends TestCase
{
    /**
     * Dto provider
     *
     * This method return a set of DTO, equality validation and error state to validate
     * the RoleFactory::BuildRole method
     *
     * @return [[array, array, bool]]
     */
    public function dtoProvider()
    {
        $provider = [
            [
                ['label' => 'MY_LABEL', 'longLabel' => 'My long label', 'description' => 'My description'],
                ['getLabel' => 'label', 'getLongLabel' => 'longLabel', 'getDescription' => 'description'],
                true
            ],
            [
                [
                    'label' => 'MY_LABEL_2',
                    'longLabel' => 'My long label',
                    'description' => 'My description',
                    'deletionDate' => new \DateTime()
                ],
                [
                    'getLabel' => 'label',
                    'getLongLabel' => 'longLabel',
                    'getDescription' => 'description',
                    'getDeletionDate' => 'deletionDate'
                ],
                true
            ]
        ];

        $this->loadError($provider, 'labels');
        $this->loadError($provider, 'longLabels');
        $this->loadError($provider, 'deletionDates');

        return $provider;
    }

    /**
     * Test valid
     *
     * This method validate the RoleFactory::BuildRole method
     *
     * @param array $initializer       The dto initialisation array
     * @param array $equalityValidator The equality validation array
     * @param bool  $isValid           The validation state of the dto
     *
     * @return       void
     * @dataProvider dtoProvider
     */
    public function testValid(array $initializer, array $equalityValidator, bool $isValid)
    {
        $configPath = str_replace('/', DIRECTORY_SEPARATOR, sprintf('%s/../../../Resources/Validator', __DIR__));
        $fileLocator = new FileLocator([realpath($configPath)]);

        $validator = Validation::createValidatorBuilder()
            ->addYamlMapping($fileLocator->locate('RoleDTO.yml'))
            ->getValidator();

        $roleFactory = new RoleFactory($validator);

        $dto = new RoleDTO();
        foreach ($initializer as $property => $value) {
            $dto->{$property} = $value;
        }

        if (!$isValid) {
            $this->expectException(UnvalidatedRoleDto::class);
            $this->assertFalse($roleFactory->isValid($dto));
            $roleFactory->buildRole($dto);
            $this->fail('BuildRole is expected to throw exception');
        }

        $this->assertTrue($roleFactory->isValid($dto));

        $role = $roleFactory->buildRole($dto);

        foreach ($equalityValidator as $roleMethod => $dtoProperty) {
            $this->assertEquals($dto->{$dtoProperty}, $role->{$roleMethod}());
        }
    }

    /**
     * Load error
     *
     * This method push into a provider result a set of invalid values
     *
     * @param array  $provider The provider to load
     * @param string $type     The type of value to load ['labels', 'longLabels', 'deletionDates']
     *
     * @return void
     */
    private function loadError(array &$provider, string $type)
    {
        $sample = [
            ['label' => 'MY_LABEL', 'longLabel' => 'My long label', 'description' => 'My description'],
            [],
            false
        ];

        foreach ($this->getErrorValues($type) as $value) {
            $sample[0][substr($type, 0, -1)] = $value;
            $provider[] = $sample;
        }
    }

    /**
     * Get error value
     *
     * This method return a set of invalid values inside a generator to use into tests
     *
     * @param string $type The type of values to return ['labels', 'longLabels', 'deletionDates']
     *
     * @return                                      Generator
     * @SuppressWarnings(PHPMD.UnusedLocalVariable) The local variables are used dynamicaly
     */
    private function getErrorValues(string $type)
    {
        if (!in_array($type, ['labels', 'longLabels', 'deletionDates'])) {
            throw new \LogicException(sprintf('The type "%s" is not allowed', $type));
        }

        $labels = [ null, '', 'My label', 'MY-LABEL', 'MY_LABEL_$', '1_MY_LABEL', 14];
        $longLabels = [null, '', 14];
        $deletionDates = ['', 14, new \stdClass(), new \DateTime('+1day UTC'), new \DateTime('+1hour UTC')];

        foreach (${$type} as $label) {
            yield $label;
        }
    }
}
