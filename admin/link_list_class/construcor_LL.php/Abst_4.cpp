
  #include<iostream.h>
    #include<string.h>
    #include<conio.h>
   // #include<stdlib.h>
  class block{
 
  public:
   block *next;//can point object of derived classes
   
   block(){next=NULL;}
   
   virtual void show()=0;
   
   void AddAfter(block *Nblock) 
     {
	  next=Nblock;
     }
 };

class list{
  block *head;
  block *tail;
 public:
 list(){head=NULL;tail=NULL;}
  void add(block *Nblock) //in the end
   {
    if (head==NULL)
	{
	head=Nblock; //in the begining
	tail=Nblock;
	}
    else
	{
	tail->next=Nblock;//AddAfter(Nblock);
	tail=Nblock;
	}
    }
void print()
  {
    block *tmp;
    for(tmp=head;tmp!=NULL;tmp=tmp->next)
	{
		tmp->show();
	    cerr<<endl;
    }
  }


 };


 class num:public block{
    int x;
   public:
   num(int Ix){x=Ix;}
   void show(){cerr<<"num    : x="<<x<<' ';} //must be declere
   };


  class string : public block{
    char str[80];
     public:
   string(const char *s)
     {
	strcpy(str,s);
      }
    void show(){cerr<<"string : s="<<str<<' ';}
    };

main()
{
   // clrscr();
    num *tmp;
    string *str;
	string *tstr;
    list l;
    int i,n;
    char word[80];
    cerr<<"input a number then a string \n";
	int value[] = {100,50,20,30,5,70,60,90,200,150,300} ;
	char* svalue[] = {"haim","rabin","qabin","kohen","swissa","levi","fridman","alon","ellen","moor","zenon" } ;
    char* Lvalue[] = {"Ahaim","Brabin","Cqabin","Dkohen","Eswissa","Flevi","Gfridman","Halon","Iellen","Jmoor","Kzenon" } ;

	for(i=0;i<11;i++)
       {
       

      tmp=new num(value[i]);
      str=new string(svalue[i]);
	  tstr=new string(Lvalue[i]);
      l.add(tmp);
      l.add(str);
      l.add(tstr);
	}
    l.print();
     delete tmp;
     delete []str;
      //getch();



	 return(0);
  }
