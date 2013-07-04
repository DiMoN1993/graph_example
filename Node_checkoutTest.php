<?php
/**
 * Created by JetBrains PhpStorm.
 * User: developer
 * Date: 6/28/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */


require_once('Node_checkout.php');

class Node_checkoutTest extends PHPUnit_Framework_TestCase
{
    private $_graph_description=array(
        'A'=>array(
            'name'=>"Dmitri",
            'uuid'=>"u1",
            'first_ref'=>"u2",
            'second_ref'=>"u5"
        ),
        'B'=>array(
            'name'=>"Igor",
            'uuid'=>"u2",
            'first_ref'=>"u1",
            'second_ref'=>"u4"
        ),
        'C'=>array(
            'name'=>"Aleksandr",
            'uuid'=>"u3",
            'first_ref'=>"u4",
            'second_ref'=>"u5"
        ),
        'D'=>array(
            'name'=>"Max",
            'uuid'=>"u4",
            'first_ref'=>"u1"
        ),
        'E'=>array(
            'name'=>"Pasha",
            'uuid'=>"u5",
            'first_ref'=>"u1"
        ),
        'K'=>array(
            'name'=>"Sergei",
            'uuid'=>"u6",
            'first_ref'=>"u3"
        )
    );
    private $_graph_description_required_data = array("u1", "u2", "u3", "u4", "u5");
    private $_test_value = "D";
    private $_set;
    private $_return_value;
    private $_test_array = array();
    private $_graph_description_lvl_first = array(
        "A"=>array("uuid"=>"1", "ref1"=>"2"),
        "B"=>array("uuid"=>"2"));
    private $_graph_description_lvl_second = array(
        "A"=>array("uuid"=>"1", "ref1"=>"2"),
        "B"=>array("uuid"=>"2", "ref1"=>"3"),
        "C"=>array("uuid"=>"3"));
    private $_graph_description_required_data_lvl_first = array("1", "2");

    public function SetNodeData($DescriptionNode, $TestValue)
    {
        $Description = new Node_checkout($DescriptionNode, $TestValue);
        $DescriptionReturn = $Description->GetNodeArray();
        return $DescriptionReturn;
    }

    private function ReturnArrayUUid($DescriptionOfArray)
    {
        foreach($DescriptionOfArray as $Node)
        {
            foreach($Node as $key=>$Node_value)
            {
                if($key == "uuid") $this->_test_array[]=$Node_value;
            }
        }
        return $this->_test_array;
    }

    public function testSubgraph()
    {
        $graph = new Graph($this->_graph_description_lvl_first);
        $subgraph = $graph->getSubgraph('A');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(2, count($SetNodeData));

        $this->assertEquals($this->_graph_description_lvl_first["A"], $SetNodeData[0]);
        $this->assertEquals($this->_graph_description_lvl_first["B"], $SetNodeData[1]);
    }

    public function testSubgraphExtended()
    {
        $graph = new Graph($this->_graph_description_lvl_second);
        $subgraph = $graph->getSubgraph('A');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(3, count($SetNodeData));

        $this->assertEquals($this->_graph_description_lvl_first["A"], $SetNodeData[0]);
        $this->assertEquals($this->_graph_description_lvl_first["B"], $SetNodeData[1]);
        $this->assertEquals($this->_graph_description_lvl_first["C"], $SetNodeData[2]);
    }

    public function testArrayReturnValueLvlFirst()
    {
        $graph = new Graph($this->_graph_description_lvl_first);
        $SetNodeData = $graph->getAllNodes();
        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(2, count($SetNodeData));

        $this->assertEquals($this->_graph_description_lvl_first["A"], $SetNodeData[0]);
        $this->assertEquals($this->_graph_description_lvl_first["B"], $SetNodeData[1]);
    }

    public function testNodeDependences()
    {
        $node = new Node(array('uuid' => 'uuid1', 'field_ref' => 12));
        $dependences = $node->getDependences();
        $this->assertEquals(12, $dependences[0]);
        $this->assertEquals(1, count($dependences));
    }

    public function testNodeDependensesSecond()
    {
        $node = new Node(array('uuid' => 'uuid1', 'field_ref1' => 1, 'field_ref2' => 4));
        $dependenses = $node->getDependences();
        $this->assertEquals(1, $dependenses[0]);
        $this->assertEquals(4, $dependenses[1]);
        $this->assertEquals(2, count($dependenses));
    }
}
