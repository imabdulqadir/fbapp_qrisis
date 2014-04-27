<?php

class Appc extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->config->load("facebook",TRUE);//getting facebook app credentials.
        $config = $this->config->item('facebook');
        $this->load->library('facebook', $config);//loading facebook php sdk.
        $this->load->model('appm');//loading model.
    }

    function index()
    {
        $this->config->load("facebook",TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('facebook', $config);
        $user = $this->facebook->getUser();//getting facebook user id.

        if ($user) {
            try {
                $data['user_profile'] = $this->facebook
                ->api('/me');//getting facebook users data.
            } 
            catch (FacebookApiException $e) {
                $user = null;
            }
        }

        if ($user) //checking if user is logged in then insert users fb id ,email and unique link in database.
        {
            $data['logout_url'] = $this->facebook
            ->getLogoutUrl(array('next'=>site_url("appc/logout")));
            $fbid=$data['user_profile']['id'];
            $email= $data['user_profile']['email'];
            $link=site_url("appc/link?qid=".$fbid);//creating unique link.
            $datatoinsert=array('fbid'=>$fbid,'email'=>$email,'link'=>$link,'count'=>0);
            $this->appm->insertdb($datatoinsert);
            
        } 
        else 
        {
            $data['login_url'] = $this->facebook
            ->getLoginUrl(array(
                'scope'=>'email,publish_stream'
                ));//asking users permission to provide email address and and publish post on wall.

        }
        $this->load->view('appv',$data);
    }
    function logout() //logging out and destroying session.
    {
        $this->facebook->destroySession();
        $bu=base_url();
        header("Location:$bu");
    }
    function share() //posting the unique link on users wall.
    {
     
        try
        {
            $fid =array('logout_url'=> $this->facebook
            ->getLogoutUrl(array('next'=>site_url("appc/logout"))),
            'fbid'=>'Link shared on your facebook wall.');
            $this->facebook->api('/me/feed','post',array(
                'message' => "Your unique link is ".site_url("appc/link?qid=".$_GET['qid'])
                ));
            $this->load->view('appv',$fid);
           

        }
        catch(FacebookApiException $e)
        {
            $fid =array('logout_url'=> $this->facebook
            ->getLogoutUrl(array('next'=>site_url("appc/logout"))),
            'fbid'=>'Error:'.$e->getMessage());
            $this->load->view('appv',$fid);
        }

        
    }
    function link()//redirecting to unique link.
    {
        $fbid=$_GET['qid'];
        $this->appm->updatecount($fbid);
        $this->load->view('ulink');
    }
    
    
}



?>