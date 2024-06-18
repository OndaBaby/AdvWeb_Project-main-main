$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/shop",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data.products, function (key, value) {
                var products = `
                    <div class='item'>
                        <div class='itemDetails'>
                            <div class='itemImage'>
                                <img src="${value.img_path}" width='200px' height='200px'/>
                            </div>
                            <div class='itemText'>
                                <p class='price-container'>Price: Php <span class='price'>${value.cost}</span></p>
                                <p>${value.description}</p>
                            </div>
                            <input type='number' class='qty' name='quantity' min='1' max='${value.stocks.quantity}'/>
                            <p class='itemId'>${value.id}</p>
                        </div>
                        <button type='button' class='btn btn-primary add'>Add to cart</button>
                    </div>`;
                $("#products").append(products);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });
});
