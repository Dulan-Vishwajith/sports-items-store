// ==========================================
// SPORTS STORE - MAIN JAVASCRIPT
// ==========================================

// ==========================================
// MOCK PAYMENT CARD VALIDATION
// ==========================================

const paymentForm = document.getElementById(
    "payment-form"
);


if (paymentForm) {

    const cardNumber = document.getElementById(
        "card-number"
    );

    const expiryDate = document.getElementById(
        "expiry-date"
    );

    const cvv = document.getElementById(
        "cvv"
    );


    // ==========================================
    // CARD NUMBER
    // ==========================================

    if (cardNumber) {

        cardNumber.addEventListener(
            "input",
            function () {

                // Remove non-numbers
                let value =
                    cardNumber.value.replace(
                        /\D/g,
                        ""
                    );


                // Add space after every 4 digits
                value =
                    value
                        .match(/.{1,4}/g)
                        ?.join(" ") || "";


                cardNumber.value = value;

            }
        );

    }


    // ==========================================
    // EXPIRY DATE
    // ==========================================

    if (expiryDate) {

        expiryDate.addEventListener(
            "input",
            function () {

                let value =
                    expiryDate.value.replace(
                        /\D/g,
                        ""
                    );


                if (value.length >= 3) {

                    value =
                        value.substring(0, 2)
                        + "/"
                        + value.substring(2, 4);

                }


                expiryDate.value = value;

            }
        );

    }


    // ==========================================
    // CVV
    // ==========================================

    if (cvv) {

        cvv.addEventListener(
            "input",
            function () {

                cvv.value =
                    cvv.value.replace(
                        /\D/g,
                        ""
                    );

            }
        );

    }


    // ==========================================
    // FORM VALIDATION
    // ==========================================

    paymentForm.addEventListener(
        "submit",
        function (event) {

            let valid = true;


            // Clear previous errors
            document.getElementById(
                "card-error"
            ).textContent = "";

            document.getElementById(
                "expiry-error"
            ).textContent = "";

            document.getElementById(
                "cvv-error"
            ).textContent = "";


            // ==================================
            // CARD NUMBER VALIDATION
            // ==================================

            const cardValue =
                cardNumber.value.replace(
                    /\s/g,
                    ""
                );


            if (!/^\d{16}$/.test(cardValue)) {

                document.getElementById(
                    "card-error"
                ).textContent =
                    "Card number must contain 16 digits.";

                valid = false;

            }


            // ==================================
            // EXPIRY DATE VALIDATION
            // ==================================

            const expiryValue =
                expiryDate.value;


            if (!/^\d{2}\/\d{2}$/.test(expiryValue)) {

                document.getElementById(
                    "expiry-error"
                ).textContent =
                    "Enter expiry date as MM/YY.";

                valid = false;

            }


            // ==================================
            // CHECK EXPIRY MONTH
            // ==================================

            else {

                const parts =
                    expiryValue.split("/");

                const month =
                    parseInt(parts[0]);


                if (
                    month < 1 ||
                    month > 12
                ) {

                    document.getElementById(
                        "expiry-error"
                    ).textContent =
                        "Enter a valid month.";

                    valid = false;

                }

            }


            // ==================================
            // CVV VALIDATION
            // ==================================

            const cvvValue =
                cvv.value;


            if (!/^\d{3}$/.test(cvvValue)) {

                document.getElementById(
                    "cvv-error"
                ).textContent =
                    "CVV must contain 3 digits.";

                valid = false;

            }


            // ==================================
            // STOP FORM IF INVALID
            // ==================================

            if (!valid) {

                event.preventDefault();

            }

        }
    );

}

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