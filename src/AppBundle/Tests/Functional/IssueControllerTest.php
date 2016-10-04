<?php

namespace AppBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

class IssueControllerTest extends WebTestCase
{

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->initClient(array(), $this->generateBasicAuthHeader());
    }

    public function testIndexAction()
    {
        $crawler = $this->client->request('GET', $this->getUrl('app_issue_index'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertEquals(
            1,
            $crawler->filter('div[data-page-component-name="app-issues-grid"]')->count()
        );
    }

    public function testViewAction()
    {
        $crawler = $this->client->request('GET', $this->getUrl('app_issue_view', ['id' => 1]));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertEquals(
            1,
            $crawler->filter('div[data-page-component-name="app-issue-collaborators-grid"]')->count()
        );
    }

    public function testIssuesByTypeChartAction()
    {
        $this->client->request(
            'GET',
            $this->getUrl(
                'app_issues_by_type_chart'
            )
        );
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains('Issues by type chart', $result->getContent());
    }
}
