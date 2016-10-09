<?php
namespace AppBundle\Tests\Functional\Controller\Api\Rest;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * @dbIsolation
 */
class IssueControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());
    }

    public function testDelete()
    {
        $this->client->request(
            'DELETE',
            $this->getUrl('app_api_delete_issue', ['id' => 3]),
            [],
            [],
            $this->generateWsseAuthHeader()
        );
        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, 204);
    }
}
