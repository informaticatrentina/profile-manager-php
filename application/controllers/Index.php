<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @package	Profile Manager
 * @author	Stefano Beccalli
 * @copyright	Copyright (c) 2017
 * @link	http://www.jlbbooks.it
 * @since	Version 2.1.0
 */
class Index extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('ProfileManagerLibrary');
    }
	
	
   /*
	* Function index
	*
	* Funzione principale , gestisce il redirect verso la pagina di login
	*/
    public function index()
    {
      redirect(base_url().'auth/login');      
    }
		
	/*
	 * Function auth
	 *
	 * Funzione che gestisce l autenticazione al sistema
	 *
	 *
	 * @return (array)
	 */
    public function auth()
    {
      if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') === 'POST')
      {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
             
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if($this->form_validation->run($this) === FALSE)
        {
          $json['response']='error';
          $json['message']=validation_errors();        
        }
        else
        {          
          // Verifico credenziali di accesso
          $username=xss_clean($this->input->post('email'));
          $password=xss_clean($this->input->post('password'));
          
          if(($user_id=$this->profilemanagerlibrary->checkLogin($username,$password)) !== FALSE)
          {         
            // Recupero informazioni utente per sessione
            if(($user_data=$this->profilemanagerlibrary->getUserById($user_id)) !== FALSE)
            {
              if(isset($user_data['_id']) && !empty($user_data['_id'])) $this->session->set_userdata('_id',$user_data['_id']);
              $json['response']='success';   
              $json['link']=base_url().'edit/'.$user_id;
            }
            else
            {
              $json['response']='error';
              $json['message']='<div class="alert alert-danger">'.$this->profilemanagerlibrary->getMessage().'</div>';
            }           
          }
          else
          {
            $json['response']='error';
            $json['message']='<div class="alert alert-danger">'.$this->profilemanagerlibrary->getMessage().'</div>';
          }          
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
      }
      else
      {
        $this->load->view('auth/login');
      }
    }
	/*
	* Function edit
	*
	* funzione che carica i dati utenti e gestisce la modifica di essi
	*
	* @param (int) id utente
	* 
	*/
    public function edit($user_id)
    {
      
      $sess_id=$this->session->userdata('_id');
      
      if(empty($sess_id) && $sess_id!=$user_id)
      {
        $this->session->sess_destroy();
        redirect(base_url().'auth/login');
        exit();
      }
      else
      {
        $data['user_data']=$this->profilemanagerlibrary->getUserById($user_id);  

        if(isset($data['user_data']['nickname'] ) && $data['user_data']['nickname'] == " ")
        {
           $data['user_data']['nickname'] = null;
        }   
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg'))
        {
          $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg';
        }
        elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png'))
        {
          $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png';
        }
        else $data['photo']=null;
        $this->load->view('user/edit',$data);       
      }      
    }
	
	/*
	* Function show
	*
	* Visualizza le informazioni del utente nella schermata principale
	*
	* @param (int) id utente
	*
	*/
    public function show($user_id)
    {      
      $sess_id=$this->session->userdata('_id');
      
      if(empty($sess_id) && $sess_id!=$user_id)
      {
        $this->session->sess_destroy();
        redirect(base_url().'auth/login');
        exit();
      }
      else
      {
        $data['user_data']=$this->profilemanagerlibrary->getUserById($user_id);
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg'))
        {
          $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg';
        }
        elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png'))
        {
          $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png';
        }
        else $data['photo']=null;

        $this->load->view('user/show',$data);       
      }      
    }
	
	/*
	* Function photo
	*
	* Funzione che gestisce il salvataggio della foto utente nel sistema
	*
	* @param (array,array) foto, dimesioni foto
	* @return (data) file caricato
	*/
    public function photo($user_id,$dim)
    {
      $data['user_data']=$this->profilemanagerlibrary->getUserById($user_id);       
      if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_'.$dim.'.jpg'))
      {
        $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_'.$dim.'.jpg';
      }
      elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_'.$dim.'.png'))
      {
        $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_'.$dim.'.png';
      }
      else $data['photo']=null;

      if(!empty($data['photo']))
      {         
        header("Content-type: " .image_type_to_mime_type(exif_imagetype($data['photo'])));
        header("Content-Length: " . filesize($data['photo']));
        readfile($data['photo']);
      }
      else
      {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/img/foto_anonima_'.$dim.'.jpg')) $data['photo']=$_SERVER['DOCUMENT_ROOT'].'/img/foto_anonima_'.$dim.'.jpg';
        else $data['photo']=$_SERVER['DOCUMENT_ROOT'].'/img/foto_anonima_150.jpg';
        header("Content-type: " .image_type_to_mime_type(exif_imagetype($data['photo'])));
        header("Content-Length: " . filesize($data['photo']));
        readfile($data['photo']);         
      }
    }
	
    /*
	 * Function save
	 *
	 * Funzione che salva i dati utente nella schermata di modifica 
	 *
	 * 
	 * @return (array)
	 */
    public function save()
    {
      if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') === 'POST')
      {
        $this->form_validation->set_rules('_id', '_id', 'required|trim');
        $this->form_validation->set_rules('firstname', 'Nome', 'required|trim|min_length[1]|max_length[132]');
        if(isset($_POST['lastname']) && !empty($_POST['lastname'])) $this->form_validation->set_rules('lastname', 'Cognome', 'required|trim|min_length[1]|max_length[132]');
        if(isset($_POST['nickname']) && !empty($_POST['nickname'])) $this->form_validation->set_rules('nickname', 'Nick Name', 'min_length[2]|max_length[132]|callback__checkNickName|callback__checkNickNameFormat');       
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');       
        $this->form_validation->set_rules('biography', 'Biografia', 'trim|min_length[1]|max_length[150]');       
        $this->form_validation->set_rules('website', 'Website', 'trim|valid_url'); 
        if(!empty($_POST['new_password'])) $this->form_validation->set_rules('new_password', 'Password', 'required|min_length[3]'); 
        if(!empty($_POST['new_password'])) $this->form_validation->set_rules('con_password', 'Ripeti Password', 'required|min_length[3]|matches[new_password]'); 
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $json['response']='';
    
        if($this->form_validation->run($this) === FALSE)
        {
          $json['response']='error';
          $json['message']=validation_errors();        
        }
        else
        {       
          $user_id=$this->input->post('_id');
          $firstname=xss_clean($this->input->post('firstname'));
          $lastname=xss_clean($this->input->post('lastname'));
          $nickname=xss_clean($this->input->post('nickname'));
          if(empty($nickname) && $nickname == "") $nickname = " ";
          $email=xss_clean($this->input->post('email'));
          $sex=$this->input->post('sex');
          $location=xss_clean($this->input->post('location'));
          $website=xss_clean($this->input->post('website'));
          $biography=xss_clean($this->input->post('biography'));
          
          $password=xss_clean($this->input->post('new_password'));          
          
          /* Campi obbligatori */
          $data=array('firstname' => $firstname, 'lastname' => $lastname, 'nickname' => $nickname, 'email' => $email);
          
          /* Verifiche campi facoltativi */
          if($sex=='M' || $sex=='F') $data['sex']=array($sex);
          
          if(empty($location)) $data['location']='';
          else $data['location']=$location;
          
          if(empty($website)) $data['website']='';
          else $data['website']=$website;
          
          if(empty($biography)) $data['biography']='';
          else $data['biography']=$biography;
          
          if(!empty($password)) $data['password']=$password;
          
          if(!$this->profilemanagerlibrary->patchUserData($user_id,$data))
          {
             $json['response']='error';
             $json['message']='<div class="alert alert-danger">'.$this->profilemanagerlibrary->getMessage().'</div>';          
          }
          
          // Effettuo l'upload della foto se non sono stati rilevati errori in precendenza         
         
          if(empty($json['response']) && isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))
          {
            // Cancello eventuali immagini presenti con una diversa estensione
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg');
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_350.jpg')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_350.jpg');
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'.jpg')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'.jpg');
 
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.png');
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_350.png')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_350.png');
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'.png')) @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'.png');   

            $config['upload_path'] = '.'.$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/';
            $config['file_name'] = $user_id;
            $config['overwrite'] = true;
            $config['allowed_types'] = 'jpg|png';
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo'))
            {
              $json['response']='error';
              $json['message']='<div class="alert alert-danger">'.$this->upload->display_errors().'</div>'; 
            }
            else
            {


              $data = $this->upload->data();       
           
              // Rinomino il file lowercase
              if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['file_name']))
              {
                rename($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['file_name'],$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.strtolower($data['file_name']));
              }            
              
              $this->load->library('image_lib');
              
              $config['image_library'] = 'gd2';
              $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.strtolower($data['file_name']);
              $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['raw_name'].'_350'.strtolower($data['file_ext']);
              $config['create_thumb'] = FALSE;
              $config['maintain_ratio'] = TRUE;
              $config['width'] = 350;
              $config['height'] = 350;
              $this->image_lib->initialize($config);

              if (!$this->image_lib->resize()) 
              {
                $json['response']='error';
                $json['message']='<div class="alert alert-danger">'.$this->image_lib->display_errors().'</div>';   
              } 
              
              $this->image_lib->clear();            
              
              $config['image_library'] = 'gd2';
              $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.strtolower($data['file_name']);
              $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['raw_name'].'_150'.strtolower($data['file_ext']);
              $config['create_thumb'] = FALSE;
              $config['maintain_ratio'] = TRUE;
              $config['width'] = 150;
              $config['height'] = 150;
              $this->image_lib->initialize($config);

              if (!$this->image_lib->resize()) 
              {
                $json['response']='error';
                $json['message']='<div class="alert alert-danger">'.$this->image_lib->display_errors().'</div>';   
              } 
              
              $this->image_lib->clear();
            }
          }          
          
          if(empty($json['response']))
          {
            $json['response']='success';
            $json['link']=base_url().'show/'.$user_id;  
          }       
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
      }
    }
	
	/*
	 * Function logout
	 *
	 * Funzione che disconnette l utente dal sistema
	 *
	 */
    public function logout()
    {
      $this->session->sess_destroy();
      redirect(base_url().'auth/login');
    }
    
	/*
	 * Function _checkNickName
	 *
	 * funzione che controlla se il nickname che sto inserendo esiste gia nel sistema
	 *
	 * @param (string) campo nickname
	 * @return (bool)
	 */
    public function _checkNickName($field)
    {
      $id=$this->input->post('_id');
      if(!$this->profilemanagerlibrary->checknickname($id,$field))
      {
        $this->form_validation->set_message('_checkNickName', 'Attenzione, il NickName da te scelto è già presente.');
        return FALSE;    
      }
      else return TRUE; 
    }
	
	/*
	 * Function _checkNickNameFormat
	 *
	 * Controllo costruzione campo nickname, verifica che sia composto unicamente da lettere e numeri. Se sono presenti spazi, simboli verrà impedita la modifica del valore
	 *
	 * @param (string) campo nickname
	 * @return (bool)
	 */
	public function _checkNickNameFormat($field)
	{

		  if(preg_match('/[^A-Za-z0-9]/',$field))
		  {
			$this->form_validation->set_message('_checkNickNameFormat', 'Attenzione, il NickName presenta caratteri non validi.');
			return FALSE;
		  }
		  else return TRUE;

	}


        
}
