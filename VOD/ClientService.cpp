#include "ClientService.h"



ClientService::ClientService()
{
	clients.clear();
}


bool ClientService::addClient(SmartPtr<Client>& toAdd)
{
	if (!toAdd) return false;

	clients.push_back(toAdd);
	return true;
};


ClientService::~ClientService()
{
}
