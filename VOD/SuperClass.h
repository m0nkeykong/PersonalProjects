#ifndef SUPERCLASS_H
#define SUPERCLASS_H

#include "ViewAble.h"
#include "Client.h"
#include "ClientService.h"
#include "PlayerService.h"
#include "Movies.h"
#include "Series.h"
#include "SmartPtr.h"
#include "RefCount.h"
#include "RefCountIMP.h"
#include <vector>
#include <iostream>
#include <string>
#include "SimulationService.h"

class SuperClass
{
public:
	SuperClass();
	~SuperClass();
};

#endif