<?php
/**
 * Created by JetBrains PhpStorm.
 * User: developer
 * Date: 6/28/13
 * Time: 1:35 PM
 * To change this template use File | Settings | File Templates.
 */

class Node_checkout {

public $AllNodes = array();
public $SwitchedNodes = array();

function GetNodeArray($graph, $test_value)
{
    foreach($graph as $key_node=>$node_content)
        {
            if($key_node === $test_value)
            {
                $AllNodes[] = $node_content;
                $SwitchedNodes[] = $node_content;

                while(array_count_values($SwitchedNodes) == 0)
                {
                    $ProcessedNodeValue = array_pop($SwitchedNodes);

                    foreach($ProcessedNodeValue as $keys=>$values)
                    {
                        if ($keys == "uuid")
                        {
                            for($i = 0; $i=array_count_values($graph); $i++)
                            {
                                /** @var $j Separated node */
                                for($j = 0; $j = array_count_values($graph[$i]); $j++)
                                {
                                 if ((key($graph[$i][$j]) != "uuid") and ($graph[$i][$j]===$values))
                                    {
                                        $AllNodes[] = $graph[$i];
                                        $SwitchedNodes[] = $graph[$i];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    return $AllNodes;
}
}