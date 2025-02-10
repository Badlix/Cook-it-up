import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "ingredientsInput",
        "recipeMain",
        "recipeLoader",
        "recipeTitle",
        "recipeDesc",
        "recipeIngredients",
        "recipeSteps",
        "searchButton"
    ];

    connect() {
        this.initTomSelect();
    }

    initTomSelect() {
        const options = this.getIngredientsList()
            .then((ingredients) => {
                new TomSelect(this.ingredientsInputTarget, {
                    options: ingredients,
                    plugins: {
                        remove_button: {
                            title: "Supprimer l'ingrédient",
                        },
                    },
                    persist: false,
                    create: true,
                });
            })
            .catch((error) => console.error("Erreur lors du chargement des ingrédients:", error));
    }

    async getIngredientsList() {
        try {
            const response = await fetch("/ingredients", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            });
            const ingredients = await response.json();
            return ingredients.map((ingredient) => ({
                value: ingredient,
                text: ingredient,
            }));
        } catch (error) {
            console.error("Error:", error);
            return [];
        }
    }

    formatIngredients(ingredients) {
        const ul = document.createElement("ul");
        ingredients.forEach((i) => {
            const li = document.createElement("li");
            li.textContent =
                i.name === "Sel" || i.name === "Poivre"
                    ? `${i.name}`
                    : `${i.quantity} ${i.unit} ${i.name}`;
            ul.appendChild(li);
        });
        return ul;
    }

    formatSteps(steps) {
        const ul = document.createElement("ul");
        steps.forEach((step) => {
            const li = document.createElement("li");
            li.textContent = step;
            ul.appendChild(li);
        });
        return ul;
    }

    saveRecipe(data) {
        const dataToSend = {
            title: data.title,
            ingredients: data.ingredients,
            duration: Math.random() * 100,
        };

        fetch("/createRecipe", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(dataToSend),
        }).catch((error) => {
            console.error("Erreur lors de l'enregistrement de la recette:", error);
        });
    }

    async search() {
        const ingredientsInputValue = this.ingredientsInputTarget.value;
        const data = { ingredients: ingredientsInputValue.split(",") };

        this.recipeLoaderTarget.classList.remove("hidden");
        this.recipeLoaderTarget.classList.add("flex");

        try {
            const response = await fetch(
                "https://cookitupapi.alwaysdata.net/gemini/generate",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                }
            );

            const recipeData = await response.json();

            this.recipeTitleTarget.innerHTML = recipeData.title;
            this.recipeDescTarget.innerHTML = recipeData.description;
            this.recipeIngredientsTarget.innerHTML =
                this.formatIngredients(recipeData.ingredients).innerHTML;
            this.recipeStepsTarget.innerHTML =
                this.formatSteps(recipeData.steps).innerHTML;

            this.recipeLoaderTarget.classList.add("hidden");
            this.recipeLoaderTarget.classList.remove("flex");
            this.recipeMainTarget.classList.remove("hidden");

            this.saveRecipe(recipeData);
        } catch (error) {
            console.error("Erreur lors de la génération de la recette:", error);
            this.recipeLoaderTarget.classList.add("hidden");
            this.recipeLoaderTarget.classList.remove("flex");
        }
    }
}