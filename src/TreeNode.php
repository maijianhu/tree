<?php
/**
 * Created by PhpStorm.
 * User: m35
 * Date: 2018/5/12
 * Time: 20:38
 */
namespace m35;

class TreeNode
{
    protected $tree; // 用于存放所属树
    protected $parent; // 用于存放父对象
    protected $children = []; // 用于存放子对象
    protected $data; // 用于存放节点数据
    protected $inherit; // 用于存放向上继承节点

    protected $attributes; // 用于存放节点特性，即节点之外的数据

    public function __construct(array $data, TreeableInterface $tree)
    {
        $this->data = $data;
        $this->tree = $tree;
    }

    /**
     * 返回节点数据
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 返回节点所在树
     * @return TreeableInterface
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * 返回子节点
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * 返回继承节点
     * @return mixed
     */
    public function getInherit()
    {
        return is_null($this->inherit) ? $this->parent : $this->inherit;
    }

    /**
     * 获取父节点
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * 返回祖先节点
     * @return array
     */
    public function getAncestors()
    {
        $ancestors = [];
        $parent = $this->getParent();
        while ($parent !== null) {
            $ancestors[] = $parent;
            $parent = $parent->getParent();
        }
        return $ancestors;
    }

    /**
     * 返回祖先节点，并包括自己
     * @return array
     */
    public function getAncestorsAndSelf()
    {
        $ancestors = $this->getAncestors();
        array_unshift($ancestors, $this);
        return $ancestors;
    }

    /**
     * 返回兄弟节点
     * @return array
     */
    public function getSiblings()
    {
        $siblings = [];
        $parent = $this->getParent();
        if ($parent) {
            foreach ($parent->getChildren() as $child) {
                if ($child !== $this) {
                    $siblings[] = $child;
                }
            }
        }
        return $siblings;
    }

    /**
     * 返回兄弟节点，包括自己
     * @return array
     */
    public function getSiblingsAndSelf()
    {
        $parent = $this->getparent();
        return $parent->getChildren();
    }
    
    /**
     * 返回节点的继承链
     */
    public function getInheritAncestors()
    {
        $ancestors = [];
        $ancestor = $this->getInherit();
        while ($ancestor !== null) {
            $ancestors[] = $ancestor;
            $ancestor = $ancestor->getInherit();
        }
        return $ancestors;
    }

    /**
     * 用于判断是否是叶子节点
     * @return bool
     */
    public function isLeaf()
    {
        return count($this->children) === 0;
    }

    /**
     * 判断是否是根节点
     * @return bool
     */
    public function isRoot()
    {
        return $this->tree->isRootNode($this);
    }

    /**
     * 用于继承某个节点
     * @param TreeNode $node
     * @return bool
     */
    public function inherit(self $node)
    {
        // 如果存在于继承链
        if ($node->isInherit($this)) {
            return false;
        }

        // 如果两个节点的树是不同的
        if ($node->getTree() !== $this->tree) {
            $this->inherit = $node;
            return true;
        }

        // 如果两个节点不同，且继承的节点不是自己的子节点
        if ($node !== $this && !$this->hasChild($node)) {
            $this->inherit = $node;
            return true;
        }

        return false;
    }

    /**
     * 判断是否继承了$node
     * @param TreeNode $node
     * @return bool
     */
    public function isInherit(self $node)
    {
        $inheritAncestors = $this->getInheritAncestors();
        foreach ($inheritAncestors as $ancestor) {
            if ($ancestor === $node) {
                return true;
            }
        }
        return false;
    }

    /**
     * 判断是否包含某个节点
     * @param TreeNode $node
     * @return bool
     */
    public function hasChild(self $node)
    {
        foreach ($node->getAncestors() as $ancestor) {
            if ($ancestor === $this) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取节点层级
     * @return mixed
     */
    public function getLevel()
    {
        return count($this->getAncestorsAndSelf());
    }

    /**
     * 用于设置节点特性
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * 用于获取节点特性，注：如果没有被设置节点特性，要回溯
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function addChild(self $child)
    {
        $this->children[$child->tree->getNodeId($child)] = $child;
        $child->setParent($this);
    }

    public function setParent(self $parent)
    {
        $this->parent = $parent;
    }

    public function getDescendants()
    {
        $descendants = [];
        foreach ($this->getChildren() as $child) {
            $descendants[] = $child;
            $descendants = array_merge($descendants, $child->getDescendants());
        }
        return $descendants;
    }

    public function getDescendantsAndSelf()
    {
        $descendants = $this->getDescendants();
        array_unshift($descendants, $this);
        return $descendants;
    }
}
