let app = angular.module('myApp', ['ngCookies', 'ngIntlTelInput']);
app.config(function (ngIntlTelInputProvider) {
    ngIntlTelInputProvider.set({defaultCountry: 'qa'});
});
app.filter('trusted', ['$sce', function ($sce) {
    return function (url) {
        return $sce.trustAsResourceUrl(url);
    };
}]);
app.filter('trustedHtml', ['$sce', function ($sce) {
    return function (text) {
        return $sce.trustAsHtml(text);
    };
}]);
app.filter('safeHtml', ['$sce', function ($sce) {
    return function (text) {
        return $sce.trustAsHtml(text);
    };
}]);
/**
 * Eg: <img ng-src="@{{ 'uploads/'+file.name | storageUrl: 'files/default.jpg' }}" class="img-fluid" />
 */
app.filter('storageUrl', function() {
    return function(path, defaultPath) {
        return storageUrl(path, defaultPath)
    };
});
app.filter('textAudio', ['$sce', function ($sce) {
    return function (text) {
        if (text){
            if (text.endsWith('.wav'))
                text = '<audio controls>'+
                    '<source src="'+storageUrl(text)+'" type="audio/wav">'+
                    'Your browser does not support the audio element.'+
                    '</audio>';
            return $sce.trustAsHtml(text);
        }
    };
}]);
function storageUrl(path, defaultPath) {
    if (path && path.includes('.'))
        return storageBaseUrl + path;
    else return storageBaseUrl + defaultPath;
}
app.filter('reverse', function() {
    return function(items) {
        if (items)
            return items.slice().reverse();
    };
});
app.filter('coma',function(){
    return function(array_values) {
        if (!array_values) return;
        return array_values.toString();
    }
});
app.filter('requestParams',function(){
    return function(object) {
        var response = '';
        angular.forEach(object, function (value, key) {
            response += '&'+key+'='+value;
        });
        return response;
    }
});
app.filter('dmyDate', function() {
    return function(str_date) {
        if (!str_date) return ;
        let date = time = null;
        if (str_date.match(' ')){
            date = str_date.split(' ')[0];
            time = str_date.split(' ')[1];
        } else date = str_date;
        date = date.split('-').reverse().join('-');
        if (time)
            return date+' '+time;
        return date;
    };
});

/**
 * Convert string date to moment object
 * @param {string} date date to be converted
 * @returns {moment|null}
 */
