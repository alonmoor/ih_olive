#include <iostream.h>
 

class Barray
{
private:
	int Size;
	int *barriar;
    int *p;
public:	
	int Init(int aSize);
	int get(int index);
	int Set(int index,int Val);
	int find(int Val);
    //~Barray();
    void destroy(); 
};


int Barray::Init(int aSize)
{
 
Size=aSize;
 p=new int[Size+1];
 barriar=p+Size;
 return 0;
}
void Barray::destroy()
	{
		if(p!=NULL)
			delete[]p;
    }

int Barray::get(int index)
{
 return p[index];
}

int Barray::Set (int  index,int Val)
{
	p[index]=Val;
	return index;
}

int Barray::  find(int Val)
{
    int *t;
	*barriar=Val;
    for(t=p;*t!=Val;t++);
		{
	 	if(t-p==Size)
          return -1;
		else
          return t-p;
		}
}


int  main()
{
	Barray  arr;
	arr.Init(5);


for(int i=0;i<5;i++)
	{
	arr.Set(i,i);
	}

if(arr.find(10)==-1)
	{
	cout<<"NOT-FOUND"<<endl;
	arr.destroy();
	}
 return 0;

}