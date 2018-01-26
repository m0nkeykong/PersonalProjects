#include <stdio.h>
#include <stdlib.h>
#include <string.h>

// Gal Argov Sofer
// Roni Polisanov


#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stddef.h>                                                            // To use strsep()

#define MAX_CAR 10                                                              // Max Car Size
#define MAX_LEVEL 24                                                            // Max Level Size
#define BUFF_SIZE 1024                                                          // Buffer size

//Globals to write log
FILE *pt_in = NULL;
FILE *pt_out = NULL;


////////////////////////////// STRUCTS //////////////////////////////
typedef struct cars {                                                           // Struct car
    char *id;
    char *kind;
    char *color;
} car;

typedef struct levels {                                                         // Struct level
    int count_car_in_level;
    car *car_num;
} level;

typedef struct parks {                                                          // Struct parking_lot
    int count_level_in_park;
    int count_car_in_park;
    int count_car_out_park;
    int count_level_destroy;
    level *level_num;
} park;


////////////////////////////// FUNCTIONS //////////////////////////////
void create_level (park * p)
{
    // check if first level - malloc
    if(p->count_level_in_park == 0)
    {
        level* p_level = (level*)malloc(sizeof(level)*1 );								//allocating memory needed for floors
        if(p_level == NULL)
            return;
        p->level_num = p_level;
        p->count_level_in_park += 1;
        p->level_num->count_car_in_level = 0;
    }
    // else (not first level) - realloc
    else
    {
        p->level_num = (level*)realloc(p->level_num, sizeof(level) * (p->count_level_in_park + 1));
        p->count_level_in_park += 1;
        p->level_num[(p->count_level_in_park) - 1].count_car_in_level = 0;
    }
    //    printf("\nlevel  %d created: \n", p->count_level_in_park);                     // write to check (command line)
    fprintf(pt_out, "\nlevel  %d created: \n", p->count_level_in_park);            // write to log
    return;
}

void create_car (park * p, char * id, char * kind, char * color)
{
    // Check if creating first car in level or second, third and more until MAX_CAR (first - malloc , other - realloc)
    if(p->level_num[p->count_level_in_park-1].count_car_in_level == 0)
    {
        car * p_car = (car*)malloc(sizeof(car) * 1 );							// allocating memory needed for cars
        if(p_car == NULL)                                                       // check goot allocate memory
            return;
        p_car->id = strdup(id);
        p_car->kind = strdup(kind);
        p_car->color = strdup(color);
        p->level_num[p->count_level_in_park-1].car_num = p_car;
    }
    else
    {
        p->level_num[p->count_level_in_park-1].car_num = (car*)realloc(p->level_num[p->count_level_in_park-1].car_num,
                                                                       sizeof(car)*(p->level_num[p->count_level_in_park-1].count_car_in_level + 1));
        if(p->level_num[p->count_level_in_park-1].car_num == NULL)
            return;
        p->level_num[p->count_level_in_park-1].car_num[p->level_num[p->count_level_in_park-1].count_car_in_level].id = strdup(id);
        p->level_num[p->count_level_in_park-1].car_num[p->level_num[p->count_level_in_park-1].count_car_in_level].kind = strdup(kind);
        p->level_num[p->count_level_in_park-1].car_num[p->level_num[p->count_level_in_park-1].count_car_in_level].color = strdup(color);
    }
    p->level_num[p->count_level_in_park-1].count_car_in_level += 1;
    p->count_car_in_park += 1;
    //    printf("<%s> [%d,%d] ",id, p->count_level_in_park, p->count_car_in_park);                            //go to log car created
    fprintf(pt_out, "car  %s , in place [%d,%d]  created.\n", id,p->count_level_in_park, p->count_car_in_park);
    return;
}

