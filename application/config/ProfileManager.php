<?php
defined('BASEPATH') OR exit('No direct script access allowed');

# WARNNG: must be changed to False in production!
$config['DEBUG'] = true;

$config['EMAIL_DEBUG'] = 'stefano.beccalli@jlbbooks.it';

# WARNNG: must be changed in production!
$config['SECRET_KEY'] = "\x01\x01\xd0\x01a\xf0\xddz|\xab\xfda\x0b\x15\xe4\xb0\xcdzs\xce\xd7\xa1+\xfe";

# IM_URL
$config['IM_URL'] = "http://identity.stefano.web/v1";
$config['IM_USER'] = "boo8iejietook9pee6ieviezaeKahghu";
$config['IM_PASSWORD'] = "";

# Set the upload folder, change in production to a suitable storage dir!
$config['UPLOAD_FOLDER'] = '/upload';

$config['IMAGE_FOLDER'] = '/images';