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
        $taskType       = $typeRepository->findOneById('task');
        $subtaskType    = $typeRepository->findOneById('subtask');
        $storyType      = $typeRepository->findOneById('story');

        $priorityClassName = ExtendHelper::buildEnumValueClassName('issue_priority');
        /** @var EnumValueRepository $priorityRepository */
        $priorityRepository = $manager->getRepository($priorityClassName);
        $majorPriority      = $priorityRepository->findOneById('major');
        $blockerPriority    = $priorityRepository->findOneById('blocker');
        $trivialPriority    = $priorityRepository->findOneById('trivial');

        $resolutionClassName = ExtendHelper::buildEnumValueClassName('issue_resolution');
        /** @var EnumValueRepository $resolutionRepository */
        $resolutionRepository = $manager->getRepository($resolutionClassName);
        $fixedResolution      = $resolutionRepository->findOneById('fixed');

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
        $manager->persist($firstIssue);

        $secondIssue = new Issue();
        $secondIssue->setSummary('Second issue..');
        $secondIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $secondIssue->setCode('APB-11');
        $secondIssue->setType($taskType);
        $secondIssue->setPriority($majorPriority);
        $secondIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $secondIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $secondIssue->setAssignee($this->getReference('usual-user'));
        $secondIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($secondIssue);

        $thirdIssue = new Issue();
        $thirdIssue->setSummary('Third issue..');
        $thirdIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $thirdIssue->setCode('APB-12');
        $thirdIssue->setType($taskType);
        $thirdIssue->setPriority($majorPriority);
        $thirdIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $thirdIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $thirdIssue->setAssignee($this->getReference('usual-user'));
        $thirdIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($thirdIssue);

        $fourthIssue = new Issue();
        $fourthIssue->setSummary('Fourth issue..');
        $fourthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $fourthIssue->setCode('APB-13');
        $fourthIssue->setType($taskType);
        $fourthIssue->setPriority($majorPriority);
        $fourthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $fourthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $fourthIssue->setAssignee($this->getReference('usual-user'));
        $fourthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($fourthIssue);

        $fifthIssue = new Issue();
        $fifthIssue->setSummary('Fifth issue..');
        $fifthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $fifthIssue->setCode('APB-14');
        $fifthIssue->setType($taskType);
        $fifthIssue->setPriority($majorPriority);
        $fifthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $fifthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $fifthIssue->setAssignee($this->getReference('usual-user'));
        $fifthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($fifthIssue);

        $sixthIssue = new Issue();
        $sixthIssue->setSummary('Sixth issue..');
        $sixthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $sixthIssue->setCode('APB-15');
        $sixthIssue->setType($taskType);
        $sixthIssue->setPriority($majorPriority);
        $sixthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $sixthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $sixthIssue->setAssignee($this->getReference('usual-user'));
        $sixthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($sixthIssue);

        $seventhIssue = new Issue();
        $seventhIssue->setSummary('Seventh issue..');
        $seventhIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $seventhIssue->setCode('APB-16');
        $seventhIssue->setType($taskType);
        $seventhIssue->setPriority($majorPriority);
        $seventhIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $seventhIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $seventhIssue->setAssignee($this->getReference('usual-user'));
        $seventhIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($seventhIssue);

        $eighthIssue = new Issue();
        $eighthIssue->setSummary('Eighth issue..');
        $eighthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $eighthIssue->setCode('APB-17');
        $eighthIssue->setType($taskType);
        $eighthIssue->setPriority($majorPriority);
        $eighthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $eighthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $eighthIssue->setAssignee($this->getReference('usual-user'));
        $eighthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($eighthIssue);

        $ninthIssue = new Issue();
        $ninthIssue->setSummary('Ninth issue..');
        $ninthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $ninthIssue->setCode('APB-18');
        $ninthIssue->setType($taskType);
        $ninthIssue->setPriority($majorPriority);
        $ninthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $ninthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $ninthIssue->setAssignee($this->getReference('usual-user'));
        $ninthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($ninthIssue);

        $tenthIssue = new Issue();
        $tenthIssue->setSummary('Tenth issue..');
        $tenthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $tenthIssue->setCode('APB-19');
        $tenthIssue->setType($taskType);
        $tenthIssue->setPriority($majorPriority);
        $tenthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $tenthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $tenthIssue->setAssignee($this->getReference('usual-user'));
        $tenthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($tenthIssue);

        $eleventhIssue = new Issue();
        $eleventhIssue->setSummary('Eleventh issue..');
        $eleventhIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $eleventhIssue->setCode('APB-20');
        $eleventhIssue->setType($taskType);
        $eleventhIssue->setPriority($majorPriority);
        $eleventhIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $eleventhIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $eleventhIssue->setAssignee($this->getReference('usual-user'));
        $eleventhIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($eleventhIssue);

        $twelfthIssue = new Issue();
        $twelfthIssue->setSummary('Twelfth issue..');
        $twelfthIssue->setDescription(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat, 
            faucibus elit id, dapibus ligula. Suspendisse vehicula quam non tincidunt ultricies. Vestibulum ante ipsum 
            primis in faucibus orci luctus et ultrices posuere cubilia Curae; In mollis nunc sed ante lacinia ultricies 
            in quis tellus. Suspendisse vulputate, nisl efficitur faucibus posuere, augue lacus ornare est, nec 
            interdum mauris neque ut arcu. Nunc dolor sapien, elementum ac ultrices id, accumsan id sapien. 
            Duis sed suscipit nulla, in ullamcorper lectus. Pellentesque quis turpis ligula. 
        '
        );
        $twelfthIssue->setCode('APB-21');
        $twelfthIssue->setType($taskType);
        $twelfthIssue->setPriority($majorPriority);
        $twelfthIssue->setUpdatedAt(new \DateTime('2016-07-01 15:11:31'));
        $twelfthIssue->setCreatedAt(new \DateTime('2016-07-01 10:11:31'));
        $twelfthIssue->setAssignee($this->getReference('usual-user'));
        $twelfthIssue->setReporter($this->getReference('admin-user'));
        $manager->persist($twelfthIssue);

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
