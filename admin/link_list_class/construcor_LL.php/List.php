#ifndef _LIST_H
#define _LIST_H
 
 
  

class  List
{
private:
	 Item*  head;
     Item*  FindByID(char* id);
public:

	 List(void);
	~ List(void);
	
	int      Length(void);
	Record* FindRecordByID(char* id);
	char*    FindNameByID(char* id);
	int      FindByName( List* list,char* Name);
    int      insert(char* name,char* id);
	int      Delete(char* id);
	void     Print(void);

};
#endif