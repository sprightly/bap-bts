<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Issue;
use Doctrine\ORM\EntityRepository;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/issue")
 */
class IssueController extends Controller
{
    /**
     * @Route("/", name="app_issue_index")
     * @Template()
     * @Acl(
     *     id="app_issue_view",
     *     type="entity",
     *     class="AppBundle:Issue",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/{id}", name="app_issue_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("app_issue_view")
     *
     * @param Issue $issue
     *
     * @return array
     */
    public function viewAction(Issue $issue)
    {
        return ['entity' => $issue];
    }

    /**
     * @Route("/dashboard/issues-by-status-chart", name="app_issues_by_type_chart")
     * @Template("AppBundle:Dashboard:issues_by_type_chart.html.twig")
     * @AclAncestor("app_issue_view")
     */
    public function issuesByTypeChartAction()
    {
        /* @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Issue');
        $query = $repository->createQueryBuilder('issue')
            ->select('count(issue.id) as value, type.name as label')
            ->leftJoin('issue.type', 'type')
            ->groupBy('issue.type')
            ->getQuery();
        $items = $query->getResult();

        $viewBuilder = $this->container->get('oro_chart.view_builder');
        $view = $viewBuilder
            ->setOptions(
                array_merge_recursive(
                    [
                        'name' => 'pie_chart',
                    ],
                    $this
                        ->get('oro_chart.config_provider')
                        ->getChartConfig('issues_by_type_chart')
                )
            )
            ->setArrayData($items)
            ->getView();

        return ['chartView' => $view];
    }
}
