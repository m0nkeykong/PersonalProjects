// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#include "Game_Manager.h"
using namespace std;
//////////////////////////////////////////////////////////////////////////


GameManager::GameManager(char* creation, char* simulation, char* gameOn) : board(0), activePlayers(0), passivePlayers(0), active(0), passive(0)
{
	createBoard(creation);
	Genesis(creation);

	//opening files(output).
	ofstream Bible;
	Bible.open(gameOn);
	if (!Bible.is_open()) {
		cerr << "Unable to open output file" << endl;
		exit(1);
	}
	gameSTART(Bible);
	Eden(simulation, Bible);
	
}

void GameManager::Genesis(char* creation_file)
{
	//initial buffer
	char* buff = new char[512];
	if (buff == 0) { cerr << "error allocating memory for buffer" << endl; exit(1); };

	//opening files(input).
	ifstream Adam;
	Adam.open(creation_file);
	if (!Adam.is_open()) {
		cerr << "Unable to open creation file" << endl;
		exit(1);	
	}

	////////////////////////////////////////////creation process/////////////////////////////


	//checks if file is open
	if (Adam.is_open())
	{
		//reads the file untill he is over
		while (!Adam.eof())
		{
			Adam.getline(buff, 512);
			//creating all the players and cards
			switch (buff[0])
			{
			case '#':
				break;
			case 'B':
				break;
			case 'X':
				break;
			case 'P':
				create_player(buff + 2);
				break;
			case 'C':
				create_card(buff + 3);
				break;
			case ' ':
				break;
			case '\0':
				break;
			default:
				cerr << buff[0] << " what is this?" << " error reading file, unknown command for creating data" << endl;
				break;
			}
		}
	}

}

void GameManager::Eden(char* simulation_file, ofstream& Bible)
{
	
	//working variables
	int _val; Card* _card;

	//initial buffer
	char* buff = new char[512];
	if (buff == 0) { cerr << "error allocating memory for buffer" << endl; exit(1); };

	//opening files(input).
	ifstream Eve;
	Eve.open(simulation_file);
	if (!Eve.is_open()) {
		cerr << "Unable to open simulation file" << endl;
		exit(1);
	}

	////////////////////////////////////////////simulation process/////////////////////////////
	
	//simulation components
	int tempID = 0;
	int tempID2 = 0;
	int tempPOSX = 0;
	int tempPOSY = 0;
	int tempCARDINDEX = 0;
	Player* WorkingOnHim;


	//reads the file untill he is over
	while (!Eve.eof())
	{

		Eve.getline(buff, 512);

		if ((buff[0] == '#') || (buff[0] == '\0'))
			continue;

		else if ((buff[0] >= '0') || (buff[0] <= '9')) {
			tempID = char2digit(buff);
		}
		else if (buff[0] == 'E')
			gameOVER();
		else
			cerr << "" << "" << buff[0] << "what is this?" << " error reading file, unknown command for creating data" << endl;

		buff += 1;

			Point tempPoint(0, 0);

		switch (buff[0])
		{
		case '\0':
			break;
			
		case 'M':
			cout << buff << endl;
			WorkingOnHim = search_player(tempID, 'A');
			if (WorkingOnHim == 0)
			{
				cout << "Player was not located in the game..." << endl;
				break;
			}
			
			cout << endl << "<*((><             M O V I N G     A     P L A Y E R             ><((*>" << endl << endl;
			Bible << endl << "M O V I N G     A     P L A Y E R" << endl
				<< "----------------------------------" << endl;
			
		
			WorkingOnHim->settempWins(0);
			buff += 5;
			tempPOSX = char2digit(buff);
			buff += 1;
			tempPOSY = char2digit(buff);
			tempPoint.setX(tempPOSX);
			tempPoint.setY(tempPOSY);
			movePlayerTo(*WorkingOnHim, tempPoint, Bible, Eve);
			
			break;
			
		case 'P':
		
			cout << endl << "<*((><             P R I N T I N G     A     P L A Y E R             ><((*>" << endl << endl;
			Bible << endl << "P R I N T I N G     A     P L A Y E R" << endl
				<< "--------------------------------------" << endl;
			cout << "                          " << tempID << endl << endl;
			WorkingOnHim = search_player(tempID, 'A');
			if (WorkingOnHim == 0)
				WorkingOnHim = search_player(tempID, 'P');
			WorkingOnHim->printPlayer();

			//printing to output file
			Bible << endl << "Player details:" << endl << "ID: " << WorkingOnHim->getID() << ", Name: " << WorkingOnHim->getName() << "," << endl
				<< "Wins: " << WorkingOnHim->getWins() << ", Loses: " << WorkingOnHim->getLoses() << "," << endl
				<< "Number of Available moves: " << WorkingOnHim->getAVmoves() << " ,and the Position is: ";
			Bible << WorkingOnHim->getPosition().getX() << " , " << WorkingOnHim->getPosition().getY();
			Bible << " ." << endl;
			if (WorkingOnHim->IsPlaying() == false)
				Bible << "The Player Is Currently Not Playing" << endl;
			Bible << "And His Cards Are: " << endl;
			_card = WorkingOnHim->getDeck();
			for (int i = 0; ((_val = _card[i].getValue()) != 0) && (i < Max_Cards); ++i)
			{
				Bible << "Name: " << WorkingOnHim->getDeck()[i].getName() << "," << endl
					<< "Value: " << WorkingOnHim->getDeck()[i].getValue() << "," << endl << "Color: ";
				int color = WorkingOnHim->getDeck()[i].getColor();

				switch (color)
				{
				case 0:
					Bible << "Red";
					break;
				case 1:
					Bible << "Green";
					break;
				case 2:
					Bible << "Blue";
					break;
				case 3:
					Bible << "Purple";
					break;
				case 4:
					Bible << "Orange";
					break;
				default:
					Bible << "Unknown color";
					break;
				}
				Bible << "." << endl << endl;
			}
			
			break;
			
		case 'R':
			WorkingOnHim = search_player(tempID, 'A');
			WorkingOnHim->setAVmoves(3);
			
			if (WorkingOnHim->IsPlaying() == false)
			{
				cout << WorkingOnHim->getName() << " is out of the game... you can't revive him.... sorrrrrryyyyy :'(" << endl;
				break;
			}
		
		default:
			break;

		}
	}
	

}



