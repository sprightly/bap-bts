<?php
namespace AppBundle\Tests\Unit\Entity;

use AppBundle\Entity\Issue;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\Testing\Unit\EntityTestCaseTrait;

class IssueTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestCaseTrait;

    /**
     * Test setters getters
     */
    public function testAccessors()
    {
        $this->assertPropertyAccessors($this->createIssueEntity(), [
            ['id', 1],
            ['summary', 'test summary'],
            ['description', 'test description'],
            ['reporter', new User()],
            ['assignee', new User()],
            ['parent', new Issue()],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ]);

        $this->assertPropertyCollections($this->createIssueEntity(), [
            ['child', new Issue()],
            ['related', new Issue()],
            ['collaborators', new User()],
        ]);
    }

    public function testExtend()
    {
        $this->assertTrue(
            is_a($this->createIssueEntity(), '\AppBundle\Model\ExtendIssue')
        );
    }

    /**
     * @return Issue
     */
    protected function createIssueEntity()
    {
        return new Issue();
    }
}
