<?php
/**
 * Created by JetBrains PhpStorm.
 * User: developer
 * Date: 6/28/13
 * Time: 1:35 PM
 * To change this template use File | Settings | File Templates.
 */

class Node_checkout
{

private $AllNodes = array();
private $SwitchedNodes = array();
private $PopOutArray;
private $node = array();
private $Graph = array();
private $TestValue;

function __construct($graph, $test_value)
{
    $this->Graph = $graph;
    $this->TestValue = $test_value;
}
/**
*@ignored
*/
function GetNodeArray()
{
    /* foreach($graph as $key_node=>$node_content)
         {
             if($key_node === $test_value)
             {
                 $this->AllNodes[] = $node_content;
                 $this->SwitchedNodes[] = $node_content;

                 while(count($this->SwitchedNodes) != 0)
                 {
                     $ProcessedNodeValue = array_pop($this->SwitchedNodes);

                     foreach($ProcessedNodeValue as $keys=>$values)
                     {

                         if ($keys == "uuid")
                         {

                             foreach($graph as $node_content_recursion)
                             {
                                 $this->RecursiveArray = $node_content_recursion;

                                 foreach($this->RecursiveArray as $key_for_search_references=>$point_for_search_references)
                                 {

                                     foreach($graph as $key_node)
                                     {
                                         if(($node_content_recursion == $key_node) and ((strpos($key_for_search_references, "_ref")) != false) and ($point_for_search_references == $values))
                                         {
                                             $AllNodes[] = $node_content_recursion;
                                             $SwitchedNodes[] = $node_content_recursion;
                                         }
                                     }
                                 }
                             }
                         }
                     }
                 }
             }
         }*/

    $this->node[] = $this->Graph[$this->TestValue];
    $this->AllNodes[$this->TestValue] = $this->node;
    $this->SwitchedNodes[$this->TestValue] = $this->node;

    $this->PopOutArray = array_pop($this->SwitchedNodes);

    $Node = new Node($this->PopOutArray);
    $dependences = $Node->getDependences();

    foreach($dependences as $key=>$references)
    {
        $this->node[] = $this->Graph;
        $this->PopOutArray = array_pop($this->node);

        if ($this->PopOutArray = $references)
        {
            $this->AllNodes[] = $this->node;
        }
    }

    return $this->AllNodes;
}
}

class Graph
{
    private $GraphDescription;
    public function __construct($Graph)
    {
        $this->GraphDescription = $Graph;
    }

    public function getSubgraph($KeyOfNode)
    {
        $ReturnSubgraph[] = $this->GraphDescription[$KeyOfNode];
        $node = new Node($this->GraphDescription[$KeyOfNode]);
        $subgraphNodes = $node->getDependences();
        $i;
        foreach($this->GraphDescription as $GraphNode)
        {
            foreach($GraphNode as $KeyGraphNode=>$ValueGraphNode)
            {
                for($i=0; $i<count($subgraphNodes); $i++)
                {
                    if(($KeyGraphNode == 'uuid') && ($ValueGraphNode == $subgraphNodes[$i]))
                    {
                        $ReturnSubgraph[] = $GraphNode;
                    }
                }
            }
        }
        return new Graph($ReturnSubgraph);
    }

    function getAllNodes()
    {
        foreach($this->GraphDescription as $node)
        {
            $Node[] = $node;
        }

        return $Node;
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
        foreach($this->Node as $key=>$value)
        {
            if(preg_match('/_ref|_ref.[0-9]|ref/', $key))
            {
                $ReturnNode[] = $value;
            }
        }
        return $ReturnNode;
    }
}