void GameManager::gameSTART(ofstream& Bible)
{
	cout << "Let The Games Begin!" << endl << "And May The Odds Be Ever, In Your Favor!" << endl << endl;
	board->PrintBoard(Bible);
}



void GameManager::duelSTART(Player& p1, Player& p2, ofstream& Bible, ifstream& Eve)								//starting the duel *take function 'A' from main*
{
	cout << "Clash! " << p1.getName() << " has declared war upon " << p2.getName() << "!" << endl;
	Bible << "Clash! " << p1.getName() << " has declared war upon " << p2.getName() << "!" << endl;
	int p1_score = 0, p2_score = 0;
	int temp_score = 0;
	int tempCARDINDEX1;
	int tempCARDINDEX2;
	int tempID;
	char* buff = new char[512];
	Player* attacker = 0;
	Player* defender = 0;

	int i = 0;

	while (i < 3)
	{
		Eve.getline(buff, 512);

		if ((buff[0] == '#') || (buff[0] == '\0'))
			continue;

		else if ((buff[0] >= '0') || (buff[0] <= '9'))
			tempID = char2digit(buff);

		i++;
		if (p1.getID() == tempID)
		{
			attacker = &p1;
			defender = &p2;
		}
		else if (p2.getID() == tempID)
		{
			attacker = &p2;
			defender = &p1;
		}

		buff += 9;

		tempCARDINDEX1 = char2digit(buff);


		Eve.getline(buff, 512);


		while ((buff[0] == '#') || (buff[0] == '\0'))
		{
			Eve.getline(buff, 512);
			continue;
		}

		buff += 12;
		tempCARDINDEX2 = char2digit(buff);


		temp_score = battleSTART(*attacker, *defender, tempCARDINDEX1, tempCARDINDEX2, Bible);
		if (temp_score == 1)
		{
			cout << attacker->getName() << " Has won the #" << i << " round!" << endl;
			Bible << attacker->getName() << " Has won the #" << i << " round!" << endl;
			attacker->settempWins(attacker->gettempWins() + 1);
		}
		else if (temp_score == -1)
		{
			cout << defender->getName() << " Has won the #" << i << " round!" << endl;
			Bible << defender->getName() << " Has won the #" << i << " round!" << endl;
			defender->settempWins(defender->gettempWins() + 1);
		}
		else
		{
			cout << "#" << i << " Battle Is A Draw!" << endl; 
			Bible << "#" << i << " Battle Is A Draw!" << endl; 
		}

	}
	
	duelOVER(*attacker, *defender, Bible);
	return;

}



