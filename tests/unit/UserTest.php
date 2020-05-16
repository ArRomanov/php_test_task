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
     * Generating different repo names
     *
     * @return array
     */
    public function getRepoNames()
    {
        return array(
            array('app\models\GithubRepo'),
            array('app\models\GitlabRepo'),
            array('app\models\BitbucketRepo')
        );
    }

    /**
     * Test case for adding repo models to user model (successful)
     *
     * @dataProvider getRepoNames
     * @param string $repoClassName
     * @return void
     */
    public function testAddingReposSucceed(string $repoClassName)
    {
        $greatRatingTestRepo = new $repoClassName('greatRatingTestRepo', 10, 20, 30);
        $littleRatingTestRepo = new $repoClassName('littleRatingTestRepo', 1, 2, 3);
        $this->testUserModel->addRepos(array($greatRatingTestRepo, $littleRatingTestRepo));
        $data = $this->testUserModel->getData();
        $this->assertEquals(
            [$this->testUserModel->getTotalRating(), 'greatRatingTestRepo', 'littleRatingTestRepo'],
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
     * @dataProvider getRepoNames
     * @param string $repoClassName
     * @return void
     */
    public function testTotalRatingCountWithRepos(string $repoClassName)
    {
        $firstTestRepo = new $repoClassName('firstTestRepo', 10, 20, 30);
        $secondTestRepo = new $repoClassName('secondTestRepo', 1, 2, 3);
        $this->testUserModel->addRepos(array($firstTestRepo, $secondTestRepo));
        $actualRating = $this->testUserModel->getTotalRating();
        $this->assertEquals($this->testUserModel->getTotalRating(), $actualRating);
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
     * Test case for user model data serialization without repo watcher-count
     *
     * @return void
     */
    public function testDataWithoutWatcherCount()
    {
        $firstTestRepo = new models\GitlabRepo('firstTestRepo', 10, 20);
        $secondTestRepo = new models\GitlabRepo('secondTestRepo', 1, 2);
        $this->testUserModel->addRepos(array($firstTestRepo, $secondTestRepo));
        $data = $this->testUserModel->getData();
        $this->assertEquals(
            [
                $this->testUserModel->getName(),
                $this->testUserModel->getPlatform(),
                $this->testUserModel->getTotalRating(),
                [],
                ['name' => 'firstTestRepo', 'fork-count' => 10, 'start-count' => 20, 'rating' => $firstTestRepo->getRating()],
                ['name' => 'secondTestRepo', 'fork-count' => 1, 'start-count' => 2, 'rating' => $secondTestRepo->getRating()]
            ],
            [
                $data['name'],
                $data['platform'],
                $data['total-rating'],
                $data['repos'],
                $data['repo'][0],
                $data['repo'][1]]
        );
    }

    /**
     * Test case for user model data serialization with watcher-count and star-count
     *
     * @return void
     */
    public function testDataWithWatcherCountAndStarCount()
    {
        $firstTestRepo = new models\GithubRepo('firstTestRepo', 10, 20, 30);
        $secondTestRepo = new models\GithubRepo('secondTestRepo', 1, 2, 3);
        $this->testUserModel->addRepos(array($firstTestRepo, $secondTestRepo));
        $data = $this->testUserModel->getData();
        $this->assertEquals(
            [
                $this->testUserModel->getName(),
                $this->testUserModel->getPlatform(),
                $this->testUserModel->getTotalRating(),
                [],
                ['name' => 'firstTestRepo', 'fork-count' => 10, 'start-count' => 20, 'watcher-count' => 30, 'rating' => $firstTestRepo->getRating()],
                ['name' => 'secondTestRepo', 'fork-count' => 1, 'start-count' => 2, 'watcher-count' => 3, 'rating' => $secondTestRepo->getRating()]
            ],
            [
                $data['name'],
                $data['platform'],
                $data['total-rating'],
                $data['repos'],
                $data['repo'][0],
                $data['repo'][1]]
        );
    }

    /**
     * Test case for user model data serialization without star-count
     *
     * @return void
     */
    public function testDataWithoutStarCount()
    {
        $firstTestRepo = new models\BitbucketRepo('firstTestRepo', 10, 30);
        $secondTestRepo = new models\BitbucketRepo('secondTestRepo', 1, 3);
        $this->testUserModel->addRepos(array($firstTestRepo, $secondTestRepo));
        $data = $this->testUserModel->getData();
        $this->assertEquals(
            [
                $this->testUserModel->getName(),
                $this->testUserModel->getPlatform(),
                $this->testUserModel->getTotalRating(),
                [],
                ['name' => 'firstTestRepo', 'fork-count' => 10, 'watcher-count' => 30, 'rating' => $firstTestRepo->getRating()],
                ['name' => 'secondTestRepo', 'fork-count' => 1, 'watcher-count' => 3, 'rating' => $secondTestRepo->getRating()]
            ],
            [
                $data['name'],
                $data['platform'],
                $data['total-rating'],
                $data['repos'],
                $data['repo'][0],
                $data['repo'][1]]
        );
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