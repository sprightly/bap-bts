<?php
namespace AppBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * @RouteResource("issue")
 * @NamePrefix("app_api_")
 */
class IssueController extends RestController
{
    /**
     * @Acl(
     *      id="app_issue_delete",
     *      type="entity",
     *      class="AppBundle:Issue",
     *      permission="DELETE"
     * )
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function getForm()
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function getFormHandler()
    {
    }

    /**
     * @inheritdoc
     * @return object
     */
    public function getManager()
    {
        return $this->get('app.issue_manager.api');
    }
}
