angular.module('SluupApp', [])
  .controller('MainController', function($scope) {

      $scope.moduloModal = true;

      console.log(angular.isDefined($scope.moduloModal));

      $scope.minimizarModal = function() {
          console.log("testandos")
          $scope.moduloModal = false;

      }
});