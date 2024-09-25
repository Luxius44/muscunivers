# Patern de développement : **Iterateur**

L'iterateur a pour but d'aider a naviguer de divers façons dans des donées complexes.

###### Application dans notre site :

On veut pouvoir trier facilement les produits dans les catégories pour cela on va crée des itérateurs qui vont permettre de naviguer facilement a travers les donées. 
On ne permet le trie uniquement dans les catégories car il n'a pas grande pertinence a trier le panier / la commande. 

```mermaid
classDiagram

%% Base classes 
Produit --o ListeProduit

class Produit {
    +String ID
    +String Nom
    +String Description
    +Int Quantite
    +Float Prix
}

class ListeProduit {
    <<interface>>
    -List~Produit~ ListProd
    +listProducts() List~Produit~
}

ListeProduitIterable ..|> ListeProduit
CategoryProductList ..|> ListeProduitIterable

class CategoryProductList {
    +Int categoryID
    -ProxyProduit dao
    -List~Produit~ ListProd
    +listProducts() List~Produit~
    +getIterateurNom() Iterateur
    +getIterateurPrix() Iterateur
    +getIterateurQuantite() Iterateur
}

%% Iterator patern

IterateurPrix --|> Iterateur
IterateurNom --|> Iterateur
IterateurQuantite --|> Iterateur

CategoryProductList <--> IterateurNom
CategoryProductList <--> IterateurPrix
CategoryProductList <--> IterateurQuantite
ListeProduitIterable ..> Iterateur

class ListeProduitIterable {
    <<interface>>
    -List~Produit~ ListProd
    +listProducts() List~Produit~
    +getIterateurNom() Iterateur
    +getIterateurPrix() Iterateur
    +getIterateurQuantite() Iterateur
}

class Iterateur {
    <<interface>>
+getNext() Produit
    +hasMore() bool
}

class IterateurPrix {
    -List~Produit~ ListProd
    -Produit current
    +getNext() Produit
    +hasMore() bool
    +listCroissant()
    +listDecroissant()
}

class IterateurNom {
    -List~Produit~ ListProd
    -Produit current
    +getNext() Produit
    +hasMore() bool
    +listCroissant()
    +listDecroissant()

}


class IterateurQuantite {
    -List~Produit~ ListProd
    -Produit current
    +getNext() Produit
    +hasMore() bool
    +listCroissant()
    +listDecroissant()
}
```