void GameManager::duelOVER(Player& attacker, Player& defender, ostream& Bible) 
{
	for (int i = 0; i < 5; ++i)												//reset all cards condition to NOT BEEN USED
	{
		attacker.getDeck()[i].setUsed(false);
		defender.getDeck()[i].setUsed(false);
	}

	int p1score = attacker.gettempWins();
	int p2score = defender.gettempWins();
	

	//checking who is the final winner
	if (p1score > p2score)		
	{
		cout << attacker.getName() << " Has Won The Duel!" << endl;
		Bible << attacker.getName() << " Has Won The Duel!" << endl;
		attacker.setWins(attacker.getWins() + 1);
		defender.setLoses(defender.getLoses() + 1);
		return;
	}
	else if (p1score < p2score)
	{
		cout << defender.getName() << " Has Won The Duel!" << endl;
		Bible << attacker.getName() << " Has Won The Duel!" << endl;
		attacker.setWins(defender.getWins() + 1);
		defender.setLoses(attacker.getLoses() + 1);
		return;
	}
	else
	{
		cout << "Duel has ends with a draw! Both players walk back to their tiles with shame..." << endl;
		Bible << "Duel has ends with a draw! Both players walk back to their tiles with shame..." << endl;
		return;
	}

}



int GameManager::battleSTART(Player& attacker, Player& defender, int cardindex1, int cardindex2, ofstream& Bible)
{
	
	Card* currentCard1;
	Card* currentCard2;
	cout << "Battle Cry!" << endl;
	currentCard1 = attacker.attackUsingCard(cardindex1, Bible);
	currentCard2 = defender.attackUsingCard(cardindex2, Bible);

	//write to the screen
	cout << attacker.getName() << " Is Attacking " << defender.getName();
	cout << " Using His " << currentCard1->getName();
	cout << endl;
	cout << defender.getName() << " Is Defending His Ground Using His Own " << currentCard2->getName();
	cout << endl;

	//print to output file
	Bible << attacker.getName() << " Is Attacking " << defender.getName();
	Bible << " Using His " << currentCard1->getName();
	Bible << endl;
	Bible << defender.getName() << " Is Defending His Ground Using His Own " << currentCard2->getName();
	Bible << endl;

	return battleOVER(*currentCard1, *currentCard2);

}

int GameManager::battleOVER(Card& currentCard1, Card& currentCard2)
{
	float cc1 = currentCard1.getValue(), cc2 = currentCard2.getValue();
	
	if ((currentCard1.getColor() == 0) && (currentCard2.getColor() == 2))       //red vs. blue
		cc2 *= 2;
	else if ((currentCard1.getColor() == 0) && (currentCard2.getColor() == 2))  //blue vs. red
		cc1 *= 2;
	else if ((currentCard1.getColor() == 0) && (currentCard2.getColor() == 1))  //red vs. green
		cc1 *= 2;
	else if ((currentCard1.getColor() == 1) && (currentCard2.getColor() == 0))  //green vs. red
		cc2 *= 2;
	else if ((currentCard1.getColor() == 1) && (currentCard2.getColor() == 2))  //green vs. blue
		cc1 *= 2;
	else if ((currentCard1.getColor() == 2) && (currentCard2.getColor() == 1))  //blue vs. green
		cc2 *= 2;
	else if ((currentCard1.getColor() == 3) && (currentCard2.getColor() == 4) || (currentCard1.getColor() == 4) && (currentCard2.getColor() == 3))  //purple vs. orange   OR   orange vs. purple
		cc1 *= 1.5;

	if (cc1 > cc2)
		return 1;
	else if (cc1 == cc2)
		return 0;
	else
		return -1;

}


/*

void GameManager::gameOVER()
{
if (activePlayers->first_p->next == 0) {
cout << activePlayers->first_p->jogador->getName() << "! You Are The Winner!" << endl << "You Now have the Iron Throne of Westeros!" << endl;
return;
}
cout << "G-A-M-E  O-V-E-R-!-!-!" << endl;
exit(1);
}

*/
GameManager::~GameManager()
{

}


