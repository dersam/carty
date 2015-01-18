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
            url: '/packages/dersam/carty/templates/'+template+'.handlebars'
        });
    },
    Events: {},
    Cart: {
        template: null
    },
    Shop: {
        item_count: 0,
        Events: {}
    }
};

Carty.Shop.init = function(){
    Carty.Shop.item_count = jQuery('#starting-item-count').val();

    jQuery('[data-role="add-product"]').on('click',function(){
        if(jQuery(this).attr('data-incart') == 'yes'){
            return;
        }

        var product_id = jQuery(this).attr('data-product');

        jQuery(this).hide();
        jQuery('[data-role="loader"][data-product="'+product_id+'"]').show();



        Carty.Cart.add(product_id, 1)
            .done(Carty.Shop.Events.AfterProductAdd);
    });
};

Carty.Shop.Events.AfterProductAdd = function(response){
    var product_id = response.product_id;
    Carty.Shop.item_count++;
    jQuery('#item-count').html("("+Carty.Shop.item_count+")");

    var button = jQuery('[data-product="'+product_id+'"][data-role="add-product"]');
    button.attr('data-incart','yes');
    button.removeClass('btn-success');
    button.addClass('btn-default');
    button.html('In Cart');
    jQuery('[data-role="loader"][data-product="'+product_id+'"]').hide();
    button.show();
};

Carty.Events.registerEvents = function(){
    jQuery('[data-role="quantity"]').on('change',
        function(event){Carty.Events.OnQuantityChange(event)});
};

Carty.Events.OnQuantityChange = function(event){
    var loc = jQuery(event.currentTarget);

    var product_id = loc.attr('data-product');
    var quantity = loc.val();
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
        .fail(function(xhr){
            var loc = jQuery('[data-role="quantity"][data-product="'+product_id+'"]');
            loc.val(xhr.responseJSON.previous_quantity);
            jQuery('#loader-image').slideUp();
            jQuery('#shopping-cart').show();
        });
};

Carty.Cart.add = function(product, quantity){
    return jQuery.ajax({
        url:'carty/cart/contents',
        method: 'post',
        data: JSON.stringify({
            product_id: product,
            quantity: quantity
        })
    });
};

Carty.Cart.reload = function(){
    var loadcart = function(){
        Carty.getCart()
            .done(function (response) {
                var html = Carty.Cart.template(response);
                jQuery('#shopping-cart').empty();
                jQuery('#shopping-cart').html(html);
                jQuery('#loader-image').slideUp();
                Carty.Events.registerEvents();
            });
    };

    if(Carty.Cart.template == null) {
        Carty.getTemplate('cart').done(function (source) {
            Carty.Cart.template = Handlebars.compile(source);
            loadcart();
        });
    }
    else{
        loadcart();
    }
};