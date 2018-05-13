<?php
/**
 * Created by PhpStorm.
 * User: m35
 * Date: 2018/5/12
 * Time: 20:38
 */
namespace m35;

trait TreeableTrait
{
    protected $treeConfig = [
        'paramNodeId' => 'id', // 参数名：节点的id
        'paramNodeParentId' => 'pid', // 参数名：节点的parent id
        'rootParentValue' => 0, // 用于从数据中对比是否是根节点
    ]; // 树配置

    public $treeData; // 存放树数据
    protected $nodes; // 节点数据
    protected $nodeHash; // 节点hash
    protected $rootNodes = []; // 用于存放根节点对象

    public function loadList(array $list)
    {
        $this->nodes = $list;
        $this->buildTree();
    }

    /**
     * 创建树
     */
    protected function buildTree()
    {
        $this->nodeHash = [];
        foreach ($this->nodes as $node) {
            $this->pushTreeNode($node);
        }
    }

    /**
     * 依据数据创建树节点
     * @param array $data
     * @return bool
     */
    protected function buildTreeNode(array $data)
    {
        if (!isset($data[$this->treeConfig['paramNodeId']])) {
            return false;
        }
        $id = $data[$this->treeConfig['paramNodeId']];

        if (!isset($data[$this->treeConfig['paramNodeParentId']])) {
            return false;
        }
        $pid = $data[$this->treeConfig['paramNodeParentId']];

        $node = new TreeNode($data, $this);
        $this->nodeHash[$id] = $node;
        if (isset($this->nodeHash[$pid])) {
            $parent = $this->nodeHash[$pid];
            $parent->addChild($node);
        }
        if ($this->isRootNode($node)) {
            $this->rootNodes[$id] = $node;
        }

        return false;
    }

    /**
     * 向树中push节点
     * @param $node
     * @return bool
     */
    public function pushTreeNode($node)
    {
        if (is_array($node)) {
            return $this->buildTreeNode($node);
        }

        return false;
    }

    public function getNodeId(TreeNode $node)
    {
        $data = $node->getData();
        return $data[$this->treeConfig['paramNodeId']];
    }

    /**
     * 配置
     * @param $key
     * @param null $value
     * @return array $treeConfig
     */
    public function treeConfig($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->treeConfig($k, $v);
            }
        } else {
            $this->treeConfig[$key] = $value;
        }
        return $this->treeConfig;
    }

    public function getTreeConfig()
    {
        return $this->treeConfig;
    }

    /**
     * 判断一个节点是否是根节点
     * @param TreeNode $node
     * @return bool
     */
    public function isRootNode(TreeNode $node)
    {
        $data = $node->getData();
        $nodeParentValue = isset($data[$this->treeConfig['paramNodeParentId']]) ? $data[$this->treeConfig['paramNodeParentId']] : null;
        if (is_numeric($this->treeConfig['rootParentValue'])) {
            return (int)$nodeParentValue === (int)$this->treeConfig['rootParentValue'];
        } else {
            return $nodeParentValue === $this->treeConfig['rootParentValue'];
        }
    }

    /**
     * 查找树的节点
     * @param $id
     * @return TreeNode|null
     */
    public function findNode($id)
    {
        return isset($this->nodeHash[$id]) ? $this->nodeHash[$id] : null;
    }

    /**
     * 返回所有nodes
     * @return mixed
     */
    public function getNodes()
    {
        return $this->nodeHash;
    }
}
