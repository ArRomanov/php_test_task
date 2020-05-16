<?php

namespace tests;

use app\models;

/**
 * UserTest contains test cases for user model
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class UserTest extends \Codeception\Test\Unit
{
    private $testUserModel;

    public function setUp(): void
    {
        $this->testUserModel = new models\User('123', 'testUserName', 'github');
    }

    /**
     * Generating data for testAddingRepos method
     *
     * @return array
     */
    public function getRepoNamesAndCountedRating()
    {
        return array(
            array('app\models\GithubRepo', 22.0),
            array('app\models\GitlabRepo', 16.5),
            array('app\models\BitbucketRepo', 22.0)
        );
    }

    /**
     * Test case for adding repo models to user model (successful)
     *
     * @dataProvider getRepoNamesAndCountedRating
     * @param string $repoClassName
     * @param float $expectedCountedRating - посчитанный рейтинг двух репозиториев (отличается у платформ)
     * @return void
     */
    public function testAddingReposSucceed(string $repoClassName, float $expectedCountedRating)
    {
        $greatRatingTestRepo = new $repoClassName('greatRatingTestRepo', 10, 20, 30);
        $littleRatingTestRepo = new $repoClassName('littleRatingTestRepo', 1, 2, 3);
        $this->testUserModel->addRepos(array($greatRatingTestRepo, $littleRatingTestRepo));
        $data = $this->testUserModel->getData();
        $this->assertEquals(
            [$expectedCountedRating, 'greatRatingTestRepo', 'littleRatingTestRepo'],
            [$data['total-rating'], $data['repo'][0]['name'], $data['repo'][1]['name']]
        );
    }

    /**
     * Test case for adding repo models to user model (unsuccessful)
     *
     * @return void
     */
    public function testAddingReposUnsuccessful()
    {
        $this->expectException(\LogicException::class);
        $this->testUserModel->addRepos(['firstRepo', 'secondRepo']);
    }

    /**
     * Test case for counting total user rating (with repos)
     *
     * @dataProvider getRepoNamesAndCountedRating
     * @param string $repoClassName
     * @param float $expectedCountedRating - посчитанный рейтинг двух репозиториев (отличается у платформ)
     * @return void
     */
    public function testTotalRatingCountWithRepos(string $repoClassName, float $expectedCountedRating)
    {
        $firstTestRepo = new $repoClassName('firstTestRepo', 10, 20, 30);
        $secondTestRepo = new $repoClassName('secondTestRepo', 1, 2, 3);
        $this->testUserModel->addRepos(array($firstTestRepo, $secondTestRepo));
        $actualRating = $this->testUserModel->getTotalRating();
        $this->assertEquals($expectedCountedRating, $actualRating);
    }

    /**
     * Test case for counting total user rating (no repos)
     *
     * @return void
     */
    public function testTotalRatingCountNoRepos()
    {
        $actualRating = $this->testUserModel->getTotalRating();
        $this->assertEquals(0.0, $actualRating);
    }

    /**
     * Test case for user model data serialization
     *
     * @return void
     */
    public function testData()
    {
        /**
         * @todo IMPLEMENT THIS
         */
    }

    /**
     * Test case for user model __toString verification
     *
     * @return void
     */
    public function testStringify()
    {
        /**
         * @todo IMPLEMENT THIS
         */
    }
}