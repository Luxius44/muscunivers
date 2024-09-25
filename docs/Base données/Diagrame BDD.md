# Diagrame BDD :

```mermaid
erDiagram

Categorie ||--o{ Produit : "appartient"
Client ||--o{ Commande : "effectue"
Produit ||--o{ ProduitCommander : "fait partie"
ProduitCommander }|--|| Commande : "Contient"

Categorie {
    INT CatID PK "ID de la catégorie"
    VARCHAR32 CatNom "Nom de la catégorie"
    TEXT CatDesc "Description de la catégorie"
}

Produit {
    VARCHAR16 ProdId PK "ID du produit"
    VARCHAR32 ProdNom "Nom du produit"
    TEXT ProdDesc "Description du produit"
    INT Stock "Quantité du produit en inventaire"
    DECIMAL Prix "Prix du produit entre 0 et 9999.99"
    INT ProdCat FK "ID de la catégorie du produit"
}

Client {
    INT CliID PK "ID du client"
    VARCHAR64 Email "Email du client"
    VARCHAR32 CliNom "Nom du client"
    VARCHAR32 CliPrenom "Prenom du client"
    TINYTEXT CliMotDePasse "Mot de passe du client"
    DATE CliDateNaissance "Date de naissance du client"
    BOOLEAN CompteVerifie "Le compte a confirmé son adresse Email"
    TEXT Cookie "Cookie du client sous forme de texte"
}

Commande {
    INT CmdID PK "ID de la commande"  
    INT CliID FK "ID du client qui commande"  
    DATETIME DateCommande "Jour ou la commande a été réalisée par le client"
    VARCHAR64 AddresseLivraison "Addresse de la livraison"
    VARCHAR16 Statut "Statut de la commande (En préparation, Expédiée, Livrée, Annulée, Retour en cours)"
}

ProduitCommander {
    INT CmdID FK "ID de la commande"
    VARCHAR16 ProdID FK "ID du produit commandé"
    INT Quantite "Quantité du produit commandé"
}
```

### Lecture Diagrame BDD :

| Symbole Gauche | Symbole Droit | Sens                |
| -------------- | ------------- | ------------------- |
| \|o            | o\|           | Zéro ou 1           |
| \|\|           | \|\|          | Uniquement 1        |
| \}o            | o\{           | Zéro ou plus (0..*) |
| \}\|           | \|\{          | Un ou plus (1..*)   |

Source : https://mermaid-js.github.io/mermaid/#/entityRelationshipDiagram
