#include<iostream.h>
  
class Array_Left_Right
{
private:
	int left;
	int  right;
	int *p;
    int Error_Code;
	 Array_Left_Right(){}
     Array_Left_Right(int ,int) ;
     ~Array_Left_Right(); 
	 void set (int index,int val);
	 int get(int index);
	 int Size;
};
Array_Left_Right ::Array_Left_Right(int aLeft,int aRight)
{
 Error_Code =0;
 if(aLeft>aRight)
 {
	 Error_Code=1;
	 return;
 }

  left=aLeft;
  right=aRight;
  p=NULL;
  if((p=new int[right-left]==NULL))
	  return;
    

}

int Array_Left_Right ::set(int index,int val)

{
  if(index<0||index>right-left)
	  return  ;
    p[index]=val;
	return index;
}

int Array_Left_Right::get (int index)
{
	if(index<0)
		return;
	return p[index];
}




~Array_Left_Right ::Array_Left_Right

{
  if(p!=NULL)
	  delete[]p;
} 



int  main()
{

Array_Left_Right arr;
arr(5,3);
	
	
return 0;

}