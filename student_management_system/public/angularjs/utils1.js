app.service('utils', function () {

    utils = this;

    // default options
    utils.options = {
        log: true,
        debug: true,
    };
    utils.test = function(){
        toast.success('Utils Test !!!');
    }

    utils.init = function (scope, options = null) {
        utils.$scope = scope;
        angular.extend(utils.options, options);
        return utils;
    }

    utils.copy = function (destination, data) {
        if (utils.options.log) console.log("utils.copy -> data", data)
        utils.$scope[destination] = angular.copy(data);
    }

    utils.find = function (id, array) {
        var result = null;
        angular.forEach(array, function (value, key) {
            if (id == value.id) result = value;
        });
        return result;
    }


    // used in documents blade
    utils.pop = function (id, array) {
        console.log('utils.pop', array);
        var resultArray = [];
        angular.forEach(array, function (value, key) {
            if (id != value.id) resultArray.push(value);
        });
        return resultArray;
    }

    utils.getPager = function (totalItems, currentPage, pageSize) {
        // default to first page
        currentPage = currentPage || 1;

        // default page size is 10
        pageSize = pageSize || 10;

        // calculate total pages
        let totalPages = Math.ceil(totalItems / pageSize);

        let startPage, endPage;
        if (totalPages <= 10) {
            // less than 10 total pages so show all
            startPage = 1;
            endPage = totalPages;
        } else {
            // more than 10 total pages so calculate start and end pages
            if (currentPage <= 6) {
                startPage = 1;
                endPage = 10;
            } else if (currentPage + 4 >= totalPages) {
                startPage = totalPages - 9;
                endPage = totalPages;
            } else {
                startPage = currentPage - 5;
                endPage = currentPage + 4;
            }
        }

        // calculate start and end item indexes
        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

        // create an array of pages to ng-repeat in the pager control
        let pages = _.range(startPage, endPage + 1);

        // return object with all pager properties required by the view
        return {
            totalItems: totalItems,
            currentPage: currentPage,
            pageSize: pageSize,
            totalPages: totalPages,
            startPage: startPage,
            endPage: endPage,
            startIndex: startIndex,
            endIndex: endIndex,
            pages: pages
        };
    }
});
