// ==========================================
// SPORTS STORE - MAIN JAVASCRIPT
// ==========================================

document.addEventListener("DOMContentLoaded", function () {

    // ==========================================
    // PRODUCT SEARCH
    // ==========================================

    const searchInput = document.querySelector(
        'input[name="search"]'
    );

    const categorySelect = document.querySelector(
        'select[name="category"]'
    );

    const productCards = document.querySelectorAll(
        ".product-card"
    );


    // Run catalog JavaScript only if
    // product catalog exists on the page
    if (
        !searchInput ||
        !categorySelect ||
        productCards.length === 0
    ) {
        return;
    }


    // ==========================================
    // SEARCH + CATEGORY FILTER
    // ==========================================

    function filterProducts() {

        const searchText =
            searchInput.value
                .toLowerCase()
                .trim();

        const selectedCategory =
            categorySelect.value
                .toLowerCase()
                .trim();


        let visibleProducts = 0;


        productCards.forEach(function (card) {

            const productName =
                card.querySelector("h3")
                    .textContent
                    .toLowerCase();

            const productCategory =
                card.querySelector("p")
                    .textContent
                    .toLowerCase();


            // Check product name
            const matchesSearch =
                productName.includes(searchText) ||
                productCategory.includes(searchText);


            // Check category
            const matchesCategory =
                selectedCategory === "" ||
                productCategory === selectedCategory;


            // Show product
            if (
                matchesSearch &&
                matchesCategory
            ) {

                card.style.display = "";

                visibleProducts++;

            }

            // Hide product
            else {

                card.style.display = "none";

            }

        });


        showNoProductsMessage(
            visibleProducts
        );
    }


    // ==========================================
    // NO PRODUCTS MESSAGE
    // ==========================================

    function showNoProductsMessage(count) {

        let message =
            document.getElementById(
                "no-products-message"
            );


        if (count === 0) {

            // Create message if it doesn't exist
            if (!message) {

                message =
                    document.createElement("p");

                message.id =
                    "no-products-message";

                message.textContent =
                    "No products found.";

                message.style.textAlign =
                    "center";

                message.style.width =
                    "100%";

                message.style.padding =
                    "20px";

                document
                    .querySelector(".product-grid")
                    .appendChild(message);
            }

        }

        else {

            // Remove message when products exist
            if (message) {

                message.remove();

            }

        }

    }


    // ==========================================
    // SEARCH WHILE TYPING
    // ==========================================

    searchInput.addEventListener(
        "input",
        function () {

            filterProducts();

        }
    );


    // ==========================================
    // CATEGORY FILTER
    // ==========================================

    categorySelect.addEventListener(
        "change",
        function () {

            filterProducts();

        }
    );

});