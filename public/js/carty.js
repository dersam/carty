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
                jQuery('#shopping-cart').html(html);
                jQuery('#loader-image').slideUp();
            });
    });
};