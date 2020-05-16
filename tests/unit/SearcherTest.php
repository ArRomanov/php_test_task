<?php

namespace tests;

use app\components;

/**
 * SearcherTest contains test cases for searcher component
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class SearcherTest extends \Codeception\Test\Unit
{

    /**
     * Generating success test data
     *
     * @return array
     */
    public function getUsersAndPlatformsForSuccess()
    {
        return array(
            array('github', 'ArRomanov', 'ArRomanov (github)                                                                            0 🏆
==================================================================================================
aqa-ci-demo                                                                    0 ⇅    0 ★    0 👁️
aqa2.4                                                                         0 ⇅    0 ★    0 👁️
at.info-knowledge-base                                                         0 ⇅    0 ★    0 👁️
awesome-test-automation                                                        0 ⇅    0 ★    0 👁️
idea_settings                                                                  0 ⇅    0 ★    0 👁️
jmeter-loadtestweb                                                             0 ⇅    0 ★    0 👁️
maxilect_test_task                                                             0 ⇅    0 ★    0 👁️
netology_test_task                                                             0 ⇅    0 ★    0 👁️
php_test_task                                                                  0 ⇅    0 ★    0 👁️
python2.2                                                                      0 ⇅    0 ★    0 👁️
QlTraining                                                                     0 ⇅    0 ★    0 👁️
QualityLabTask                                                                 0 ⇅    0 ★    0 👁️
ubuntu-16-postinstall                                                          0 ⇅    0 ★    0 👁️
'),
            array('bitbucket', '557058:955cce5b-b3ce-440a-9d40-5ba30248e3fc', 'ArRomanov (bitbucket)                                                                        18 🏆
==================================================================================================
meddlesome_telebot                                                             1 ⇅           1 👁️
video_telebot                                                                  1 ⇅           1 👁️
UchebnikRestTests                                                              1 ⇅           1 👁️
UchebnikWebTests                                                               1 ⇅           1 👁️
JavaWebService                                                                 1 ⇅           1 👁️
QualityLabTask                                                                 1 ⇅           1 👁️
TenderProTask                                                                  1 ⇅           1 👁️
BuilderSamples                                                                 1 ⇅           1 👁️
RussianLottoStatistic                                                          1 ⇅           1 👁️
docker-test-sample                                                             1 ⇅           1 👁️
QlTraining                                                                     1 ⇅           1 👁️
Imhio_backend_tests                                                            1 ⇅           1 👁️
'),
        );
    }

    /**
     * Test case for searching via several platforms (Successful)
     *
     * @dataProvider getUsersAndPlatformsForSuccess
     * @param $platform_name
     * @param $userName
     * @param $expectedUser
     * @return void
     */
    public function testSearcherSuccessful($platform_name, $userName, $expectedUser)
    {
        $platformFactory = new components\Factory();
        $platform = $platformFactory->create($platform_name);
        $searcher = new components\Searcher();
        $users = $searcher->search(array($platform), array($userName));
        $this->assertEquals($expectedUser, (string)$users[0]);
    }

    /**
     * Generating failure test data
     *
     * @return array
     */
    public function getUsersAndPlatformsForFailure()
    {
        return array(
            array('github', 'FakeUser'),
            array('gitlab', 'arromanov')
        );
    }

    /**
     * Test case for searching via several platforms (Unsuccessful)
     *
     * @dataProvider getUsersAndPlatformsForFailure
     * @param $platform_name
     * @param $userName
     * @param $expectedUser
     */
    public function testSearcherUnsuccessful($platform_name, $userName)
    {
        $platformFactory = new components\Factory();
        $platform = $platformFactory->create($platform_name);
        $searcher = new components\Searcher();
        $users = $searcher->search(array($platform), array($userName));
        $this->assertCount(0, $users);
    }
}