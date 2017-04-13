#ifndef _LIST_ITEM_H
#define _LIST_ITEM_H
 class Item
   {
    
    private:
	Item* next;
	Record*  r;
public:
//cur=new Item(aname,aid,head,&rc);
	Item(char* name,char* id,Item* anext,int* p_rc)
	{
      SetNext(anext);
	  if((r=new Record(name,id,p_rc))==NULL)
	  {
		  if(p_rc!=NULL)
			  
			  *p_rc=-1;
	  }

	}	  


Item(Record* astudent,Item* anext)
{
	 
	SetNext(anext);
	SetRecord(r);
}



~Item(void)
{

  if(r!=NULL)

	  delete r;
}


void SetNext(Item* anext){next=anext;}
void SetRecord(Record* arecord){r=arecord;}
Item* GetNext(void){return next;}
Record* GetRecord(void){return r;}
};


#endif