void GameManager::createBoard(char* filename)
{

	//initial buffer
	char* buff = new char[512];
	if (buff == 0) { cerr << "error allocating memory for buffer" << endl; exit(1); };

	//opening all the working file
	ifstream boardLimits;
	boardLimits.open(filename);
	if (!boardLimits.is_open()) {
		cerr << "Unable to open creation file" << endl;
		exit(1);
	}
	boardLimits.getline(buff, 512);

	while (buff[0] != 'B')
		boardLimits.getline(buff, 512);

	boardLimits.getline(buff, 512);
	int c = strlen(buff);

	board = new Board(1, c);
	Board* tempBoard = new Board(1, c);

	for (int r = 1; buff[0] != 'B'; ++r)
	{
		if (r != 1) {

			delete board;
			board = new Board(*tempBoard, r, c);

		}


		for (int i = 0; i < c; i++)
		{
			if (buff[i] == 'X')
				board->getGameBoard()[r - 1][i].setTraversable();

		}

		delete tempBoard;
		tempBoard = new Board(*board, r, c);

		boardLimits.getline(buff, 512);

	}
		delete tempBoard;
	boardLimits.close();
}
//////////////////////////////////////////////////////////////////////////




void GameManager::create_player(char* buffer)
{

	int tempID = 0;
	char* tempNAME = new char[20];
	int tempWINS = 0;
	int tempLOSSES = 0;
	int tempPOSX = 0;
	int tempPOSY = 0;
	int mult_ten = 1;



	while (*buffer != ',')
	{
		if ((*buffer == 48))
		{
			tempID *= 10;
		}
		else if (((tempID % 10) == 0) && (tempID != 0))
			tempID = (tempID * 10) + (buffer[0] - 48);
		else
			tempID += (mult_ten* ((buffer[0]) - 48));

		buffer += 1;
		mult_ten *= 10;
	}



	buffer += 1;
	int i = 0;

	for (; *buffer != ','; ++i) {
		tempNAME[i] = *buffer;
		buffer += 1;
	}

	tempNAME[i] = '\0';
	buffer += 1;
	mult_ten = 1;

	while (*buffer != ',') {
		tempWINS += (mult_ten* ((*buffer) - 48));
		buffer += 1;
		mult_ten *= 10;
	}

	buffer += 1;
	mult_ten = 1;

	while (*buffer != ',') {
		tempLOSSES += (mult_ten* ((*buffer) - 48));
		buffer += 1;
		mult_ten *= 10;
	}

	buffer += 1;
	mult_ten = 1;

	while (*buffer != ':') {
		if ((buffer[0] == 48))
		{
			tempPOSX *= 10;
		}
		else
			tempPOSX += (mult_ten* ((buffer[0]) - 48));

		buffer += 1;
		mult_ten *= 10;
	}

	buffer += 1;
	mult_ten = 1;

	while (*buffer != '\0') {
		if ((buffer[0] == 48))
		{
			tempPOSY *= 10;
		}
		else
			tempPOSY += (mult_ten* ((buffer[0]) - 48));

		buffer += 1;
		mult_ten *= 10;
	}

	if (!board->getGameBoard()[tempPOSY][tempPOSX].getTraversable())
	{
		cout << "Oh... Thats too bad...  " << tempNAME << " was not allowed to enter the Garden Of Eden :'(  (Out Of Bounds)." << endl;
		return;
	}
	if (board->getGameBoard()[tempPOSY][tempPOSX].getOccuiped())
	{
		cout << "Unfortunatlly the tile that " << tempNAME << " wants to start on is occupied by " << board->getGameBoard()[tempPOSY][tempPOSX].getPlayerInTile()->getName()
			<< "." << endl << "And He doesn't like to share  (Out Of Bounds)." << endl;
		return;
	}

	Player* newPlayer = new Player(tempNAME, tempID, tempWINS, tempLOSSES, tempPOSX, tempPOSY);
	if (!(newPlayer))
	{
		cerr << "out of memory!" << endl;
		exit(1);
	}
	
	addToActList(*newPlayer);
	board->getGameBoard()[tempPOSY][tempPOSX].setCurrentPlayer(newPlayer);
	board->getGameBoard()[tempPOSY][tempPOSX].setOccuipied();
}

