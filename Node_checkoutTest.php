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
    private $_test_value = "D";
    private $_set;
    /*Tests for check data (needs array) and output data (also array)*/
    public function testGetNodeArrayReturnArray()
    {
        $this->_set = new Node_checkout();
        $this->assertInternalType('array', $this->_set->GetNodeArray($this->_graph_description, $this->_test_value));
    }
}