void wainting_list (level * level_waiting_list, char * id, char * kind, char * color)
{
    static int count = 0;
    if (level_waiting_list->count_car_in_level == 0) {
        car * ptr = (car*)malloc(sizeof(car));
        if (ptr == NULL)
            return;
        level_waiting_list->car_num = ptr;
        level_waiting_list->car_num->id = strdup(id);
        level_waiting_list->car_num->color = strdup(color);
        level_waiting_list->car_num->kind = strdup(kind);
    }
    else {
        level_waiting_list->car_num = (car*)realloc(level_waiting_list->car_num,sizeof(car)*(1+level_waiting_list->count_car_in_level));
        level_waiting_list->car_num[level_waiting_list->count_car_in_level].id = strdup(id);
        level_waiting_list->car_num[level_waiting_list->count_car_in_level].color = strdup(color);
        level_waiting_list->car_num[level_waiting_list->count_car_in_level].kind = strdup(kind);
    }
    level_waiting_list->count_car_in_level +=1;
    count +=1;
    //    printf("\nThere is %d cars in waiting list (ID %s).", count, id);
    fprintf(pt_out, "\nThere is %d cars in waiting list (ID %s).", count, id);
    return;
}



void free_car(char * id, park * p)
{
    int i,j;
    for (i=0 ; i < p->count_level_in_park ; ++i)
        //( i = 0 ;(i<p->count_level_in_park); ++i ) //i <  MAX_LEVEL) &&
    {
        for( j = 0 ; (j < MAX_CAR) && ( j < p->level_num[i].count_car_in_level) ; ++j )
        {
            if( strcmp(id, p->level_num[i].car_num[j].id) == 0)
            {
                p->level_num[i].car_num[j].id = strdup("0");
                p->level_num[i].count_car_in_level -= 1;											//free car's data (contain ptrs)
                p->count_car_out_park +=1;
                fprintf(pt_out,"Car %s get out from the park.\n",id);
                return;
            }
        }
    }
    return;
}
////////////////////////////////// NEED FIXING /////////////////////////////////
park * shrink_park (park * p)
{
    int i , j = 0 ;
    char *temp_id = NULL;                                                       // Temporary ID
    char *temp_kind = NULL;                                                     // Temporary kind
    char *temp_color = NULL;                                                    // Temporary color
    park * park_new = (park*)malloc(1*sizeof(park));;
    if (park_new == NULL)
    {
        printf("Can't create new park for shriking.\n");
        fprintf(pt_out,"Can't create new park for shriking.\n");
    }
    else
    {
        park_new->count_level_in_park = 0;
        park_new->count_car_in_park = 0;
        park_new->count_car_out_park = p->count_car_out_park;
        park_new->count_level_destroy = p->count_level_destroy;
        park_new->level_num = NULL;
    }

    for (i =0; i < MAX_LEVEL ; ++i)
    {
        for (j = 0 ;j<MAX_CAR ; ++ j)
        {



            if (park_new->count_car_in_park < (MAX_CAR * MAX_LEVEL))
            {
                if ((park_new->count_car_in_park%MAX_CAR) == 0)
                {
                    create_level (park_new);
                }
                if (p->level_num[i].car_num[j].id != NULL)
                {
                    temp_id = p->level_num[i].car_num[j].id;
                    temp_kind = p->level_num[i].car_num[j].kind;
                    temp_color = p->level_num[i].car_num[j].color;

                    create_car(park_new, temp_id, temp_kind, temp_color);
                }
            }
        }
    }
    printf("Finish Created Park %d %d.\n", i, j);
    fprintf(pt_out, "Finish Created Park %d %d.\n", i,j);

    park_new->count_level_in_park = ((park_new->count_car_in_park)/MAX_CAR);
    park_new->count_level_destroy = p->count_level_in_park - park_new->count_level_in_park;
    return park_new;
}
////////////////////////////////// NEED FIXING /////////////////////////////////

////////////////////////////////// NEED FIXING /////////////////////////////////
void search_car (park * p, char * id)
{
    int i , j ;
    for (i=0 ; i < p->count_level_in_park ; ++i)
    {
        for( j = 0 ; (j < MAX_CAR) && ( j < p->level_num[i].count_car_in_level) ; ++j )
        {
            //printf("compare car id to every space in park - freeeeeeeeeeeedom\n");
            if( strcmp(id, p->level_num[i].car_num[j].id) == 0)
            {
                printf("The car %s is in level: %d, in slot: %d.\n",p->level_num[i].car_num[j].id, i, j);
                fprintf(pt_out, "The car %s is in level: %s, in slot: %s.\n","p->level_num[i].car_num[j].id", "i", "j");
                return;
            }
        }
    }
    printf ("The car %s does not exsist in the parking lot\n", p->level_num->car_num->id);
    fprintf(pt_out, "The car %s does not exsist in the parking lot\n", p->level_num->car_num->id);
}
////////////////////////////////// NEED1 FIXING /////////////////////////////////

