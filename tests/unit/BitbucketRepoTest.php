<?php

namespace tests;

use app\models;

/**
 * BitbucketRepoTest contains test cases for bitbucket repo model
 * 
 * IMPORTANT NOTE:
 * All test cases down below must be implemented
 * You can add new test cases on your own
 * If they could be helpful in any form
 */
class BitbucketRepoTest extends \Codeception\Test\Unit
{

    /**
     * Generating different repo forkCount, watcher count and rating
     *
     * @return array
     */
    public function getForkCountWatcherCountAndRating()
    {
        return array(
            array(0, 0, 0.0),
            array(0, 1, 0.5),
            array(1, 1, 1.5),
            array(1, 0, 1.0),
            array(10, 20, 20.0)
        );
    }

    /**
     * Test case for counting repo rating
     *
     * @dataProvider getForkCountWatcherCountAndRating
     * @param int $forkCount
     * @param int $watcherCount
     * @param int $expectedRating
     * @return void
     */
    public function testRatingCount(int $forkCount, int $watcherCount, float $expectedRating )
    {
        $bitbucketTestRepo = new models\BitbucketRepo('bitbucketTestRepo', $forkCount, $watcherCount);
        $this->assertEquals($expectedRating, $bitbucketTestRepo->getRating());
    }

    /**
     * Test case for repo model data serialization
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
     * Test case for repo model __toString verification
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