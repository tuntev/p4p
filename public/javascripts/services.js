/**
 * Created by tunte on 11/3/14.
 */
app.service('GetTodos', ['$http', function($http) {
    return {
        getData: function() {
            return $http.get('todos').then(function(result) {
                return result.data;
            });
        }
    }
}]);

app.service('ProjectsService', ['$http','$sanitize', function($http, $sanitize){

    return {
        getProjects: function() {
            return $http.get('p4projects').then(function(result) {
                return result.data;
            });
        },

        updateDone: function(id, done){

            return $http.put('p4projects/update/' + id, { done: done } ).success(function(data, status) {
                if(data) {
                    return data;
                }
            }).error(function(data, status) {
                    console.log('status: ' + status);
                });

        },
        sanitizeInput: function(input){
            return {
                title: $sanitize(input.title),
                student: $sanitize(input.student),
                csrf_token: $sanitize($('meta[name="csrf-token"]').attr('content'))

            };
        },

        addNew: function(input){
            return $http.post('p4projects', input);
        },

        delete: function(id){
            return $http.delete('p4projects/delete/' + id).error(function(data, status) {
                console.log(status);
            });
        }

    }
}]);

app.service('TabService', function(){
    return {
        setTab: function(id){
            var currentActiveTab = $('#tabs').find('.active');
            currentActiveTab.removeClass();
            $('#ng-tab' + id).addClass('active');
        }
    }
});