<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title><?php if(isset($user_data['firstname']) && !empty($user_data['firstname'])): ?><?php echo $user_data['firstname']; ?><?php endif; ?> 
           <?php if(isset($user_data['lastname']) && !empty($user_data['lastname'])): ?><?php echo ' '.$user_data['lastname']; ?><?php endif; ?> | Profilo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    
    <link href="/css/bootstrap.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <link href="/css/font-awesome.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/css/font-awesome-ie7.min.css?bootstrap=2.3.2.post1.dev1">
    <![endif]-->
    <style>
      body {
        padding-top: 60px;
      }
    </style>
    <link href="/css/bootstrap-responsive.min.css?bootstrap=2.3.2.post1.dev1" rel="stylesheet">
    <link rel=stylesheet href="/css/jquery.pageslide.css">
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

    
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner" id="nav-main-menu">
            <div class="container">
              <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <div class="nav-collapse collapse">
          <ul class="nav" id="nav-menu">   
            <li class="hidden-desktop">
              <a href="/show/<?php echo $user_data['_id']; ?>" target="blank">	   
                <?php if(isset($user_data['sex']) && $user_data['sex']=='F'): ?>Benvenuta, <?php else: ?>Benvenuto, <?php endif; ?>
                <strong>
                <?php if(isset($user_data['firstname']) && !empty($user_data['firstname'])): ?><?php echo $user_data['firstname']; ?><?php endif; ?>
                <?php if(isset($user_data['lastname']) && !empty($user_data['lastname'])): ?><?php echo ' '.$user_data['lastname']; ?><?php endif; ?>
                </strong>
              </a>
            </li>
            <li class="hidden-desktop">
              <a class=" hidden-desktop" href="/auth/logout">Logout</a>
            </li>
          </ul>
		      <ul id="nav-login" class="nav pull-right visible-desktop">
            <li class="visible-desktop">
              <a href="/show/<?php echo $user_data['_id']; ?>" target="blank">
                <?php if(isset($user_data['sex']) && $user_data['sex']=='F'): ?>Benvenuta, <?php else: ?>Benvenuto, <?php endif; ?>
                <strong>
                <?php if(isset($user_data['firstname']) && !empty($user_data['firstname'])): ?><?php echo $user_data['firstname']; ?><?php endif; ?>
                <?php if(isset($user_data['lastname']) && !empty($user_data['lastname'])): ?><?php echo ' '.$user_data['lastname']; ?><?php endif; ?>
                </strong>
	           </a>
            </li>
            <li class="visible-desktop">
              <a class="btn btn-small visible-desktop" href="/auth/logout">Logout</a>
            </li>
          </ul>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

    
    

    <div class="bio">
        <div class="container">
            <div class="span1 quotation offset3">
                <i class="icon-quote-left icon-4x pull-left icon-muted"></i>
            </div>

            <div class="span5 profilebio">
               <?php if(isset($user_data['biography']) && !empty($user_data['biography'])): ?><?php echo $user_data['biography']; ?><?php endif; ?>
            </div>

            <div class="span1 quotationleft">
                <i class="icon-quote-right icon-4x pull-right icon-muted"></i>
            </div>
        </div>

        <div class="bioend"></div>
    </div>

    

    <div class="container">
        <div class="row-fluid userpanel">

            <div class="span4 avatar">
                <div class="row-fluid">
                    <div class="span12">
                    <?php if(file_exists($photo)): ?>                
                      <img src="/upload/images/<?php echo $user_data['_id'].'_thumb.jpg'; ?>" alt="La tua foto"/>
                    <?php else: ?>
                      <img src="/img/foto_anonima.jpg" alt="La tua foto"/>
                    <?php endif; ?>    		              
                    </div>
                </div>
	        </div>

            <div class="span8">

                   <div class="generality">
		       
                       
                           <a href="/edit/<?php echo $user_data['_id']; ?>"
                              title="Modifica il tuo profilo">
                              <i class="icon-edit icon-2x"></i>
                           </a>
                       

                        <h1 class="name">
                          <?php if(isset($user_data['firstname']) && !empty($user_data['firstname'])): ?><?php echo $user_data['firstname']; ?><?php endif; ?>
                          <?php if(isset($user_data['lastname']) && !empty($user_data['lastname'])): ?><?php echo ' '.$user_data['lastname']; ?><?php endif; ?>                            
                          <?php if(isset($user_data['nickname']) && !empty($user_data['nickname'])): ?><?php echo ' ('.$user_data['nickname'].')'; ?><?php endif; ?>                            
                        </h1>
                   </div>

                
                    <div class="details">

                            <?php if(isset($user_data['location']) && !empty($user_data['location'])): ?>
                            <span class="icon-stack">
                                <i class="icon-check-empty icon-stack-base"></i>
                                <i class="icon-map-marker" style="top: -2px;"></i>
                            </span>
                            <?php echo $user_data['location']; ?><br>
                            <?php endif; ?>
                            
                            <?php if(isset($user_data['location']) && !empty($user_data['location'])): ?>                        
                            <span class="icon-stack">
                                <i class="icon-check-empty icon-stack-base"></i>
                                <i class="icon-chevron-sign-right" style="top: -1px;"></i>
                            </span>
                            <a href="<?php echo $user_data['website']; ?>"><?php echo $user_data['website']; ?></a><br>
                            <?php endif; ?>

                    </div>
                
     
            </div>
        </div>
    </div>

    
    <div class="footer">
        <div class="container">
            <footer>
	      <p>&nbsp</p>
            </footer>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js?bootstrap=2.3.2.post1.dev1"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.inputhints.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.pageslide.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.maxlength.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/custom.js"></script>
  </body>
  <!-- Font Awesome is licensed CC-BY-3.0: http://fortawesome.github.com/Font-Awesome -->
</html>