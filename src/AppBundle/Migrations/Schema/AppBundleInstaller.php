<?php

namespace AppBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\NoteBundle\Migration\Extension\NoteExtension;
use Oro\Bundle\NoteBundle\Migration\Extension\NoteExtensionAwareInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class AppBundleInstaller implements Installation, ExtendExtensionAwareInterface, NoteExtensionAwareInterface
{
    /** @var NoteExtension */
    protected $noteExtension;

    protected $issueTableName = 'app_issue';

    /**
     * {@inheritdoc}
     */
    public function setNoteExtension(NoteExtension $noteExtension)
    {
        $this->noteExtension = $noteExtension;
    }

    /** @var  ExtendExtension */
    protected $extendExtension;

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createAppIssueTable($schema);
        $this->createAppIssuesCollaboratorsTable($schema);
        $this->createIssueRelatedTable($schema);

        /** Foreign keys generation **/
        $this->addAppIssueForeignKeys($schema);
        $this->addAppIssuesCollaboratorsForeignKeys($schema);
        $this->addIssueRelatedForeignKeys($schema);

        /** Add configurable fields **/
        $this->addIssuePriorityField($schema);
        $this->addIssueTypeField($schema);
        $this->addIssueResolutionField($schema);

        $this->noteExtension->addNoteAssociation($schema, $this->issueTableName);
    }


    /**
     * Create app_issue table
     *
     * @param Schema $schema
     */
    protected function createAppIssueTable(Schema $schema)
    {
        $table = $schema->createTable($this->issueTableName);
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('assignee_id', 'integer', ['notnull' => false]);
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_id', 'integer', ['notnull' => false]);
        $table->addColumn('summary', 'string', ['length' => 255]);
        $table->addColumn('code', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', []);
        $table->addColumn('serialized_data', 'array', ['notnull' => false, 'comment' => '(DC2Type:array)']);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['code'], 'UNIQ_C47EAEF377153098');
        $table->addIndex(['reporter_id'], 'IDX_C47EAEF3E1CFE6F5', []);
        $table->addIndex(['assignee_id'], 'IDX_C47EAEF359EC7D60', []);
        $table->addIndex(['parent_id'], 'IDX_C47EAEF3727ACA70', []);
    }

    /**
     * Create app_issues_collaborators table
     *
     * @param Schema $schema
     */
    protected function createAppIssuesCollaboratorsTable(Schema $schema)
    {
        $table = $schema->createTable('app_issues_collaborators');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('user_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'user_id']);
        $table->addIndex(['issue_id'], 'IDX_335E04005E7AA58C', []);
        $table->addIndex(['user_id'], 'IDX_335E0400A76ED395', []);
    }

    /**
     * Create issue_related table
     *
     * @param Schema $schema
     */
    protected function createIssueRelatedTable(Schema $schema)
    {
        $table = $schema->createTable('issue_related');
        $table->addColumn('issue_source', 'integer', []);
        $table->addColumn('issue_target', 'integer', []);
        $table->setPrimaryKey(['issue_source', 'issue_target']);
        $table->addIndex(['issue_source'], 'IDX_C5AF3571AD7AF554', []);
        $table->addIndex(['issue_target'], 'IDX_C5AF3571B49FA5DB', []);
    }

    /**
     * Add app_issue foreign keys.
     *
     * @param Schema $schema
     */
    protected function addAppIssueForeignKeys(Schema $schema)
    {
        $table = $schema->getTable($this->issueTableName);
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assignee_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable($this->issueTableName),
            ['parent_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['reporter_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add app_issues_collaborators foreign keys.
     *
     * @param Schema $schema
     */
    protected function addAppIssuesCollaboratorsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('app_issues_collaborators');
        $table->addForeignKeyConstraint(
            $schema->getTable($this->issueTableName),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add issue_related foreign keys.
     *
     * @param Schema $schema
     */
    protected function addIssueRelatedForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('issue_related');
        $table->addForeignKeyConstraint(
            $schema->getTable($this->issueTableName),
            ['issue_source'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable($this->issueTableName),
            ['issue_target'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * @param Schema $schema
     */
    protected function addIssuePriorityField(Schema $schema)
    {
        $table = $schema->getTable($this->issueTableName);
        $this->extendExtension->addEnumField(
            $schema,
            $table,
            'priority',
            'issue_priority',
            false,
            true,
            [
                'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
            ]
        );
    }

    /**
     * @param Schema $schema
     */
    protected function addIssueTypeField(Schema $schema)
    {
        $table = $schema->getTable($this->issueTableName);
        $this->extendExtension->addEnumField(
            $schema,
            $table,
            'type',
            'issue_type',
            false,
            true,
            [
                'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
            ]
        );
    }

    /**
     * @param Schema $schema
     */
    protected function addIssueResolutionField(Schema $schema)
    {
        $table = $schema->getTable($this->issueTableName);
        $this->extendExtension->addEnumField(
            $schema,
            $table,
            'resolution',
            'issue_resolution',
            false,
            true,
            [
                'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
            ]
        );
    }
}
