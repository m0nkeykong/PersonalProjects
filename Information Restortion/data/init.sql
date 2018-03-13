    CREATE DATABASE IF NOT EXISTS ir;

    /*select database to use*/
    USE ir;

    /*file list table - contains the file number and the file name*/
    CREATE TABLE file_list(file_number varchar(255),
                        file_name varchar(255),
                        file_author varchar(255),
                        file_type varchar(255),
                        file_created varchar(255),
                        PRIMARY KEY(file_number));


    /*word list table - contains all the words and file occurences*/
    CREATE TABLE word_list(word varchar(255),
                            file_number varchar(255),
                            occurrences int,
                            PRIMARY KEY(word, file_number),
                            FOREIGN KEY (file_number) REFERENCES file_list(file_number) ON UPDATE CASCADE ON DELETE CASCADE);


    CREATE TABLE stop_list(word varchar(255),
                        file_number varchar(255),
                        occurrences int,
                        PRIMARY KEY(word, file_number),
                        FOREIGN KEY (file_number) REFERENCES file_list(file_number) ON UPDATE CASCADE ON DELETE CASCADE);
