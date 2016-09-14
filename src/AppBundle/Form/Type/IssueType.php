<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Issue;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\EntityExtendBundle\Entity\AbstractEnumValue;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{
    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /** @var  Issue */
    protected $entity;

    /**
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(DoctrineHelper $doctrineHelper)
    {
        $this->doctrineHelper = $doctrineHelper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $issueTypes        = $this->doctrineHelper
            ->getEntityRepository(ExtendHelper::buildEnumValueClassName('issue_type'))
            ->findAll();
        $issueTypesChoices = [];
        /** @var AbstractEnumValue $issueType */
        foreach ($issueTypes as $issueType) {
            $issueTypesChoices[$issueType->getName()] = $issueType;
        }

        $issuePriorities      = $this->doctrineHelper
            ->getEntityRepository(ExtendHelper::buildEnumValueClassName('issue_priority'))
            ->findAll();
        $issuePriorityChoices = [];
        /** @var AbstractEnumValue $issuePriority */
        foreach ($issuePriorities as $issuePriority) {
            $issuePriorityChoices[$issuePriority->getName()] = $issuePriority;
        }

        $this->entity = $builder->getData();
        $builder
            ->add('summary')
            ->add('code')
            ->add('description')
            ->add(
                'assignee',
                EntityType::class,
                [
                    'label'       => 'app.issue.assignee.label',
                    'class'       => User::class,
                    'choice_attr' => function ($val) {
                        if ($this->entity->getAssignee() == $val) {
                            return ['selected' => 'selected'];
                        } else {
                            return [];
                        }
                    },
                ]
            )
            ->add(
                'type',
                EntityType::class,
                [
                    'class'   => ExtendHelper::buildEnumValueClassName('issue_type'),
                    'choices' => $issueTypesChoices,
                    'label' => 'app.issue.type.label'
                ]
            )
            ->add(
                'priority',
                EntityType::class,
                [
                    'class'   => ExtendHelper::buildEnumValueClassName('issue_priority'),
                    'choices' => $issuePriorityChoices,
                    'label' => 'app.issue.priority.label'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Issue',
            )
        );
    }

    public function getName()
    {
        return 'app_issue';
    }
}
