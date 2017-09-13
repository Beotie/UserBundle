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
namespace Beotie\UserBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\UserBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configuration test
 *
 * This class is used to validate the Configuration
 *
 * @category Test
 * @package  Beotie_User_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationTest extends TestCase
{
    /**
     * Test getConfigTreeBuilder
     *
     * This method validate the Configuration::getConfigTreeBuilder result
     *
     * @return void
     */
    public function testGetConfigTreeBuilder()
    {
        $instance = new Configuration();

        $result = $instance->getConfigTreeBuilder();

        $this->assertInstanceOf(
            TreeBuilder::class,
            $result,
            sprintf(
                'The Configuration::getConfigTreeBuilder is expected to return an instance of %s',
                TreeBuilder::class
            )
        );

        $this->assertEquals(
            'beotie_user',
            $result->buildTree()->getName(),
            sprintf(
                'The TreeBuilder returned by the Configuration::getConfigTreeBuilder is expected to be named "%s"',
                'beotie_user'
            )
        );
    }
}
