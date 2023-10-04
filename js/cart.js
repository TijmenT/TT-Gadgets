
function AddToCart(productID) {
    $.ajax({
        url: 'controllers/cart_controller.php',
        type: 'GET',
        data: { type: 'AddToCart', product_ID: productID },
        success: function (result) {
            var popup = document.getElementById("cart-popup");
            popup.textContent = result;
            popup.style.display = "block";
            setTimeout(function () {
                popup.style.display = "none";
            }, 2000);
        }
    });
}

function UpdateCart(productID, newAmount){
    if(newAmount == 0){
        if(confirm("Weet u zeker dat u dit wilt verwijderen uit uw winkelwagen?")){
            $.ajax({
                url: 'controllers/cart_controller.php',
                type: 'GET',
                data: { type: 'UpdateCart', product_ID: productID, newAmount: newAmount},
                success: function (result) {
                    window.location.reload()
                }
            });
        }
    }
    else{
        if(newAmount > 10){
            $.ajax({
                url: 'controllers/cart_controller.php',
                type: 'GET',
                data: { type: 'UpdateCart', product_ID: productID, newAmount: 10},
                success: function (result) {
                    window.location.reload()
                }
            }); 
        }else{
        $.ajax({
            url: 'controllers/cart_controller.php',
            type: 'GET',
            data: { type: 'UpdateCart', product_ID: productID, newAmount: newAmount},
            success: function (result) {
                window.location.reload()
            }
        }); 
    }
    }
    
}

function ApplyCoupon(){
    var coupon = document.getElementsByName("korting")[0].value;
    $.ajax({
        url: 'controllers/cart_controller.php',
        type: 'GET',
        data: { type: 'ApplyCoupon', coupon: coupon},
        success: function (result) {
            if(!isNaN(result)){
                window.location.reload();
                }
            else
            {
                var popup = document.getElementById("cart-popup");
                popup.textContent = " Invalid coupon or expired.";
                popup.style.display = "block";
                setTimeout(function () {
                    popup.style.display = "none";
                }, 2000);
            }
        }
    });
}

function RemoveDiscount(){
    $.ajax({
        url: 'controllers/cart_controller.php',
        type: 'GET',
        data: { type: 'RemoveDiscount'},
        success: function (result) {
            if(result == "removed"){
                window.location.reload();
                }
            else
            {
                var popup = document.getElementById("cart-popup");
                popup.textContent = " Failed to delete discount.";
                popup.style.display = "block";
                setTimeout(function () {
                    popup.style.display = "none";
                }, 2000);
            }
        }
    });
}

function ProcessOrder(){
    console.log(document.getElementById('shippingSelect').value)
    if(document.getElementById('shippingSelect').value == "fast"){
        fastshipping = true;
    }
    else if(document.getElementById('shippingSelect').value == "standaard"){
        fastshipping = false;
    }
    $.ajax({
        url: 'controllers/cart_controller.php',
        type: 'GET',
        data: { type: 'LoggedIn'},
        success: function (result) {
            if(result == "active"){
                location.href = "controllers/order_controller.php?type=Checkout&fastshipping="+fastshipping;
                }
            else
            {
                location.href = "../login.php";

            }
        }
    });
}

