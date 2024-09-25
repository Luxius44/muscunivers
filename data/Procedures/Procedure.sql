CREATE OR REPLACE PROCEDURE CreeCompteClient(
    pEmail VARCHAR(64),
    pNom VARCHAR(32),
    pPrenom VARCHAR(32),
    pPasswordHash TINYTEXT,
    pBirthdate DATE,
    pStatut VARCHAR(16)
)
    MODIFIES SQL DATA
BEGIN
    INSERT INTO Client (Email, CliNom, CliPrenom, CliMotDePasse, CliDateDeNaissance, CompteVerifie, Statut,Cookies)
    VALUES (pEmail, pNom, pPrenom, pPasswordHash, pBirthdate, FALSE,pStatut,'');
END;

CREATE OR REPLACE PROCEDURE CheckIfClientExist(
    IN mail VARCHAR(64)
)
    READS SQL DATA
BEGIN
    SELECT ROW_COUNT() FROM Client c WHERE c.Email = mail;
end;

CREATE OR REPLACE PROCEDURE ConnexionClient(
    IN pEmail VARCHAR(64)
)
    READS SQL DATA
BEGIN
    SELECT * FROM Client c WHERE c.Email = pEmail;
end;

CREATE OR REPLACE PROCEDURE ActiveCompteClient(
    IN cID INT
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.CompteVerifie = TRUE WHERE c.CliID = cID;
END;

CREATE OR REPLACE PROCEDURE GetInfoClient(
    IN cID INT
)
    READS SQL DATA
BEGIN
    SELECT c.Email,c.CliDateDeNaissance,c.CliNom,CliPrenom,c.Statut,c.CompteVerifie FROM Client c WHERE c.CliID = cID;
end;

CREATE OR REPLACE PROCEDURE UpdateInfoClient(
    IN cID INT,
    IN mail VARCHAR(64),
    IN nom VARCHAR(32),
    IN prenom VARCHAR(32),
    IN dateNaissance DATE
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c
    SET c.Email              = mail,
        c.CliNom             = nom,
        c.CliPrenom          = prenom,
        c.CliDateDeNaissance = dateNaissance
    WHERE c.CliID = cID;
end;

CREATE OR REPLACE PROCEDURE ChangeMotDePasseClient(
    IN cID INT,
    IN cPass TINYTEXT
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.CliMotDePasse = cPass WHERE c.CliID = cID;
end;

CREATE OR REPLACE PROCEDURE GetCookies(
    mail VARCHAR(64)
)
    READS SQL DATA
BEGIN
    SELECT c.Cookies FROM Client c WHERE c.Email = mail;
    UPDATE Client c SET c.Cookies = '' WHERE c.Email = mail;
end;

CREATE OR REPLACE PROCEDURE UpdateCookies(
    mail VARCHAR(64),
    cookie TEXT
)
    MODIFIES SQL DATA
BEGIN
    UPDATE Client c SET c.Cookies = cookie WHERE c.Email = mail;
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
    INSERT INTO Commande (CliID, DateCommande, AdresseLivraison, Statut)
        VALUE (IdClient, Date, Adresse, 0);
    SELECT c.CmdId
    FROM Commande c
    WHERE c.CliID = IdClient
      AND c.DateCommande = Date
      AND c.AdresseLivraison = Adresse;
END;

CREATE OR REPLACE PROCEDURE CheckoutProduct(
    IdCommande INT,
    IdProduit INT,
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

CREATE OR REPLACE PROCEDURE GetAllCommandeClient(
    IDClient INT
)
BEGIN
    SELECT * FROM Commande c WHERE c.CliID = IDClient ORDER BY c.DateCommande;
END;

CREATE OR REPLACE PROCEDURE GetCommandeClient(
    IDClient INT,
    nombre INT
)
BEGIN
    SELECT * FROM Commande c WHERE c.CliID = IDClient ORDER BY c.DateCommande LIMIT nombre;
END;

CREATE OR REPLACE PROCEDURE GetProductByID(
    ID INT
)
    READS SQL DATA
BEGIN
    SELECT * FROM Produit p WHERE p.ProdID = ID;
end;

CREATE OR REPLACE PROCEDURE GetProductsFromCommande(
    IDCommande INT
)
    READS SQL DATA
BEGIN
    SELECT p.ProdID, p.ProdNom, p.ProdDesc, c.Quantite, p.Prix, p.ProdCat
    FROM Produit p
             LEFT JOIN ProduitCommander c on p.ProdID = C.ProdID
    WHERE c.CmdID = IDCommande;
end;