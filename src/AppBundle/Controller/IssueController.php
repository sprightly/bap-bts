<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Issue;
use Doctrine\ORM\EntityRepository;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/update/{id}", name="app_issue_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="app_issue_update",
     *     type="entity",
     *     class="AppBundle:Issue",
     *     permission="EDIT"
     * )
     * @param Issue $issue
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Issue $issue, Request $request)
    {
        return $this->update($issue, $request);
    }

    /**
     * @Route(
     *     "/create/subtask/{story_id}",
     *     name="app_issue_create_subtask",
     *     requirements={"story_id":"\d+"}
     * )
     * @Template("AppBundle:Issue:update.html.twig")
     * @Acl(
     *     id="app_issue_create",
     *     type="entity",
     *     class="AppBundle:Issue",
     *     permission="CREATE"
     * )
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createSubtaskAction(Request $request)
    {
        $issue = new Issue();
        $story = $this->get('doctrine')
                      ->getRepository('AppBundle:Issue')
                      ->findOneById(
                          $request->attributes->get('_route_params')['story_id']
                      );
        $issue->setParent($story);

        $subtaskType = $this->getDoctrine()
                            ->getRepository(ExtendHelper::buildEnumValueClassName('issue_type'))
                            ->find('subtask');
        $issue->setType($subtaskType);
        $issue->setReporter($this->getUser());

        return $this->update($issue, $request);
    }

    /**
     * @Route(
     *     "/create/{assignee_id}",
     *     name="app_issue_create",
     *     requirements={"assignee_id":"\d+"},
     *     defaults={"assignee_id":null}
     * )
     * @Template("AppBundle:Issue:update.html.twig")
     * @Acl(
     *     id="app_issue_create",
     *     type="entity",
     *     class="AppBundle:Issue",
     *     permission="CREATE"
     * )
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $issue = new Issue();
        if (is_array($request->attributes->get('_route_params'))
            && ! empty($request->attributes->get('_route_params')['assignee_id'])
        ) {
            $assignee = $this->get('oro_user.manager')
                             ->getRepository()
                             ->findOneById(
                                 $request->attributes->get('_route_params')['assignee_id']
                             );
            $issue->setAssignee($assignee);
        }
        $issue->setReporter($this->getUser());

        return $this->update($issue, $request);
    }

    /**
     * @param Issue $issue
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param array $formOptions
     *
     * @internal param Issue $issue
     */
    private function update(Issue $issue, Request $request)
    {
        $form = $this->get('form.factory')->create('app_issue', $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($issue);
            $entityManager->flush();

            return $this->redirectToRoute('app_issue_index');
        }

        return [
            'entity' => $issue,
            'form'   => $form->createView(),
        ];
    }

    /**
     * @Route("/dashboard/issues-by-status-chart", name="app_issues_by_status_chart")
     * @Template("AppBundle:Dashboard:issues_by_status_chart.html.twig")
     * @AclAncestor("app_issue_view")
     */
    public function issuesByTypeChartAction()
    {
        /* @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('OroWorkflowBundle:WorkflowItem');
        $query = $repository->createQueryBuilder('wi');
        $query->select('count(wi.entityId) AS value, ws.label AS label')
           ->join('wi.currentStep', 'ws')
           ->where($query->expr()->eq('wi.entityClass', ':entityClass'))
           ->groupBy('ws.label')
           ->setParameter('entityClass', Issue::class);
        $items = $query->getQuery()->getArrayResult();

        $viewBuilder = $this->container->get('oro_chart.view_builder');
        $view        = $viewBuilder
            ->setOptions(
                array_merge_recursive(
                    [
                        'name' => 'pie_chart',
                    ],
                    $this
                        ->get('oro_chart.config_provider')
                        ->getChartConfig('issues_by_status_chart')
                )
            )
            ->setArrayData($items)
            ->getView();

        return ['chartView' => $view];
    }
}
