<?php
namespace AppBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Issue;
use Oro\Bundle\EntityExtendBundle\Entity\Repository\EnumValueRepository;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;

class LoadIssueData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function load(ObjectManager $manager)
    {
        $typeClassName = ExtendHelper::buildEnumValueClassName('issue_type');
        /** @var EnumValueRepository $typeRepository */
        $typeRepository = $manager->getRepository($typeClassName);
        $taskType = $typeRepository->findOneById('task');
        $subtaskType = $typeRepository->findOneById('subtask');
        $storyType = $typeRepository->findOneById('story');

        $priorityClassName = ExtendHelper::buildEnumValueClassName('issue_priority');
        /** @var EnumValueRepository $priorityRepository */
        $priorityRepository = $manager->getRepository($priorityClassName);
        $majorPriority = $priorityRepository->findOneById('major');
        $blockerPriority = $priorityRepository->findOneById('blocker');
        $trivialPriority = $priorityRepository->findOneById('trivial');

        $resolutionClassName = ExtendHelper::buildEnumValueClassName('issue_resolution');
        /** @var EnumValueRepository $resolutionRepository */
        $resolutionRepository = $manager->getRepository($resolutionClassName);
        $fixedResolution = $resolutionRepository->findOneById('fixed');

        $firstIssue = new Issue();
        $firstIssue->setSummary('First issue..');
        $firstIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $firstIssue->setCode('APB-1');
        $firstIssue->setType($taskType);
        $firstIssue->setPriority($majorPriority);
        $firstIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $firstIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $firstIssue->setAssignee($this->getReference('usual-user'));
        $firstIssue->setReporter($this->getReference('admin-user'));
        $firstIssue->addCollaborator($this->getReference('usual-user'));
        $firstIssue->addCollaborator($this->getReference('admin-user'));
        $manager->persist($firstIssue);

        $storyIssue = new Issue();
        $storyIssue->setSummary('Story issue..');
        $storyIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $storyIssue->setCode('APB-2');
        $storyIssue->setType($storyType);
        $storyIssue->setPriority($majorPriority);
        $storyIssue->setUpdatedAt(new \DateTime('2016-07-01 22:11:31'));
        $storyIssue->setCreatedAt(new \DateTime('2016-07-01 19:11:31'));
        $storyIssue->setAssignee($this->getReference('usual-user'));
        $storyIssue->setReporter($this->getReference('admin-user'));
        $storyIssue->addCollaborator($this->getReference('usual-user'));
        $storyIssue->addCollaborator($this->getReference('admin-user'));
        $manager->persist($storyIssue);

        $openSubTask = new Issue();
        $openSubTask->setSummary('Open sub-task..');
        $openSubTask->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $openSubTask->setCode('APB-3');
        $openSubTask->setType($subtaskType);
        $openSubTask->setPriority($trivialPriority);
        $openSubTask->setUpdatedAt(new \DateTime('2016-07-03 19:11:31'));
        $openSubTask->setCreatedAt(new \DateTime('2016-07-01 18:15:31'));
        $openSubTask->setAssignee($this->getReference('usual-user'));
        $openSubTask->setReporter($this->getReference('another-usual-user'));
        $openSubTask->addCollaborator($this->getReference('usual-user'));
        $openSubTask->addCollaborator($this->getReference('admin-user'));
        $openSubTask->addCollaborator($this->getReference('another-usual-user'));
        $openSubTask->setParent($storyIssue);
        $manager->persist($openSubTask);

        $closedSubTask = new Issue();
        $closedSubTask->setSummary('Closed sub-task..');
        $closedSubTask->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $closedSubTask->setCode('APB-4');
        $closedSubTask->setType($subtaskType);
        $closedSubTask->setPriority($blockerPriority);
        $closedSubTask->setResolution($fixedResolution);
        $closedSubTask->setUpdatedAt(new \DateTime('2016-07-05 10:11:31'));
        $closedSubTask->setCreatedAt(new \DateTime('2016-07-04 12:11:31'));
        $closedSubTask->setAssignee($this->getReference('another-usual-user'));
        $closedSubTask->setReporter($this->getReference('admin-user'));
        $closedSubTask->addCollaborator($this->getReference('another-usual-user'));
        $closedSubTask->addCollaborator($this->getReference('admin-user'));
        $closedSubTask->setParent($storyIssue);
        $manager->persist($closedSubTask);

        $manager->flush();

        $this->addReference('first-issue', $firstIssue);
        $this->addReference('story-issue', $storyIssue);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Migrations\Data\Demo\ORM\LoadUserData',
        ];
    }
}
