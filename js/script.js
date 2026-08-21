// Product search
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.querySelector(
        'input[name="search"]'
    );

    const productCards = document.querySelectorAll(
        ".product-card"
    );

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener("keyup", function () {

        const searchText =
            searchInput.value.toLowerCase().trim();

        productCards.forEach(function (card) {

            const productName =
                card.querySelector("h3").textContent.toLowerCase();

            const productCategory =
                card.querySelector("p").textContent.toLowerCase();

            if (
                productName.includes(searchText) ||
                productCategory.includes(searchText)
            ) {

                card.style.display = "";

            } else {

                card.style.display = "none";

            }

        });

    });

});