<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @package	Profile Manager
 * @author	Stefano Beccalli
 * @copyright	Copyright (c) 2017
 * @link	http://www.jlbbooks.it
 * @since	Version 1.0.0
 */
class Index extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('ProfileManagerLibrary');
    }
    
    public function index()
    {
      redirect(base_url().'auth/login');      
    }
    
    public function auth()
    {
      if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') === 'POST')
      {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
             
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

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
              $json['message']='<div class="alert alert-warning">'.$this->profilemanagerlibrary->getMessage().'</div>';
            }           
          }
          else
          {
            $json['response']='error';
            $json['message']='<div class="alert alert-warning">'.$this->profilemanagerlibrary->getMessage().'</div>';
          }          
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
      }
      else
      {
        $this->load->view('auth/login');
      }
    }
    
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
        $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg';
        $this->load->view('user/edit',$data);       
      }      
    }
    
    public function detail($user_id)
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
        $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg';
        $this->load->view('user/show',$data);       
      }      
    }
    
    public function show($user_id)
    {
       $data['user_data']=$this->profilemanagerlibrary->getUserById($user_id);       
       $data['photo']=$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$user_id.'_150.jpg';
       if(!file_exists($data['photo']))
       {         
         header("Content-type: " .image_type_to_mime_type(exif_imagetype($data['photo'])));
         header('Content-Length: ' . filesize($data['photo']));
         readfile($data['photo']);
         exit();
       }
       else
       {
         $data['photo']=$_SERVER['DOCUMENT_ROOT'].'/img/foto_anonima_150.jpg';
         header("Content-type: " .image_type_to_mime_type(exif_imagetype($data['photo'])));
         header('Content-Length: ' . filesize($data['photo']));
         readfile($data['photo']);
         exit();
       }
    }
    
    public function save()
    {
      if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') === 'POST')
      {
        $this->form_validation->set_rules('_id', '_id', 'required|trim');
        $this->form_validation->set_rules('firstname', 'Nome', 'required|trim|min_length[1]|max_length[132]');
        $this->form_validation->set_rules('lastname', 'Cognome', 'required|trim|min_length[1]|max_length[132]');
        $this->form_validation->set_rules('nickname', 'Nick Name', 'required|trim|min_length[1]|max_length[132]|callback__checkNickName');       
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');       
        $this->form_validation->set_rules('biography', 'Biografia', 'trim|min_length[1]|max_length[150]');       
        $this->form_validation->set_rules('website', 'Website', 'trim|valid_url'); 
        if(!empty($_POST['new_password'])) $this->form_validation->set_rules('new_password', 'Password', 'required|min_length[3]'); 
        if(!empty($_POST['new_password'])) $this->form_validation->set_rules('con_password', 'Ripeti Password', 'required|min_length[3]|matches[new_password]'); 
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');
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
             $json['message']='<div class="alert alert-warning">'.$this->profilemanagerlibrary->getMessage().'</div>';          
          }
          
          // Effettuo l'upload della foto se non sono stati rilevati errori in precendenza         
         
          if(empty($json['response']) && isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))
          {
            $config['upload_path'] = '.'.$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/';
            $config['file_name'] = $user_id;
            $config['overwrite'] = true;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 1024;
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo'))
            {
              $json['response']='error';
              $json['message']='<div class="alert alert-warning">'.$this->upload->display_errors().'</div>'; 
            }
            else
            {    
              $data = $this->upload->data();       
           
              // Rinomino il file lowercase
            
              if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['file_name']))
              {
                rename($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['file_name'],$_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.strtolower($data['file_name']));
              }
            
              // Creo la miniatura - se esiste già la cancello
              if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['raw_name'].'_150'.strtolower($data['file_ext'])))
              {
                @unlink($_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['raw_name'].'_150'.strtolower($data['file_ext']));
              }
            
              
              $config['image_library'] = 'gd2';
              $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.strtolower($data['file_name']);
              $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].$this->config->item('UPLOAD_FOLDER').$this->config->item('IMAGE_FOLDER').'/'.$data['raw_name'].'_150'.strtolower($data['file_ext']);
              $config['create_thumb'] = FALSE;
              $config['maintain_ratio'] = TRUE;
              $config['width'] = 150;
              $config['height'] = 150;
              $this->load->library('image_lib', $config);

              if (!$this->image_lib->resize()) 
              {
                $json['response']='error';
                $json['message']='<div class="alert alert-warning">'.$this->image_lib->display_errors().'</div>';   
              } 
              
              $this->image_lib->clear();
            }
          }          
          
          if(empty($json['response']))
          {
            $json['response']='success';
            $json['link']=base_url().'detail/'.$user_id;  
          }       
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
      }
    }

    public function logout()
    {
      $this->session->sess_destroy();
      redirect(base_url().'auth/login');
    }
    
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
        
}
