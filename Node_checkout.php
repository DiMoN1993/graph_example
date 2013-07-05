<?php
/**
 * Created by JetBrains PhpStorm.
 * User: developer
 * Date: 6/28/13
 * Time: 1:35 PM
 * To change this template use File | Settings | File Templates.
 */

class Graph
{
    private $GraphDescription;

    public function __construct($Graph)
    {
        $this->GraphDescription = $Graph;
    }

    public function getSubgraph($KeyOfNode)
    {
        $AllNodes = array();
        $SwitchedNodes = array();
        $AllNodes[$KeyOfNode] = $this->GraphDescription[$KeyOfNode];
        $SwitchedNodes[$KeyOfNode] = $this->GraphDescription[$KeyOfNode];
        $i;
        while (count($SwitchedNodes) != 0)
        {
            $PopOutArray = array_pop($SwitchedNodes);
            $node = new Node($PopOutArray);
            $subgraphNodes = $node->getDependences();
            foreach ($subgraphNodes as $node_id)
            {
                if(!isset($AllNodes[$node_id]))
                {
                    $GraphNode = $this->getNode($node_id);
                    $AllNodes[$GraphNode['uuid']] = $GraphNode;
                    $SwitchedNodes[$GraphNode['uuid']] = $GraphNode;
                }
            }
        }
        return new Graph($AllNodes);
    }


    function getNode($node_id)
    {
       return $this->GraphDescription[$node_id];
    }

    function getAllNodes()
    {
        return $this->GraphDescription;
    }
}

class Node
{
    private $Node = array();

    public function __construct($Node)
    {
        $this->Node = $Node;
    }

    public function getDependences()
    {
        $ReturnNode = array();
        foreach ($this->Node as $key => $value)
        {
            if (preg_match('/_ref|_ref.[0-9]|ref/', $key))
            {
                $ReturnNode[] = $value;
            }
        }
        return $ReturnNode;
    }
}