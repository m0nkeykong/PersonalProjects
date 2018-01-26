#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int flag = -1;

typedef struct wagon
{
    char id[5];
    int priority;
    char location[15];
    char destination[15];
    struct wagon* next;

}wagon;


typedef struct station
{
    char name[15];
    wagon* drop;
    wagon* attach;
    struct station* next_station;

}station;


typedef struct engine
{
    station* current_station;
    station* next_station;
    wagon* next;

}engine;



station* create_station(char* buffer, FILE* newfp)								//function that gets the stations from the file and creates them in a linked list *this function is called from "main" fucntion*//
{																				
    
    station* new_station = (station*)calloc(1, sizeof(station));

    if (new_station == NULL)
    {
        printf("Insufficient Memory! exiting.");
        return NULL;
    }

    int i;
    for (i = 0; (buffer[i] != '\n') && (buffer[i]!= ' '); ++i)
        new_station->name[i] = buffer[i];
    
    new_station->next_station = NULL;
    
    printf("**<3<3 The %s has been created <3<3**\n",new_station->name);
    fprintf(newfp, "**<3<3 The %s has been created <3<3**\n", new_station->name);
	return new_station;
	
}


void park_wagon_in_station(FILE* newfp, wagon* new_wagon,station* wheretopark)				//function that gets wagons from file and park them in their start location *this function is called from the fucntion "check_start_location"*//
{																								
	
	wagon* runner = wheretopark->attach;
	
	if (runner == NULL)
	{
		wheretopark->attach = new_wagon;
	}
	else
	{
		while (runner->next != NULL)
				runner = runner->next;
		
		runner = new_wagon;
		new_wagon->next = NULL;
	}
	
    fprintf(newfp,"**<3<3Unit Of Blood ID No.%s has been stored at The %s <3<3*\n",new_wagon->id, new_wagon->location);
    printf("**<3<3Unit Of Blood ID No.%s has been stored at The %s <3<3*\n",new_wagon->id, new_wagon->location);
}



engine* check_start_location(FILE* newfp, wagon* new_wagon, engine* head, station* rail)						//function that checks the location of the wagons recieved from the file *this function is called from "main" function*//				
{																																
    
	int i;																										  
    char check[] = "Heart";
	int maybe = strcmp(new_wagon->location, check);
	wagon* run = head->next;
	
	
	if (maybe == 0)
	{
		if (head->next == NULL)
		{
			head->next = new_wagon;
			fprintf(newfp, "**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",new_wagon->id);
        	printf("**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",new_wagon->id);	
			return;
		}
		while (run->next != NULL)
			run = run->next;	
			
		run->next = new_wagon;
		
		fprintf(newfp, "**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",new_wagon->id);
        printf("**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",new_wagon->id);	
	}
   
   
    if (maybe != 0)    
    	{		
	    	station* temp = rail;
			for (; ;)
			{
	            if ((strcmp(new_wagon->location, temp->name)) == 0)
	            {
	                park_wagon_in_station(newfp, new_wagon, temp);        
	               	break;
				}
			temp = temp->next_station;		
			}	
		}
		
	
}
        
