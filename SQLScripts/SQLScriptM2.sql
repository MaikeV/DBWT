DROP TABLE IF EXISTS hatMB;
DROP TABLE IF EXISTS enthaeltMZ;
DROP TABLE IF EXISTS braucht;
DROP TABLE IF EXISTS befreundetMit;
DROP TABLE IF EXISTS enthaeltBM;
DROP TABLE IF EXISTS gehoertZu;

DROP TABLE IF EXISTS Kommentare;
DROP TABLE IF EXISTS Mitarbeiter;
DROP TABLE IF EXISTS Studenten;
DROP TABLE IF EXISTS Gaeste;
DROP TABLE IF EXISTS FH_Angehoerige;
DROP TABLE IF EXISTS Fachbereiche;
DROP TABLE IF EXISTS Preise;
DROP TABLE IF EXISTS Bestellungen;
DROP TABLE IF EXISTS Mahlzeiten;
DROP TABLE IF EXISTS Deklarationen;
DROP TABLE IF EXISTS Kategorien;
DROP TABLE IF EXISTS Bilder;
DROP TABLE IF EXISTS Zutaten;
DROP TABLE IF EXISTS Benutzer;

CREATE TABLE Benutzer
(
    Nummer        INT        NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `E-Mail`      CHAR(100)  NOT NULL UNIQUE,
    Bild          MEDIUMBLOB,
    Nutzername    CHAR(100)  NOT NULL UNIQUE,
    Anlegedatum   DATETIME   NOT NULL,
    Aktiv         BOOLEAN,
    Vorname       CHAR(100)  NOT NULL,
    Nachname      CHAR(50)   NOT NULL,
    Geburtsdatum  DATE,
    `Alter`       INT AS(TIMESTAMPDIFF(YEAR, Geburtsdatum, CURDATE())),
    Hash          CHAR(60)   NOT NULL,
    LetzterLogin  DATETIME   DEFAULT NULL
);

CREATE TABLE Gaeste
(
    Nummer      INT NOT NULL UNIQUE PRIMARY KEY,
    Grund       CHAR(254) NOT NULL,
    Ablaufdatum DATETIME  NOT NULL DEFAULT (DATE_ADD(CURRENT_DATE, INTERVAL 1 WEEK)),
    FOREIGN KEY(Nummer)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
);

