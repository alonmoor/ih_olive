#include <iostream.h>
 class heap
 {
 private :
	 int Max_Size;
     int Size;
	 int *p;
	 
 int   Left(int i)
 {
	 return i*2;

 }



 int   Right (int i)
 {
	 return i*2+1;

 }


 int   Parent(int i)
 {
	 return i/2;

 }

 
 public:
	 int Init(int aSize);
	 int Insert (int Val);
      void  Swap(int* a,int* b)	;
	 ~heap()
	 {
		 if (p!=NULL)
		   delete []p;
	   Size=Max_Size=-1;
     }

     int Extract_Max();
 };

 int heap::Init(int aSize)
 {
   if (aSize==0)
	   return -1;
	Max_Size=aSize ;
   Size=0;
   p=new int[aSize+1];
   if(p==NULL)
		return -1;
	return 0;
 }





 int heap::Insert (int Val)
 {
	int parent ,i;
	if (Max_Size==Size)
		return -1;
	Size++;
	i=Size;
	*(p+Size)=Val;
	parent=Parent(Size);
	while(parent!=0)
	{
		if(p[i]<=p[parent])
			return 0;
		Swap(p+i,p+parent);

		i=parent;
		parent=Parent(i);
	}
   return 0;
 }


 int heap::Extract_Max ()
 {
  int Max,i=1,Son;
  Max=p[i];
  p[i]=p[Size];
  Size--;
  if(p[Left(i)]>p[Right(i)])
	  Son=Left(i);
  else
	  Son=Right(i);
  if(p[i]>=p[Son])
	  return Max;
  else
	  Swap(p+i,p+Son);
  return Max;
 }

 void heap:: Swap(int* a,int* b)
 {
	int tmp;
	 tmp=*a;
	*a=*b;
	*b=tmp;
 }

int  main()
{
  heap h1;
  return 0;

}





