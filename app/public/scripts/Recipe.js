$(() => {
    const confirmButton = $('#confirmButton');
    const ingredientSelect = $('#ingredientSelect');
    const ingredientsContainer = $('#ingredientsContainer');
    const nameInput = $('#nameInput');
    const recipeTextInput = $('#recipeTextInput');
    let ingredients;

    ingredientSelect.on('change', (e) => {
        e.preventDefault();
        let selectedIngredient = getIngredientById($(e.target).val());
        if (!selectedIngredient) {
            return;
        }
        addIngredient(selectedIngredient);

        $(`#ingredientSelect option[value="${selectedIngredient.id}"]`).prop("disabled",true);
        $('#ingredientSelect .default').prop("selected",true);
    });

    getIngredients();

    confirmButton.on('click', (e) => {
        if (!nameInput.val() || !recipeTextInput.val() || !ingredientsContainer.children().length) {
            alert('Нужно заполнить название, описание рецепта и ингредиенты');
        }
        let ingredientsRecipe = $.map($('.ingredientId'), (item) => {
            console.log($(item).closest('div').find('.ingredientCount').val())
            return {
                'id' : $(item).val(),
                'count' : $(item).closest('div').find('.ingredientCount').val(),
            };
        });
        let recipe = {
            name: nameInput.val(),
            text: recipeTextInput.val(),
            ingredients: ingredientsRecipe,
        };
        $.ajax({
            type: 'POST',
            url: '/createRecipeConfirm',
            data: {
                recipe,
            }
        }).done((response) => {
            console.log(response);
        }).fail((response) => {
            alert(response.responseText);
        });
    });

    function addIngredient(ingredient) {
        ingredientsContainer.append(`
            <div class="row g-3 ingredient">
                <input type="number" value="${ingredient.id}" class="ingredientId" hidden>
                <div class="col-auto">
                    <input type="text" readonly class="form-control-plaintext" value="${ingredient.name}">
                </div>
                <div class="col-auto">
                    <input type="number" class="form-control ingredientCount" placeholder="Количество">
                </div>
                <div class="col-auto removeIngredient">
                    <button type="submit" class="btn btn-danger mb-3">Удалить</button>
                </div>
            </div>
        `);
    }

    function getIngredients() {
        $.ajax({
            type: 'GET',
            url: '/getIngredients'
        }).done((response) => {
            ingredients = response;
            renderIngredients(response);
        }).fail((response) => {
            alert(response.responseText);
        });
    }

    function renderIngredients(ingredients) {
        ingredients.map((ingredient) => {
            let ingredientParams = ingredient.volume ? (ingredient.volume + ' мл') : ''
                + ingredient.weight ? (ingredient.weight + ' г') : ''
            let displayName = `${ingredient.name}(${ingredientParams})`;
            ingredientSelect.append(`
                <option value="${ingredient.id}">${displayName}</option>
            `);
        })
    }

    function getIngredientById(id) {
        return ingredients.filter(ingredient => ingredient.id == id)[0];
    }

});