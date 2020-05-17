<?php

/**
 * Base contains test cases for testing api endpoint
 *
 * @see https://codeception.com/docs/modules/Yii2
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class BaseCest
{
    /**
     * Example test case
     *
     * @return void
     */
    public function cestExample(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => [
                'kfr',
            ],
            'platforms' => [
                'github',
            ]
        ]);
        $expected = json_decode('[
            {
                "name": "kfr",
                "platform": "github",
                "total-rating": 1.5,
                "repos": [],
                "repo": [
                    {
                        "name": "kf-cli",
                        "fork-count": 0,
                        "start-count": 2,
                        "watcher-count": 2,
                        "rating": 1
                    },
                    {
                        "name": "cards",
                        "fork-count": 0,
                        "start-count": 0,
                        "watcher-count": 0,
                        "rating": 0
                    },
                    {
                        "name": "UdaciCards",
                        "fork-count": 0,
                        "start-count": 0,
                        "watcher-count": 0,
                        "rating": 0
                    },
                    {
                        "name": "unikgen",
                        "fork-count": 0,
                        "start-count": 1,
                        "watcher-count": 1,
                        "rating": 0.5
                    }
                ]
            }
        ]');
        $I->assertEquals($expected, json_decode($I->grabPageSource()));
    }

    /**
     * Test case for api with bad request params
     *
     * @return void
     */
    public function cestBadParams(\FunctionalTester $I)
    {
        //ToDo - I couldn't check this exception. I don't know how to do it.

        $I->amOnPage([
            'base/api',
            'users' => 123,
            'platforms' => 'kfr'
        ]);
        $I->expectThrowable(LogicException::class, function () use ($I) {
            $I->grabPageSource();
        });
    }

    /**
     * Test case for api with empty user list
     *
     * @return void
     */
    public function cestEmptyUsers(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => [],
            'platforms' => ['github']
        ]);
        $expected = '<pre>Bad Request: Missing required parameters: users</pre>';
        $I->assertEquals($expected, $I->grabPageSource());
    }

    /**
     * Test case for api with empty platform list
     *
     * @return void
     */
    public function cestEmptyPlatforms(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => ['kfr'],
            'platforms' => []
        ]);
        $expected = '<pre>Bad Request: Missing required parameters: platforms</pre>';
        $I->assertEquals($expected, $I->grabPageSource());
    }

    /**
     * Test case for api with non empty platform list
     *
     * @return void
     */
    public function cestSeveralPlatforms(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => ['kfr'],
            'platforms' => ['github', 'gitlab']
        ]);
        $expected = '[{"name":"kfr","platform":"github","total-rating":1.5,"repos":[],"repo":[{"name":"kf-cli","fork-count":0,"start-count":2,"watcher-count":2,"rating":1},{"name":"cards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"UdaciCards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"unikgen","fork-count":0,"start-count":1,"watcher-count":1,"rating":0.5}]}]';
        $I->assertEquals($expected, $I->grabPageSource());
    }

    /**
     * Test case for api with non empty user list
     *
     * @return void
     */
    public function cestSeveralUsers(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => ['kfr', 'ArRomanov'],
            'platforms' => ['github']
        ]);
        $expected = '[{"name":"kfr","platform":"github","total-rating":1.5,"repos":[],"repo":[{"name":"kf-cli","fork-count":0,"start-count":2,"watcher-count":2,"rating":1},{"name":"cards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"UdaciCards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"unikgen","fork-count":0,"start-count":1,"watcher-count":1,"rating":0.5}]},{"name":"ArRomanov","platform":"github","total-rating":0,"repos":[],"repo":[{"name":"aqa-ci-demo","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"aqa2.4","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"at.info-knowledge-base","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"awesome-test-automation","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"idea_settings","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"jmeter-loadtestweb","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"maxilect_test_task","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"netology_test_task","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"php_test_task","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"python2.2","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"QlTraining","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"QualityLabTask","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"ubuntu-16-postinstall","fork-count":0,"start-count":0,"watcher-count":0,"rating":0}]}]';
        $I->assertEquals($expected, $I->grabPageSource());
    }

    /**
     * Test case for api with unknown platform in list
     *
     * @return void
     */
    public function cestUnknownPlatforms(\FunctionalTester $I)
    {
        //ToDo - I couldn't check this exception. I don't know how to do it.

        $I->amOnPage([
            'base/api',
            'users' => ['kfr'],
            'platforms' => ['githup']
        ]);
        $I->expectThrowable(\LogicException::class, function () use ($I) {
            $I->grabPageSource();
        });
    }

    /**
     * Test case for api with unknown user in list
     *
     * @return void
     */
    public function cestUnknownUsers(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => ['dsgvsfdversb'],
            'platforms' => ['github']
        ]);
        $I->assertEquals('[]', $I->grabPageSource());
    }

    /**
     * Test case for api with mixed (unknown, real) users and non empty platform list
     *
     * @return void
     */
    public function cestMixedUsers(\FunctionalTester $I)
    {
        $I->amOnPage([
            'base/api',
            'users' => ['dsgvsfdversb', 'kfr'],
            'platforms' => ['github']
        ]);
        $expected = '[{"name":"kfr","platform":"github","total-rating":1.5,"repos":[],"repo":[{"name":"kf-cli","fork-count":0,"start-count":2,"watcher-count":2,"rating":1},{"name":"cards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"UdaciCards","fork-count":0,"start-count":0,"watcher-count":0,"rating":0},{"name":"unikgen","fork-count":0,"start-count":1,"watcher-count":1,"rating":0.5}]}]';
        $I->assertEquals($expected, $I->grabPageSource());
    }

    /**
     * Test case for api with mixed (github, gitlab, bitbucket) platforms and non empty user list
     *
     * @return void
     */
    public function cestMixedPlatforms(\FunctionalTester $I)
    {
        //ToDo - I couldn't check this exception. I don't know how to do it.

        $I->amOnPage([
            'base/api',
            'users' => ['kfr'],
            'platforms' => ['github', 'githup']
        ]);
        $I->expectThrowable(\LogicException::class, function () use ($I) {
            $I->grabPageSource();
        });
    }
}