#ifndef ARRAY_
#define ARRAY_

class Array
  {
  public:
      int size;
	  int *arr;
	  int chack_index(int index);
      int key; 
      //int maxsize;
  public:
          Array();
          Array(int akey,int);
          ~Array(); 
	      int alloc (int size);
		  int Get(int index);
		  int Get(int index,int *p_value);
		  int set(int index,int value);
		  //int ChackIndex(int index);
          void dealloc();
		  int Size();
          int find_place(int *array,int size, int maxsize, int key);
          void move_tail(int *array,int find_place,int array_size);
          void insert(int array[],int find_place,int key,int * array_size);
          void array_print(int array_value[],int array_size);

  }; 
  #endif 