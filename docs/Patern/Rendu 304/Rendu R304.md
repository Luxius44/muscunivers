# Patern de dévelopement :

!! Ce document utilise des diagrames générer avec [MERMAID]([Class diagrams | Mermaid](https://mermaid.js.org/syntax/classDiagram.html)) des captures d'écran seront fournies mais il est recommander d'utiliser un editeur supportant ce format !!

## Singleton :

Pour éviter la duplication d'objets client et se protéger de risque de conflits de session (plusieur objets client présents), nous avons implementé le patern singleton :

En PHP il n'y a pas de structure préconstruite pour faire un singleton donc il faut implémenter un classe singleton qui empéche la dupplication d'instances de la class `ClientEntity`

On peut donc récuperer l'unique instance en faisant : 

```php
$client = ClientEntity::getInstance();
```

```mermaid
classDiagram

Singleton o-- ClientEntity

class Singleton {
    <<interface>>
    -List<Singleton> instances
    +getInstance() Singleton

}

class ClientEntity {
    -constructor() Client
    -Int ID
    +String Email
    +String Nom
    +String Prenom
    +String Birthdate
    +Panier Panier
    +CheckIfInitialized() bool
}
```

## Proxy :

Nous voulons limiter le nombre de requettes effectuées à la base de donnée sans compromettre l'expèrience utilisateur·ice.
Lorsqu'un·e utilisateur·ice regarde des produits dans une catégorie il est inutile de la recharger à chaque visite.
Nous avons donc mis en place le patern Proxy qui nous permet de stocker les produits dans un cache.

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
    +getIterateurNom() Iterateur
    +getIterateurPrix() Iterateur
    +getIterateurQuantite() Iterateur
}


%% Proxy Patern
CategoryProductList ..|> ListeProduit
CategoryProductList *-- ProxyProduit
CachedProductDAO ..|> ProxyProduit
ProductDAO ..|> ProxyProduit
ProductDAO --o CachedProductDAO


%% Modif liée au patern Iterateur
class CategoryProductList {
    +Int categoryID
    -ProxyProduit dao
    -List~Produit~ ListProd
    +listProducts() List~Produit~
    +getIterateurNom() Iterateur
    +getIterateurPrix() Iterateur
    +getIterateurQuantite() Iterateur
}

class ProxyProduit {
    <<interface>>
    +getProductList() List~Produit~
    +getProduct(id) Produit
}


class CachedProductDAO {
    -ProductDAO service 
    -DateTime lastRefresh
    -List~Produit~ CachedProductList
    +getProductList() List~Produit~
    +getProduct(id) Produit
    +RefreshData()
}

class ProductDAO {
    +getProductList() List~Produit~
    +getProduct(id) Produit
}
```

## Iterateur :

Pour permettre aux clients de trier les produits dans l'ordre qu'iel désire nous avons besoin d'un moyen de parcourir la structure de donnée produit.
Nous afaisons appel au patern itérateur.
Créer plusieurs itérateurs pour traverser `CategoryProductList` nous evitera de devoir trier la liste plusieurs fois.

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
