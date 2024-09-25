# Listes des procédures :

* **CreeCompteClient** : Crée un compte client à partir des infos  envoyées dans l'appel

* **ConnexionClient** : Renvoit des infos client si les identifiants envoyer sont valide

* **ActiveCompteClient** : Met le boolean

```sql
CREATE OR REPLACE PROCEDURE CreeCompteClient(
    pEmail VARCHAR(64),
    pNom VARCHAR(32),
    pPrenom VARCHAR(32),
    pPasswordHash TINYTEXT,
    pBirthdate DATE
)
    MODIFIES SQL DATA
BEGIN
    INSERT INTO Client (Email, CliNom, CliPrenom, CliMotDePasse, CliDateDeNaissance, CompteVerifie)
    VALUES (pEmail, pNom, pPrenom, pPasswordHash, pBirthdate, FALSE);
END;

CREATE OR REPLACE PROCEDURE ConnexionClient(
    IN pEmail VARCHAR(64),
    IN pHash TINYTEXT
)
BEGIN
    SELECT * FROM Client c WHERE c.Email = pEmail AND c.CliMotDePasse = pHash;
end;

CREATE OR REPLACE PROCEDURE ActiveCompteClient(
    IN cID INT
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.CompteVerifie = TRUE WHERE c.CliID = cID;
END;

CREATE OR REPLACE PROCEDURE UpdateInfoClient(
    IN cID INT,
    IN mail VARCHAR(64),
    IN nom VARCHAR(32),
    IN prenom VARCHAR(32),
    IN dateNaissance DATE
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.Email = mail, c.CliNom = nom, c.CliPrenom = prenom, c.CliDateDeNaissance = dateNaissance WHERE c.CliID = cID;
end;

CREATE OR REPLACE PROCEDURE ChangeMotDePasseClient(
    IN cID INT,
    IN cPass TINYTEXT
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.CliMotDePasse = cPass WHERE c.CliID = cID;
end;

CREATE OR REPLACE PROCEDURE listeProduitCategorie(
    IN catID INT
)
BEGIN
    SELECT * FROM Produit p WHERE p.ProdCat = catID;
end;

CREATE OR REPLACE PROCEDURE CreeCommande(
    IdClient INT,
    Date DATETIME,
    Adresse VARCHAR(64)
)
    MODIFIES SQL DATA
BEGIN
    INSERT INTO Commande (CliID, DateCommande, AddresseLivraison, Statut)
        VALUE (IdClient, Date, Adresse, 0);
END;

CREATE OR REPLACE PROCEDURE CheckoutProduct(
    IdCommande INT,
    IdProduit VARCHAR(16),
    Quantite INT
)
    MODIFIES SQL DATA
BEGIN

    IF (SELECT Stock FROM Produit p WHERE p.ProdID = IdProduit) < Quantite THEN
        DELETE FROM ProduitCommander WHERE ProduitCommander.CmdID = IdCommande;
        DELETE FROM Commande WHERE Commande.CmdId = IdCommande;
        SIGNAL SQLSTATE '45002'
            SET MESSAGE_TEXT = 'Le stock est insufissant pour commander';
    ELSE
        INSERT INTO ProduitCommander (CmdID, ProdID, Quantite) VALUES (IdCommande, IdProduit, Quantite);
        UPDATE Produit p SET p.Stock = p.Stock - Quantite WHERE p.ProdID = IdProduit;
    END IF;
END;
```
