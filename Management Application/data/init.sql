CREATE DATABASE IF NOT EXISTS sc;

/*select database to use*/
USE sc;

/*engineer table*/
CREATE TABLE engineer(engineer_id varchar(255),
                      first_name varchar (255),
                      last_name varchar(255),
                      date_of_birth varchar(255),
                      age int,
                      city varchar(255),
                      street varchar(255),
                      PRIMARY KEY(engineer_id));

/*phone table*/
CREATE TABLE phone_number(engineer_id varchar(255),
                          telephone varchar(255),
                          telephone2 varchar(255),
                          FOREIGN KEY(engineer_id) REFERENCES engineer(engineer_id) on UPDATE CASCADE on DELETE CASCADE,
                          PRIMARY KEY (telephone));

/*software table*/
CREATE TABLE software_field(field_id int AUTO_INCREMENT,
                            specialization varchar(255),
                            name varchar(255),
                            PRIMARY KEY(field_id));

/*projects table*/
CREATE TABLE projects(project_number int AUTO_INCREMENT,
                      project_name varchar(255),
                      customer_name varchar(255),
                      start_date varchar(255),
                      description varchar (255),
                      PRIMARY KEY(project_number));

/*milestones table*/
CREATE TABLE milestones(project_number int,
                        date varchar(255),
                        submission varchar(255),
                        receive_payment int,
                        cur_month varchar(255),
                        FOREIGN KEY(project_number) REFERENCES projects(project_number) on UPDATE CASCADE on DELETE CASCADE,
                        CONSTRAINT PK_MS PRIMARY KEY (project_number, date));

/*development table*/
CREATE TABLE development_stages(project_number int,
                                production_management varchar(255),
                                mission_management varchar(255),
                                design_review varchar(255),
                                requirements_management varchar(255),
                                planning varchar(255),
                                software_checks varchar(255),
                                unit_checks varchar(255),
                                PRIMARY KEY(project_number),
                                FOREIGN KEY(project_number) REFERENCES projects(project_number) on UPDATE CASCADE on DELETE CASCADE);

/*grade table*/
CREATE TABLE monthly_grade(month int,
                          grade int,
                          engineer_id varchar(255),
                          project_number int,
                          FOREIGN KEY(engineer_id) REFERENCES engineer(engineer_id) on UPDATE CASCADE on DELETE CASCADE,
                          FOREIGN KEY(project_number) REFERENCES projects(project_number) on UPDATE CASCADE on DELETE CASCADE,
                          CONSTRAINT PK_MG PRIMARY KEY(engineer_id, project_number, month));

/*engineer - project connection*/
CREATE TABLE takespart(engineer_id varchar(255),
                      project_number int,
                      FOREIGN KEY(engineer_id) REFERENCES engineer(engineer_id) on UPDATE CASCADE on DELETE CASCADE,
                      FOREIGN KEY(project_number) REFERENCES projects(project_number) on UPDATE CASCADE on DELETE CASCADE,
                      CONSTRAINT PK_TP PRIMARY KEY(engineer_id, project_number));

/*engineer - software connection*/
CREATE TABLE speciality(engineer_id varchar(255),
                  field_id int,
                  FOREIGN KEY(engineer_id) REFERENCES engineer(engineer_id) on UPDATE CASCADE on DELETE CASCADE,
                  FOREIGN KEY(field_id) REFERENCES software_field(field_id) on UPDATE CASCADE on DELETE CASCADE,
                  PRIMARY KEY(engineer_id));


/*insert raw data into ENGINEER table*/
INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("1", "Haim", "Elbaz", "24/07/1990", "28", "Ashkelon", "Kineret 12");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("2", "Roni", "Polisanov", "26/07/1992", "26", "Hadera", "Harav Ovadia Yosef 17");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("3", "Asaf", "Loch", "30/10/1990", "28", "Rehovot", "Zarnuga 14");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("4", "Tal", "Blonder", "01/05/1990", "28", "Emek Izrael", "Yashresh 98");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("5", "Zion", "Maor", "30/012/1990", "28", "Tel-Aviv", "Ben Yehuda 163");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("6", "Tzah", "Sabag", "22/06/1989", "29", "Ness-Ziona", "Habanim 7");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("7", "Niv", "Nucher", "16/09/1987", "31", "Petah-Tikva", "Yeda Am 118");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("8", "Gal", "Harel", "30/04/1990", "28", "Or Yehuda", "Shalom Alehem 36");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("9", "Din", "Samual", "05/05/1985", "33", "Holon", "Haachmaot 243");

INSERT INTO engineer(engineer_id, first_name, last_name, date_of_birth, age, city, street)
            VALUES ("10", "Yarden", "Halfon", "14/12/1990", "28", "Netanya", "Hacham Hanuka 78");

