// main2.cpp
// ctrudeau@etude
//
// This file contains test code for the sample link list with template 
// implementations.
//
// ----------------------------------------------------------------------------

// System Include Files
#include <stdio.h>
#include <stdlib.h>
#include <iostream.h>

// User Include Files
#include "llist2.hpp"

// ============================================================================
//	Class Code
// ============================================================================

// DataObject Class - sample object to put on the list
//
class DataObject
{
public:
	DataObject() {}
	DataObject( int _Integer1, int _Integer2 )
	{
		Integer1 = _Integer1;
		Integer2 = _Integer2;
	} // end constructor 

	~DataObject() {}

	void Display() { cout << Integer1 << " " << Integer2 << endl; }

private:
	int Integer1;
	int Integer2;
}; // end DataObject

// ----------------------------------------------------------------------------

// ============================================================================
// Main code
// ============================================================================

int main()
{
	LList<DataObject> list;
	DataObject *p;

	// create a new data object and push it onto the list
	p = new DataObject( 1, 1000 );
	list.push( p );

	// create some more items for the list
	list.push( new DataObject( 2, 2000 ) );
	list.push( new DataObject( 3, 3000 ) );
	list.push( new DataObject( 4, 4000 ) );
	list.push( new DataObject( 5, 5000 ) );
	list.push( new DataObject( 6, 6000 ) );

	// the following line should not compile
	// list.push( new int( 5 ) );
	
	// pop a data object and display its contents
	p = (DataObject *)list.pop();
	cout << "Popped ";
	p->Display();
	delete p;

	// queue a new data object on the list
	list.queue( new DataObject( 7, 7000 ) );

	// show the first and last items in the last
	p = (DataObject *)list.first();
	cout << "First ";
	p->Display();
	p = (DataObject *)list.last();
	cout << "Last ";
	p->Display();

	// iterate through the list
	list.top();
	while( 1 )
	{
		p = (DataObject *)list.next();
		if( p == NULL )
			break;

		cout << "Object ";
		p->Display();
	} // end while
	
	list.destroy();
	p = (DataObject *)list.first();
	if( p != NULL )
		cout << "Error!!! Empty list has something in it" << endl;
		
} // end main

// ----------------------------------------------------------------------------