void attach_wagon(engine* head, station* current_station, FILE* newfp)										//function that attach wagons from the station to the engine *this function is called from "search_and_drop" function*//			
{
wagon* runner = head->next;
wagon* attacher = current_station->attach;

if (attacher != NULL)
{
	if (runner == NULL)
	{
		head->next = attacher;
		current_station->attach = attacher->next;
		attacher->next = NULL;
		fprintf(newfp, "**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",attacher->id);
        printf("**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",attacher->id);
		return;
	}
	
	while (runner->next != NULL)
		runner = runner->next;
		
	head->next = attacher;
	current_station->attach = attacher->next;
	attacher->next = NULL;
	fprintf(newfp, "**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",attacher->id);
    printf("**<3<3 Unit Of Blood ID No.%s has been stored at The Heart <3<3**\n",attacher->id);
}
}
        
        
        
        
void remove_wagon(engine* head, wagon* wagon_check)                                                         //function that removes wagons from the engine *this function is called from "search_and_drop" function*//
{
while(head->next != wagon_check)
	head->next = head->next->next;
	
head->next = wagon_check->next;
}
        
        
        
        
search_and_drop(FILE* newfp, char* temp, station* rail, engine* head)										//function that search the destination of the wagon and drops it there *this function is called from "daily_routine" function*//
{																																
printf ("Bo-Boom! Bo-Boom! Bo-Boom! Bo-Boom!\n");
fprintf (newfp, "Bo-Boom! Bo-Boom! Bo-Boom! Bo-Boom!\n");
station* station_check = rail;     																					
wagon* wagon_check = head->next;

		while (strcmp(station_check->name, temp) != 0)
			station_check = station_check->next_station;
		
		printf("**<3<3 The Blood-Stream has arrived to The %s <3<3**\n", temp);
		fprintf(newfp,"**<3<3 The Blood-Stream has arrived to The %s <3<3**\n", temp);
				
		while (station_check->drop != NULL)
			station_check->drop = station_check->drop->next;		

		
			while (strcmp(wagon_check->destination, station_check->name) != 0)
				{
				wagon_check = wagon_check->next;
				}
		
			while (station_check->drop != NULL)
				station_check->drop = station_check->drop->next;
			
			remove_wagon(head, wagon_check);
			station_check->drop = wagon_check;
			station_check->drop->next = NULL;
			
			if (station_check->attach != NULL)
				attach_wagon(head, station_check, newfp);
					
				
			printf("**<3<3 Unit Of Blood id No.%s has been supplied at The %s <3<3**\n", wagon_check->id, temp);
			fprintf(newfp,"**<3<3 Unit Of Blood id No.%s has been supplied at The %s <3<3**\n", wagon_check->id, temp);			
		}	

        
        
        
int end_of_day(engine* head, station* rail)														//function that checkes if all the wagons arrived to their stations *the function is called from "daily_routine" function*//
{ 
while (rail != NULL)
	{
	if (rail->attach != NULL)
		return 0;
		
	rail = rail->next_station;
	}
	
if (head->next != NULL)
	return 0;
	 
return 1;
}
        
        
int haveifinished(engine* head, station* rail)														//function that checkes if all the wagons arrived to their stations *the function is called from "daily_routine" function*//
{ 
while (rail != NULL)
	{
	if (rail->attach != NULL)
		return rail;
		
	rail = rail->next_station;
	}
	 
return NULL;
}    
        
        
        
void daily_routine(engine* head, FILE* newfp, station* rail) 													//function that starts the moving of the train and distribute all the wagons to their destination *this function is called from "main" function*//
{																									
	while(!end_of_day(head, rail))
	{															
		int p_chck;																								 
		wagon* runner = head->next;
		char temp[15] = {0};
		if (runner != NULL)
		{
		p_chck = runner->priority;
		strcpy(temp, runner->destination);
			
			while (runner->next != NULL)
			{
				runner = runner->next;
				if (runner->priority > p_chck)
				{
					p_chck = runner->priority;
					strcpy(temp, runner->destination);	
				}
			}
	
		printf("**<3<3 the next Organ will be - The %s <3<3**\n", temp);
		fprintf(newfp, "**<3<3 the next Organ will be - The %s <3<3**\n", temp);
		search_and_drop(newfp, temp, rail, head);	
		}
		
		if (runner == NULL)
		{
		head->next_station = haveifinished(head, rail);

		if (head->next_station != NULL)
		finishday(head, newfp, rail);	
		}
	}
	
		
}



void finishday(engine* head, FILE* newfp, station* rail)
{
printf("**<3<3 the next Organ will be - The %s <3<3**\n", head->next_station);
fprintf(newfp, "**<3<3 the next Organ will be - The %s <3<3**\n", head->next_station);	
station* temp = rail;

while((strcmp(temp->name, head->next_station)) != 0)
	temp = temp->next_station;

attach_wagon(head, temp, newfp);	
}












