//simple tree
  
#include <iostream.h>
#include <stdlib.h>
#include <string.h> 
class block
{
	int n;
	block* right;
	block* left;
public:
	block();
	block(int);
	void showBlock();
	friend class tree;
};
block::block()
{}
block::block(int x)
{
	n=x;
	right=left=NULL;
}
void block::showBlock()
{
	cout<<n<<" ";
}

class tree
{
public:
	block* root;
	tree();
	~tree();
	void insert(block* r,block* newBlock);
	void show(block* r);
	void del(int);
	block* find_prev_del(block* r,int);
	void deltree(block* r);
	block* find_prev(block* );
    block* find (int );
};


	block* tree::find_prev(block* );


tree::tree()
{
	root=NULL;
}
void tree::insert(block* r,block* theNewBlock)
{
	if (root==NULL)
	{
		root=theNewBlock;
		return;
	}
 	if (theNewBlock->n  >  r->n)
	{
		if (r->right!=NULL)
		{
			insert(r->right,theNewBlock);
			return;
		}
		else            // meaning r->right is NULL !
		{
			r->right=theNewBlock;
			return;
		}
	}
	if (theNewBlock->n  <=  r->n ) //simple "else" case,actually...
	{
		if (r->left!=NULL)
		{
			insert(r->left,theNewBlock);
			return;
		}
		else            //meaning r->left is NULL !
		{
			r->left=theNewBlock;
			return;
		}
	}
}
void tree::show(block* r)
{
	if (r==NULL)
	{
			return;
	}
	show(r->left);
	r->showBlock();
	show(r->right);
}

block* tree::find_prev_del(block* r,int x)
{
	if (r==NULL)              // not found !!
	{
		return NULL;
	}
	if (r->n > x)  //else,actually
	{
		if ((r->left)&&(r->left->n==x))
		{
			return r;
		}
		else
		{
			return find_prev_del(r->left,x);
		}
	}
	if (r->n <= x)  //else, actually
	{
		if ( (r->right!=NULL) && (r->right->n==x) )
		{
			return r;
		}
		else
		{
			return find_prev_del(r->right,x);
		}
	}
}

void tree::del(int x) 
{
	if (root->n==x)           // deleting root
	{
		block* r=root->right;  // root->right is pointed by root,
				       // which is about to be deleted !!!
		block* tmp=root->right;
		if (tmp==NULL)           // means there is no r->right (it is NULL).
		{
		      r=root;
		      root=root->left;
		      delete r;
		      return;
		}
		while (tmp->left!=NULL)
		{
			tmp=tmp->left;
		}
		tmp->left=root->left;
		delete root;
		root=r;
		return;
	}
	block* prevDel=find_prev_del(root,x);
	if (prevDel==NULL)
	{
		return;
	}
	if (prevDel->right->n==x)
	{
		  block* toDelete=prevDel->right;
		  if (toDelete->right==NULL)
		  {
		      prevDel->right=toDelete->left;
		      delete toDelete;
		      return;
		  }
		  else
		  {
		      block* tmp=toDelete->right;
		      while (tmp->left!=NULL)
		      {
			   tmp=tmp->left;
		      }
		      tmp->left=toDelete->left;
		      prevDel->right=toDelete->right;  //==prev_del->right->right
		      delete toDelete;
		      return;
		  }
	}

	else           // meaning prevDel->left->n==x, which means prevDel->left
		       // is to be deleted. We will be doing the
		       // same thing on the other side !
	{
		  block* toDelete=prevDel->left;
		  if (toDelete->right==NULL)
		  {
		      prevDel->left=toDelete->left;
		      delete toDelete;
		      return;
		  }
		  else
		  {
		      block* tmp=toDelete->right;
		      while (tmp->left!=NULL)
		      {
			   tmp=tmp->left;
		      }
		      tmp->left=toDelete->left;
		      prevDel->left=toDelete->right;  //==prev_del->right->right
		      delete toDelete;
		      return;
		  }
	}
}
tree::~tree()
{
	deltree(root);
}
void tree::deltree(block* r)
{
	if (r==NULL)
	{
		return;
	}
	deltree(r->right);
	deltree(r->left);
	delete r;
}

void main()
{
	tree t1;
	block* b=new block(10);
	t1.insert(t1.root,b);
	b=new block(8);
	t1.insert(t1.root,b);
	b=new block(12);
	t1.insert (t1.root,b);
	b=new block(11);
	t1.insert(t1.root,b);
	b=new block(13);
	t1.insert(t1.root,b);
	b=new block(9);
	t1.insert(t1.root,b);
	b=new block(5);
	t1.insert(t1.root,b);
	t1.show(t1.root);
	cout<<"\n";

//	t1.del(12);
	t1.show(t1.root);
	cout<<"\n";
 t1.del(8);
	t1.del(10);
	t1.show(t1.root);
    t1.del(12);
	cout<<"\n";

} 
  