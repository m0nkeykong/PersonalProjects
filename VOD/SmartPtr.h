#ifndef SMARTPTR_H
#define SMARTPTR_H
#include "RefCountIMP.h"


template <class T> class SmartPtr
{

private:
	RC<T> *m_refcount;

	class __RefCounter : public RCI<T>
	{
	private:
		T *__m_ptr;
	protected:
		virtual T * GetPtr() const
		{
			return __m_ptr;
		}

		virtual void __DestroyRef() { delete this; }
	public:

		__RefCounter(T *ptr)
		{
			__m_ptr = ptr;
		}

		virtual ~__RefCounter()
		{
			RCI<T>::__DestroyRef();
		}
	};

	// this method is called if T does not implement IRefCount
	void Assign(void *ptr)
	{
		if (ptr == NULL)
			Assign((RC<T> *)NULL);
		else
		{
			Assign(new __RefCounter(static_cast<T *>(ptr)));
		}
	}

	// this method is picked over Assign(void *ptr)
	// if T implements IRefCount.
	// This allows some memory usage optimization
	void Assign(RC<T> *refcount)
	{
		if (refcount != NULL)
			refcount->__IncRefCount();

		RC<T> *oldref = m_refcount;
		m_refcount = refcount;

		if (oldref != NULL)
			oldref->__DecRefCount();
	}

public:
	SmartPtr()
	{
		m_refcount = NULL;
	}

	SmartPtr(T * ptr)
	{
		m_refcount = NULL;

		Assign(ptr);
	}

	template<class newType>
	SmartPtr(RC<newType>* newRef)
	{
		m_refcount = NULL;
		Assign((RC<T>*) newRef);
	}

	SmartPtr(const SmartPtr &SmartPtr)
	{
		m_refcount = NULL;
		Assign(SmartPtr.m_refcount);
	}

	virtual ~SmartPtr()
	{
		Assign((RC<T> *)NULL);
	}

	// CASTING OPERATOR
	template<class newType>
	operator SmartPtr<newType>()
	{
		return SmartPtr<newType>(this->m_refcount);
	}

	// get the contained pointer, not really needed but...
	T *GetPtr() const
	{
		if (m_refcount == NULL) return NULL;
		return m_refcount->GetPtr();
	}

	// assign another smart pointer
	SmartPtr & operator = (const SmartPtr &SmartPtr) { Assign(SmartPtr.m_refcount); return *this; }

	// assign pointer or NULL
	SmartPtr & operator = (T * ptr) { Assign(ptr); return *this; }

	// to access members of T
	T * operator ->()
	{
		if (GetPtr() != NULL)
			return GetPtr();
		return NULL;
	}

	// conversion to T* (for function calls)
	operator T* () const
	{
		return GetPtr();
	}

	// utilities
	bool operator !()
	{
		return GetPtr() == NULL;
	}

	bool operator ==(const SmartPtr &SmartPtr)
	{
		return GetPtr() == SmartPtr.GetPtr();
	}

	bool operator !=(const SmartPtr &SmartPtr)
	{
		return GetPtr() != SmartPtr.GetPtr();
	}

};

#endif 