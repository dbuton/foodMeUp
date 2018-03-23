<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="category")
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="path", type="text")
     *
     * @var string
     */
    private $path;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     *
     * @var int
     */
    private $left;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="level", type="integer")
     *
     * @var int
     */
    private $level;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     *
     * @var int
     */
    private $right;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Category
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Category
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     *
     * @var Category
     */
    private $children;

    /**
     * Category constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getLeft(): int
    {
        return $this->left;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getRight(): int
    {
        return $this->right;
    }

    /**
     * @return Category
     */
    public function getRoot(): ? Category
    {
        return $this->root;
    }

    /**
     * @return Category
     */
    public function getParent(): ? Category
    {
        return $this->parent;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }
}
