<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Issue;
use Oro\Bundle\WorkflowBundle\Model\WorkflowManager;

class IssueListener
{
    /**
     * @var WorkflowManager
     */
    private $workflowManager;

    /**
     * IssueListener constructor.
     *
     * @param WorkflowManager $workflowManager
     */
    public function __construct(WorkflowManager $workflowManager)
    {
        $this->workflowManager = $workflowManager;
    }

    public function postLoad(Issue $issue)
    {
        if (!$this->workflowManager) {
            return null;
        }

        $workflowItem = $this->workflowManager->getWorkflowItem($issue, 'issue_status');

        if (!$workflowItem) {
            return null;
        }

        if (!$workflowItem->getCurrentStep()) {
            return null;
        }

        $issue->setWorkflowStepLabel($workflowItem->getCurrentStep()->getLabel());
    }
}
