/* this program is an example of using binary tree */
#include <stdio.h>
#include <conio.h>
#include <iostream.h>
#include <stdlib.h>
#define TRUE 1
#define FALSE 0

// node type
 struct node {
  // int key;
  
	 int height;
	 int key;
   node *left;   //pointer to the left son
   node *reight;  //pointer to the reight son
   void print(){cout<<"key="<<key<< endl;}
   node(long aKey)
   {
	   left=NULL;
	   reight=NULL;
       key=aKey;
       height=0;
   }
//
 };

// tree type
 class tree{
  
 public:
node *root;	 //the instance  have to start with something

tree(){root=NULL;}
 







void delItem(node* t)

{
	if(t){
		node* tmp=find_prev(t);
		if(!tmp)
			root=NULL;
		else
			if(tmp->left==t)
				tmp->left =NULL;
			else
				tmp->left=NULL;
			if(t->left )
				addItem(t->left );
				if(t->reight )
					addItem(t->reight);
				delete t;
	}
}




void addItem(node* t)
{
	node* tmp=root;
	node* tmp1;
	while(tmp)
	{
		if(t->key >tmp->key)
			tmp=tmp->reight ;
		else
			tmp=tmp->left ;
    }
	if(root)
	
		if(tmp->key <t->key )
			tmp1->reight =t;
		else
            tmp->left=t;
        else
			root=t;
	

}

node* find_prev(node* t)
{
	node* tmp=root;
	if(t==root)
		return NULL;
	while(tmp->left !=t&&tmp->reight !=t)
	{
		if(tmp->key >t->key )
			tmp=tmp->left ;
		else
			tmp=tmp->reight ;
    }
}


 node* find(int n)
   {
	    
     node* t=root;
	 while(t->key!=n&& t)
		{
		 if(t->key<n)
             t=t->reight;
		    else
             t=t->left;
			return t;
		 
		}
   }


 void treeDisplay_inorder(node *root)
	{
    if (root != NULL){ //the base of the recorsia
        treeDisplay_inorder(root-> left);//to type the left side recorsivi
    // visit node
         printf("%d,",root-> key);
        treeDisplay_inorder(root-> reight);
		}
	}


 


int len_TREE(node * root){
	if(root)
		return len_TREE(root->reight) + len_TREE(root->left)+1;
    return 0;
}




  
//////////////////////////////////////////////////////////////////////////	

void insert(node *root,node *bnew)/*pointer to root and pointer to
									new block that we wont to add*/
  {
    
    
//////////////////////////////////////////////////////////////////////////	
	if (root==NULL)/*case (2) if the place we wont to add is null, if the 
				   anaf is empty-then he got a new block*/
	{
	root=bnew;
	bnew->height=0;
	return;
	}
   

//////////////////////////////////////////////////////////////////////////	
	
if (bnew->key >= root->key)/*case (3) if the new block is smaller 
							   or bigger then the current one ,if he is
					   be put in the rieght side,if he is smaller
					   bigger from the current one
								   from the current one and the left side is
										   and the rieght side is empty will
								empty ,will put in the left side */
	{
	 if (root->reight==NULL)//if the reight side is empty 
	    {
	     bnew->height++;
	     root->reight=bnew;//get in this place ther new block
	    }
	 
	 
	 else// the tree is not empty and..

	    {
	    bnew->height++;
	    insert(root->reight,bnew);
		return;
	    }

	 }
    
//////////////////////////////////////////////////////////////////////////	
  if (bnew->key < root->key)/*case(4)if in the reight side we wont to add
								 the new block is bigger then the new 
								 block,call recorsive and sending the
								 current reight side as a root*/
	   
	{
	    if (root->left==NULL)
		{
		bnew->height++;
		root->left=bnew;
		}
	    else
		{
		bnew->height++;
		insert(root->left,bnew);
		return;
		}

	}
   }

    
//////////////////////////////////////////////////////////////////////////	

void tree_free(node *root)
 {//reliset from the end to the begining
  if (root != NULL)  {
    tree_free(root -> left); //killing the son relist couse recorsia
    tree_free(root-> reight);//killing the son
    // free node
    free(root); //killing the father
  }
}
 

    
//////////////////////////////////////////////////////////////////////////	


void print(node *root)
   {
    if (root==NULL) return;//the base of the function when root is null
	                       //will not be print
	print(root->left);//left,root,rieght
	root->print();
	print(root-> reight);
    }




 };

//****************************************************************
// prototype of tree function


//*************************************************************************

 main()  {
  tree tree1;
  
  node* tmp;
  node* tmp1;
    long num,num1;
    //int data;
  // initialize the tree
  for(int i=0;i<5;i++)
      {

       cout<<"ENTER NUMBER "; 
			   cin>>num;
	   tmp=new node(num);//tmp is a new block
	   tree1.insert(tree1.root ,tmp);//t.r expected block *root,t.r is the root
       
	}
  tree1.find (5); 
  
  num1=5;
//tree1.delItem ( num1);
  
  // cout<<tree1.find (6);
  //t.print(t.r);//t.r expected block *root*/
       /*cout<<"add new item"<<endl;
       cin>>num1;
	   tmp1=new node(num1);//tmp is a new block
	  */
//tree1.addItem (tmp1);
 // tree1.delItem( 
  tree1 .print (tree1.root);
    
	 

 /*	cout<<"input phone number\n";
    do{
     cin>>num;
	      tmp=new node(num);
	        tree1.insert (tree1.root,tmp); 
	
     }while(num>=0);

    tree1.treeDisplay_inorder(tree1.root);*/

	
	return 0;


  }

 
 /* //tree2->find(numa);
  tree1.treeDisplay_inorder(tree1.root); 
  tree1.tree_free (tree1.root ); 
//tree1.strict_binary(tree1.root);
  printf("enter data to search\n");
  scanf("%d",&data);
  if(tree1.delnode(r,data))
tree1.treeDisplay_inorder(r); 
   //i=tree1.len_TREE (tree1.root);
   /// printf("%d",i);
}*/
  
 
  
  
/*
char delnode(node* root, int x)
{
   node *ptr1, *ptr2=NULL, *ptr3, *ptr4, *ptr5;
   ptr1=root;
   char flag=0; 

   while((ptr1!=NULL)&&(!flag))

	   if(x==*(int*)ptr1->key)
         flag=1; 
      else
      {
         ptr2=ptr1;
         if(x<*(int*)ptr1->key)
            ptr1=ptr1->left;
         else
            ptr1=ptr1->reight;
      }

   if(flag) 
   {
      if(ptr1->left==NULL)
         ptr3=ptr1->reight;
      else if(ptr1->reight==NULL)
                 ptr3=ptr1->left;
             else 
             {
                ptr4=ptr1;
                ptr3=ptr1->reight;
                for(ptr5=ptr3->left; ptr5!=NULL; ptr5=ptr3->left)
                {
                   ptr4=ptr3;
                   ptr3=ptr5;
                }
                if(ptr4!=ptr1)
                {
                   ptr4->left=ptr3->reight;
                   ptr3->reight=ptr1->left;
                }
                ptr3->left=ptr1->left;
             }

      if(ptr2==NULL)
         root=ptr3;
      else if(ptr1==ptr2->left)
                ptr2->left=ptr3;
             else
                ptr2->reight=ptr3;
      free(ptr1); 
   }
   return(flag);
}

*/












