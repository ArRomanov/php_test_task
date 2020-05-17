<?php

namespace tests;

use app\models;

/**
 * GitlabRepoTest contains test cases for gitlab repo model
 *
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class GitlabRepoTest extends \Codeception\Test\Unit
{
    /**
     * Generating counts of forks, of stars and rating
     *
     * @return array
     */
    public function getForksStarsCountAndRating()
    {
        return array(
            array(0, 0, 0.0),
            array(0, 1, 0.25),
            array(1, 0, 1),
            array(1, 1, 1.25),
            array(10, 20, 15.0)
        );
    }

    /**
     * Test case for counting repo rating
     *
     * @dataProvider getForksStarsCountAndRating
     * @param int $forkCount
     * @param int $starCount
     * @param float $expectedRating
     * @return void
     */
    public function testRatingCount(int $forkCount, int $starCount, float $expectedRating)
    {
        $gitlabTestRepo = new models\GitlabRepo('gitlabTestRepo', $forkCount, $starCount);
        $this->assertEquals($expectedRating, $gitlabTestRepo->getRating());
    }

    /**
     * Generating all gitlab repo data
     *
     * @return array
     */
    public function getAllGitlabRepoData()
    {
        return array(
            array('repoName', 0, 0, 0.0),
            array('ИмяРепозитория', 0, 1, 0.25),
            array('!@#$%^&*', 1, 0, 1),
            array('repo-name', 1, 1, 1.25),
            array('repo.name', 10, 20, 15.0)
        );
    }

    /**
     * Test case for repo model data serialization
     *
     * @dataProvider getAllGitlabRepoData
     * @param string $repoName
     * @param int $forkCount
     * @param int $starCount
     * @param float $expectedRating
     * @return void
     */
    public function testData(string $repoName, int $forkCount, int $starCount, float $expectedRating)
    {
        $gitlabTestRepo = new models\GitlabRepo($repoName, $forkCount, $starCount);
        $this->assertEquals(
            ['name' => $repoName, 'fork-count' => $forkCount, 'start-count' => $starCount, 'rating' => $expectedRating,],
            $gitlabTestRepo->getData()
        );
    }

    /**
     * Generating all gitlab repo data for stringify
     *
     * @return array
     */
    public function getAllGitlabRepoDataForStringify()
    {
        return array(
            array('repoName', 0, 0, 'repoName                                                                       0 ⇅    0 ★'),
            array('ИмяРепозитория', 0, 1, 'ИмяРепозитория                                                   0 ⇅    1 ★'),
            array('!@#$%^&*', 1, 1, '!@#$%^&*                                                                       1 ⇅    1 ★'),
            array('repo-name', 1, 0, 'repo-name                                                                      1 ⇅    0 ★'),
            array('repo.name', 10, 20, 'repo.name                                                                     10 ⇅   20 ★')
        );
    }

    /**
     * Test case for repo model __toString verification
     *
     * @dataProvider getAllGitlabRepoDataForStringify
     * @param string $repoName
     * @param int $forkCount
     * @param int $starCount
     * @param string $expectedString
     * @return void
     */
    public function testStringify(string $repoName, int $forkCount, int $starCount, string $expectedString)
    {
        $gitlabTestRepo = new models\GitlabRepo($repoName, $forkCount, $starCount);
        $this->assertEquals($expectedString, (string)$gitlabTestRepo);
    }
}