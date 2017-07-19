angular.module("PostApp2.0")
	.directive("uploadImg", function($parse){
		return {
			link: function($scope, element, attrs){
				element.on("change", function(event){
					var files = event.target.files;
					$parse(attrs.uploadImg).assign($scope, element[0].files);
					$scope.$apply();
				});
			}
		}
	});