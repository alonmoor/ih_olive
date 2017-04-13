 /* Potashnikov David

 This program build a SORTED ARRAY.
 */
#include "sortarr.h"
#include<iostream.h>
#include<stdlib.h>
#define ARRAY_FULL        -1
#define ARRAY_HOLDS_VALUE -2
#define ARRAY_NOT_ALLOCED -3


int main()
{
    
	int size;
 
    int v; 
	size=5;
	Sorted_array  arr1;


	if (arr1.Alloc(size) == NULL)
	{
	 return ARRAY_NOT_ALLOCED;
	}

int values[] = { 100, 20, 10, 200, 5,99 };
	for (int i = 0; i <= size; i++){
		arr1.Insert(values[i]);
          arr1.Print();
		  cout<<endl;
	}	
	
  arr1.Insert (33);
  arr1.Insert ( 3);
arr1.Insert (73);
 arr1.Insert (43);
 arr1.Print();
 cout<<endl;
 arr1.Delete (33);
 arr1.Print();
arr1.Get(0, &v);
 cerr<<endl<<v<<endl;

 
 return 0;
}