///////////////////// NEED TO BUILD (dont have time \=) ////////////////////////
//int destroy_level (park  * p, level * l)
//{

//}
///////////////////// NEED TO BUILD (dont have time \=) ////////////////////////


int main (int argc, char * argv[]) {
    char *in = NULL;                                                            // Temporary in
    char *temp_id = NULL;                                                       // Temporary ID
    char *temp_kind = NULL;                                                     // Temporary kind
    char *temp_color = NULL;                                                    // Temporary color
    char buff[BUFF_SIZE] =  { 0 };                                              // Buffer that will hold information (line) from the file
    char *token = buff;                                                         // Pointer to start of line


    // Open files and check arguments
    pt_in = fopen(argv[1],"r");
    if (pt_in == NULL)
    {
        printf("Error Input argument 1");
        return -1;
    }
    pt_out = fopen(argv[2],"w");
    if (pt_out == NULL)
    {
        printf("Error Input argument 2");
        return -1;
    }

    // Create main Parking Lot
    printf("Start Create Park.\n");
    fprintf(pt_out, "Create Park.\n");
    park *Park = (park*)malloc(1*sizeof(park));
    if (Park == NULL)
    {
        printf("Can't malloc park.\n");
        fprintf(pt_out, "Can't malloc park.\n");
    }
    else
    {
        Park->count_level_in_park = 0;
        Park->count_car_in_park = 0;
        Park->count_car_out_park = 0;
        Park->count_level_destroy = 0;
        Park->level_num = NULL;
        printf("Finish Created Park.\n");
        fprintf(pt_out, "Finish Created Park.\n");
    }

    // Create Waiting list level
    printf("Start Create Wainting List.\n");
    fprintf(pt_out, "Create Wainting List.\n");

    level * level_waiting_list = (level*)malloc(1*sizeof(level));
    if (level_waiting_list == NULL){
        printf("Can't malloc waiting list level.\n");
        fprintf(pt_out, "Can't malloc waiting list level.\n");

    }
    else
    {
        level_waiting_list->count_car_in_level = 0;
        printf("Wainting List Was Created.\n");
        fprintf(pt_out, "Wainting List Was Created.\n");
    }

    // Reading until end of file
    fprintf(pt_out,"\n\n\n\n\n start reading file\n\n\n\n\n");
    while((fgets(buff, sizeof(buff), pt_in) != NULL))
    {
        // Switch Case: In (I), Out (O) or Comment (#)
        switch (buff[0]) {
                // Comment case
            case '#':
                break;
                // Input case
            case 'I':
                // Seperate the line to short strings (ID, kind and color)
                in = strtok(buff,",");
                temp_id=strtok(NULL,",");
                temp_kind=strtok(NULL,",");
                temp_color=strtok(NULL,",");
                // logic
                if (Park->count_car_in_park < (MAX_CAR * MAX_LEVEL))
                {
                    if ((Park->count_car_in_park%MAX_CAR) == 0)
                    {
                        create_level (Park);
                    }
                    create_car(Park, temp_id, temp_kind, temp_color);
                }
                else
                {
                    wainting_list (level_waiting_list, temp_id, temp_kind, temp_color);
                }
                token = buff;
                break;
                // Output case
            case 'O':
                in = strtok(buff,",");
                temp_id=strtok(NULL,",");
//                temp_color=strtok(NULL,",");
                temp_id[strlen(temp_id)] = '\0';
                char *id_b = strdup(temp_id);
                unsigned long int len = 0;
                while ((len = strlen(id_b)) > 1 && id_b[len - 1] == '\n') {
                    id_b[len - 1] = '\0';
                }
                free_car(id_b, Park);
                token = buff;
                break;
        }
    }


    if (pt_in != NULL)
    {
        fclose(pt_in);
        //printf("\nInput file was closed.\n");
        fprintf(pt_out, "\nInput file was closed.\n");

    }
    //Final Report
    fprintf(pt_out, "\n\n******** Final Report **********\n");
    fprintf(pt_out, "******** Input Cars %d *********\n",Park->count_car_in_park);
    fprintf(pt_out, "******** Output Cars %d ********\n",Park->count_car_out_park);
    fprintf(pt_out, "******** Created Levels %d******\n",Park->count_level_in_park);
    fprintf(pt_out, "******** Destroy Levels %d******\n\n\n",Park->count_level_destroy);


    /////////////////////////// MENU ////////////////////////////////////
    char choice;
    char id[6];
    char *b = id;
    int FLAG=1;
    int i,j;
    printf("\n\n\n~~~~~~~~~~~~~~~~~  HELLO  ~~~~~~~~~~~~~~~~~~\n");
    printf("~~~~~~~~ WELCOME TO THE PARKING LOT ~~~~~~~~\n");
    printf("~~~~~~~~~~~~~~~~~~  MENU  ~~~~~~~~~~~~~~~~~~\n");
    printf("\nPress '1' to search car\nPress '2' to reduce floor\nPress '3' to quit\nWrite here your choice: ");
    do
    {
        fflush(stdin);
        scanf("%c", &choice);
        fflush(stdin);
        //Switch case: Search car(1), Reduce floors(2), Quit(3)
        switch (choice)
        {
            case '1':
                printf("please enter car's id number: ");
                scanf("%s", b);
                search_car (Park, id);
                printf("\n\n\nWelcome back!\n");
                printf("Enter 1 ,2 or 3 again\n");
                break;
            case '2':
                printf("\nSHRINKKKKKKKKKKKKKKKKKKKK\n");
                Park = shrink_park(Park);
                //Final Report
                fprintf(pt_out, "\n\n******** Final Report (after shrink) **********\n");
                fprintf(pt_out, "******** Input Cars %d *********\n",Park->count_car_in_park);
                fprintf(pt_out, "******** Output Cars %d ********\n",Park->count_car_out_park);
                fprintf(pt_out, "******** Created Levels %d******\n",Park->count_level_in_park);
                fprintf(pt_out, "******** Destroy Levels %d******\n\n\n",Park->count_level_destroy);
                for(i=0; i<MAX_CAR*MAX_LEVEL; ++i)
                {
                    for(j=0; j<MAX_CAR;++j)
                    fprintf(pt_out, "car  %s , in place [%d,%d]  created.\n", Park->level_num[i].car_num[j].id, i, j);
                }
                break;
            case '3':
                FLAG=0;
                break;
            default:
                printf("Invailed input.\n");
        }
    } while(FLAG);




    // Cleanups
    if (level_waiting_list != NULL)

    {
        free(level_waiting_list);
        //printf("Free waiting list.\n");
        fprintf(pt_out, "Free waiting list.\n");
    }
    if (Park != NULL)
    {
        free(Park);
        //printf("Free Park\n");
        fprintf(pt_out, "Free park.\n");
    }

    if (pt_out != NULL)
    {
        fclose(pt_out);
        //printf("Output file was closed.\n");
        fprintf(pt_out, "Output file was closed.\n");
    }
    printf("Waiting to see you soon again, goodbye...\n");
    return 0;
}












































































