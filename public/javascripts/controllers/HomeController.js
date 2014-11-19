/**
 * Created by tunte on 19-Nov-14.
 */

app.controller('HomeController',['$scope','TabService', function($scope, TabService){

    TabService.setTab(1);

}]);