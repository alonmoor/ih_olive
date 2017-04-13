#include <iostream>
#include <string>
#include <fstream>
using namespace std;

class Node
{

public:
Node();
//remember to do a destructer
string getName(Node*);
void setName(string name, Node *node);
void addNodeStart(string name);
void addNodeEnd(string name);
void Display();
Node* getPrevious(Node* current);

private:
string name;
Node *link,*head,*tail,*current;
};


/*********
Constructor
********/
Node::Node()
{
  head = new Node;
  tail=head;
  
}

/**********
Gets previous Node from current index 
 ********/
Node* Node::getPrevious(Node* index)
{
  if(index == head)
  {
    return head;
  }
  else
  {
    Node* iterator;
     iterator = head;
    while(iterator->link != index)
     {
     iterator = iterator->link;  
     }
     return iterator;
  }

}

/**********
Sets the name of given node in list
 ********/
void Node::setName(string name,Node *node)
{
  node->name=name;
}

/**********
Gets name of given node 
 ********/
string Node::getName(Node *node)
{
   
     return node->name;
     
}

/***********
Returns:Adds node to front of list
PreCondition: If list is null it will apply this node to head of list

************/
void Node::addNodeStart(string name)
{
cout << "start top" << endl;      
   //check make sure list is not empty
     if(head == NULL)
     {
      head->name=name;
       head->link=NULL;
       head = tail;
     }
     else
     {
       
      Node *temp_ptr;
      temp_ptr = new Node;

      temp_ptr->name=name;;

      temp_ptr->link = head;
      head = temp_ptr;
       
     }



}

/**********
Adds new node to the end of list
 ********/
void Node::addNodeEnd(string name)
{
      
    //check make sure list is not empty
     if(head == NULL)
     {
      head->name=name;
       head->link=NULL;
       head = tail;
     }
     else
     {
       
      Node *temp_ptr;
      temp_ptr = new Node;

     
       
     }



}


/**********
Display the entire list 
 ********/
void Node::Display()
{
  Node *iter;
cout << " the contents of the list: " << endl;
  for(iter = head; iter !=NULL; iter= iter->link)
  {
    
     cout << iter->name << " " ;
  }
}



void main()
{
cout << "testy" << endl;

Node n; // <==============  afer this nothing.....
cout << "1" << endl;
 
n.addNodeStart("Steve");
cout << "2" << endl;
n.addNodeStart("John");
n.addNodeStart("Will");
n.Display();
 
cout << "test" << endl;


//return 0;

}