enum {calledfromremove, locate, nospace, freespace};
int caddc = 1, faddc = 1, caronholdc = 0;

typedef struct vehicle
{
    char id[10];
    char brand[20];
    char color[10];
}car;

typedef struct floor
{
    car* location;
}spot;

typedef struct parking
{
    spot* park;
}gush;

addcar(char *buffer, gush *vehicle)
{

int i, j;

if (caddc == 240)
 {
    caronhold(&buffer, &vehicle);
    return;
 }

if (!(caddc % 10))
    vehicle = addfloor(&vehicle);


for (i = 3, j = 0; buffer[i] != ','; ++i, ++j)
    vehicle->id[j] = buffer[i];


    ++i;
for  (j = 0; buffer[i] != ','; ++i, ++j)
    vehicle->brand[j] = buffer[i];

        ++i;

for  (j = 0; buffer[i] != ',' || ' '; ++i, ++j)
    vehicle->color[j] = buffer[i];


++caddc;
}


int addfloor(gush* vehicle)
{

if (faddc == 24)
{
    printf("were sorry but the parking is full!, please wait patiently");
    caronhold(&vehicle);
    return;
}
++faddc;

gush* temp;
     temp = (car*)realloc(vehicle, sizeof(car) * 10 * faddc);

    if (temp == NULL)
{
   printf("insufficent memory! exiting!") ;
   return -1;
}

vehicle = temp;
return (&vehicle);
}


