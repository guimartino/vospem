
<script src="//code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>

  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI(response);
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1264011017036295',
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.11' // use graph api version 2.8
  });


	FB.login(function(response) {
	  if (response.status === 'connected') {
		// Logged into your app and Facebook.
	  } else {
		// The person is not logged into this app or we are unable to tell.
	  }
	  //alert('chegou');
	});
  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.
  //
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

};



(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/pt_BR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI(responseGot) {
  	id = 0;
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!'
        +'<br> Access Token: ' + responseGot.authResponse.accessToken + '<br>Response: ' + response
		+'<br> Expires in: ' + responseGot.authResponse.expiresIn
		;

        id = response.id;
  //       var output = '';
		// for (var property in response) {
		//   output += property + ': ' + response[property]+'; ';
		// }
		// alert(output);
    });

    /* make the API call */
	before = null;
	after = null;
		FB.api("/me/accounts", function (response) {
		      if (response && !response.error) {
		        /* handle the result */
		        data = response.data;

            for(i=0; i<data.length;i++){
		          var output = '';
              for (var property in data[i]) {
                output += property + ': ' + data[i][property]+'; ';
              }
              console.log(output)
            }


    				//alert(output);

		      }else{
		      	var output = '';
		      	error = response.error;
    				for (var property in error) {
    				  output += property + ': ' + error[property]+'; ';
    				}
		      }
		    }
		);


  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email,manage_pages,pages_show_list,read_page_mailboxes" onlogin="checkLoginState();" data-auto-logout-link="true" >
</fb:login-button>
<div id="status">
</div>

</body>
</html>






























<!--

https://developers.facebook.com/docs/facebook-login/web

https://developers.facebook.com/docs/facebook-login/overview/#logindialog

https://developers.facebook.com/docs/facebook-login/access-tokens/?locale=pt_BR#usertokens
