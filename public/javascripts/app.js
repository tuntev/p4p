/**
 * Created by tunte on 11/3/14.
 */
var createAccountApp = angular.module('createAccount',['ngRoute','ngSanitize'],['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);

createAccountApp.config(['$routeProvider', function($routeProvider){

//    $routeProvider.when('/', {
//        templateUrl: 'create.html',
//        controller: 'CreateAccountController'
//    });
//
//    $routeProvider.otherwise({
//        redirectTo: '/'
//    });
}]);

var app = angular.module('app',['ngRoute','ngSanitize','ui.bootstrap','dialogs.main'], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);

app.config(['$routeProvider', function($routeProvider){

    $routeProvider.when('/home', {
        templateUrl: 'templates/home.html',
        controller: 'HomeController'
    });

    $routeProvider.when('/projects', {
        templateUrl: 'templates/projects.html',
        controller: 'ProjectsController'
    });

    $routeProvider.when('/projects/:projectId', {
        templateUrl: 'templates/project_details.html',
        controller: 'ProjectDetailsController'
    });

    $routeProvider.when('/todo', {
        templateUrl: 'templates/todos.html',
        controller: 'TodoController'
    });

    $routeProvider.when('/demo', {
        templateUrl: 'templates/demo.html',
        controller: 'DemoController'
    });

    $routeProvider.when('/chat', {
        templateUrl: 'templates/chat.html',
        controller: 'ChatController'
    });

    $routeProvider.otherwise({
        redirectTo: '/home'
    });
}]);


