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

    public function testArrayReturnValueLvlFirst()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2"));

        $graph = new Graph($array);
        $SetNodeData = $graph->getAllNodes();
        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(2, count($SetNodeData));

        $this->assertEquals($array["1"], $SetNodeData["1"]);
        $this->assertEquals($array["2"], $SetNodeData["2"]);
    }

    public function testSubgraph()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2"));

        $graph = new Graph($array);

        $subgraph = $graph->getSubgraph('1');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(2, count($SetNodeData));

        $this->assertEquals($array["1"], $SetNodeData[1]);
        $this->assertEquals($array["2"], $SetNodeData[2]);
    }

    public function testGetNode()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2"));

        $graph = new Graph($array);

        $node = $graph->getNode("2");

        $this->assertEquals($array["2"], $node);
    }

    public function testSubgraphExtended()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2", "ref1" => "3"),
            "3" => array("id"=>"3", "uuid" => "uuid3"));

        $graph = new Graph($array);
        $subgraph = $graph->getSubgraph('1');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(3, count($SetNodeData));

        $this->assertEquals($array["1"], $SetNodeData[1]);
        $this->assertEquals($array["2"], $SetNodeData[2]);
        $this->assertEquals($array["3"], $SetNodeData[3]);
    }

    public function testSubgraphCyclic()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2", "ref1" => "3"),
            "3" => array("id"=>"3", "uuid" => "uuid3", "ref1" => "2"));

        $graph = new Graph($array);
        $subgraph = $graph->getSubgraph('1');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(3, count($SetNodeData));

        $this->assertEquals($array["1"], $SetNodeData[1]);
        $this->assertEquals($array["2"], $SetNodeData[2]);
        $this->assertEquals($array["3"], $SetNodeData[3]);
    }

    public function testFinalGraph()
    {
        $array = array(
            "1" => array("id"=>"1", "uuid" => "uuid1", "ref1" => "2"),
            "2" => array("id"=>"2", "uuid" => "uuid2", "ref1" => "3", "ref2" => "4"),
            "3" => array("id"=>"3", "uuid" => "uuid3", "ref1" => "2", "ref2" => "1"),
            "4" => array("id"=>"4", "uuid" => "uuid4", "ref1" => "5", "ref2" => "1"),
            "5" => array("id"=>"5", "uuid" => "uuid5", "ref1" => "2"),
            "6" => array("id"=>"6", "uuid" => "uuid6", "ref1" => "4"));

        $graph = new Graph($array);
        $subgraph = $graph->getSubgraph('1');
        $SetNodeData = $subgraph->getAllNodes();

        $this->assertInternalType("array", $SetNodeData);
        $this->assertEquals(5, count($SetNodeData));

        $this->assertEquals($array["1"], $SetNodeData[1]);
        $this->assertEquals($array["2"], $SetNodeData[2]);
        $this->assertEquals($array["3"], $SetNodeData[3]);
        $this->assertEquals($array["4"], $SetNodeData[4]);
        $this->assertEquals($array["5"], $SetNodeData[5]);
    }
}