function parseMoment(date) {
    if (!date) return;
    if (date.length === 27) return moment(date);
    return moment.utc(date, date.match(' ') ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD');
}

/**
 * Example use
 * @{{ deadline | formatDate : 'MMM Do, ddd'}}
 */
app.filter('formatDate', function() {
    return function(start_date, outputFormat='DD-MM-YYYY') {
        if (!start_date) return ;
        let inputFormat = start_date.match(' ') ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD';
        let mom = (start_date.length === 27) ? moment(start_date) : moment.utc(start_date, inputFormat);
        return mom.local().format(outputFormat);
    };
});

app.filter('titleCase', function() {
    return function(str) {
        str = str.replaceAll('_', ' ');
        str = str.replaceAll('-', ' ');
        str = str.replaceAll('.', ' ');
        return str.replace(
            /\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    };
});

function ageInDays(date) {
    if (!date) return;
    return moment().diff(parseMoment(date), 'days');
}
app.filter('ageInDays', function() {
    return function(date) {
        return  ageInDays(date);
    };
});

function ageInMinutes(date) {
    if (!date) return ;
    return moment().diff(parseMoment(date), 'minutes');
}
app.filter('ageInMinutes', function() {
    return function(date) {
        return ageInMinutes(date);
    };
});

function ageInHours(date) {
    if (!date) return;
    return moment().diff(parseMoment(date), 'hours');
}
app.filter('ageInHours', function() {
    return function(date) {
        return ageInHours(date);
    };
});

app.filter('dayDiff', function() {
    return function(date) {
        if (!date) return ;
        return  moment(date, "YYYY-MM-DD").diff(moment().format("YYYY-MM-DD"), 'days');
    };
});

app.filter('addMonth', function() {
    return function(date) {
        if (!date) return ;
        return  moment(date, "YYYY-MM-DD").add(1, 'M').format("YYYY-MM-DD");
    };
});

app.filter('add3Month', function() {
    return function(date) {
        if (!date) return ;
        return  moment(date, "YYYY-MM-DD").add(3, 'M').format("YYYY-MM-DD");
    };
});

class ApiResponse {
    constructor(success, data) {
        this.success = success;
        this.data = data;
    }
}

app.service('api', function ($http, $rootScope) {

    function fullUrl(url){
        if (url.startsWith('api')){
            let baseUrl = $rootScope.baseUrl;
            // let baseUrl = apiBaseUrl;
            if (!baseUrl.endsWith('/')) baseUrl += '/';
            url = baseUrl+url;
        }
        return url;
    }
    var api = this;

    this.init = async function (scope) {
        this.$scope = scope;
        return this;
    }

    this.error = function (response) {
        if (response.config && response.config.method)
            console.error('ERROR '+response.config.method+' '+response.config.url, response);
        else console.error('ERROR ', response);

        var error_messages = [];
        if (response.status == -1) {
            toast.error('No internet connection');
        } else if (response.status == 422) {
            angular.forEach(response.data.errors, function (value, key) {
                error_messages.push(value[0]);
            });
            toast.error(response.data.message);
            return error_messages;
        } else if (response.status == 403) {
            if (response.data.message)
                toast.error(response.data.message);
            else
                toast.error('This action is unauthorized');
        } else toast.error(response.statusText);
    }
    this.success = function (response) {
        console.log('SUCCESS '+response.config.method+' '+response.config.url, response);
        return response.data;
    }
    this.saved = function (response, params=null) {
        console.log('SUCCESS '+response.config.method+' '+response.config.url, response);
        if (params && params.toast != null){
            if (!params.toast == false)
                toast.success(params.toast);
        } else toast.success('Successfully Saved');
        return response.data;
    }
    this.deleted = function (response) {
        console.log('SUCCESS '+response.config.method+' '+response.config.url, response);
        toast.success('Successfully Deleted');
        return response.data;
    }
    this.updated = function (response) {
        console.log('SUCCESS '+response.config.method+' '+response.config.url, response);
        toast.success('Successfully Updated');
        return response.data;
    }
    this.uploaded = function (response) {
        console.log('SUCCESS '+response.config.method+' '+response.config.url, response);
        toast.success('Successfully Uploaded');
        return response.data;
    }


    /* -- async --*/
    this.confirm = async function (options = null) {
        let result = null;
        await swal({...{
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Delete it!',
                buttonsStyling: false
            }, ...options}).then(function (response) {
            result = response.value;
        }).catch(swal.noop)
        return result;
    }
    this.prompt = async function (field, title = '') {
        var response = {};
        await swal({
            title: title,
            html: '<div class="form-group">' +
                '<input class="form-control" placeholder="Enter '+field+'" id="api-input-field">'+
                '</div>',

            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function(result) {
            response.success = result.value;
            if (result.value) response.data = $('#api-input-field').val();
        })
            .catch(swal.noop);
        return response;
    }
    this.promptText = async function (field, title = '') {
        var response = {};
        await swal({
            title: title,
            html: '<div class="form-group">' +
                '<textarea class="form-control" rows="5" placeholder="Enter '+field+'" id="api-input-field"></textarea>'+
                '</div>',

            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function(result) {
            response.success = result.value;
            if (result.value) response.data = $('#api-input-field').val();
        }).catch(swal.noop);
        return response;
    }

    /**
     * @param {string} url
     * @param {object|null} params
     * @param {object} params.config
     * @param {object} params.config.data
     * @return {ApiResponse}
     * Example use: api.get('api/users', {config:{data:{key:'value'},headers:{}}});
     */
    this.get = async function (url, params = null) {
        let data = null;
        let config = (params?.config) ? params.config : {};
		url = fullUrl(url);
        await $http.get(url, config)
            .then(function (response) {
                data = api.success(response);
            }, api.error);
        return data;
    }
    this.post = async function (url, data, params=null) {
        let response = { success: false };
        let config = (params && params.config) ? params.config : {};
        if (params && params.event) $(params.event.target).addClass("disabled");
		url = fullUrl(url);
        await $http.post(url, data, config)
            .then(function (http_response) {
                response.data = api.saved(http_response, params);
                response.success = true;
            }, function (http_response) {
                response.data = api.error(http_response)
            });
        if (params && params.event) $(params.event.target).removeClass("disabled");
        return response;
    }
    this.put = async function (url, data, params = null) {
        let response = { success: false };
        let config = (params && params.config) ? params.config : {};
        await $http.put(url, data, config)
            .then(function (http_response) {
                response.data = api.updated(http_response);
                response.success = true;
            }, function (http_response) {
                response.data = api.error(http_response)
            });
        return response;
    }
    this.delete = async function (url, params = null) {
        let response = { success: false };
        let config = (params && params.config) ? params.config : {};
		url = fullUrl(url);
		await $http.delete(url, config)
            .then(function (http_response) {
                response.data = api.deleted(http_response);
                response.success = true;
            }, api.error);
        return response;
    }

    this.comment = async function (model, comment) {
        console.log('model', model);
        console.log('comment', comment);

        if (!model.class_name){
            console.error('utils.comment', 'class_name required');
            toast.error('utils.comment ', 'Oops! Something went wrong!!!');
            return;
        } else if (!model.id){
            console.error('utils.comment', 'parent id required');
            toast.error('utils.comment ', 'Oops! Something went wrong!!!');
            return;
        } else if (!comment){
            console.error('utils.comment', 'comment required');
            toast.error('utils.comment ', 'Oops! Something went wrong!!!');
            return;
        }

        return await api.post('api/comment', {
            commentable_id: model.id,
            commentable_type: model.class_name,
            comment: comment,
        });
    }


    this.fileUpload = async function (e, params = {}) {
        if (e.target.files.length === 0) return;
        let max_file_upload_size = 41943040;
        let error_file_size_exceeded = "Maximum size is 40 MB";
        let response = { success: false };
        let formData = new FormData();
        formData.append('file', e.target.files[0]);
        formData.append('file_type', (params.file_type) ? (params.file_type) : 'attachment');
        if (params.parent_id) formData.append('parent_id', params.parent_id);
        if (params.parent_type) formData.append('parent_type', params.parent_type);
        if (params.doc_type) formData.append('doc_type', params.doc_type);
        if (params.extra) formData.append('extra', params.extra);

        if (!params.url) params.url = "api/file_upload";
        if (e.target.files[0]?.size > max_file_upload_size ){
            toast.error(error_file_size_exceeded);
            return;
        }
        if (params.file_type && params.file_type === 'attachments'){
            console.log('doc_type', params.doc_type);
            if (!params.doc_type){
                toast.error('Document type required');
                return;
            }
            formData.append('doc_type', params.doc_type);
        }
        let headers = {...{ 'Content-Type': undefined }, ...params?.config?.headers};
		await $http({
            method: 'POST',
            url: fullUrl(params.url),
            data: formData,
            headers: headers,
            uploadEventHandlers: { progress: function(e) {
                    console.log('uploading', e);
                    var progress = Math.round((e.loaded/e.total)*100);
                    // if (params.progress)
                }}
        }).then(function (http_response) {
            response.data = api.uploaded(http_response)
            response.success = true;
            // params.success(http_response);
        }, function (http_response) {
            response.data = api.error(http_response)
        });
        return response;
    }
    this.filesUpload = async function (e, params = {}) {
        if (e.target.files.length === 0) return;
        let max_file_upload_size = 41943040;
        let error_file_size_exceeded = "Maximum size is 40 MB";
        let response = { success: false };
        let formData = new FormData();
        formData.append('file_type', (params.file_type) ? (params.file_type) : 'attachment');
        if (params.parent_id) formData.append('parent_id', params.parent_id);
        if (params.parent_type) formData.append('parent_type', params.parent_type);
        if (params.doc_type) formData.append('doc_type', params.doc_type);
        if (params.tab_name) formData.append('tab_name',params.tab_name);
        if (params.classification && params.tab_name==null){
            toast.error('select Document category name');
            return ;
        }
        if (params.extra) formData.append('extra', params.extra);

        if (!params.url) params.url = "api/file_upload";

        if (e.target.files[0].size > max_file_upload_size ){
            toast.error(error_file_size_exceeded);
            return;
        }
        if (params.file_type && params.file_type == 'attachments'){
            console.log('doc_type', params.doc_type);
            if (!params.doc_type){
                toast.error('Document type required');
                return;
            }
            formData.append('doc_type', params.doc_type);
        }
        let headers = {...{ 'Content-Type': undefined }, ...params?.config?.headers};
        for (let index = 0; index < e.target.files.length; index++) {
            formData.append('file', e.target.files[index]);
            await $http({
                method: 'POST',
                url: fullUrl(params.url),
                data: formData,
                headers: headers,
                uploadEventHandlers: { progress: function(e) {
                        // console.log('uploading', e);
                        var progress = Math.round((e.loaded/e.total)*100);
                        console.log('progress', progress+'%');

                        // if (params.progress)
                    }}
            }).then(function (http_response) {
                response.data = api.uploaded(http_response)
                response.success = true;
                // params.success(http_response);
            }, function (http_response) {
                response.data = api.error(http_response)
            });
        }

        return response;
    }

});
function scrollBodyToTop(elem = null){
    let target = elem ? $(elem) : $('#card');
    if (isWindows && $('.main-panel.ps-container').length) {
        $('.main-panel.ps-container').animate({
            scrollTop: target.offset().top
        }, 500);
    } else {
        $('html').animate({
            scrollTop: target.offset().top
        }, 500);
    }
}
app.filter('timeToHuman', function() {
    return function(millisecond) {
        return  timeToHuman(millisecond);
    };
});
function timeToHuman(millisecond) {
    if (!millisecond) return '';
    let secs = Math.floor(millisecond / 1000);
    let hr = Math.floor(secs / 3600);
    let min = Math.floor((secs - (hr * 3600)) / 60);
    let sec = Math.floor(secs - (hr * 3600) - (min * 60));
    if (min < 10) { min = "0" + min; }
    if (sec < 10) { sec = "0" + sec; }
    if(hr <= 0) { return min + ':' + sec; }
    return hr + ':' + min + ':' + sec;
}
/**
 * @return RecordRTC
 */
async function getRecorder(){
    let recorder;
    await navigator.mediaDevices.getUserMedia({audio: true})
        .then(function(microphone) {
            recorder = RecordRTC(microphone, {
                type: 'audio',
                recorderType: StereoAudioRecorder,
                desiredSampRate: 16000,
                disableLogs: true,
            });
            recorder.microphone = microphone;
        })
        .catch(function(error) {
            alert('Microphone permission denied');
            console.error(error);
        });
    return recorder;
}
