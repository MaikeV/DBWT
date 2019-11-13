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
    `Alter`       INT AS(TIMESTAMPDIFF(YEAR, Geburtsdatum, CURDATE())) VIRTUAL,
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
    hatKategorien INT,
    hatBilder INT,
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
	Name CHAR(50) NOT NULL,
	Vorrat int default 0 NOT NULL,
	Beschreibung char(255) NOT NULL,
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
    ID INT(5) UNSIGNED ZEROFILL UNIQUE NOT NULL PRIMARY KEY ,
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
    IDZutaten INT(5) UNSIGNED ZEROFILL,
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
INSERT INTO Mitarbeiter(Nummer, Buero, Telefon) VALUES((SELECT Nummer FROM Benutzer WHERE Nutzername = 'jd4321m'), 'E190', '01234567');

INSERT INTO Benutzer(`E-Mail`, Nutzername, Anlegedatum, Aktiv, Vorname, Nachname, Geburtsdatum, Hash, LetzterLogin) VALUES ('testuser@fh-aachen.de', 'testuser', CURRENT_DATE, 1, 'Test', 'User', '1863-12-12', '123456', NOW());

# DELETE FROM Benutzer WHERE Nummer = 3;


INSERT INTO Kategorien(Bezeichnung) VALUES ('schwedisch'), ('japanisch'), ('chinesisch'), ('italienisch'), ('amerikanisch'), ('deutsch');

INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Koettbullar', 100, 'Leckere schwedische Fleischbaellchen mit Kartoffelpueree und Preisselbeerne. Dazu Gurkensalat und Sahnesosse.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'schwedisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Ramen', 1000, 'Leckere japanische Nudelsuppe mit Schweinebauch, Ei, Shiitake und Fruehlingszwiebeln.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'japanisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Rumpsteak', 100, 'Frisch gegrilltes Rumpsteak, englisch. Dazu Folienkartoffel, frisch aus dem Ofen mit Kraeuterquark.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'amerikanisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Burger', 0, 'Saftiger Rindfleischburger mit Bacon, Kaese, Tomate und roten Zwiebeln.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'amerikanisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Sushi', 400, 'Frisches Sushi, verschiedene Sorten unter anderem mit Lachs, Thunfisch, Avocado und Garnelen.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'japanisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Pizza', 100, 'Ofenfrische italienische Pizza mit Tomatensosse, frischem Mozzarella und Basilikum. Dazu Parmesan und Olivenoel.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'italienisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Dumplings', 300, 'Frisch gesteamte chinesische Dumplings, gefuellt mit Rindergehacktem, Shiitake und Pak Choi. Dazu Chilioel und Knobalauchwasser.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'chinesisch'));
INSERT INTO Mahlzeiten(Name, Vorrat, Beschreibung, istIn) VALUES('Lachsforelle aus dem Ofen', 50, 'Taeglich frisch gefangene Lachsforelle. Im Ofen gegart, mit Knoblauch und roten Zwiebeln. Dazu Kartoffeln mit Butter.', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'deutsch'));


INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00000, 'Gehacktes (Rind)', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00001, 'Gehacktes (gemischt)', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00002, 'Gehacktes (Schwein)', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00003, 'Sahne', 1, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00004, 'Paniermehl', 0, 1, 1, 0);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00005, 'Preisselbeeren', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00006, 'Kartoffeln', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00007, 'Gurken', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00008, 'Nudeln (asiatisch)', 0, 1, 1, 0);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00009, 'Schweinebauch', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00010, 'Ei', 1, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00011, 'Shiitake', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00012, 'Fruehlingszwiebeln', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00013, 'Rindersteak', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00014, 'Quark', 1, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00015, 'Kraeuter', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00016, 'Bacon', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00017, 'Kaese', 1, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00018, 'Tomate', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00019, 'Zwiebeln (rot)', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00020, 'Lachs', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00021, 'Thunfisch', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00022, 'Garnelen', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00023, 'Avocado', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00024, 'Reis', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00025, 'Mehl', 0, 1, 1, 0);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00026, 'Wasser', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00027, 'Hefe', 0, 1, 1, 0);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00028, 'Mozzarella', 0, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00029, 'Parmesan', 0, 1, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00030, 'Basilikum', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00031, 'Olivenoel', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00032, 'Salz', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00033, 'Pak Choi', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00034, 'Chilis', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00035, 'Knoblauch', 1, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00036, 'Oel', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00037, 'Gewuerze', 0, 1, 1, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00038, 'Lachsforelle', 1, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00039, 'Bruehe', 0, 0, 0, 1);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00040, 'Buns', 0, 1, 0, 0);
INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES (00041, 'Essig', 0, 1, 1, 1);

INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (1, 00001), (1, 00003), (1, 00004), (1, 00005), (1, 00006), (1, 00007), (1, 00032);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (2, 00008), (2, 00009), (2, 00010), (2, 00011), (2, 00012), (2, 00039), (2, 00032);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (3, 00013), (3, 00014), (3, 00015), (3, 00006), (3, 00032);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (4, 00000), (4, 00016), (4, 00017), (4, 00018), (4, 00019), (4, 00040);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (5, 00020), (5, 00021), (5, 00022), (5, 00023), (5, 00024), (5, 00041);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (6, 00025), (6, 00026), (6, 00027), (6, 00028), (6, 00029), (6, 00030), (6, 00031);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (7, 00025), (7, 00026), (7, 00032), (7, 00002), (7, 00011), (7, 00033), (7, 00034), (7, 00035), (7, 00036), (7, 00037);
INSERT INTO enthaeltMZ(IDMahlzeiten, IDZutaten) VALUES (8, 00038), (8, 00006), (8, 00035), (8, 00019), (8, 00032);


INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '5.50', '3.50', '4.50', 1);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '4.50', '2.60', '3.60', 2);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '8.50', '6.00', '7.00', 3);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '6.50', '4.20', '5.20', 4);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '8.50', '6.00', '7.00', 5);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '5.50', '3.50', '4.50', 6);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '4.50', '2.50', '3.50', 7);
INSERT INTO Preise(Jahr, Gastpreis, Studentpreis, `MA-Preis`, ID) VALUES ('2019', '5.50', '3.50', '4.50', 8);