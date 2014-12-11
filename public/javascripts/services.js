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

            return $http.get('api/p4p').then(function(result) {
                return result.data;
            });
        },

        updateDone: function(id, done){

            return $http.put('api/p4p/' + id, { done: done } ).success(function(data, status) {
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
            return $http.post('api/p4p', input).then(function(result) {
                return result.data;
            });
        },

        delete: function(id){
            return $http.delete('api/p4p/' + id).error(function(data, status) {
                console.log(status);
            });
        },

        getProjectById: function(id){
            return $http.get('api/p4p/' + id).then(function(result) {
                return result.data;
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

app.service('UserService', ['$http',function($http){
    return {
        getUser: function(id){
            return $http.get('api/users/' + id).then(function(result) {
                return result.data;
            });
        }
    }
}]);

app.service('StudentService', ['$http',function($http){
    return {

        getStudentByName: function(input){
            return $http.get('api/student/' + input).then(function(result) {
                return result.data;
            });
        },

        getStudentById: function(id){
            return $http.get('api/student/' + id + '/edit').then(function(result) {
                return result.data;
            });
        }
    }
}]);