int main(int argc, char* argv[])
{

char buffer[200] = {0};

FILE* fp;
fp = fopen(argv[1], "r");

if (fp == NULL)
{
    printf("Cant find file.\n");
    return -1;
}

FILE* newfp;

newfp = fopen(argv[2], "w");

if (newfp == NULL)
{
    printf("Cant find file.\n");
    return -1;
}

printf("********************************************************************************\n");
fprintf(newfp,"********************************************************************************\n");
printf("\n\n\n               Hello and Wellcome to the Blood-Stream Train!          \n\n\n");
fprintf(newfp,"\n\n\n               Hello and Wellcome to the Blood-Stream Train!          \n\n\n");
printf("\n\n********************************************************************************\n\n\n");
fprintf(newfp,"\n\n********************************************************************************\n\n\n");

printf("********************************Composing Human Body...********************************\n\n");
fprintf(newfp,"********************************Composing Human Body...********************************\n\n");

/** create stations */
station* rail = (station*)calloc(1,sizeof(station));
    if (rail == NULL)
        {
            printf("Insufficient Memory! exiting.");
            return -1;
        }


station* temp = rail;
		
while (fgets(buffer, 15, fp) != NULL)
{
	if (buffer[0] == '+')
		break;
	
	if(buffer[0]=='#')
		continue;
		
	if (flag < 0)
		{
		int kkk;
		for (kkk = 0; (buffer[kkk] != '\n') && (buffer[kkk]!= ' '); ++kkk)
        	rail->name[kkk] = buffer[kkk];	
        	
		printf("**<3<3 The %s has been created! <3<3**\n",rail->name);
    	fprintf(newfp, "**<3<3 The %s has been created! <3<3**\n", rail->name);	
		}
		
	if (flag >= 0)
	{
		temp->next_station = create_station(buffer, newfp);
		temp = temp->next_station;
	}
	++flag;
}

/** create engine */
engine* head = (engine*)calloc(1, sizeof(engine));

    if (head == NULL)
    {
        printf("Insufficient Memory! exiting.");
        return NULL;
    }

    head->current_station = rail;
    head->next = NULL;
    head->next_station = rail->next_station;
    printf("**<3<3 The Heart has been created! <3<3**\n");
    fprintf(newfp, "**<3<3 The Heart has been created! <3<3**\n");



/** create wagons */
while (!feof(fp))
{
while (fgets(buffer, 150, fp) != NULL)
{ 
    if (buffer[0] == '#')
        continue;

    wagon* tempwagon = (wagon*)calloc(1,sizeof(wagon));
 
    if (tempwagon == NULL)
    {
        printf("Insufficient Memory! exiting.");
        return -1;
    }

    
    int i, j;

    for (i = 0, j = 0; buffer[i] != ','; ++i, ++j)
            tempwagon->id[j] = buffer[i];
        ++i; 
       
       		tempwagon->priority = (buffer[i] - 0x30);
	    ++i;
		++i;
	
        for (j = 0; buffer[i] != ','; ++i, ++j)
            tempwagon->location[j] = buffer[i];
            
            
        ++i;

        for (j = 0; (buffer[i] != '\n' && buffer[i] != ' '); ++i, ++j)
            tempwagon->destination[j] = buffer[i];
            
		tempwagon->next = NULL;
		
	check_start_location(newfp, tempwagon, head, rail);
}
}


/** start driving */
printf ("\n\n\n**<3<3 All aboard! *Cho! Cho!* <3<3**\n\n\n**<3<3 Sending Blood Units! <3<3**\n\n\n");
fprintf(newfp, "\n\n\n**<3<3 All aboard! *Cho! Cho!* <3<3**\n\n\n**<3<3 Sending Blood Units! <3<3**\n\n\n");
daily_routine(head, newfp, rail);


printf ("**<3<3 This is the final Organ for this Blood-Stream! <3<3**\n**<3<3 Stay Healthy and keep it up! Have a nice day!<3<3**\n\n");
fprintf(newfp, "**<3<3 This is the final Organ for this Blood-Stream! <3<3**\n**<3<3 Stay Healthy and keep it up! Have a nice day!<3<3**\n\n v");

printf("********************************De-Composing Human Body...********************************\n");
fprintf(newfp,"********************************De-Composing Human Body...********************************\n");

fclose(fp);
fclose(newfp);
free(rail);


return 0;
}
