(function(){
    var app = angular.module('musicStore', ['ch.filters']);

    app.controller('StoreController', ['$http', function($http) {
        var store = this;
        store.products = [];
        
        $http.get('products.php').success(function(data) {
            store.products = data;
        });
        $http.get('products.php').error(function() {
            store.products = music;
        });
    }]);

    app.directive("cartContent", function() {
        return {
            restrict: 'E',
            templateUrl: 'cart-content.html'
        };
    });
    
    app.controller('CartController', function() {
        this.cart = {};
        this.cart.products = [];
        this.cart.totalPrice = 0;
        
        this.showCart = function(modalID) {
            $('#'+ modalID).modal('show');
        };
        
        this.hideCart = function(modalID) {
            $('#'+ modalID).modal('hide');
        };
        
        this.addProductToCart = function(product) {
            if ( !this.cartContainsProduct(product) ) {
                this.cart.products.push(product);
                this.cart.totalPrice += parseFloat(product.price);
            }
        };
        
        this.removeProductFormCart = function(product) {
            this.cart.products.pop(product);
            this.cart.totalPrice -= parseFloat(product.price);
            if ( this.cart.products.length == 0 ) {
                this.hideCart("modalCart");
            }
        };
        
        this.cartContainsProduct = function(product) {
            for (var i = 0; i < this.cart.products.length; i++) {
                if (angular.equals(this.cart.products[i], product)) {
                    return true;
                }
            }
            return false;
        };
        
        // check out using PayPal; for details see:
        // http://www.paypal.com/cgi-bin/webscr?cmd=p/pdn/howto_checkout-outside
        this.cartCheckOutPayPal = function () {
            // global data
            var data = {
                cmd: "_cart",
                business: "99EJBB5ZKHMZC", // FOR PRODUCTION
                //business: "mrfender-facilitator@gmail.com", // FOR TESTING
                upload: "1",
                rm: "2",
                charset: "utf-8",
                currency_code: "EUR",
                'notify_url': "http://joyproject-joystore.rhcloud.com/paypal.php",
                'return': "http://joyproject-joystore.rhcloud.com/download.php"
            };

            // item data
            for (var i = 0; i < this.cart.products.length; i++) {
                var item = this.cart.products[i];
                var ctr = i + 1;
                data["item_number_" + ctr] = item.productID;
                data["item_name_" + ctr] = item.artist +"-"+ item.title;
                data["quantity_" + ctr] = 1;
                data["amount_" + ctr] = parseFloat(item.price).toFixed(2);
            }

            // build form
            var form = $('<form></form>');
            //form.attr("action", "https://www.sandbox.paypal.com/cgi-bin/webscr"); // FOR TESTING
            form.attr("action", "https://www.paypal.com/cgi-bin/webscr"); // FOR PRODUCTION
            form.attr("method", "POST");
            form.attr("style", "display:none;");
            this.addFormFields(form, data);
            //this.addFormFields(form, parms.options);
            $("body").append(form);

            // submit form
            //this.clearCart = clearCart == null || clearCart;
            form.submit();
            form.remove();
        };
        
        // utility methods
        this.addFormFields = function (form, data) {
            if (data != null) {
                $.each(data, function (name, value) {
                    if (value != null) {
                        var input = $("<input></input>").attr("type", "hidden").attr("name", name).val(value);
                        form.append(input);
                    }
                });
            }
        }
    });
    
    var music = [
        { 
            artist: 'noArtist', 
            title: 'noTitle', 
            price: 0.00, 
            downloadURL: '', 
            soundcloudURL: 'https://soundcloud.com/joy-project/noTrack' 
        }
    ];
})();