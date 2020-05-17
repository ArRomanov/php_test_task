<?php

namespace tests;

use app\models;
use function GuzzleHttp\Psr7\str;

/**
 * GithubRepoTest contains test cases for github repo model
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class GithubRepoTest extends \Codeception\Test\Unit
{
    /**
     * Generating counts of forks, of stars, of watchers and rating
     *
     * @return array
     */
    public function getForksStarsWatchersCountAndRating()
    {
        return array(
            array(0, 0, 0, 0.0),
            array(0, 1, 1, 0.5),
            array(1, 1, 1, 1.1666666666667),
            array(1, 0, 1, 1.0),
            array(0, 0, 1, 0.33333333333333),
            array(10, 20, 30, 20.0)
        );
    }

    /**
     * Test case for counting repo rating
     *
     * @dataProvider getForksStarsWatchersCountAndRating
     * @param int $forkCount
     * @param int $starCount
     * @param int $watcherCount
     * @param float $expectedRating
     * @return void
     */
    public function testRatingCount(int $forkCount, int $starCount, int $watcherCount, float $expectedRating)
    {
        $githubTestRepo = new models\GithubRepo('githubTestRepo', $forkCount, $starCount, $watcherCount);
        $this->assertEquals($expectedRating, $githubTestRepo->getRating());
    }

    /**
     * Generating all github repo data
     *
     * @return array
     */
    public function getAllGithubRepoData()
    {
        return array(
            array('repoName', 0, 0, 0, 0.0),
            array('ИмяРепозитория', 0, 1, 1, 0.5),
            array('!@#$%^&*', 1, 1, 1, 1.1666666666667),
            array('repo-name', 1, 0, 1, 1.0),
            array('repo.name', 0, 0, 1, 0.33333333333333)
        );
    }

    /**
     * Test case for repo model data serialization
     *
     * @dataProvider getAllGithubRepoData
     * @param string $repoName
     * @param int $forkCount
     * @param int $starCount
     * @param int $watcherCount
     * @param float $expectedRating
     * @return void
     */
    public function testData(string $repoName, int $forkCount, int $starCount, int $watcherCount, float $expectedRating)
    {
        $githubTestRepo = new models\GithubRepo($repoName, $forkCount, $starCount, $watcherCount);
        $this->assertEquals(
            ['name' => $repoName, 'fork-count' => $forkCount, 'start-count' => $starCount, 'watcher-count' => $watcherCount, 'rating' => $expectedRating,],
            $githubTestRepo->getData()
        );
    }

    /**
     * Generating all github repo data for stringify
     *
     * @return array
     */
    public function getAllGithubRepoDataForStringify()
    {
        return array(
            array('repoName', 0, 0, 0, 'repoName                                                                       0 ⇅    0 ★    0 👁️'),
            array('ИмяРепозитория', 0, 1, 1, 'ИмяРепозитория                                                   0 ⇅    1 ★    1 👁️'),
            array('!@#$%^&*', 1, 1, 1, '!@#$%^&*                                                                       1 ⇅    1 ★    1 👁️'),
            array('repo-name', 1, 0, 1, 'repo-name                                                                      1 ⇅    0 ★    1 👁️'),
            array('repo.name', 10, 20, 30, 'repo.name                                                                     10 ⇅   20 ★   30 👁️')
        );
    }

    /**
     * Test case for repo model __toString verification
     *
     * @dataProvider getAllGithubRepoDataForStringify
     * @param string $repoName
     * @param int $forkCount
     * @param int $starCount
     * @param int $watcherCount
     * @param string $expectedString
     * @return void
     */
    public function testStringify(string $repoName, int $forkCount, int $starCount, int $watcherCount, string $expectedString)
    {
        $githubTestRepo = new models\GithubRepo($repoName, $forkCount, $starCount, $watcherCount);
        $this->assertEquals($expectedString, (string)$githubTestRepo);
    }
}