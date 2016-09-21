<?php
namespace AppBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\WorkflowBundle\Model\WorkflowAwareManager;

class UpdateIssuesWorkflowState extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $workflowAwareManager = new WorkflowAwareManager($this->container->get('oro_workflow.manager'));
        $workflowAwareManager->setWorkflowName('issue_status');
        $issues = $manager->getRepository('AppBundle:Issue')->findAll();
        foreach ($issues as $issue) {
            if (! $workflowAwareManager->getWorkflowItem($issue)) {
                $workflowAwareManager->startWorkflow($issue);
            }
        }

        $workflowManager = $this->container->get('oro_workflow.manager');
        foreach ($issues as $issue) {
            if ('APB-4' == $issue->getCode()) {
                $workflowManager->transit(
                    $workflowAwareManager->getWorkflowItem($issue),
                    'close'
                );
            } elseif ('APB-11' == $issue->getCode() || 'APB-15' == $issue->getCode()) {
                $workflowManager->transit(
                    $workflowAwareManager->getWorkflowItem($issue),
                    'start_progress'
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Migrations\Data\Demo\ORM\LoadIssueData',
        ];
    }
}
