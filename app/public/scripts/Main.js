$(() => {
    const logoutButton = $('#logoutButton');
    const searchInput = $('#searchInput');
    const recipesContainer = $('#recipesContainer');
    let recipes;

    searchInput.prop('disabled', false);
    getRecipes();

    searchInput.on('input', (e) => {
        let target = $(e.target);
        if (target.val().length >= 3) {
            $.ajax({
                type: 'GET',
                url: '/getRecipes',
                data: {
                    searchString: target.val(),
                }
            }).done((response) => {
                renderRecipes(response)
            }).fail((response) => {
                alert(response.responseText);
            });
        }
    });

    function renderRecipes(recipes) {
        recipesContainer.empty();
        recipes.map((item) => {
            let ingredients = [];
            item.ingredients.map((ingredient) => {
                ingredients.push(Object.keys(ingredient)[0]);
            });
            recipesContainer.append(`
                <div class="card m-3" style="width: 18rem;">
                    <img src="../images/bookRecipesIcon.svg" class="card-img-top" alt="Изображение">
                    <div class="card-body">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">${ingredients.join(', ')}</p>
                        <a href="/recipeInfo?id=${item.id}" class="btn btn-primary">Открыть рецепт</a>
                    </div>
                </div>
            `);
        });
    }

    function getRecipes() {
        $.ajax({
            type: 'GET',
            url: '/getRecipes'
        }).done((response) => {
            recipes = response;
            renderRecipes(recipes);
        }).fail((response) => {
            alert(response.responseText);
        });
    }

    logoutButton.on('click', () => {
        document.cookie = "seaOfRecipesToken=removed; expires= Thu, 21 Aug 2014 20:00:00 UTC";
    });

});