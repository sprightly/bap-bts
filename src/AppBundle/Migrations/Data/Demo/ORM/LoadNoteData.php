<?php
namespace AppBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\NoteBundle\Entity\Note;

class LoadNoteData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function load(ObjectManager $manager)
    {
        $firstNote = new Note();
        $firstNote->setOwner($this->getReference('admin-user'));
        $firstNote->setOrganization($this->getReference('admin-user')->getOrganization());
        $firstNote->setMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non sem volutpat....');
        $firstNote->setTarget($this->getReference('first-issue'));
        $manager->persist($firstNote);

        $firstNote = new Note();
        $firstNote->setOwner($this->getReference('admin-user'));
        $firstNote->setOrganization($this->getReference('admin-user')->getOrganization());
        $firstNote->setMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit.....');
        $firstNote->setTarget($this->getReference('first-issue'));
        $manager->persist($firstNote);

        $firstNote = new Note();
        $firstNote->setOwner($this->getReference('admin-user'));
        $firstNote->setOrganization($this->getReference('admin-user')->getOrganization());
        $firstNote->setMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit.....');
        $firstNote->setTarget($this->getReference('story-issue'));
        $manager->persist($firstNote);

        $manager->flush();
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
