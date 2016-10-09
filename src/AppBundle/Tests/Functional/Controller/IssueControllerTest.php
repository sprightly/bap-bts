<?php

namespace AppBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * Class IssueControllerTest
 * @package AppBundle\Tests\Functional\Controller
 * @dbIsolation
 */
class IssueControllerTest extends WebTestCase
{

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());
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
        $this->assertContains(
            'APB-1',
            $crawler->filter('.control-label')->eq(1)->text()
        );
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

    public function testCreateAction()
    {
        $testIssueSummary = 'test add issue action';
        $testIssueDescription = '...';
        $testIssueType = 'task';
        $testIssuePriority = 'critical';

        $crawler = $this->client->request('GET', '/issue/create/2');

        $form = $crawler->filter('button.btn-success[type=submit]')->form(
            [
                'app_issue[summary]' => $testIssueSummary,
                'app_issue[description]' => $testIssueDescription,
                'app_issue[type]' => $testIssueType,
                'app_issue[priority]' => $testIssuePriority,
            ]
        );
        $crawler = $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains(
            $testIssueSummary,
            $crawler->filter('input[name="app_issue[summary]"]')->attr('value')
        );
    }

    public function testCreateSubtaskAction()
    {
        $testIssueSummary = 'test add subtask issue action';
        $testIssueDescription = '...';
        $testIssuePriority = 'critical';
        $testAssignee = 2;

        $crawler = $this->client->request('GET', '/issue/create/subtask/13');

        $form = $crawler->filter('button.btn-success[type=submit]')->form(
            [
                'app_issue[summary]' => $testIssueSummary,
                'app_issue[description]' => $testIssueDescription,
                'app_issue[assignee]' => $testAssignee,
                'app_issue[priority]' => $testIssuePriority,
            ]
        );
        $crawler = $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains(
            $testIssueSummary,
            $crawler->filter('input[name="app_issue[summary]"]')->attr('value')
        );
    }

    public function testUpdateAction()
    {
        $testIssueSummary = 'Third issue.. updated';

        $crawler = $this->client->request('GET', '/issue/update/3');

        $form = $crawler->filter('button.btn-success[type=submit]')->form(
            [
                'app_issue[summary]' => $testIssueSummary,
            ]
        );
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains(
            $testIssueSummary,
            $crawler->filter('div[data-page-component-name="app-issues-grid"]')->attr('data-page-component-options')
        );
    }
}