/*insert raw data into PHONE_NUMBER table*/
INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("1", "202-555-0186", "202-555-0116");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("2", "202-555-0155", "202-555-0117");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("3", "404-555-0118", "404-555-0121");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("4", "775-555-0180", "775-555-0157");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("5", "775-555-0160", "775-555-0185");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("6", "860-555-0128", "860-555-0151");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("7", "860-555-0178", "860-555-0170");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("8", "785-555-0143", "785-555-0174");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("9", "302-555-0154", "302-555-0195");

INSERT INTO phone_number(engineer_id, telephone, telephone2)
            VALUES ("10", "617-555-0123", "617-555-0151");

/*insert raw data into SOFTWARE_FIELD table*/
INSERT INTO software_field(specialization, name)
            VALUES ("Software Checking", "QA");

INSERT INTO software_field(specialization, name)
            VALUES ("Drinking Tea", "Taster");

INSERT INTO software_field(specialization, name)
            VALUES ("Eating Meat", "Cower");

INSERT INTO software_field(specialization, name)
            VALUES ("Riding Horses", "Cowboy");

INSERT INTO software_field(specialization, name)
            VALUES ("Bull Fighting", "Matador");

INSERT INTO software_field(specialization, name)
            VALUES ("Investigating Drunk People", "Drunk Investigator");

INSERT INTO software_field(specialization, name)
            VALUES ("Finding Lost People", "TzofitGrant");

INSERT INTO software_field(specialization, name)
            VALUES ("Killing Engineers", "Murderer");

INSERT INTO software_field(specialization, name)
            VALUES ("Making Coffe", "Nesppresso");

INSERT INTO software_field(specialization, name)
            VALUES ("Buying Food", "Frayer");


/*insert raw data into PROJECTS table*/
INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("WhatsApp", "Halfon", "01/01/2017", "Message Application");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Windows", "Bill Gates", "01/01/2015", "OS");
            
INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Facebook", "Mark Tzukerberg", "01/01/2014", "Social Network");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Pintrest", "Alex Tazi", "01/03/2017", "Photo Album");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("El Gaucho", "Enrique Empanadas", "31/11/2012", "Restaurant");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Fal Falafel", "Shuki Hatuka", "21/09/2017", "A Very Successful Falafeliya");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Hatuliya", "Tziyon Hatuka", "12/07/2001", "Selling Cats");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Indigo", "Raz Frishman", "01/01/2015", "Hotel");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Apple", "Steve Job R.I.P", "01/01/2000", "General Company");

INSERT INTO projects(project_name, customer_name, start_date, description)
            VALUES ("Samsung", "Ishim Oto", "01/01/2005", "Cleaning Company");


/*insert raw data into MILESTONES table*/
INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("1", "01/01/2018", "finish all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("2", "01/01/2018", "eat all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("3", "01/01/2018", "drink all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("4", "01/01/2018", "shoot all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("5", "01/01/2018", "steal all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("6", "01/01/2018", "keep all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("7", "01/01/2018", "spend all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("8", "01/01/2018", "throw all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("9", "01/01/2018", "give all the money", "10000", "01");

INSERT INTO milestones(project_number, date, submission, receive_payment, cur_month)
            VALUES ("10", "01/01/2018", "take all the money", "10000", "01");


/*insert raw data into DEVELOPMENT_STAGES table*/
INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("1", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("2", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("3", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("4", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("5", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("6", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("7", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("8", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("9", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");

INSERT INTO development_stages(project_number, production_management, mission_management, design_review, requirements_management, planning, software_checks, unit_checks)
            VALUES ("10", "c++", "moqups", "dev++", "draw.io", "GIT", "xcode", "Office");


/*insert raw data into MONTHLY_GRADE table*/
INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("1", "1", "1", "1");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("2", "2", "2", "2");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("3", "3", "3", "3");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("4", "4", "4", "4");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("5", "5", "5", "5");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("6", "6", "6", "6");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("7", "7", "7", "7");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("8", "8", "8", "8");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("9", "9", "9", "9");

INSERT INTO monthly_grade(month, grade, engineer_id, project_number)
            VALUES ("10", "10", "10", "10");


/*insert raw data into TAKESPART table*/
INSERT INTO takespart(engineer_id, project_number)
            VALUES ("1", "1");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("2", "2");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("3", "3");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("4", "4");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("5", "5");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("6", "6");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("7", "7");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("8", "8");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("9", "9");

INSERT INTO takespart(engineer_id, project_number)
            VALUES ("10", "10");



/*insert raw data into SPECIALITY table*/
INSERT INTO speciality(engineer_id, field_id)
            VALUES ("1", "1");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("2", "2");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("3", "3");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("4", "4");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("5", "5");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("6", "6");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("7", "7");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("8", "8");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("9", "9");

INSERT INTO speciality(engineer_id, field_id)
            VALUES ("10", "10");
