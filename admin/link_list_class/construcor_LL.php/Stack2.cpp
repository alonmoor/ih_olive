#include <iostream.h>

template <class T>
class Vector
{
	 T *v;
	 int size;
public:
	 Vector(int _size);
	 ~Vector()
	 {
		  if (v != NULL)
		  {
				delete v;
		  }
	 }
	 int Set(int i, T val);
	 int Get(int i, T *val);
	 int Size();
};

template <class T>
Vector<T>::Vector(int _size)
{
	 size = _size;
	 v = new T[size];
}

template <class T>
int Vector<T>::Set(int i, T val)
{
		  v[i] = val;
		  return 0;
}

template <class T>
int Vector<T>::Get(int i, T *val)
{
		  *val = v[i];
		  return 0;
}

template <class T>
int Vector<T>::Size()
{
	return size;
}

template <class T>
class Stack : public Vector<T>
{
	  int sp;
public:
	  Stack(int size);
	  ~Stack()
	  {
	  }

	  int Push(T val);
	  int Pop(T *val);
	  int isFull(void)
	  {
			return sp == 0;
	  }

	  int isEmpty()
	  {
			return sp == Size();
	  }
};

template <class T>
Stack<T>::Stack(int size) : Vector<T>(size)
{
			sp = size;
}

template <class T>
int Stack<T>::Push(T val)
	  {
			if (isFull())
				return -1;
			sp--;
			Set(sp,val);
			return 0;
	  }

template <class T>
int Stack<T>::Pop(T *val)
{
		if (isEmpty())
			return -1;
		Get(sp,val);
		sp++;
		return 0;
}


void main(void)
{
	  int i;
	  Stack<int>  st(5);
	  Stack<char> st1(5);
	  //char i;

     i = 1;
	  while (i != 0)
	  {
		  if (st.Push(i) == -1)
				break;
		  st1.Push(i);
		  cin>>i;
	  }

	  cout<<"stack size = "<<st.Size()<<endl;
	  while (st.Pop(&i) != -1)
	  {
			cout <<i<<' ';
	  }
	  cout << endl;
}
