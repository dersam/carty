jQuery(document).ready(function(){
    Carty.init();
});

var Carty = {
    init: function(){
        var context = Carty.getPageContext();
        if(context=='cart')
            Carty.Cart.reload();
        else if(context=='shop'){
            Carty.Shop.init();
        }
    },
    getPageContext: function(){
        return jQuery('#page-context').val();
    },
    getCart: function(){
        return jQuery.ajax({
            url: '/carty/cart/contents',
            method: 'get'
        });
    },
    getTemplate: function(template){
        return jQuery.ajax({
            url: '/packages/Dersam/Carty/templates/'+template+'.handlebars'
        });
    },
    Events: {},
    Cart: {},
    Shop: {}
};

Carty.Shop.init = function(){
    console.log('booting shop');
};

Carty.Events.registerEvents = function(){
    jQuery('[data-role="quantity"]').on('change',
        function(event){Carty.Events.OnQuantityChange(event)});
};

Carty.Events.OnQuantityChange = function(event){
    var product_id = event.target.dataset.product;
    var quantity = event.target.value;
    jQuery('#shopping-cart').hide();

    quantity = quantity == '' ? 0 : quantity;
    jQuery('#loader-image').slideDown();
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
            jQuery('#shopping-cart').empty();
            jQuery('#shopping-cart').show();
            Carty.Cart.reload();
        })
        .fail(function(response){
            jQuery('#loader-image').slideUp();
            jQuery('#shopping-cart').show();
        });
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