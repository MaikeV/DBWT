DROP TABLE IF EXISTS Benutzer;
DROP TABLE IF EXISTS Bestellungen;
DROP TABLE IF EXISTS Mahlzeiten;
DROP TABLE IF EXISTS Kategorien;
DROP TABLE IF EXISTS Bilder;
DROP TABLE IF EXISTS Zutaten;

CREATE TABLE Benutzer
(
    Nummer        int        not null UNIQUE PRIMARY KEY,
    `E-Mail`      char(100)  not null UNIQUE,
    Bild          mediumblob null,
    Nutzername    char(100)  not null UNIQUE,
    Anlegedatum   datetime   not null,
    Aktiv         tinyint(1) null,
    Vorname       char(100)  not null,
    Nachname      char(50)   not null,
    Geburtsdatum date       null,
    `Alter`       int        null,
    Hash          char(60)   not null,
    LetzterLogin  DATETIME   null
);

CREATE TABLE Bestellungen
(
	Abholzeitpunkt DATETIME null,
	Bestellzeitpunkt DATETIME not null,
	Nummer int not null PRIMARY KEY UNIQUE ,
	Endpreis double not null
);

CREATE TABLE Mahlzeiten
(
	IDM int not null UNIQUE PRIMARY KEY ,
	Vorrat int default 0 not null,
	Beschreibung char(255) not null
);

CREATE TABLE Kategorien
(
    IDCat INT NOT NULL UNIQUE PRIMARY KEY,
    Bezeichnung char(100) NOT NULL
);

CREATE TABLE Bilder
(
    IDB INT NOT NULL UNIQUE PRIMARY KEY,
    `Alt-Text` char(50) NOT NULL,
    Titel char(100) NULL,
    Binaerdaten MEDIUMBLOB NULL
);

CREATE TABLE Zutaten
(
    IDZ NUMERIC(5, 0) UNIQUE NOT NULL PRIMARY KEY ,
    Name char(100) NOT NULL,
    Bio BOOLEAN NOT NULL,
    Vegetarisch BOOLEAN NOT NULL,
    Vegan BOOLEAN NOT NULL,
    Glutenfrei BOOLEAN NOT NULL
);

CREATE TABLE Kommentare
(
    IDK INT UNIQUE NOT NULL PRIMARY KEY,
    Bemerkung CHAR(255),
    Bewertung
)