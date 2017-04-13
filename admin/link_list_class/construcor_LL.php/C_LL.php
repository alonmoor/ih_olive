<?php 
class Node
{
    public $data;
    public $next;
    public $prev;
 
    public function __construct($data, $prev, $next)
    {
        $this->data = $data;
        $this->prev = $prev;
        $this->next = $next;
    }
}
 
class LinkedList
{
    protected $front = null;
 
    public function add($data)
    {
        if (!$this->front) {
            $node = new Node($data, null, null);
            $this->front = &$node;
        } else {
            if ($data < $this->front->data) {
                $node = new Node($data, null, $this->front);
                $this->front = $node;
                return;
            }
 
            $current = $this->front;
            while ($current) {
                if ($current->data < $data && isset($current->next) && $current->next->data > $data) {
                    $node = new Node($data, $current, $current->next);
                    $current->next = $node;
                }
                if ($current->data < $data && !isset($current->next)) {
                    $node = new Node($data, $current, $current->next);
                    $current->next = $node;
                }
                $current = $current->next;
            }
        }
    }
 
    public function printl()
    {
        $current = &$this->front;
        while($current) {
            echo $current->data, '<br />';
            $current = $current->next;
        }
    }
}
 
$list = new LinkedList();
$list->add(13);
$list->add(14);
$list->add(15);
$list->add(11);
$list->add(12);
$list->add(17);
$list->add(10);
$list->add(16);
 
$list->printl();