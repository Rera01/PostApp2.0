angular.module("PostApp2.0")
	.controller("Main", function($scope, PostResource, user, $timeout){
		//This is to call the posts data but with $resource
		// $scope.cc = PostResource.query();
		// console.log($scope.cc);
		// I will be using factories to call the data of the posts
		// While in-file codes to call the users, just to use different methods for the same.

		//Checks if the user is already logged in
		$scope.logged = user.isUserLoggedIn();

		$scope.readPosts = function(){

	        // use posts factory
	        PostResource.readPosts().then(function (response){
	            $scope.posts = response.data;
	        }, function (response){
	            console.log("Unable to read posts.");
	        });
 
    	}
	})

	//Controller for the Login
	.controller("Login", function($scope, $http, user, $location){
		//Function Called to validates values
		$scope.login = function(){
			var username = $scope.username;
			var password = $scope.password;
			//Posts values to check in the database and go to the dashboard
			$http({
				url: "api/users/read.php",
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				data: "username="+username+"&password="+password
			}).then(function(response){
				for(var i = 0; i < response.data.records.length; i++){
					if((response.data.records[i].username == username) && (response.data.records[i].password == password)) {
						user.saveData(response.data.records[i]);
						$location.path("/dashboard");
						break;
					}
					else {
						console.log("Login invalid");
					}
				}

			}, function(response) {
					console.log(response);
			});
		}
	})

	.controller("Dashboard", function($scope, $http, user, $location){
		$scope.user = user.getName();
		$scope.picture = user.getPicture();
		$scope.logged = user.isUserLoggedIn();
		var newPic;

		$scope.logout = function() {
			$location.path("/logout");
		};

		$scope.getPic = function(){
			console.log($scope.picture);
		};

		$scope.uploadImage = function() {
			return newPic = true;
		};

		$scope.saveChanges = function(){
			if(newPic) {
				$scope.changePicture();
			}
			if($scope.newPass){
				$scope.changePass();
			}

			$scope.newPass = null;
			document.getElementById('files').value = null
		};

		$scope.changePicture = function(){
			var form_data = new FormData();
			var id = user.getID();			

			angular.forEach($scope.files, function(file){
				form_data.append('file', file);
			});

			form_data.append('userid', id);

			$http({
				url: 'api/users/update_pic.php',
				method: 'POST',
				data: form_data,
				transformRequest: angular.identity,
				headers: {
					"Content-Type": undefined
				}
			}).then(function(response){
				if(response.data.status == "done"){
					user.setPicture(response.data.newPic);
					console.log("Picture updated");
					$scope.picture = user.getPicture();
					console.log($scope.picture);
				}
				else{
					console.log("Update unsuccessful");
				}
			}, function(response){
					console.log(response);
			});
		};	

		$scope.changePass = function(){
			var password = $scope.newPass;
			var id = user.getID();

			$http({
				url: "api/users/update_pass.php",
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: "password="+password+"&userid="+id
			}).then(function(response){
				console.log(response.data);
				if(response.data.status == "done"){
					console.log("Pass updated")
				}
				else{
					console.log("Update unsuccessful");
				}
			}, function(response){
				console.log(response);
			});
		}

		$scope.deleteAccount = function(){
			if (confirm("Are you sure?")){
				$http({
					url: 'api/users/delete.php',
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					data: "userid="+user.getID()
				}).then(function(response){
					console.log(response.data);
					if(response.data.status == "deleted"){
						console.log(response.data);
						alert("User Deleted");
						$scope.register();
						$location.path("/logout");
					} else if (response.data.status == "noThisOne"){
						alert("Please try deleting another user, this it for testing");
					}
					else{
						alert("Error deleting user");
					}
					}, function(response){
						console.log(response);
				})
			}
		}

		$scope.register = function(){
			var username = "rera01";
			var password = 12345;
			//Posts values to check in the database and go to the dashboard
			$http({
				url: "api/users/create.php",
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				data: "username="+username+"&password="+password
			}).then(function(response){
					if(response.data.status == "created") {
					}
					else {
						console.log("Login invalid");
					}

			}, function(response) {
					console.log(response);
			});
		}
	})

	.controller("Register", function($scope, $http, user, $location){
		$scope.register = function(){
			var username = $scope.username;
			var password = $scope.password;
			//Posts values to check in the database and go to the dashboard
			$http({
				url: "api/users/create.php",
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				data: "username="+username+"&password="+password
			}).then(function(response){
					if(response.data.status == "created") {
						alert("User Created");
						$location.path("/login");
					}
					else {
						console.log("Login invalid");
					}

			}, function(response) {
					console.log(response);
			});
		}
	})