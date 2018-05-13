<?php
/**
 * Created by PhpStorm.
 * User: m35
 * Date: 2018/5/12
 * Time: 20:37
 */
namespace m35;

class Tree implements TreeableInterface
{
    use TreeableTrait;

    /**
     * Tree constructor.
     * @param array $list
     * @param array $treeConfig
     */
    public function __construct(array $list = [], $treeConfig = [])
    {
        if (!empty($treeConfig)) {
            $this->treeConfig($treeConfig);
        }

        if ($list) {
            $this->loadList($list);
        }
        return $this;
    }
}
