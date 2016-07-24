DROP DATABASE travelreviews;
CREATE DATABASE travelreviews;
USE travelreviews;
CREATE TABLE Users
	(Username VARCHAR(15) NOT NULL,
	Email VARCHAR(30) NOT NULL,
	UPassword VARCHAR(15) NOT NULL,
    IsManager BOOLEAN NOT NULL,
	PRIMARY KEY (Username),
	UNIQUE (Email)
);

CREATE TABLE Categories
	(Category VARCHAR(15) NOT NULL,
	PRIMARY KEY(Category)
    );

CREATE TABLE Reviewable
	(ReviewableID int NOT NULL,
	PRIMARY KEY(ReviewableID));

CREATE TABLE Country
	(CountryName VARCHAR(50),
	NUsername VARCHAR(15) NOT NULL,
	Population INT UNSIGNED NOT NULL,

	PRIMARY KEY(CountryName),
	FOREIGN KEY(NUsername) REFERENCES Users(Username)
		ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE City
	(CityName VARCHAR(50),
	CountryName VARCHAR(50),
	Latitude varchar(10) NOT NULL,
	Longitude varchar(10) NOT NULL,
	MUsername VARCHAR(15) NOT NULL,
	ReviewableID INT NOT NULL,
	Capital BOOLEAN NOT NULL,
    Population int not null,

	PRIMARY KEY(CityName, CountryName),
	FOREIGN KEY(CountryName) REFERENCES Country(CountryName)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(ReviewableID) REFERENCES Reviewable(ReviewableID)
		ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Location
(
    Address         VARCHAR(100)        NOT NULL,
    CityName        VARCHAR(50)    NOT NULL,
    CountryName     VARCHAR(50)     NOT NULL,
    LName           VARCHAR(50)   NOT NULL,
    Cost            INT         NOT NULL,
    LocationType    VARCHAR(15) NOT NULL,
    StudentDiscount BOOL        NOT NULL,
    ReviewableID    INT       NOT NULL,


    FOREIGN KEY(CityName)      REFERENCES City(CityName)               ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(CountryName)   REFERENCES Country(CountryName)            ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(ReviewableID)  REFERENCES Reviewable(ReviewableID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(LocationType)  REFERENCES Categories(Category) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY(Address,
                CityName,
                CountryName)
);




CREATE TABLE Event
	(EName VARCHAR(50) NOT NULL,
	EDate DATE NOT NULL,
	StartTime TIME NOT NULL,
	Address VARCHAR(100) NOT NULL,
	CityName VARCHAR(50) NOT NULL,
	CountryName VARCHAR(50) NOT NULL,
	EndTime TIME,
	Cost INT NOT NULL,
	StudentDiscount boolean NOT NULL DEFAULT false,
	Description TEXT NOT NULL,
	EventType VARCHAR(15) NOT NULL,
	ReviewableID int NOT NULL,

	CHECK (StartTime < EndTime),
	FOREIGN KEY(Address) REFERENCES Location(Address)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(CityName) REFERENCES Location(CityName)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(CountryName) REFERENCES Location(CountryName)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(EventType) REFERENCES Categories(Category)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(ReviewableID) REFERENCES Reviewable(ReviewableID)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT EVENTID PRIMARY KEY (EName, EDate, StartTime, Address, CityName, CountryName)
);


CREATE TABLE Review
	(Date DATE,
	 Username varchar(15) NOT NULL,
	 Score int,
	 Description varchar(255),
	 ReviewableID int NOT NULL,
	 PRIMARY KEY(Date, Username, ReviewableID),
	 FOREIGN KEY(Username) REFERENCES Users(Username),
	 FOREIGN KEY(ReviewableID) REFERENCES Reviewable(ReviewableID)
		 ON DELETE RESTRICT	ON UPDATE CASCADE
);

CREATE TABLE Languages 
	(LanguageName varchar(25) NOT NULL,
     PRIMARY KEY(LanguageName)
);

CREATE TABLE CountryLanguage
	(CountryName varchar(50) NOT NULL,
	 LanguageName varchar(25) NOT NULL,
	 PRIMARY KEY(CountryName, LanguageName),
	 FOREIGN KEY(CountryName) REFERENCES Country(CountryName)
		ON DELETE RESTRICT	ON UPDATE CASCADE,
	 FOREIGN KEY (LanguageName) REFERENCES Languages(LanguageName)
		ON DELETE RESTRICT	ON UPDATE CASCADE
);

CREATE TABLE CityLanguage
	(CountryName varchar(50) NOT NULL,
	 CityName varchar(50) NOT NULL,
	 LanguageName varchar(25) NOT NULL,
	 PRIMARY KEY(CountryName, LanguageName),
	 FOREIGN KEY(CityName) REFERENCES City(CityName)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	 FOREIGN KEY(CountryName) REFERENCES Country(CountryName)
		ON DELETE RESTRICT	ON UPDATE CASCADE,
	FOREIGN KEY (LanguageName) REFERENCES Languages(LanguageName)
		ON DELETE RESTRICT	ON UPDATE CASCADE
);


