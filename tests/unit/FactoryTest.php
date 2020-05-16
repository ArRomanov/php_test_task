<?php

namespace tests;

use app\components;

/**
 * FactoryTest contains test cases for factory component
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class FactoryTest extends \Codeception\Test\Unit
{
    /**
     * Generating succeed test data
     *
     * @return array
     */
    public function getUsersAndPlatformsForSuccess()
    {
        return array(
            array('github', components\platforms\Github::class),
            array('bitbucket', components\platforms\Bitbucket::class),
            array('gitlab', components\platforms\Gitlab::class)
        );
    }

    /**
     * Test case for creating platform component (Successful)
     *
     * @dataProvider getUsersAndPlatformsForSuccess
     * @param string $platformName
     * @param string $expectedInstance
     * @return void
     */
    public function testCreateSucceed(string $platformName, string $expectedInstance)
    {
        $platformFactory = new components\Factory();
        $this->assertInstanceOf($expectedInstance, $platformFactory->create($platformName));
    }

    /**
     * Generating unsuccessful test data
     *
     * @return array
     */
    public function getUsersAndPlatformsForFailure()
    {
        return array(
            array('fake_platform'),
            array(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5))
        );
    }

    /**
     * Test case for creating platform component (Unsuccessful)
     *
     * @dataProvider getUsersAndPlatformsForFailure
     * @param string $fakePlatformName
     * @return void
     */
    public function testCreateUnsuccessful(string $fakePlatformName)
    {
        $this->expectException(\LogicException::class);
        $platformFactory = new components\Factory();
        $platformFactory->create($fakePlatformName);
    }
}