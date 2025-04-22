document.addEventListener("DOMContentLoaded", function () {
    let allPizzas = {};
    const menuContainer = document.getElementById("menu-container");
    const categoryFilter = document.getElementById("categoryFilter");

    fetch("php/get_pizzas.php")
        .then(response => response.json())
        .then(data => {
            allPizzas = data;
            displayPizzas("all");
        });

    categoryFilter.addEventListener("change", function () {
        displayPizzas(this.value);
    });

    function displayPizzas(category) {
        let menuHTML = "";
        for (let cat in allPizzas) {
            if (category === "all" || cat === category) {
                menuHTML += `<h3 class="mt-4">${cat} Pizzas</h3><div class="row">`;
                allPizzas[cat].forEach(pizza => {
                    console.log("Loading image:", pizza.image); // Debugging
                    menuHTML += `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="${pizza.image}" class="card-img-top" alt="${pizza.name}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">${pizza.name}</h5>
                                    <p class="card-text">$${pizza.price}</p>
                                    <button class="btn btn-danger">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                menuHTML += `</div>`;
            }
        }
        menuContainer.innerHTML = menuHTML;
    }
});