CREATE TABLE FH_Angehoerige(
    Nummer INT NOT NULL UNIQUE PRIMARY KEY,
    CONSTRAINT NummerBenutzer
        FOREIGN KEY(Nummer)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Fachbereiche
(
    ID INT UNIQUE NOT NULL PRIMARY KEY,
    Name CHAR(100) NOT NULL,
    Website CHAR(150) NOT NULL
);

# N - M zwischen Fachbereich und FH-Angehoerige
CREATE TABLE gehoertZu
(
    IDFachbereich INT UNIQUE NOT NULL,
    NummerBenutzer INT UNIQUE NOT NULL,
    CONSTRAINT IDFachbereichGehoertZuFachbereich
        FOREIGN KEY(IDFachbereich)
        REFERENCES Fachbereiche(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT NummerBenutzerGehoertZuFachbereich
        FOREIGN KEY(NummerBenutzer)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY(IDFachbereich, NummerBenutzer)
);

CREATE TABLE Mitarbeiter
(
    Nummer INT UNIQUE PRIMARY KEY NOT NULL,
    Buero CHAR(50) NULL,
    Telefon CHAR(20) NULL,
    FOREIGN KEY(Nummer)
        REFERENCES FH_Angehoerige(Nummer)
        ON DELETE CASCADE
);

CREATE TABLE Studenten
(
    Nummer INT UNIQUE PRIMARY KEY NOT NULL,
    Matrikelnummer INT NOT NULL UNIQUE CHECK(Matrikelnummer > 10000000 AND Matrikelnummer < 999999999),
    Studiengang CHAR(3) NOT NULL,
    FOREIGN KEY(Nummer)
        REFERENCES FH_Angehoerige(Nummer)
        ON DELETE CASCADE,
    CONSTRAINT checkStudiengang
        CHECK (Studiengang IN ('ET', 'INF', 'ISE', 'MCD', 'WI'))
);

CREATE TABLE Bestellungen
(
	Bestellzeitpunkt DATETIME NOT NULL DEFAULT NOW(),
	Abholzeitpunkt DATETIME CHECK(Abholzeitpunkt > Bestellzeitpunkt),
	Nummer INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT,
	Endpreis DOUBLE NOT NULL,
	getaetigtVon INT NOT NULL,
	CONSTRAINT getaetigtVon
        FOREIGN KEY(getaetigtVon)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Bilder
(
    ID INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `Alt-Text` CHAR(50) NOT NULL,
    Titel CHAR(100) NULL,
    Binaerdaten MEDIUMBLOB NULL
);

CREATE TABLE Kategorien
(
    ID INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    Bezeichnung char(100) NOT NULL,
    hatKategorien INT NOT NULL,
    hatBilder INT NOT NULL,
    CONSTRAINT hatKategorien
        FOREIGN KEY(hatKategorien)
        REFERENCES Kategorien(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT hatBilder
        FOREIGN KEY(hatBilder)
        REFERENCES Bilder(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Mahlzeiten
(
	ID INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
	Vorrat int default 0 not null,
	Beschreibung char(255) not null,
	Verfuegbar BOOLEAN AS(Vorrat > 0) VIRTUAL,
	istIn INT NOT NULL,
	CONSTRAINT inKategorie
        FOREIGN KEY(istIn)
        REFERENCES Kategorien(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

# N - M zwischen Bestellungen und Mahlzeiten
CREATE TABLE enthaeltBM
(
    NummerBestellungen INT NOT NULL,
    IDMahlzeiten INT NOT NULL,
    Anzahl INT NOT NULL,
    CONSTRAINT NummerBestellungenEnthaeltMahlzeiten
        FOREIGN KEY(NummerBestellungen)
        REFERENCES Bestellungen(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT IDMahlzeitenEnthaeltMahlzeiten
        FOREIGN KEY(IDMahlzeiten)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY(NummerBestellungen, IDMahlzeiten)
);

CREATE TABLE Preise
(
    Jahr YEAR NOT NULL,
    Gastpreis DOUBLE NOT NULL CHECK (Gastpreis > 0),
    Studentpreis DOUBLE CHECK(Studentpreis < `MA-Preis` AND Studentpreis > 0),
    `MA-Preis` DOUBLE CHECK (`MA-Preis` > 0),
    ID INT NOT NULL,
    CONSTRAINT IDMahlzeitPreise
        FOREIGN KEY(ID)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY(Jahr, ID)
);

# N - M zwischen Mahlzeiten und Bilder
CREATE TABLE hatMB
(
    IDMahlzeiten INT NOT NULL,
    IDBilder INT NOT NULL,
    CONSTRAINT IDMahlzeitenHat
        FOREIGN KEY(IDMahlzeiten)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT IDBilderHat
        FOREIGN KEY(IDBilder)
        REFERENCES Bilder(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Zutaten
(
    ID NUMERIC(5, 0) UNIQUE NOT NULL PRIMARY KEY ,
    Name char(100) NOT NULL,
    Bio BOOLEAN NOT NULL,
    Vegetarisch BOOLEAN NOT NULL,
    Vegan BOOLEAN NOT NULL,
    Glutenfrei BOOLEAN NOT NULL
);

# N - M zwischen Mahlzeiten und Zutaten
CREATE TABLE enthaeltMZ
(
    IDMahlzeiten INT,
    IDZutaten NUMERIC(5, 0),
    CONSTRAINT IDMahlzeitEnthaeltZutaten
        FOREIGN KEY (IDMahlzeiten)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT IDZutatenEnthaeltZutaten
        FOREIGN KEY (IDZutaten)
        REFERENCES Zutaten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT JoinedPrimaryKeyEnthaeltMZ
        PRIMARY KEY (IDMahlzeiten, IDZutaten)
);

CREATE TABLE Deklarationen
(
    Zeichen CHAR(2) UNIQUE PRIMARY KEY NOT NULL,
    Beschriftung CHAR(32) NOT NULL
);

# N - M zwischen Mahlzeiten und Deklarationen
CREATE TABLE braucht
(
    IDMahlzeiten INT NOT NULL,
    ZeichenDeklarationen CHAR(2) NOT NULL,
    CONSTRAINT IDMahlzeitBraucht
        FOREIGN KEY (IDMahlzeiten)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT ZeichenDeklarationenBraucht
        FOREIGN KEY (ZeichenDeklarationen)
        REFERENCES Deklarationen(Zeichen)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT JoinedPrimaryKeyBraucht
        PRIMARY KEY(IDMahlzeiten, ZeichenDeklarationen)
);

CREATE TABLE Kommentare
(
    ID INT UNIQUE NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Bemerkung CHAR(255),
    Bewertung TINYINT(1),
    zu INT NOT NULL,
    GeschriebenVon INT NOT NULL,
    CONSTRAINT KommentarZu
        FOREIGN KEY(zu)
        REFERENCES Mahlzeiten(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT KommentarVon
        FOREIGN KEY(GeschriebenVon)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

# N - M Benutzer
CREATE TABLE befreundetMit
(
    Nummer INT UNIQUE PRIMARY KEY NOT NULL,
    CONSTRAINT NummerBenutzerBefreundetMit
        FOREIGN KEY(Nummer)
        REFERENCES Benutzer(Nummer)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


INSERT INTO Benutzer(`E-Mail`, Nutzername, Anlegedatum, Aktiv, Vorname, Nachname, Geburtsdatum, Hash, LetzterLogin) VALUES ('mv6889s@fh-aachen.de', 'mv6889s', CURRENT_DATE, 1, 'Maike', 'Voss', '1995-08-03', '123456', NOW());
INSERT INTO FH_Angehoerige(Nummer) SELECT Nummer FROM Benutzer WHERE Nutzername = 'mv6889s';
INSERT INTO Studenten(Nummer, Matrikelnummer, Studiengang) VALUES((SELECT Nummer FROM Benutzer WHERE Nutzername = 'mv6889s'), 31912330, 'INF');

INSERT INTO Benutzer(`E-Mail`, Nutzername, Anlegedatum, Aktiv, Vorname, Nachname, Geburtsdatum, Hash, LetzterLogin) VALUES ('mm1234s@fh-aachen.de', 'mm1234s', CURRENT_DATE, 1, 'Max', 'Mustermann', '1993-05-10', '123456', NOW());
INSERT INTO FH_Angehoerige(Nummer) SELECT Nummer FROM Benutzer WHERE Nutzername = 'mm1234s';
INSERT INTO Studenten(Nummer, Matrikelnummer, Studiengang) VALUES((SELECT Nummer FROM Benutzer WHERE Nutzername = 'mm1234s'), 123456789, 'ET');

INSERT INTO Benutzer(`E-Mail`, Nutzername, Anlegedatum, Aktiv, Vorname, Nachname, Geburtsdatum, Hash, LetzterLogin) VALUES ('jd4321m@fh-aachen.de', 'jd4321m', CURRENT_DATE, 1, 'Jane', 'Doe', '1992-06-04', '123456', NOW());
INSERT INTO FH_Angehoerige(Nummer) SELECT Nummer FROM Benutzer WHERE Nutzername = 'jd4321m';
INSERT INTO Mitarbeiter(Nummer) VALUES((SELECT Nummer FROM Benutzer WHERE Nutzername = 'jd4321m'));

INSERT INTO Benutzer(`E-Mail`, Nutzername, Anlegedatum, Aktiv, Vorname, Nachname, Geburtsdatum, Hash, LetzterLogin) VALUES ('testuser@fh-aachen.de', 'testuser', CURRENT_DATE, 1, 'Test', 'User', '1863-12-12', '123456', NOW());
