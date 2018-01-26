#ifndef __RCI_H__
#define __RCI_H__
#include "RefCount.h"
#include <iostream>          

using namespace std;


template <class T>
class RCI : public RC<T>
{
private:
	int __m_counter;
	void prntCntr() { cout << __m_counter << "\n"; }

protected:
	virtual void __IncRefCount()
	{
		__m_counter++;
		cout << "increased reference, it is now : ";
		prntCntr();
	}
	virtual void __DecRefCount()
	{
		__m_counter--;

		cout << "Decreased reference, it is now : ";
		prntCntr();

		if (__m_counter <= 0)
		{
			cout << "Reference is 0, destroying Ref.\n";
			__DestroyRef();
		}
	}
	virtual T * GetPtr() const
	{
		return ((T *)this);
	}
	virtual void __DestroyRef()
	{
		if (GetPtr() != NULL)
			delete GetPtr();
		cout << "Deleted reference\n";
	}
	RCI()
	{
		__m_counter = 0;
	}

};
#endif 