void GameManager::create_card(char* buffer)
{

	char* tempNAME = new char[25];
	int tempVAL = 0;
	char tempCOLOR[10];
	int i = 0;
	int mult_ten = 1;

	for (; *buffer != '"'; ++i) {
		tempNAME[i] = *buffer;
		buffer += 1;
	}

	buffer += 2;
	tempNAME[i] = '\0';

	while ((*buffer != ',')) {
		if ((buffer[0] == 48))
		{
			tempVAL *= 10;
		}
		else
			tempVAL += (mult_ten* ((buffer[0]) - 48));

		buffer += 1;
		mult_ten *= 10;
	}

	buffer += 1;

	for (i = 0; *buffer != '\0'; ++i) {
		tempCOLOR[i] = *buffer;
		buffer += 1;
	}

	tempCOLOR[i] = '\0';
	Jogador* temp = activePlayers;

	int chck_count = (active - 1);

	while (chck_count)
	{
		temp = temp->next;
		--chck_count;
	}
	if (active == 0)
	{
		cerr << "There is no players in the game, who do you want me to give the card to?, talk to me when you get serious..." << endl;
		exit(1);
	}

	Card* newCARD = new Card(tempNAME, tempVAL, tempCOLOR);
	addCard2Deck(temp->jogador->getDeck(), *newCARD);
	delete newCARD;

	return;
};

void GameManager::print_Playerlist()
{
	Jogador* temp = activePlayers;

	for (int chck_count = ((active)-1); chck_count > 0; --chck_count)
	{
		temp->jogador->printPlayer();

		temp = temp->next;
	}
}


Player* GameManager::search_player(int tempID, char ap)    //moving in the linked list of the players untill we find the requested player
{
	Jogador* temp = 0;

	if (ap == 'A')
		temp = activePlayers;

	if (ap == 'P')
		temp = passivePlayers;

	if ((temp == 0) && (ap == 'P'))
	{
		cout << "Oh oh... i was unable to find " << temp->jogador->getName() << "...   sorry :S" << endl;
		return 0;
	}

	if (temp->jogador->getID() == tempID)
		return temp->jogador;

	while ((temp->next != 0) && (tempID != temp->jogador->getID()))
		temp = temp->next;
	
	return temp->jogador;
}


int char2digit(char* &buffer)    //replacing the ATOI function - HOMEMADE  :)
{
	int tempNUMB = 0;
	int mult_ten = 1;
	while ((*buffer != ' ') && (*buffer != '\0') && (*buffer != ':')) {
		if ((*buffer == 48))
		{
			tempNUMB *= 10;
		}
		else if (((tempNUMB % 10) == 0) && (tempNUMB != 0))
			tempNUMB = (tempNUMB * 10) + (buffer[0] - 48);
		else
			tempNUMB += (mult_ten* ((buffer[0]) - 48));

		buffer += 1;
		mult_ten *= 10;
	}

	return tempNUMB;
}


void GameManager::addToActList(Player& player)
{
	Jogador* temp = activePlayers;
	Jogador* newJogador = new Jogador;

	if (!newJogador)
	{
		cerr << "out of memory!" << endl;
		exit(1);
	}

	newJogador->jogador = &player;
	newJogador->next = 0;
	++active;
	
	if (active ==1) {
		activePlayers = newJogador;
		return;
	}
	
	while (temp->next != 0)
		temp = temp->next;

	temp->next = newJogador;

}








void GameManager::addToPassList(const Player& player)
{
	Jogador* tempA = activePlayers;
	Jogador* tempP = passivePlayers;
	Jogador* tempo = activePlayers;

	if (tempP != 0)
	{
		while (tempP->next != 0)
			tempP = tempP->next;
	}	

	if (tempA == 0)
	{
		cerr << "Error" << endl;
	}

	if (tempA->next == 0)
	{
		if (tempA->jogador->getID() == player.getID())
		{
			if (passive > 0)
				tempP->next = tempA;
			else
				passivePlayers = tempA;

			activePlayers = 0;
			--active;
			passive++;
		}
	}
	else
	{
		while ((tempA->next != 0) && (tempA->jogador->getID() != player.getID())) {
			tempo = tempA;
			tempA = tempA->next;
		}

		if (passive > 0) 
		{
			tempP->next = tempo;
			tempA->next = tempo->next;
			tempo->next = 0;
		}
		else 
		{
			passivePlayers = tempA;
			tempo->next = tempA->next;
			passivePlayers->next = 0;
		}
		--active;
		passive++;
	}


}
	



