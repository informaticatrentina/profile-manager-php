<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ProfileManagerLibrary
 * 
 * @package Profile Manager
 * @author  Stefano Beccalli
 * @copyright Copyright (c) 2017
 * @link  http://www.jlbbooks.it
 * @since Version 1.0.0
 */
class ProfileManagerLibrary
{
  protected $_CI=NULL;
  private $_message=NULL;
	
  public function __construct()
  {
    $this->_CI = &get_instance();
  }
  
  public function checkLogin($username, $password)
  {
    if(empty($username)) throw new Exception(__METHOD__.' - Attenzione la variabile $username è vuota o non valida. Valore: '.var_export($username,TRUE), 1);
		if(empty($password)) throw new Exception(__METHOD__.' - Attenzione la variabile $password è vuota o non valida. Valore: '.var_export($password,TRUE), 1);
     
    $login_params='/users/?where={"email": "'.urlencode($username).'", "password": "'.urlencode($password).'"}';
		
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$this->_CI->config->item('IM_URL').$login_params);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_USERAGENT,"ProfileManager PHP User Agent");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, $this->_CI->config->item('IM_USER').':'.$this->_CI->config->item('IM_PASSWORD'));
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);
   
    if($status_code==0)
    {
      $this->_message='Attenzione, Identity Manager non raggiungibile.';
      return FALSE;
    }
    else
    {
      // Converto il risultato da JSON in Array
      $result_arr=json_decode($result,TRUE);
      if(isset($result_arr['_items'][0]['status']) && $result_arr['_items'][0]['status']==1 && isset($result_arr['_items'][0]['_id']) && !empty($result_arr['_items'][0]['_id']))
      {
        return $result_arr['_items'][0]['_id'];
      }
      else
      {
        $this->_message='Attenzione, credenziali di accesso non corrette.';
        return FALSE;
      }
    }
  }
  
  public function getUserById($user_id)
  {
    if(empty($user_id)) throw new Exception(__METHOD__.' - Attenzione la variabile $user_id è vuota o non valida. Valore: '.var_export($user_id,TRUE), 1);
   
    $options_get='/users/'.$user_id;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$this->_CI->config->item('IM_URL').$options_get);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_USERAGENT,"ProfileManager PHP User Agent");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, $this->_CI->config->item('IM_USER').':'.$this->_CI->config->item('IM_PASSWORD'));
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);
    
    if($status_code==0)
    {
      $this->_message='Attenzione, Identity Manager non raggiungibile.';
      return FALSE;
    }
    else
    {
      // Converto il risultato da JSON in Array
      $result_arr=json_decode($result,TRUE);	
      if(isset($result_arr['_status']) && $result_arr['_status']=='ERR')
      {
        $this->_message='Attenzione, si è verificato un errore durante il recupero dei dati dell\'utente dall\'Identity Manager.';
        return FALSE;
      }
      else
      {
        $data=array();
        //die(print('<pre>'.print_r($result_arr,TRUE).'</pre>'));
        if(isset($result_arr['_id']) && !empty($result_arr['_id'])) $data['_id']=$result_arr['_id'];
        if(isset($result_arr['email']) && !empty($result_arr['email'])) $data['email']=$result_arr['email'];
        if(isset($result_arr['nickname']) && !empty($result_arr['nickname'])) $data['nickname']=$result_arr['nickname'];
        if(isset($result_arr['firstname']) && !empty($result_arr['firstname'])) $data['firstname']=$result_arr['firstname'];
        if(isset($result_arr['lastname']) && !empty($result_arr['lastname'])) $data['lastname']=$result_arr['lastname'];
        if(isset($result_arr['location']) && !empty($result_arr['location'])) $data['location']=$result_arr['location'];
        if(isset($result_arr['biography']) && !empty($result_arr['biography'])) $data['biography']=$result_arr['biography'];   
        if(isset($result_arr['website']) && !empty($result_arr['website'])) $data['website']=$result_arr['website'];       
        if(isset($result_arr['sex'][0]) && !empty($result_arr['sex'][0])) $data['sex']=$result_arr['sex'][0];
        if(empty($data))
        {
          $this->_message='Attenzione, si è verificato un errore durante il recupero dei dati dell\'utente dall\'Identity Manager.';
          return FALSE;
        }
        else return $data;
      }     
    }
  }
  
  public function checknickname($user_id,$nickname)
  {
    if(empty($user_id)) throw new Exception(__METHOD__.' - Attenzione la variabile $user_id è vuota o non valida. Valore: '.var_export($user_id,TRUE), 1);
    if(empty($nickname)) throw new Exception(__METHOD__.' - Attenzione la variabile $nickname è vuota o non valida. Valore: '.var_export($nickname,TRUE), 1);
    
    $get_params='/users/?where={"nickname": "'.$nickname.'"}&projection={"'.$nickname.'":1}';
          
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$this->_CI->config->item('IM_URL').$get_params);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_USERAGENT,"ProfileManager PHP User Agent");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, $this->_CI->config->item('IM_USER').':'.$this->_CI->config->item('IM_PASSWORD'));
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);
    
    if($status_code==0)
    {
      $this->_message='Attenzione, Identity Manager non raggiungibile.';
      return FALSE;
    }
    else
    {
      // Converto il risultato da JSON in Array
      $result_arr=json_decode($result,TRUE);   
      if(isset($result_arr['_items'][0]['_id']) && !empty($result_arr['_items'][0]['_id']))
      {
        if($result_arr['_items'][0]['_id']==$user_id) return TRUE;
        else return FALSE;
      }
      else return TRUE;
    }
  }
  
  public function patchUserData($user_id,$data)
  {
    if(empty($data) || !is_array($data)) throw new Exception(__METHOD__.' - Attenzione la variabile $data è vuota o non valida. Valore: '.var_export($data,TRUE), 1);
    
    $patch_params='/users/'.$user_id.'/';   
   
    $data_json = json_encode($data);
        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$this->_CI->config->item('IM_URL').$patch_params);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_USERAGENT,"ProfileManager PHP User Agent");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $this->_CI->config->item('IM_USER').':'.$this->_CI->config->item('IM_PASSWORD'));
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);   
    
    $result_arr=json_decode($result,TRUE);
  
    if(isset($result_arr['_status']) && $result_arr['_status']=='OK') return TRUE;
    else
    {
      if(isset($result_arr['_status']) && $result_arr['_status']=='ERR' && isset($result_arr['_issues'])) $this->_message=print_r($result_arr['_issues'],TRUE);
      else $this->_message=print_r($status_code,TRUE); //$this->_message='Si è verificato un errore generico durante l\'aggiornamento del profilo utente';
      return FALSE;
    }
  }
  
  public function getMessage()
  {
    return $this->_message;
  }
}
