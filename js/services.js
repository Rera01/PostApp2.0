angular.module("PostApp2.0")
	// .factory("PostResource", function($resource){
	// 	return $resource("api/posts/read.php");
	// })
	.factory("PostResource", function($http){
		var posts = {};
 
	    // read all Posts
	    posts.readPosts = function(){
	        return $http({
	            method: 'GET',
	            url: 'api/posts/read.php'
	        });
	    };
     
    	return posts;
	})

	.service("user", function(){
		//this service has all the functions to validate the user before and after log in
		var username;
		var loggedin = false;
		var id = "";
		var password;
		var picture;

		//gets the name of the user logged in
		this.getName = function(){
			return username;
		};

		// set the ID of the user logged in if needed
		this.setID = function(userID){
			id = userID;
		};
		
		this.getID = function() {
			return id;
		};

		//gets password of user
		this.getPass = function(){
			return password;
		}

		//sets new password
		this.setPass = function(newPass){
			password = newPass;
		}

		//set new picture
		this.setPicture = function(newPic){
			picture = newPic;
			localStorage.setItem("login", JSON.stringify({
				username: username,
				id: id,
				password: password,
				picture: picture
			}));
		}

		// gets the picture of user logged in
		this.getPicture = function(){
			return picture;
		}

		// checks if the user is logged in from the local storage of the browser
		this.isUserLoggedIn = function(){
			//if there is a file called "login" in the local storage, then proceed
			if(!!localStorage.getItem("login")){
				loggedin = true;
				var data = JSON.parse(localStorage.getItem("login"));
				username = data.username;
				id = data.id;
				password = data.password;
				picture = data.picture;
			}

			return loggedin;
		};

		// Saves the data of the user logged in into the local storage to be read after
		this.saveData = function(data){
			username = data.username;
			id = data.userid;
			password = data.password;
			picture = data.picture;
			loggedin = true;
			localStorage.setItem("login", JSON.stringify({
				username: username,
				id: id,
				password: password,
				picture: picture
			}));
		};

		// clears the data in case of logout
		this.clearData = function(){
			localStorage.removeItem("login");
			username = "";
			id = "";
			loggedin = false;
		}
	})
