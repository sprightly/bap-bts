<?php
namespace AppBundle\Entity;

use AppBundle\Model\ExtendIssue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_issue")
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *     defaultValues={
 *          "security"={
 *              "type"="acl"
 *          },
 *          "tag"={
 *              "enabled"=true
 *          },
 *          "workflow"={
 *              "active_workflows"={"issue_status"}
 *          }
 *     }
 * )
 */
class Issue extends ExtendIssue implements DatesAwareInterface
{
    use DatesAwareTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(min=1, max=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @ConfigField()
     *
     * @Assert\Length(min=1, max=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="reporter_id", referencedColumnName="id", onDelete="SET NULL")
     *
     * @var User
     */
    private $reporter;

    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     *
     * @var User
     */
    private $assignee;

    /**
     * @ORM\ManyToMany(targetEntity="Oro\Bundle\UserBundle\Entity\User", inversedBy="issues")
     * @ORM\JoinTable(name="app_issues_collaborators")
     *
     * @var PersistentCollection|ArrayCollection
     */
    private $collaborators;

    /**
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Issue
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="parent")
     *
     * @var ArrayCollection Issue[]
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="Issue", inversedBy="related")
     * @ORM\JoinTable(name="issue_related")
     *
     * @var ArrayCollection Issue[]
     */
    private $related;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->collaborators = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->related = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Issue
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Issue
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Issue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set reporter
     *
     * @param User $reporter
     *
     * @return Issue
     */
    public function setReporter(User $reporter = null)
    {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * Get reporter
     *
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Set assignee
     *
     * @param User $assignee
     *
     * @return Issue
     */
    public function setAssignee(User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * Add collaborator
     *
     * @param User $collaborator
     *
     * @return Issue
     */
    public function addCollaborator(User $collaborator)
    {
        if (! $this->getCollaborators()->contains($collaborator)) {
            $this->collaborators[] = $collaborator;
        }

        return $this;
    }

    /**
     * Remove collaborator
     *
     * @param User $collaborator
     */
    public function removeCollaborator(User $collaborator)
    {
        $this->collaborators->removeElement($collaborator);
    }

    /**
     * Get collaborators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollaborators()
    {
        return $this->collaborators;
    }

    /**
     * Set parent
     *
     * @param Issue $parent
     *
     * @return Issue
     */
    public function setParent(Issue $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Issue
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param Issue $child
     *
     * @return Issue
     */
    public function addChild(Issue $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param Issue $child
     */
    public function removeChild(Issue $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add related
     *
     * @param Issue $related
     *
     * @return Issue
     */
    public function addRelated(Issue $related)
    {
        $this->related[] = $related;

        return $this;
    }

    /**
     * Remove related
     *
     * @param Issue $related
     */
    public function removeRelated(Issue $related)
    {
        $this->related->removeElement($related);
    }

    /**
     * Get related
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRelated()
    {
        return $this->related;
    }
}
