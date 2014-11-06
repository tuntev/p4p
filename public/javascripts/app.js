/**
 * Created by tunte on 11/3/14.
 */
var app = angular.module('p4p',['ngRoute','ngSanitize','ui.bootstrap','dialogs.main'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.config(function($routeProvider){

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

    $routeProvider.otherwise({
        redirectTo: '/home'
    });
});


