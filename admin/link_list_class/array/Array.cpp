#include "Array.h"
#include <iostream.h>


Array::Array()
	{
	size=0;
	arr=NULL;
	}

/*Array::Array(int akey,int s=size)
	{
	 key=akey;
	
	}*/

Array::~Array()
	{
  	 
     dealloc();
	}

int Array::alloc(int asize)
	{
 
	  for(int i=0;i<size;i++)
		  
		  if(array[i]==NULL)
		     {
			  array[i]=newEtem;
			  return *this;
             }
			 
       int temp=size +CHUNK;
	 void **tempArray=new void* [temp];

	  for( i=0;i<size ;i++)
		   
		  tempArray[i]=array[i];
	      
	  for (; i<temp ;i++)
          tempArray[i]=NULL;

		  tempArray[i=size]= newEtem;
	     
         delete array;
		 array=tempArray;
		 size=temp;
		 return *this;
		 }


	
	
	/*	if( size<0)
		return 0;

	if(arr!=NULL)
		return 0;


	arr=new int[size];

	  if(arr==NULL)
		  return 0;

	  size=asize;*/

		return 1;
	}
 
  int  Array::Get(int index ,int *p_value)
  {
	   if(p_value==NULL)
		   return 0;


	   /*if (chack_index ==0)
		return 0;*/

	   if (index<0||index>=size-1)
		   return NULL;

	   *p_value=arr[index];

	   return 1;

  }


int Array::Size()
{

	return size;
}

int Array::set(int index,int value)

{
	/*if (chack_index ()==0)
		return 0;*/

	if (arr==NULL)
		 return 0;


	if(index<0||index>size-1)

	{
		return NULL;
    }
	


	arr[index]=value;

	return 1;
}




 int Array:: chack_index (int index)
 {


	 if (index<0||index>size-1)

		 return 0;
	     return 1;

 }



void Array::dealloc()
{
	 
	if (arr==NULL)
		return;
	delete []arr;
}



//find_place(array,size,sz,key);

int Array::find_place(int *array,int size, int maxsize, int key)
{
	int i;
	if  (size == 0)
	{
		return 0;
	}
	if (size == maxsize)
	{
		return -1;
	}

	for (i=0;i<size;i++)
	{
	  if(array[i]>key)
		  return i;
	  if (array[i]==key)
		  return -2;
	}
   return size;
}

void Array:: move_tail(int *array,int find_place,int array_size)
{
	int i;
	for (i=array_size -1; i >= find_place;i--)
	{
	  array[i+1]=array[i];//mooving last element forward
	}
}
 //insert(&array[0],place,key,&size);
void Array::insert(int array[],int find_place,int key,int * array_size)
{
	array[find_place]=key;
   *array_size=*array_size+1;
}



void Array:: array_print(int array_value[],int array_size)
{
              int i=0 ;
			  for(i=0;i<array_size;i++)
			  {
			  cout<<array_value[i]<<" ";
			  }                       
 }



/*Array::Array(int s)
{
	key= new int[size=s]; 
	 
}
Array::~Array()
{
	delete [] data;
}
void  Array::add(const String &word, int row)
{ 
	int found = find(word);
	if(found != -1)
		data[found].add_row(row);
	else // new word in the index
	{
		if(curr<size) 
			data[curr++].init(word, row);
	}
}
void Array::print() const
{
	int *sort_arr = new int[curr];
	sort(sort_arr);

	cout << "Printing the document index:" << endl;
	for(int i=0; i<curr; i++)
		data[sort_arr[i]].print();
	delete [] sort_arr;
}

void Array::sort(int sort_arr[])  const // bubble sort
{
	int i,j;

	for(i=0; i<curr; i++)
		sort_arr[i] = i;

	for(i=0; i<curr; i++)
	{
		for(j=0; j < curr - 1 - i; j++)
		{
			if(data[sort_arr[j]].compare(data[sort_arr[j+1]]) > 0)
			{
				// swap the indices in swap array
				int temp = sort_arr[j];
				sort_arr[j] = sort_arr[j+1];
				sort_arr[j+1] = temp;
			}
		}
	}
}

int Array::find(const String &word) const
{
	for(int i=0; i<curr; i++)
		if(data[i].contains(word))
			return i;
	return -1;
	
}
*/