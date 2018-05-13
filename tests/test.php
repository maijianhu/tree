<?php
require __DIR__ . "/../vendor/autoload.php";

use m35\Tree;

$list = [
    [
        'id' => 1,
        'name' => 'default',
        'pid' => 0,
    ],
    [
        'id' => 2,
        'name' => 'node-a',
        'pid' => 1,
    ],
    [
        'id' => 3,
        'name' => 'node-b',
        'pid' => 1,
    ],
    [
        'id' => 4,
        'name' => 'node-b-a',
        'pid' => 3,
    ]
];

$data = [
    ['id' => 1, 'parent' => 0, 'title' => 'Node 1'],
    ['id' => 2, 'parent' => 1, 'title' => 'Node 1.1'],
    ['id' => 3, 'parent' => 0, 'title' => 'Node 3'],
    ['id' => 4, 'parent' => 1, 'title' => 'Node 1.2'],
];
$otherTree = new Tree($list, [
//    'paramNodeParentId' => 'parent',
]);

$node1 = $otherTree->findNode(4);
echo $node1->getLevel();
//$arr = $node1->getDescendantsAndSelf();
//print_r($arr);
//$arr = $node1->getAncestorsAndSelf();
//print_r($otherTree->getNodeId());


//$aTree = new Tree($list);
//$bTree = new Tree($list);
//
//$aRoot = $aTree->find(1);
//$bRoot = $bTree->find(1);
//
//$aA = $aTree->find(2);
//$bA = $bTree->find(2);
//
//$aB = $aTree->find(3);
//$bB = $bTree->find(3);
//
//$aBA = $aTree->find(4);
//$bBA = $bTree->find(4);
//
//var_dump($aRoot->inherit($bBA));
//var_dump($bB->inherit($aB));
//
//$result = $aBA->getInheritAncestors();
//foreach ($result as $item) {
//    print_r($item->getData());
//}
//var_dump($defaultB->inherit($nodeBA));
//var_dump($node_BA->inherit($nodeBA));




//var_dump($defaultB->inherit($default));
//$a = $defaultB->getInheritAncestors();

//var_dump($default->inherit($defaultB));
//var_dump($default->inherit($nodeA));

//$c = $defaultB->getInheritAncestors();
//var_dump($default->hasChild($defaultB));
//var_dump($default->hasChild($nodeA));

