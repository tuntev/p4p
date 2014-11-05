/**
 * Created by tunte on 11/3/14.
 */
var app = angular.module('app',['ngRoute','ngSanitize'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.config(function($routeProvider){

    $routeProvider.when('/projects', {
        templateUrl: 'templates/projects.html',
        controller: 'ProjectsController'
    });

    $routeProvider.when('/todo', {
        templateUrl: 'templates/todos.html',
        controller: 'TodoController'
    });

    $routeProvider.when('/demo', {
        templateUrl: 'templates/demo.html',
        controller: 'DemoController'
    });

    $routeProvider.otherwise({
        redirectTo: '/projects'
    });
});


