var app = angular.module('detall', ['ngAnimate', 'ui.bootstrap', 'ngLoadingSpinner']) .controller('emalist', function($scope, $uibModal) {
$scope.open = function (size) {

//console.log(size);
  $scope.animationsEnabled = true;
    var modalInstance = $uibModal.open({
      animation: $scope.animationsEnabled,
      templateUrl: '../taules/Gestor_grups.php?a=get_html_email&b='+size,
      controller: 'ModalInstanceCtrl',
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
});
}});

//var detall = angular.module('detall', []);



angular.module('detall').controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, $http) {

  $scope.ok = function () {
    $uibModalInstance.dismiss('ok');
  };

  $scope.reenvia = function (mid) {
    //$uibModalInstance.close($scope.selected.item);
    $http.get("../taules/Gestor_grups.php?a=resend_email&b=" + mid)
        .then(function(response) {
        //    console.log(response);
        //  alert(response.data);
        if (response.data.resultat){
            location.reload();
        }else{
            alert("L'enviament ha fallat!");
        }
        });
    //alert("reenvia");
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('detall').controller('llistatEmails', function ($scope,  $http) {
   // $scope
   $scope.init = function(idr)
  {
    
    $scope.idr = idr;
        $http.get("Gestor_grups.php?a=llista_emails_reserva&b="+$scope.idr )
        .then(function(response) {
          $scope.confirmada = response.data.confirmada;
          $scope.files = response.data.rows;  
  
    });
    
    $scope.className = function(resultat, restaurant) {
//.alert-warning
//var base = ' alert';
//var base = ' label';
//var base = ' panel';
var base = ' btn';
        var className = base + '-danger';
console.log(resultat);
        if (resultat){
            className = base + '-success';
             if (restaurant)
                className = base + '-info';
        }
        else{
             className = base + '-danger';
             if (restaurant)
                className = base + '-warning';
            
        }
        
       
        return className;
    };
  };
   
    

    
});


app.filter('num', function() {
    return function(input) {
      return parseInt(input, 10);
    }
});