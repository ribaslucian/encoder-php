/**
 * iniciando aplicacao e informando quais metodos serao utializados
 * 
 * @type @exp;angular@call;module
 */
var app = angular.module('Liv', []);


/**
 * Inserindo o serviço $app em $rootScope.
 */
app.run(function ($rootScope, $encoder) {
    $rootScope.encoder = $encoder;
});

app.service('$utils', function () {
    this.objectIsEmpty = function (obj) {
        for (var i in obj)
            if (obj.hasOwnProperty(i))
                return false;
        return true;
    };
});

app.service('$checkbox', function () {
    this.arrayClean = function (options_array) {
        $.each(options_array, function (index, value) {
            if (!value) {
                delete options_array[index];
            }
        });
    }
    
    this.hasSelection = function (options_array) {
        if (! (options_array instanceof Object)) {
            return false;
        }

        var hasCheck = false;

        $.each(options_array, function (index, value) {
            if (value) {
                return (hasCheck = true);
            }
        });

        return hasCheck;
    }
    
    this.countSelections = function (options_array) {
        if (!(options_array instanceof Object)) {
            return 0;
        }

        var countSelections = 0;

        $.each(options_array, function (index, value) {
            if (value)
                countSelections++
        });

        return countSelections;
    }
    
    this.setAll = function (options_array, selectAll) {
        if (!(options_array instanceof Object)) {
            return 0;
        }
        
        $.each(options_array, function (index, value) {
            options_array[index] = selectAll;
        });
    }
    
    this.allSelected = function (options_array) {
        if (!(options_array instanceof Object)) {
            return false;
        }

        var allSelected = true;

        $.each(options_array, function (index, value) {
            if (!value)
                return (allSelected = false);
        });

        return allSelected;
    }
});

app.service('$encoder', function ($utils, $checkbox) {
    this.utils = $utils;
    this.checkbox = $checkbox;
});