void GameManager::movePlayerTo(Player& player, Point& destination, ofstream& Bible, ifstream& Eve)
{
	int x = player.getPosition().getX();
	int y = player.getPosition().getY();

	while ((player.getAVmoves() >= 1) && (player.getPosition() != destination))							//moves the player along the path
	{
		if ((player.getAVmoves() > 1) && (x + 1 != destination.getX()) && (x - 1 != destination.getX()) && (y + 1 != destination.getY()) && (y - 1 != destination.getY()))
		{
			if ((x < destination.getX()) && (y == destination.getY())) {
				if ((board->getTile(x + 1, y).getOccuiped() != true) && (board->getTile(x + 1, y).getTraversable() != false))
					++x;
			}

			else if ((x > destination.getX()) && (y == destination.getY())) {
				if ((board->getTile(x - 1, y).getOccuiped() != true) && (board->getTile(x - 1, y).getTraversable() != false))
					--x;
			}

			else if ((x == destination.getX()) && (y < destination.getY())) {
				if ((board->getTile(x, y + 1).getOccuiped() != true) && (board->getTile(x, y + 1).getTraversable() != false))
					++y;
			}

			else if ((x == destination.getX()) && (y > destination.getY())) {
				if ((board->getTile(x, y - 1).getOccuiped() != true) && (board->getTile(x, y - 1).getTraversable() != false))
					--y;
			}
			else
			{
				cout << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
				Bible << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
				return;
			}

			board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
			board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
			board->setMovementOfPlayer(board->getTile(x, y), player, x, y);
		}

		else
		{

			if ((x < destination.getX()) && (y == destination.getY()))
			{
				if ((board->getTile(x + 1, y).getOccuiped() == true) && (board->getTile(x + 1, y).getTraversable() == true))
				{
					duelSTART(player, *(board->getTile(x + 1, y).getPlayerInTile()), Bible, Eve);		//x and y are just for writing, later will fix it (answer will determine which player will get the tile)
					if (player.gettempWins() > board->getTile(x + 1, y).getPlayerInTile()->gettempWins())
					{
						cout << board->getTile(x + 1, y).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << board->getTile(x + 1, y).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						board->getTile(x + 1, y).getPlayerInTile()->setIsPlaying(false);
						addToPassList(*board->getTile(x + 1, y).getPlayerInTile());
						board->getTile(x + 1, y).setCurrentPlayer(&player);
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
						board->setMovementOfPlayer(board->getTile(x + 1, y), player, x + 1, y);
						board->PrintBoard(Bible);
						return;
					}
					else if (player.gettempWins() < board->getTile(x + 1, y).getPlayerInTile()->gettempWins())
					{
						cout << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						player.setIsPlaying(false);
						addToPassList(player);
						board->PrintBoard(Bible);
						return;
					}
					else
					{
						board->PrintBoard(Bible);
						return;
					}
				}
				else if ((board->getTile(x + 1, y).getOccuiped() == false) && (board->getTile(x + 1, y).getTraversable() == true))
				{
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
					board->setMovementOfPlayer(board->getTile(x + 1, y), player, x + 1, y);
				}
				else
				{
					cout << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					Bible << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					return;
				}
			}

			else if ((x > destination.getX()) && (y == destination.getY()))
			{
				if ((board->getTile(x - 1, y).getOccuiped() == true) && (board->getTile(x - 1, y).getTraversable() == true))
				{
					duelSTART(player, *(board->getTile(x - 1, y).getPlayerInTile()), Bible, Eve);		//x and y are just for writing, later will fix it (answer will determine which player will get the tile)	
					if (player.gettempWins() > board->getTile(x - 1, y).getPlayerInTile()->gettempWins())
					{
						cout << board->getTile(x - 1, y).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << board->getTile(x - 1, y).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						board->getTile(x - 1, y).getPlayerInTile()->setIsPlaying(false);
						addToPassList(*board->getTile(x - 1, y).getPlayerInTile());
						board->getTile(x-1, y).setCurrentPlayer(0);
						
						board->getTile(x-1, y).setOccuipied();
						board->getTile(x - 1, y).setCurrentPlayer(&player);
						board->setMovementOfPlayer(board->getTile(x - 1, y), player, x - 1, y);
						board->getTile(x, y).setCurrentPlayer(0);
						board->getTile(x, y).setOccuipied();
						board->PrintBoard(Bible);
						return;
					}
					else if (player.gettempWins() < board->getTile(x - 1, y).getPlayerInTile()->gettempWins())
					{
						cout << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						player.setIsPlaying(false);
						addToPassList(player);
						board->PrintBoard(Bible);
						return;
					}
					else
					{
						board->PrintBoard(Bible);
						return;
					}


				}
				else if ((board->getTile(x - 1, y).getOccuiped() == false) && (board->getTile(x - 1, y).getTraversable() == true))

				{
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
					board->setMovementOfPlayer(board->getTile(x - 1, y), player, x - 1, y);
				}
				else
				{
					cout << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					Bible << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					return;
				}
			}

			else if ((x == destination.getX()) && (y < destination.getY()))
			{
				if ((board->getTile(x, y + 1).getOccuiped() == true) && (board->getTile(x, y + 1).getTraversable() == true))
				{
					duelSTART(player, *(board->getTile(x, y + 1).getPlayerInTile()), Bible, Eve);		//x and y are just for writing, later will fix it (answer will determine which player will get the tile)
					if (player.gettempWins() > board->getTile(x, y + 1).getPlayerInTile()->gettempWins())
					{
						cout << board->getTile(x, y + 1).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << board->getTile(x, y + 1).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						board->getTile(x, y + 1).getPlayerInTile()->setIsPlaying(false);
						addToPassList(*board->getTile(x, y + 1).getPlayerInTile());
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
						board->getTile(x, y + 1).setCurrentPlayer(&player);
						board->setMovementOfPlayer(board->getTile(x, y + 1), player, x, y + 1);
						board->PrintBoard(Bible);
						return;
					}
					else if (player.gettempWins() < board->getTile(x, y + 1).getPlayerInTile()->gettempWins())
					{
						cout << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						player.setIsPlaying(false);
						addToPassList(player);
						board->PrintBoard(Bible);
						return;
					}
					else
					{
						board->PrintBoard(Bible);
						return;
					}
				
				}
				else if ((board->getTile(x, y + 1).getOccuiped() == false) && (board->getTile(x, y + 1).getTraversable() == true))
				{
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
					board->setMovementOfPlayer(board->getTile(x, y + 1), player, x, y + 1);
				}
				else
				{
					cout << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					Bible << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					return;
				}
			}

			else if ((x == destination.getX()) && (y > destination.getY()))
			{
				if ((board->getTile(x, y - 1).getOccuiped() == true) && (board->getTile(x, y - 1).getTraversable() == true))
				{
					duelSTART(player, *(board->getTile(x, y - 1).getPlayerInTile()), Bible, Eve);		//x and y are just for writing, later will fix it (answer will determine which player will get the tile)
					if (player.gettempWins() > board->getTile(x, y - 1).getPlayerInTile()->gettempWins())
					{
						cout << board->getTile(x, y - 1).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << board->getTile(x, y - 1).getPlayerInTile()->getName() << " is sent to the passive list, and has been removed from the game." << endl;
						board->getTile(x, y - 1).getPlayerInTile()->setIsPlaying(false);
						addToPassList(*board->getTile(x, y - 1).getPlayerInTile());
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
						board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
						board->getTile(x, y - 1).setCurrentPlayer(&player);
						board->setMovementOfPlayer(board->getTile(x, y - 1), player, x, y - 1);
						board->PrintBoard(Bible);
						return;
					}
					else if (player.gettempWins() < board->getTile(x, y - 1).getPlayerInTile()->gettempWins())
					{
						cout << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						Bible << player.getName() << " is sent to the passive list, and has been removed from the game." << endl;
						player.setIsPlaying(false);
						addToPassList(player);
						board->PrintBoard(Bible);
						return;
					}
					else
					{
						board->PrintBoard(Bible);
						return;
					}
				}
				else if ((board->getTile(x, y - 1).getOccuiped() == false) && (board->getTile(x, y - 1).getTraversable() == true))
				{
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setCurrentPlayer(0);
					board->getTile(player.getPosition().getX(), player.getPosition().getY()).setOccuipied();
					board->setMovementOfPlayer(board->getTile(x, y - 1), player, x, y - 1);
				}
				else
				{
					cout << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					Bible << " Oh oh, it seems that the road is blocked...(illegal move)" << endl;
					return;
				}
			}
		}		
		board->PrintBoard(Bible);
	}

}

