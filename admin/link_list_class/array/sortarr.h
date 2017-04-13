#ifndef __SORTED_ARRAY_H
#define __SORTED_ARRAY_H

enum    { FALSE, TRUE};
enum errorType { OK,
					  ERROR_FAIL_TO_ALLOCATE_MEMORY,
					  ERROR_ITEM_ALLREADY_EXIST,
					  ERROR_NO_ROOM_TO_INSERT_ITEM,
					  ERROR_ITEM_DOES_NOT_EXIST,
					  ERROR_INDEX_OUT_OF_BOUNDS,
					  ERROR_NULL_POINTER
					};
class Sorted_array 
 {
 public:
	Sorted_array ();
	int* Alloc( int asize);
	int Insert(int key);
	void Print();
    bool   Delete(int value);
  bool Get(int index,int *V);
 private:
	int find_place(int key);
	void move_tail(int place);
	int *array ;
	int size;
	int maxsize;
 enum { CHUNCK = 10};
 int Expand();
 };

#endif
