<?php

namespace ZF\Doctrine\Audit\Entity;

/**
 * TargetEntity
 */
class TargetEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var boolean
     */
    private $isJoinTable = '0';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ZF\Doctrine\Audit\Entity\AuditEntity
     */
    private $auditEntity;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $child;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $revisionEntity;

    /**
     * @var \ZF\Doctrine\Audit\Entity\TargetEntity
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->child = new \Doctrine\Common\Collections\ArrayCollection();
        $this->revisionEntity = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TargetEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tableName
     *
     * @param string $tableName
     *
     * @return TargetEntity
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Get tableName
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set isJoinTable
     *
     * @param boolean $isJoinTable
     *
     * @return TargetEntity
     */
    public function setIsJoinTable($isJoinTable)
    {
        $this->isJoinTable = $isJoinTable;

        return $this;
    }

    /**
     * Get isJoinTable
     *
     * @return boolean
     */
    public function getIsJoinTable()
    {
        return $this->isJoinTable;
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
     * Set auditEntity
     *
     * @param \ZF\Doctrine\Audit\Entity\AuditEntity $auditEntity
     *
     * @return TargetEntity
     */
    public function setAuditEntity(\ZF\Doctrine\Audit\Entity\AuditEntity $auditEntity)
    {
        $this->auditEntity = $auditEntity;

        return $this;
    }

    /**
     * Get auditEntity
     *
     * @return \ZF\Doctrine\Audit\Entity\AuditEntity
     */
    public function getAuditEntity()
    {
        return $this->auditEntity;
    }

    /**
     * Add child
     *
     * @param \ZF\Doctrine\Audit\Entity\TargetEntity $child
     *
     * @return TargetEntity
     */
    public function addChild(\ZF\Doctrine\Audit\Entity\TargetEntity $child)
    {
        $this->child[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \ZF\Doctrine\Audit\Entity\TargetEntity $child
     */
    public function removeChild(\ZF\Doctrine\Audit\Entity\TargetEntity $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Add revisionEntity
     *
     * @param \ZF\Doctrine\Audit\Entity\RevisionEntity $revisionEntity
     *
     * @return TargetEntity
     */
    public function addRevisionEntity(\ZF\Doctrine\Audit\Entity\RevisionEntity $revisionEntity)
    {
        $this->revisionEntity[] = $revisionEntity;

        return $this;
    }

    /**
     * Remove revisionEntity
     *
     * @param \ZF\Doctrine\Audit\Entity\RevisionEntity $revisionEntity
     */
    public function removeRevisionEntity(\ZF\Doctrine\Audit\Entity\RevisionEntity $revisionEntity)
    {
        $this->revisionEntity->removeElement($revisionEntity);
    }

    /**
     * Get revisionEntity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRevisionEntity()
    {
        return $this->revisionEntity;
    }

    /**
     * Set parent
     *
     * @param \ZF\Doctrine\Audit\Entity\TargetEntity $parent
     *
     * @return TargetEntity
     */
    public function setParent(\ZF\Doctrine\Audit\Entity\TargetEntity $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ZF\Doctrine\Audit\Entity\TargetEntity
     */
    public function getParent()
    {
        return $this->parent;
    }
}
