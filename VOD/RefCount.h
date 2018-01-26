#ifndef __SP_H__
#define __SP_H__


template <class T>
class RC
{

	template <class U> friend class SmartPtr;
protected:
	virtual void __IncRefCount() = 0;
	virtual void __DecRefCount() = 0;
	virtual T * GetPtr() const = 0;
};

#endif 