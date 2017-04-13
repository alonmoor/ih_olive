#include <iostream.h>
 class heap
 {
 private :
	 int Max_Size;
     int Size;
	 int *p;
	 
 int   Left(int i){return i*2;}



 int   Right (int i){return i*2+1;}


 int   Parent(int i){return i/2;}

 
 public:
	 heap (int  );

	 int Init(int aSize);
	 int Insert (int Val);
      void  Swap(int* a,int* b)	;
	 void destroy();
	  void sort(int* ar,int Size); 
	 int ErrorCode (int );
	  ~heap()
	 {
		 if (p!=NULL)
		   delete []p;
	   Size=Max_Size=-1;
     }

     int Error_Code;
	  int Extract_Max();
 };

  
 int heap::ErrorCode (int val)
 {
  if(Error)
   return Error_Code;
 }


  


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

 heap::heap(int aSize)
 {
  
 if(aSize<=0)
	{
	 Error_Code=1;
	 return;
	}
	 Size=0;
	 Max_Size =aSize;
     p=new int [Max_Size +1];
	 if (p==NULL)
		 Error_Code =1;
	 else
		 Error_Code =0;

 }






 int heap::Extract_Max ()
 {
  int Max,i=1,left,right,greatest;
  
  Max=p[i];
  p[1]=p[Size];
  Size--;
  for(;;)
  {
	  greatest=0;
  left=Left(i);
    
  if(p[left]>p[i])
  {

	  greatest=left;

  }
  if(right<=Size)
  {
	  if(p[right]>p[greatest])
	  {
		  greatest=right;
      }
  }
 
  
  if(i==greatest)
  {
	  //break;
  }  
	  Swap(p+i,p+greatest);
	   greatest=i;
  }
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
  heap* p;
  heap h1;
  h1.Init (Size);
  if(h1.Init (Size)==1)
	  return -1;
  if(h1==NULL)
	  return -1;
  for (int i=0;i<Size;i++,p++)
  {
     p=array; 
    h1.insert(heap* p);
    if(Size==0||array==NULL)
		return -1;
   for (int i=0;i<Size;i++,p++)
   {
    p=array;
	*p=Extract_Max();
	h1.Extract_Max ();
	h1.destroy ();
   }

 
  h1.Insert (6);
  h1.Extract_Max ();
  return 0;

}