int caronhold(char* buffer, gush* vehicle, int k, int p, gush* temp, int selection)
{
int i, j;

if (selection == nospace)
{
    vehicle = (car*)malloc(sizeof(car));

    if (vehicle == NULL)
        {
            printf("insufficent memory! exiting!") ;
            return -1;
        }
}

if (selection == freespace)
{
for (i = 3, j = 0; buffer[i] != ','; ++i, ++j)
   vehicle->park[k].location[p].id[i] = buffer[i];
++i;

for  (j = 0; buffer[i] != ','; ++i, ++j)
    vehicle->park[k].location[p].brand[i] = buffer[i];
++i;

for  (j = 0; buffer[i] != '\0'; ++i, ++j)
    vehicle->park[k].location[p].color[j] = buffer[i];
}

++caronholdc;
}


void removecar(char* buffer, gush* vehicle)
{

    int check = search_car(&buffer, &vehicle, remove);

    if (check = 1)
    {
        printf("Pof! the requested car has left the building!");
        return;
    }

    printf("sorry, the requested car does not exist in the parking");

}

void search_car (char* buffer, gush* vehicle, int selection)
{
int i, j, k, p, cccc;

if (selection == calledfromremove)
{
    for (k = 0; k <= faddc || cccc != 7; ++k)
    {
        for (p = 0; p <= (faddc*caddc) || cccc != 7; ++p)
        {
            for (i = 0, j = 4, cccc = 0; buffer[j] != ',' || cccc != 7; ++i, ++j)
            {
                if (buffer[j] == (vehicle->park[k].location[p].id[i]))
                {
                    ++cccc;
                    continue;
                }
                else
                    break;
            }
        }
    }
                            if (caronholdc == 0)
                            {
                            for (j = 0; j < 10;  ++j)
                                vehicle->park->location->id[j] = NULL;
                                ++i;

                                for  (j = 0; j < 20; ++j)
                                vehicle->park->location->brand[j] = NULL;
                                ++i;

                                for  (j = 0; j < 10;  ++j)
                                vehicle->park->location->color[j] = NULL;
                            }

                            if (caronholdc != 0)
                            {
                                gush* temp = caronhold(&buffer, 0, 0, k, p, calledfromremove);
                                --caronholdc;
                            }
}

if (selection = locate)
  {


    for (k = 0; k <= faddc ; ++k)
    {
        for (p = 0; p <= (faddc*caddc); ++p)
        {
            j = strcmp(buffer,vehicle->park[k].location[p].id);
                if (j == 0)
                {
                   printf("the vehicle is located in floor %d, parking spot number %d", k, p);
                   return;
                }
        }
     }
    printf("sorry, but license plate does not exist in our parking loot.");
  }
}



void removefloor()
{

}

 void parking_sorting()
 {

 }


void unknown_word(char* index)
{
    printf("sorry, i dont know the word %s",index);
    return;
}


int main(int argc,char* argv[])
{

argv[1]="carLOG.txt";

argv[2]="newcarlog.txt";

char buffer[100] = {0};

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

gush* vehicle = (car*)malloc(sizeof(car) * 10);

    if (vehicle == NULL)
        {
            printf("insufficent memory! exiting!") ;
            return -1;
        }

while (!feof (fp))
{

fgets(buffer, 99, fp);

    switch (buffer[0])
    {
    case '#':
        break;
    case 'I':
        printf("%s", buffer);
        addcar(&buffer, &vehicle);
        break;
    case 'O':
        fprintf(newfp, "%s", buffer);
        removecar(&buffer, &vehicle);
        break;
    default:
        unknown_word(&buffer);
        break;
    }
}


    char* id;
    int choice = 0;
    printf("Hello! Welcome to the Magical-Parking!!!.\n Please enter your selection:\n For car search Enter '1' .\n For Parking sorting (blowing up floors - if you enjoy it) Enter '2' .\n If you'r not enjoying your self and you want to leave Enter '3' .\n");
    scanf("%d", &choice);

    switch(choice)
    {
    case (1):
        printf("Enter id number");
        gets(&id);
        search_car(&id, &vehicle, locate);
        break;
    case (2):
        parking_sorting();
        printf("(Pof!) The Magical-Parking is now compressed is now sorted!");
        break;
    case (3):
        printf("Ok... hope to see you soon again... DASVIDANYA GOVARISH!");
        break;
    }


    fclose(fp);
    fclose(newfp);
    free(vehicle);

    return 0;

}
