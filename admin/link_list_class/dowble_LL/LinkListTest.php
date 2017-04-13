<?php

require_once 'doublelist.class.php';
require_once 'PHPUnit/Framework.php';

class LinkListTest extends PHPUnit_Framework_TestCase {
    
    public function testLinkList() {
        
        $totalNodes = 100;
        
        $theList = new DoublyLinkedList();
    
        for($i=1; $i <= $totalNodes; $i++) {
            $theList->insertLast($i);
        }
        
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
        for($i=1; $i <= $totalNodes; $i++) {
            $theList->insertFirst($i);
        }
	
        $totalNodes = $totalNodes * 2;
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
        $theList->deleteFirstNode(); $totalNodes--;
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
        $theList->deleteLastNode(); $totalNodes--;
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
        /* Delete node which has a key value of '50' */
        $theList->deleteNode(50); $totalNodes--;
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
        /* Insert a node at the end of the list with a value of '22' */
        $theList->insertLast(22); $totalNodes++;
        $this->assertEquals($totalNodes, $theList->totalNodes());
        
    }
}

?>