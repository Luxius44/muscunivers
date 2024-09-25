USE MuscuniversStore;

DROP TABLE IF EXISTS ProduitCommander;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS Produit;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Client;

CREATE TABLE Categorie
(
    CatID   INT NOT NULL PRIMARY KEY,
    CatNom  VARCHAR(32),
    CatDesc TEXT
);

CREATE TABLE Produit
(
    ProdID   INT NOT NULL PRIMARY KEY,
    ProdNom  VARCHAR(32),
    ProdDesc TEXT,
    Stock    INT,
    Prix     DECIMAL(6, 2),
    ProdCat  INT NOT NULL,
    FOREIGN KEY fk_categorie_produit (ProdCat) REFERENCES Categorie (CatID)
);

CREATE TABLE Client
(
    CliId              INT NOT NULL PRIMARY KEY,
    Email              VARCHAR(64),
    CliNom             VARCHAR(32),
    CliPrenom          VARCHAR(32),
    CliMotDePasse      TINYTEXT,
    CliDateDeNaissance DATE,
    CompteVerifie      BOOLEAN,
    Panier             VARCHAR(256),
    Statut             VARCHAR(32)
);

CREATE TABLE Commande
(
    CmdId            INT NOT NULL PRIMARY KEY,
    CliId             INT NOT NULL,
    DateCommande      DATETIME,
    AddresseLivraison VARCHAR(64),
    Statut            VARCHAR(16),
    FOREIGN KEY fk_commande_client (CliId) REFERENCES Client (CliId)
);

CREATE TABLE ProduitCommander
(
    CmdId              INT NOT NULL,
    ProdID            INT NOT NULL,
    Quantite           INT NOT NULL,
    FOREIGN KEY fk_produitcommander_produit (ProdId) REFERENCES Produit (ProdId),
    FOREIGN KEY fk_produitcommander_commande (CmdId) REFERENCES Commande (CmdId)
);



