<div id="fb_div">
    <h3>Post to your Facebook wall:</h3> <br />
    <textarea id="fb_message" name="fb_message" cols="70" rows="7"></textarea> <br />
    <input type="button" value="Post on Wall" onClick="post_on_wall();" />
</div>

<script>

						  window.fbAsyncInit = function() {
							FB.init({
							  appId      : "698255393636113",
							  xfbml      : true,
							  version    : "v2.4",
							  cookie	 : true
							});
						  };
						
						  (function(d, s, id){
							 var js, fjs = d.getElementsByTagName(s)[0];
							 if (d.getElementById(id)) {return;}
							 js = d.createElement(s); js.id = id;
							 js.src = "//connect.facebook.net/en_US/sdk.js";
							 fjs.parentNode.insertBefore(js, fjs);
						   }(document, 'script', 'facebook-jssdk'));
						   
function post_on_wall()
{
    FB.login(function(response)
    {
        if (response.authResponse)
        {
            alert('Logged in!');
 
            // Post message to your wall
 
            var opts = {
                message : document.getElementById('fb_message').value,
                name : 'Post Title',
                link : 'www.postlink.com',
                description : 'post description',
                picture : 'http://2.gravatar.com/avatar/8a13ef9d2ad87de23c6962b216f8e9f4?s=128&amp;d=mm&amp;r=G'
            };
 
            FB.api('/me/feed', 'post', opts, function(response)
            {
				console.log(response);
                if (!response || response.error)
                {
                    alert('Posting error occured');
                }
                else
                {
                    alert('Success - Post ID: ' + response.id);
                }
            });
        }
        else
        {
            alert('Not logged in');
        }
    }, { scope : 'publish_stream' });
}
</script>