CREATE OR REPLACE TRIGGER InsertClient
    BEFORE INSERT
    ON Client
    FOR EACH ROW
BEGIN
    IF EXISTS(SELECT * FROM Client where Client.Email = NEW.Email) THEN
        SIGNAL SQLSTATE '45001' SET
            MESSAGE_TEXT = 'Email deja enregister';
    end if;
END;

CREATE OR REPLACE TRIGGER UpdateClient
    BEFORE UPDATE
    ON Client
    FOR EACH ROW
BEGIN
    IF EXISTS(SELECT * FROM Client where Client.Email = NEW.Email) THEN
        SIGNAL SQLSTATE '45001' SET
            MESSAGE_TEXT = 'Email déjà enregister';
    ELSEIF OLD.Email != NEW.Email THEN
        UPDATE Client c SET c.CompteVerifie = FALSE WHERE c.Email = OLD.Email;
    end if;
END;


CREATE OR REPLACE TRIGGER InsertProduit
    BEFORE INSERT
    ON Produit
    FOR EACH ROW
BEGIN
    IF NEW.Stock < 0 THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Stock initial inférieur à 0';
    end if;
    IF NEW.Prix < 0 THEN
        SIGNAL SQLSTATE '45003' SET
            MESSAGE_TEXT = 'Prix initial trop faible';
    end if;
END;

CREATE OR REPLACE TRIGGER UpdateProduit
    BEFORE UPDATE
    ON Produit
    FOR EACH ROW
BEGIN
    IF NEW.Stock < 0 THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Nouveau Stock inférieur à 0';
    end if;
    IF NEW.Prix < 0 THEN
        SIGNAL SQLSTATE '45003' SET
            MESSAGE_TEXT = 'Nouveau Prix trop faible';
    end if;
END;


CREATE OR REPLACE TRIGGER DeleteProduit
    BEFORE DELETE
    ON Produit
    FOR EACH ROW
BEGIN
    IF EXISTS(SELECT * FROM ProduitCommander pc where pc.ProdID = OLD.ProdID)
    THEN
        SIGNAL SQLSTATE '45004' SET
            MESSAGE_TEXT = 'Ce produit est dans une commande, il ne peut pas être supprimer';
    end if;
end;

CREATE OR REPLACE TRIGGER CreeCommande
    BEFORE INSERT
    ON Commande
    FOR EACH ROW
BEGIN
    IF (SELECT c.CompteVerifie FROM Client c WHERE NEW.CliID = c.CliID) = FALSE THEN
        SIGNAL SQLSTATE '45005' SET
            MESSAGE_TEXT = 'Impossible de commander avec un compte non vérifié';
     end if;
end;

CREATE OR REPLACE TRIGGER ProduitCommanderInsert
    BEFORE INSERT
    ON ProduitCommander
    FOR EACH ROW
BEGIN
    IF NEW.Quantite < 1 THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Impossible de commander une quantité négative ou nulle';
    ELSEIF (SELECT p.Stock FROM Produit p WHERE  p.ProdID = NEW.ProdID) < NEW.Quantite THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Stock insuffisant';
    ELSE
        UPDATE Produit p SET p.Stock = p.Stock - NEW.Quantite WHERE p.ProdID = NEW.ProdID;
    end if;
end;

CREATE OR REPLACE TRIGGER ProduitCommanderUpdate
    BEFORE UPDATE
    ON ProduitCommander
    FOR EACH ROW
BEGIN
    IF NEW.Quantite < 1 THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Impossible de commander une quantité négative ou nulle';
    ELSEIF NEW.ProdID != OLD.ProdID THEN
        SIGNAL SQLSTATE '45006' SET
            MESSAGE_TEXT = 'Impossible de modifier le produit commander';
    ELSEIF (SELECT p.Stock FROM Produit p WHERE  p.ProdID = NEW.ProdID) < (NEW.Quantite - OLD.Quantite) THEN
        SIGNAL SQLSTATE '45002' SET
            MESSAGE_TEXT = 'Stock insuffisant';
    ELSE
        UPDATE Produit p SET p.Stock = p.Stock + OLD.Quantite - NEW.Quantite WHERE p.ProdID = NEW.ProdID;
    end if;
end;

CREATE OR REPLACE TRIGGER ProduitCommanderDelete
    BEFORE DELETE
    ON ProduitCommander
    FOR EACH ROW
BEGIN
    UPDATE Produit p SET p.Stock = p.Stock + OLD.Quantite WHERE p.ProdID = OLD.ProdID;
end;