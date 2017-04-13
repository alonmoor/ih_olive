<?php
 
class Node
{
 public $data;
 public $leftChild;
 public $rightChild;

 public function __construct($data)
  {
   $this->data=$data;
   $this->leftChild=null;
   $this->rightChild=null;
  }
 public function disp_data()
  {
   echo $this->data;
  }


}//end class Node
class BinaryTree
{
 public $root;
 //public $s;
 public function __construct()
  {
   $this->root=null;
   //$this->s=file_get_contents('store');

  }
//function to display the tree
  public function display()
  {
   $this->display_tree($this->root);

  }
  public function display_tree($local_root)
  {

   if($local_root==null) 
     return;
    $this->display_tree($local_root->leftChild);
    echo $local_root->data."<br/>";
    $this->display_tree($local_root->rightChild);

  } 
// function to insert a new node
  public function insert($key)
   {
    $newnode=new Node($key);
      if($this->root==null)
        {
         $this->root=$newnode;
         return;
        }
      else
        {
         $parent=$this->root;
         $current=$this->root;
           while(true)
             {
               $parent=$current;
                 //$this->find_order($key,$current->data);
                if($key==($this->find_order($key,$current->data)))
                  {
                      $current=$current->leftChild;
                       if($current==null)
                         {
                          $parent->leftChild=$newnode;
                          return;
                         }//end if2
                  }//end if1 
                else
                  {
                      $current=$current->rightChild;
                       if($current==null)
                         {
                          $parent->rightChild=$newnode;
                          return;  
                         } //end if1                       
                  } //end else
             }//end while loop 
        }//end else

   } //end insert function

//function to search a particular Node
 public function find($key)
  {
    $current=$this->root;
     while($current->data!=$key)
          {
            if($key==$this->find_order($key,$current->data))
              {
                $current=$current->leftChild;
              }
            else
              {
                $current=$current->rightChild;
              }
            if($current==null)
              return(null);

          }
         return($current->data); 
  }// end the function to search
 public function delete1($key)
  {
    $current=$this->root;
    $parent=$this->root;

    $isLeftChild=true;
     while($current->data!=$key)
          {
           $parent=$current;
           if($key==($this->find_order($key,$current->data)))
             {
              $current=$current->leftChild;
              $isLeftChild=true;
             }   
           else
             {
              $current=$current->rightChild;
              $isLeftChild=false;   
             } 
            if($current==null)
              return(null);
          }//end while loop 

      echo "<br/><br/>Node to delete:".$current->data;
     //to delete a leaf node 
     if($current->leftChild==null&&$current->rightChild==null)
       {
           if($current==$this->root)
              $this->root=null;  
          else if($isLeftChild==true)
           {
            $parent->leftChild=null;
           }  
         else
           {
            $parent->rightChild=null;
           }
         return($current);       
       }//end if1
     //to delete a node having a leftChild 
   else if($current->rightChild==null)
       {
          if($current==$this->root)
           $this->root=$current->leftChild;
          else if($isLeftChild==true)
           {
            $parent->leftChild=$current->leftChild;
           }
          else
           {
            $parent->rightChild=$current->leftChild;
           }   
          return($current);
       }//end else if1
    //to delete a node having a rightChild
   else if($current->leftChild==null)
       {
         if($current==$this->root)
           $this->root=$current->rightChild;
         else if($isLeftChild==true)
           {
            $parent->leftChild=$current->rightChild;
           }  
         else
           {
            $parent->rightChild=$current->rightChild; 
           }  
           return($current);
       }  
   //to delete a node having both childs
    else
       {
        $successor=$this->get_successor($current);
        if($current==$this->root)
          {
            $this->root=$successor; 

          }
        else if($isLeftChild==true)
          {
           $parent->leftChild=$successor;
          }
        else
          {
           $parent->rightChild=$successor;
          }     
         $successor->leftChild=$current->leftChild;
        return($current);
       }   


  }//end the function to delete a node
//Function to find the successor node
 public function get_successor($delNode)
  {
   $succParent=$delNode;
   $successor=$delNode;
   $temp=$delNode->rightChild;
    while($temp!=null)
         {
          $succParent=$successor;
          $successor=$temp;
          $temp=$temp->leftChild;
         }
   if($successor!=$delNode->rightChild)
     {
      $succParent->leftChild=$successor->rightChild;
      $successor->rightChild=$delNode->rightChild;
     }
  return($successor);
  }
//function to find the order of two strings
 public function find_order($str1,$str2)
  {
     $str1=strtolower($str1);
     $str2=strtolower($str2);
     $i=0;
     $j=0;

     $p1=$str1[i];
     $p2=$str2[j]; 
  while(true)
   {  
       if(ord($p1)<ord($p2)||($p1==''&&$p2==''))
         {

           return($str1);
         }
      else
         {
           if(ord($p1)==ord($p2))
             {
              $p1=$str1[++$i];
              $p2=$str2[++$j];
              continue;
             }
          return($str2); 
         }
   }//end while

  } //end function find string order

 public function is_empty()
  {
    if($this->root==null)
      return(true);
    else
      return(false);
  }
}//end class BinaryTree
?>
