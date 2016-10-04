<?php
namespace AppBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Migrations\Data\ORM\LoadOrganizationAndBusinessUnitData;
use Oro\Bundle\UserBundle\Entity\Repository\UserRepository;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\UserBundle\Entity\UserManager;
use Oro\Bundle\UserBundle\Migrations\Data\ORM\LoadRolesData;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager = $container->get('oro_user.manager');
    }

    public function load(ObjectManager $manager)
    {
        $organization = $manager->getRepository('OroOrganizationBundle:Organization')->getFirst();
        $businessUnit = $manager
            ->getRepository('OroOrganizationBundle:BusinessUnit')
            ->findOneBy(['name' => LoadOrganizationAndBusinessUnitData::MAIN_BUSINESS_UNIT]);

        /** @var UserRepository $userRepository */
        $adminUser = $manager->getRepository('OroUserBundle:User')->findOneByUsername('admin');
        if (empty($adminUser)) {
            $adminRole = $manager->getRepository('OroUserBundle:Role')
                                 ->findOneBy(['role' => LoadRolesData::ROLE_ADMINISTRATOR]);

            if (! $adminRole) {
                throw new \RuntimeException('Administrator role should exist.');
            }

            /** @var User $adminUser */
            $adminUser = $this->userManager->createUser();
            $adminUser
                ->setUsername('admin')
                ->setEmail('admin@example.com')
                ->setFirstName('John')
                ->setLastName('Doe')
                ->setEnabled(true);
            $adminUser
                ->setOwner($businessUnit)
                ->setPlainPassword('admin')
                ->addRole($adminRole)
                ->addBusinessUnit($businessUnit)
                ->setOrganization($organization)
                ->addOrganization($organization);
            $this->userManager->updateUser($adminUser);
        }

        /** @var User $usualUser */
        $usualUser = $this->userManager->createUser();
        $usualUser
            ->setUsername('usual-user')
            ->setEmail('usual-user@example.com')
            ->setFirstName('Usual First Name')
            ->setLastName('Usual Last Name')
            ->setEnabled(true);
        $usualUser
            ->setOwner($businessUnit)
            ->setPlainPassword('usual-user')
            ->addBusinessUnit($businessUnit)
            ->setOrganization($organization)
            ->addOrganization($organization);
        $this->userManager->updateUser($usualUser);

        /** @var User $anotherUsualUser */
        $anotherUsualUser = $this->userManager->createUser();
        $anotherUsualUser
            ->setUsername('another-usual-user')
            ->setEmail('another-usual-user@example.com')
            ->setFirstName('Another Usual First Name')
            ->setLastName('Another Usual Last Name')
            ->setEnabled(true);
        $anotherUsualUser
            ->setOwner($businessUnit)
            ->setPlainPassword('another-usual-user')
            ->addBusinessUnit($businessUnit)
            ->setOrganization($organization)
            ->addOrganization($organization);
        $this->userManager->updateUser($anotherUsualUser);

        $manager->flush();

        $this->addReference('admin-user', $adminUser);
        $this->addReference('usual-user', $usualUser);
        $this->addReference('another-usual-user', $anotherUsualUser);
    }
}
