<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    
    <link href="/css/bootstrap.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <link href="/css/font-awesome.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/static/bootstrap/css/font-awesome-ie7.min.css?bootstrap=2.3.2.post1.dev1">
    <![endif]-->
    <link href="/css/bootstrap-responsive.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <link rel=stylesheet href="/css/custom.css">
    <link rel="shortcut icon" href="/img/favicon-profiles.png">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19976491-4']);
  _gaq.push(['_setDomainName', 'civiclinks.it']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script> 


<div class="profiles-login-page">
    <div id="wrapper">
        <?php echo form_open("auth/login", array("name" => "login-form", "class" => "login-form form-horizontal", "id" => "login-form")); ?> 
            <div class="header">
                <h2>Accedi con il tuo account IoPartecipo</h2>
             </div>
            <div id="error_message_content"></div>
            <div class="content">
                <input class="input email hint" id="email" name="email" placeholder="Email" type="text" value="">
              <div class="user-icon"></div>
              <input class="input password hint" id="password" name="password" placeholder="Password" type="password" value="">
              <div class="pass-icon"></div>
              <button type="button" id="btn-login" class="btn">Login</button>
            </div>
            <div class="end">
              <h4>Non ancora registrato?</h4>
              <p>Vai a uno dei siti IoPartecipo per registrare un nuovo account</p>
            </div>
        </form>
	<div style="clear: both"></div>
    </div>
</div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js?bootstrap=2.3.2.post1.dev1"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.pageslide.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.maxlength.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.inputhints.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/custom.js"></script>
    <script type="text/javascript">// <![CDATA[
        /* Always put the background to the full window*/
        $(function($){

            adaptbackground = function() {
                if ( $(".profiles-login-page").height() <= $(window).height() ) {
                    $(".profiles-login-page").height( $(window).height());
                }
            }

            $(window).resize(function() {
                adaptbackground();
            });

            adaptbackground();

            /* Show input Hints */
            // hook up placeholder text on any input with a title
            $('input[title]').inputHints();

        });

    // ]]>
    </script>
  </body>
  <!-- Font Awesome is licensed CC-BY-3.0: http://fortawesome.github.com/Font-Awesome -->
</html>