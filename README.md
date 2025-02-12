# Cook-it-up

## Description du projet :

Génèrer des recettes grâce à l'IA à partir d'une liste d'ingrédients.

## Mise en place du projet : 
```bash
composer install && npm install && npm run build
```
```bash
symfony serve
```

## Communication avec l'API :

Notre projet utilise une API qui permet de générer une recette à partir d'une liste d'ingrédient.
L'API utilise Gemini pour la génération de recette, les recettes générés sont ensuite stocker dans une base de données.

L'API est hébergé sur always.data, il est possible d'y effectuer des requêtes avec cette commande curl : 

```bash
curl -X POST "https://cookitupapi.alwaysdata.net/gemini/generate" -H "Content-Type: application/json" -d '{"ingredients": ["chevre", "fromage", "riz"]}'
```
Pour chaque recette l'api renvoie : 
- le nom de la recette ```("title")```
- sa description ```("description")```
- les étapes de la recette ```("steps")```
- la liste des ingrédients ```("ingredients")```

## Membres du groupe :
- [Alexandre POSSENTI](https://github.com/Alex28345/)
- [Mathieu LEROUX](https://github.com/Badlix)
- [Tom EVEN](https://github.com/GeniusTom-Dev)

