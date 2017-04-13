<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>PHP Linear Linked List</title>
    </head>
    <body>
    <h1>A Linear Linked List in PHP:</h1>
    <?php
    /* ----------------------------------------------------------------------- 
        Author:         Peter Ajtai                                          |
        Description:    A very simple linear linked list program that makes  |
                            use of the object oriented functionality of PHP. |
        Date:           2010 06 11                                           |
       ---------------------------------------------------------------------*/
    
    // Linear Linked List implepmenatation
    $myList = new LLL;
    $theData = array('a','b','c','d','e','f','g');
    // Add the nodes with data one by one.
    foreach($theData as $value)
    {
        $myList->insertFirst($value);
    }
    $myList->showall();
    
    // Class defintions and methods:
    class Node
    {
        public $data;
        public $next;
    }
    class LLL
    {
        // The first node
        private $head;
        public function __construct()
        {
            $this->head = NULL;
        }
        public function insertFirst($data)
        {
            if (!$this->head)
            {
                // Create the head
                $this->head = new Node;
                $temp =& $this->head;
                $temp->data = $data;
                $temp->next = NULL;                     
            } else
            {
                // Add a node, and make it the new head.
                $temp = new Node;        
                $temp->next = $this->head;
                $temp->data = $data;
                $this->head =& $temp;
            }
        }
        public function showAll()
        {
            echo "The linear linked list:<br/>&nbsp;&nbsp;";
            if ($this->head)
            {               
                $temp =& $this->head;
                do
                {
                    echo $temp->data . " ";
                } while ($temp =& $temp->next);
            } else
            {
                echo "is empty.";
            }
            echo "<br/>";
        }
    }
    ?>
    <h2>The Code (fresh off the presses, displaying what was used above):</h2>
    <?php
        // Show code ##################################################################
        highlight_file(__FILE__);
    ?>
    </body>
</html>
