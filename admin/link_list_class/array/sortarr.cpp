#include "sortarr.h"
#include "iostream.h"
#include<string.h>
#include <stdlib.h>

#define ARRAY_FULL        -1
#define ARRAY_HOLDS_VALUE -2
#define ARRAY_NOT_ALLOCED -3

Sorted_array ::Sorted_array (void)
{
	array = NULL;
	size = -1;
	maxsize = -1;
}
int Sorted_array :: find_place(int key)
{
	int i;

	if (size == maxsize)
	{
	   if(!Expand())
		return ARRAY_FULL ;
	   else
		   Sorted_array ::Insert(key);
	}
	for (i=0;i<size;i++)
	{
		if(array[i]>key)
		{
			return i;
		} // End of if statement.

		if (array[i]==key)
		{
			return i;
		}
	} // End of for loop.
	return i;
}

void Sorted_array ::move_tail(int place)
{
	int i;
	for (i=size-1; i >= place;i--)
	{
	  array[i+1]=array[i];
	}
}
//This function inserts the new number into the array.

int Sorted_array ::Insert(int key)
{
	int place;

	place = find_place(key);

if (place ==ARRAY_FULL ||place == ARRAY_HOLDS_VALUE )
	{
		 return place;
	}
	move_tail(place);

	array[place]=key;
	size++;
	return size;
}

// This function prints the array.

void Sorted_array ::Print()
{
	int i=0 ;

	for(i=0;i<size;i++)
	{
		  cout<<array[i]<<" ";
	}
}



int *Sorted_array ::Alloc( int asize )
{
  if (array != NULL)
  {
	  delete[] array;
  }
  array  = new int[ asize ];
  if (array != NULL)
  {
		maxsize = asize;
	  size =0;

  }
  return array;
}



bool  Sorted_array::Get(int index,int *V)
{
  
  	*V=array[index];
	
	 return TRUE;

}



int Sorted_array ::Expand()
{
	unsigned new_max_size = maxsize + CHUNCK  ;

	// Create array with new length
	int* tmp = new int[new_max_size];
	if (tmp == NULL) {
	    return ARRAY_NOT_ALLOCED;
 		 
	}

	// Copy old array to new array
	for( int i = 0; i <= size; i++)
		tmp[i] = array[i];

	delete [] array;
	array = tmp;
	maxsize = new_max_size;

	return TRUE;
}  // SortedArray::Expand



bool  Sorted_array::Delete(int value)
{
	int index = find_place(value);
	if (index == - 1) { // item not found
	 
		return FALSE;
	}

	// Item found
	for (int i = index; i <= size - 1; i++)
		array[i] = array[i+1];
	size--;

 

	return TRUE;
} // SortedArray::Delete



