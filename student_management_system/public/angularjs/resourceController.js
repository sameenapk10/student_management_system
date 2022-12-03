// How to use
// app.controller('myCtrl', function ($scope, $controller, api, utils) {
//     angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
//     $scope.fetchInitData();
//     $scope.updateTable();
// });

app.controller('resourceController', function ($scope, utils, api) {
    $scope.defaults = [];
    // $scope.defaults.webPathName
    // $scope.defaults.pathName = '/my_users';
    // $scope.defaults.objectName = 'user';
    // $scope.defaults.collectionName = 'users';
    // $scope.defaults.updateTableOnSave = false;
    // $scope.defaultObject = {}
    $scope.getCollectionName = function(){
        if ($scope.defaults.collectionName) return $scope.defaults.collectionName;
        if ($scope.defaults.pathName) return $scope.defaults.pathName.substr(1);
        return location.pathname.substr(1);
    }
    $scope.getObjectName = function(){
        return $scope.defaults.objectName ?? $scope.getCollectionName().substr(0,$scope.getCollectionName().length-1);
    }
    $scope.getObject = function (){
        return $scope[$scope.getObjectName()];
    }
    $scope.getCollection = function(){
        return $scope[$scope.getCollectionName()];
    }

    $scope.getPath = function (){
        return $scope.defaults.pathName ?
            location.origin+"/api"+$scope.defaults.pathName :
            location.origin+"/api"+location.pathname;
    }
    $scope.getWebPath = function () {
        return $scope.defaults.webPathName ?
            location.origin+'/'+$scope.defaults.webPathName :
            location.origin+'/'+location.pathname;
    }
    $scope.fetchInitData = async function (){
        $scope.data = await api.get($scope.getPath()+'/get_init_data'+$scope.getParams(),{config:$scope.config})
        $scope.$apply();
    }
    $scope.getParams = function (){
        let params = window.location.search ? window.location.search : '?';
        if ($scope.page) params += '&page=' + $scope.page ?? 1;
        if ($scope.searchParams) params += '&' + $scope.searchParams;
        if ($scope.defaults.updateTableParams) params += '&' + $scope.defaults.updateTableParams;
        return cleanUrl(params);
    }
    $scope.onTableUpdated = function (data) { }
    $scope.updateTable = async function (params){
        $('#table-loader').show();
        if (params) $scope.searchParams = params;
        let response = await api.get($scope.getPath()+$scope.getParams(),{config:$scope.config});
        if (response.current_page) {
            $scope[$scope.getCollectionName()] = response.data;
            $scope.pager = utils.getPager(response.total, response.current_page,response.per_page);
        } else $scope[$scope.getCollectionName()] = response;
        $('#table-loader').hide();
        $scope.onTableUpdated(response);
        $scope.$apply();
    }
    function debounce(func, timeout = 1000){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }
    $scope.debounceSearch = debounce(()=> $scope.updateTable());
    $scope.filterSearch = function (params, params2 = ''){
        $scope.page = 1;
        $scope.searchParams = params + params2;
        if ($scope.pager) $scope.debounceSearch();
    }
    $scope.search = function (params, params2 = ''){
        $scope.page = 1;
        $scope.searchParams = params +'&'+ params2;
        $scope.updateTable();
    }
    $scope.setPage = async function (page) {
        $scope.page = page;
        await $scope.updateTable();
        scrollBodyToTop('.table-responsive');
    }
    $scope.export = function (params, params2 = ''){
        $scope.searchParams = params + params2;
        let url = $scope.getWebPath()+'/export'+$scope.getParams()+'&type=xlsx';
        window.open(cleanUrl(url));
    }
    $scope.add = async function (event, object=null) {
        let addObjectName = 'add'+$scope.getObjectName().charAt(0).toUpperCase() + $scope.getObjectName().slice(1);
        let data = object ?? $scope[addObjectName];
        console.log('add->data', data);
        let response = await api.post($scope.getPath(), data, {event:event})
        if (response.success){
            // TODO: Handle object and array
            console.log('addObjectName', addObjectName);
            $scope[addObjectName] = $scope.defaultObject ?? null;
            $scope.error_messages = null;
            $scope.onAdded(response.data);
            await $scope.updateTable();
        } else {
            $scope.error_messages = response.data;
            $scope.$apply();
        }
    }
    $scope.onAdded = function (data) {}

    $scope.edit = async function(object){
        $scope.id = object.id;
        $scope.showForm = true;
        $scope[$scope.getObjectName()] = $scope.defaults.fetchOnEdit ?
            await api.get($scope.getPath()+'/'+ $scope.id) :
            angular.copy(object);
        $('.ps-container').animate({ scrollTop: 0 }, 500);
        if(!$scope.$$phase) $scope.$apply();
    }
    $scope.onSaving = function (object){}
    $scope.onSaved = function (response){}
    $scope.save = async function (event, object = null, params) {
        object = object ?? $scope.getObject();
        $scope.onSaving(object);
        let response = await api.post($scope.getPath(), object, {event:event, config: $scope.config})
        if (response.success){
            $scope[$scope.getObjectName()] = response.data;
            if ($scope.defaults.updateTableOnSave)
                await $scope.updateTable();
            if (params?.errors) $scope[params?.errors] = null;
            else $scope.error_messages = null;
        } else {
            if (params?.errors) $scope[params?.errors] = response.data;
            else $scope.error_messages = response.data;
        }
        $scope.onSaved(response)
        if(!$scope.$$phase) $scope.$apply();
    }
    $scope.delete = async function (id) {
        if (!await api.confirm()) return ;
        let response = await api.delete($scope.getPath()+'/'+id, {config: $scope.config});
        if (response.success)
            $scope[$scope.getCollectionName()] = utils.pop(id, $scope.getCollection());
        $scope.$apply();
    }

    $scope.show = async function (id) {
        if (id) {
            $scope.id = id;
            await $scope.refreshCardData();
        } else $scope[$scope.getObjectName()] = null;
        $('.nav-item.details>.nav-link').click();
        let card = $('#card');
        if (card.length){
            card.fadeIn();
            scrollBodyToTop();
        }
    }
    $scope.refreshCardData = async function (id = null) {
        let objectId = id ?? $scope.id;
        let data = await api.get($scope.getPath()+'/'+ objectId, {config:$scope.config});
        if (data == null) return;
        $scope[$scope.getObjectName()] = data;
        $scope.$apply();
    }
    $scope.copy = function (destination, data) {
        console.log("resourceController.copy -> data", data)
        $scope[destination] = angular.copy(data);
    }
    $scope.find = function (id, array) {
        return utils.find(id, array);
    }
    $scope.getRootScope = function (){
        let $body = angular.element(document.body);
        return $body.injector().get('$rootScope');
    }
    $scope.showFilesModal = function (model, id) {
        $scope.getRootScope().$broadcast('initFiles', {model: model,id: id,modal:true});
    }
    $scope.range = function(min,max,step = 1) {
        return  _.range(min, max + 1, step);
    };
    $scope.duration = function (start_date, end_date, unit = null) {
        if (!start_date) return;
        start_date = (start_date.length === 27) ? moment(start_date) : moment.utc(start_date, start_date.match(' ') ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD');
        end_date = end_date ? (end_date.length === 27) ? moment(end_date) : moment.utc(end_date, end_date.match(' ') ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD') : moment.utc();
        return unit ? end_date.diff(start_date, unit) : moment.duration(end_date.diff(start_date)).humanize();
    }
    $scope.ageInDays = function (date) { return ageInDays(date); }
    $scope.ageInHours = function (date) { return ageInHours(date); }
    $scope.ageInMinutes = function (date) { return ageInMinutes(date); }

    $scope.storageUrl = function (path) {
        return storageBaseUrl + path;
    }
});
function cleanUrl(url) {
    url.replace('?&', '?');
    while(url.includes('//')) url = url.replaceAll('//', '/')
    while(url.includes('&&')) url = url.replaceAll('&&', '&')
    return url.replace(':/', '://');
}
