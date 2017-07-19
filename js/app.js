// All routes of the pages and sections

angular.module("PostApp2.0", ["ui.bootstrap", "ngRoute", "ngResource"])
	.config(function($routeProvider){
		$routeProvider
			//Main page section
			.when("/", {
				controller: "Main",
				templateUrl: "templates/home.html"
			})
			//Login section
			.when("/login", {
				controller: "Login",
				templateUrl: "templates/login.html",
				resolve: {
					check: function($location, user){
						if(user.isUserLoggedIn()) {
							$location.path("/dashboard");
						}
					}
				}
			})
			//Dasboard (Only if logged)
			.when("/dashboard", {
				resolve: {
					check: function($location, user){
						if(!user.isUserLoggedIn()){
							$location.path("/login")
						}
					}
				},
				controller: "Dashboard",
				templateUrl: "templates/dashboard.html"
			})
			//Logout, just go here if want to log out
			.when("/logout", {
				resolve: {
					deadResolve: function($location, user){
						user.clearData();
						$location.path("/");
					}
				}
			})
			.when("/register", {
				controller: "Register",
				templateUrl: "templates/register.html",
				resolve: {
					check: function($location, user){
						if(user.isUserLoggedIn()) {
							$location.path("/dashboard");
						}
					}
				}

			})
			//To recover password if forgoten
			// .when("/recover", {
			// 	resolve: {
			// 		check: function($location, user){
			// 			if(user.isUserLoggedIn()){
			// 				$location.path("/")
			// 			}
			// 		}
			// 	},
			// 	controller: "Recovery",
			// 	templateUrl: "templates/check_user.html"
			// })
			// .when("/changepass", {
			// 	controller: "ChangePass",
			// 	templateUrl: "templates/change_pass.html"
			// })
			// .when("/passconfirm", {
			// 	controller: "PassConfirm",
			// 	templateUrl: "templates/pass_confirm.html"
			// })
			.otherwise({
				template: "404"
			});
	});