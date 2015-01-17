jQuery(document).ready(function(){
    Carty.init();
});

var Carty = {
    init: function(){
        Carty.Cart.reload();
    },
    getCart: function(){
        return jQuery.ajax({
            url: 'cart/contents',
            method: 'get'
        });
    },
    getTemplate: function(template){
        return jQuery.ajax({
            url: '/packages/Dersam/Carty/templates/'+template+'.handlebars'
        });
    },
    Events: {},
    Cart: {}
};

Carty.Events.registerEvents = function(){
    jQuery('[data-role="quantity"]').on('change',
        function(event){Carty.Events.OnQuantityChange(event)});
};

Carty.Events.OnQuantityChange = function(event){
    console.log(event);
    var product_id = event.target.dataset.product;
    var quantity = event.target.value;

    quantity = quantity == '' ? 0 : quantity;

    jQuery.ajax({
        url:'cart/contents',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            product_id: product_id,
            quantity: quantity
        })
    })
        .done(function(response){

            jQuery('#loader-image').slideDown();
            jQuery('#shopping-cart').empty();
            Carty.Cart.reload();
        })
        .fail(function(response){
            if(response.code == 400)
                Alert.error("Invalid quantity ("+quantity+") requested.");
        });
};

Carty.Cart.add = function(){

};

Carty.Cart.update = function(){

};

Carty.Cart.remove = function(){

};

Carty.Cart.reload = function(){
    Carty.getTemplate('cart').done(function(source){
        var template = Handlebars.compile(source);
        Carty.getCart()
            .done(function(response){
                var html = template(response);
                jQuery('#shopping-cart').empty();
                jQuery('#shopping-cart').html(html);
                jQuery('#loader-image').slideUp();
                Carty.Events.registerEvents();
            });
    });
};

var Alert = {
    info: function(message){
        noty({
            text: message,
            type: 'information',
            animation: {
                open: 'animated bounceInUp', // Animate.css class names
                close: 'animated bounceOutDown' // Animate.css class names
            },
            layout: 'bottom',
            timeout: 5000
        });
    },

    error: function(message){
        noty({
            text: message,
            type: 'error',
            animation: {
                open: 'animated bounceInUp', // Animate.css class names
                close: 'animated bounceOutDown' // Animate.css class names
            },
            layout: 'bottom',
            timeout: 5000
        });
    }
};