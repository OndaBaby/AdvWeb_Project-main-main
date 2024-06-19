$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/shop",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
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
                console.log(products);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });

    $("#products").on('click', '.add', function () {
		itemCount++;
		$('#itemCount').text(itemCount).css('display', 'block');
		clone = $(this).siblings().clone().appendTo('#cartItems')
			.append('<button class="removeItem">Remove Item</button>');
		// Calculate Total Price
		var price = parseInt($(this).siblings().find('.price').text());
		priceTotal += price;
		$('#cartTotal').text("Total: php" + priceTotal);
	});

    $('.openCloseCart').click(function () {
		$('#shoppingCart').show();
	});
    $('#close').click(function () {
		$('#shoppingCart').hide();
	});

    $('#shoppingCart').on('click', '.removeItem', function () {
		$(this).parent().remove();
		itemCount--;
		$('#itemCount').text(itemCount);

		// Remove Cost of Deleted Item from Total Price
		var price = parseInt($(this).siblings().find('.price').text());
		priceTotal -= price;
		$('#cartTotal').text("Total: php" + priceTotal);

		if (itemCount === 0) {
			$('#itemCount').css('display', 'none');
            $('#shoppingCart').hide();
		}
	});
});
