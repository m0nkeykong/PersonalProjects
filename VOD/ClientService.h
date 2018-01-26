#ifndef CLIENTSERVICE_H
#define CLIENTSERVICE_H
#include "ViewAble.h"
using namespace std;


class ClientService
{
private: 
	vector<SmartPtr<Client>> clients;					//changed from 
public:
	ClientService();
	bool addClient(SmartPtr<Client>&);
	vector<SmartPtr<Client>>& getClients() { return clients; };
	~ClientService();
};

#endif
