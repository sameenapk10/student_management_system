<script>
    @auth
    app.config(function ($httpProvider) {
        $httpProvider.defaults.headers.common.Authorization = "Bearer {{ Auth::user()->api_token }}";
    });
    @endauth

    let baseUrl = '{{ url('') }}';
    function url(path) {
        return baseUrl + '/' + path;
    }

    app.filter('objToRequestParams',function(){
    return function(obj) {
            var res = {};
            (function recurse(obj, current) {
                for(var key in obj) {
                    var value = obj[key];
                    var newKey = (current ? current + "." + key : key);  // joined key with dot
                    if(value && typeof value === "object") {
                        recurse(value, newKey);  // it's a nested object, so do it again
                    } else {
                        res[newKey] = value;  // it's not an object, so set the property
                    }
                }
            })(obj);
            var response = '';
            angular.forEach(res, function (value, key) {
                response += '&'+key+'='+value;
            });
            return response;
        }
    });
</script>
