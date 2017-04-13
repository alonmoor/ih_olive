<html>
<?php
//Copyright Christopher Thomas 2003 (cst at andrew dot cmu dot edu)
//You may use and redistribute freely as long as you keep this copyright
//notice. Feel free to modify as you want
class Node
{
var $left;
var $right;
var $data;
function BinaryTree()
{
$this->left=null;
$this->right=null;
}
function search ($key)
{
if ($this->data == $key)
return true;
if ($this->left != null && $this->data < $key)
return $this->left->search($key);
if ($this->right != null && $this->data > $key)
return $this->right->search($key);
return false;
}
function addItem ($key)
{
if ($this->data == $key)
{
return false; //already got it
}
if ($this->left != null && $key < $this->data)
return $this->left->addItem($key);
if ($this->right != null && $key > $this->data)
return $this->right->addItem($key);
if ($this->left == null && $key < $this->data)
{
$this->left = new Node();
$this->left->data = $item;
return true;
}
if ($right == null && $key > $this->data)
{
$this->right = new Node();
$this->right->data = $item;
return true;
}
}
}

class BinaryTree
{
var $root;
function BinaryTree()
{
$this->root = null;
}
function search($key)
{
if ($this->root == null)
return false;
return $this->root->search($key);
}
function addItem($item)
{
if ($this->root == null)
{
$this->root = new Node();
$this->root->data = $item;
return true;
}
return $this->root->addItem($item);
}
}
?>
</html> 