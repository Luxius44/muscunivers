# MariaBD :

### DB principale :

* Nom utilisteur : `Admin`

* Mot de passe : `Biceps`

* Nom de la DB : `MuscuniversStore`

### DB de Production :

* Nom utilisteur : `Admin`

* Mot de passe : `Biceps`

* Nom de la DB : `Production`

## Configuration des tables :

```sql
USE Production;

DROP TABLE IF EXISTS ProduitCommander;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS Produit;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Client;


CREATE TABLE Categorie
(
    CatID   INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CatNom  VARCHAR(32),
    CatDesc TEXT
) AUTO_INCREMENT = 1;

CREATE TABLE Produit
(
    ProdID   VARCHAR(16) NOT NULL PRIMARY KEY,
    ProdNom  VARCHAR(32),
    ProdDesc TEXT,
    Stock    INT,
    Prix     DECIMAL(6, 2),
    ProdCat  INT         NOT NULL,
    FOREIGN KEY fk_categorie_produit (ProdCat) REFERENCES Categorie (CatID)
);


-- Add cell to protect password hash
CREATE TABLE Client
(
    CliID              INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Email              VARCHAR(64) NOT NULL,
    CliNom             VARCHAR(32),
    CliPrenom          VARCHAR(32),
    CliMotDePasse      TINYTEXT,
    CliDateDeNaissance DATE,
    CompteVerifie      BOOLEAN,
    Cookies            TEXT
) AUTO_INCREMENT = 1;

CREATE TABLE Commande
(
    CmdId             INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CliID            INT NOT NULL,
    DateCommande      DATETIME,
    AddresseLivraison VARCHAR(64),
    Statut            SMALLINT,
    FOREIGN KEY fk_client (CliID) REFERENCES Client (CliID)
) AUTO_INCREMENT = 1;

CREATE TABLE ProduitCommander (
    CmdID INT NOT NULL,
    ProdID VARCHAR(16),
    Quantite INT,
    FOREIGN KEY fk_commande (CmdID) REFERENCES Commande (CmdID),
    FOREIGN KEY fk_produit (ProdID) REFERENCES Produit (ProdID)
);
```
