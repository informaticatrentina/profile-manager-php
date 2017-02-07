<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Modifica il tuo profilo</title>
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
    <link rel="stylesheet" href="/css/jasny-bootstrap.min.css">

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
              <a href="/detail/<?php echo $user_data['_id']; ?>" target="blank">	   
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
              <a href="/detail/<?php echo $user_data['_id']; ?>" target="blank">
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
    <div class="title-bar">
        <div class="container">
            <h1>Aggiungi le tue caratteristiche</h1>
            <h2>Carica una foto e descriviti</h2>
        </div>
    </div>
    <div class="container">
      <?php echo form_open_multipart('save', array('id' => 'update-form')); ?>
      <input type="hidden" name="_id" value="<?=(isset($user_data['_id']) && !empty($user_data['_id']))?($user_data['_id']):(''); ?>" />
      <div class="row-fluid userform">
        <div class="span4">
          <h3>Informazioni</h3>
            <div class="form-box form-box-1"> 
              <input id="firstname" name="firstname" placeholder="Nome" type="text" value="<?=(isset($user_data['firstname']) && !empty($user_data['firstname']))?($user_data['firstname']):(''); ?>"> 
              <input id="lastname" name="lastname" placeholder="Cognome" type="text" value="<?=(isset($user_data['lastname']) && !empty($user_data['lastname']))?($user_data['lastname']):(''); ?>"> 
              <input id="nickname" name="nickname" placeholder="Nick Name" type="text" value="<?=(isset($user_data['nickname']) && !empty($user_data['nickname']))?($user_data['nickname']):(''); ?>">
              <input type="hidden" name="type" value="user">
              <div id="nickname-availability" class="hide"></div>
              <input id="email" name="email" title="Il tuo indirizzo email" type="text" value="<?=(isset($user_data['email']) && !empty($user_data['email']))?($user_data['email']):(''); ?>">
              <select id="sex" name="sex" title="Seleziona sesso">
                <option value="U">Seleziona sesso</option>
                <option value="M" <?=(isset($user_data['sex']) && $user_data['sex']=='M')?('selected="selected"'):(''); ?>>Maschile</option>
                <option value="F" <?=(isset($user_data['sex']) && $user_data['sex']=='F')?('selected="selected"'):(''); ?>>Femminile</option>
              </select>
            </div>
            <div class="form-box form-box-2"> 
              <input id="location" name="location" placeholder="Posizione" type="text" value="<?=(isset($user_data['location']) && !empty($user_data['location']))?($user_data['location']):(''); ?>">
                <label for="location">Dove ti trovi?</label> 
              <input id="tags" name="tags" placeholder="Tag" type="text" value="<?=(isset($user_data['tag']) && !empty($user_data['tag']))?($user_data['tag']):(''); ?>">
                <label for="tags">Quali sono i tuoi interessi?</label>
              <input id="website" name="website" placeholder="Sito Web" type="text" value="<?=(isset($user_data['website']) && !empty($user_data['website']))?($user_data['website']):(''); ?>">
                <label for="website">Hai una homepage o un blog?</label>
            </div>
        </div>
        <div class="span4">
          <h3>La tua bio</h3>
          <div class="form-box bio-form">
            <label for="biography">Racconta qualcosa di te in 150 caratteri</label>
              <div class="bio-textarea-container">
                <div class="bio-textarea-1">“</div>
                <div class="bio-textarea-2">                               
                  <textarea id="biography" name="biography" title=""><?=(isset($user_data['biography']) && !empty($user_data['biography']))?($user_data['biography']):(''); ?></textarea>
                  <input type="hidden" name="maxlength" value="150">
                  <p>Caratteri rimanenti: <span class="charsLeft"></span></p>
                </div>
                <div class="bio-textarea-3">„</div>
                <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <div class="span4">
          <h3>La tua foto</h3>
            <div class="form-box form-box-1">
            <div class="fileupload-new thumbnail avatar-preview" style="width:150px;height:150px;">
              <?php if(file_exists($photo)): ?>                
                <img src="/upload/images/<?php echo $user_data['_id'].'_150.jpg'; ?>" alt="La tua foto"/>
              <?php else: ?>
                <img src="/img/foto_anonima.jpg" alt="La tua foto"/>
              <?php endif; ?>              
            </div> 
            <input id="photo" name="photo" type="file">
              <div class="span12 desc">
                <label>La tua foto può pesare al massimo 1MB ed il formato dell’immagine deve essere jpg o png</label>
              </div>
            </div>
        </div>
        <div class="span4">
        <h3>Cambia password</h3>
          <div class="form-box form-box-5">             
  <!-- Questo input non funziona. Lo disabilito.
  <input id="old_password" name="old_password" placeholder="Vecchia Password" type="password" value="">
  -->

                        
  
  <input id="new_password" name="new_password" placeholder="Password" type="password" value="">
  

                        
  
  <input id="con_password" name="con_password" placeholder="Ripeti password" type="password" value="">

  

                    </div>
                </div>
            </div>
            <div class="row-fluid save">
                <div id="error_message_content"></div>
                <div class="span12">           
                    <button class="btn btn-default btn-block btn-primary" id="btn-updateprofile" type="submit">Salva modifiche</button>
                </div>
            </div>
        </form>
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
   <script type="text/javascript" src="/js/jasny-bootstrap.min.js"></script>
   <script type="text/javascript">  var $SCRIPT_ROOT = "";  </script>
    <script type="text/javascript">// <![CDATA[
        $(function($) {
            // hook up placeholder text on any input with a title
            $('input[title]').inputHints();
        });
    // ]]></script>
  </body>
  <!-- Font Awesome is licensed CC-BY-3.0: http://fortawesome.github.com/Font-Awesome -->
</html>
