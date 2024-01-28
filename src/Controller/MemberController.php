<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Model\Table\MembersTable;
use App\Service\TwilioService;
/**
 * Member Controller
 */
class MemberController extends AppController
{
    public function register()
    {
        if ($this->request->is('post')) {
            $username = $this->request->getData('username');
            $fullname = $this->request->getData('fullname');
            $phone_no = $this->request->getData('phone_no');
            $password = $this->request->getData('password');
        
          
            if (empty($username) || empty($fullname) || empty($phone_no) || empty($password)) {
                $this->Flash->error(__('Please fill in all the required fields.'));
            } else {
                $membersTable = new MembersTable();
                $user = $membersTable->findByUsername($username)->first();
                if($user) {
                    $this->Flash->error(__('Username already exit.'));
                } else {
                        $memberData = $this->request->getData();
                        $member = $membersTable->newEmptyEntity();
                        $member = $membersTable->patchEntity($member, $memberData);
                        if ($membersTable->save($member)) {
                            $otp = mt_rand(100000, 999999);
                            $this->getRequest()->getSession()->write('OTP', $otp);
                            $this->getRequest()->getSession()->write('username', $username);
                            $twilioService = new TwilioService();
                            $callSid = $twilioService->sendVoiceOTP($phone_no, $otp);
                            $this->Flash->success(__('Registration successful'));
                            $this->redirect(['action' => 'verify']);
                        } else {
                            $this->Flash->error(__('Unable to register. Please, try again.'));
                        }
                }
            }
        }
    }
    public function login()
    {
        if ($this->request->is('post')) {
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');
            $membersTable = new MembersTable();
            $user = $membersTable->findByUsername($username)->first();
            if($user){
                if($password===$user["password"]) {
                    $this->getRequest()->getSession()->write('username', $username);
                    if($user['verify_status']==="Pending"){
                        $phone_no=$user['verify_status'];
                        $otp = mt_rand(100000, 999999);
                        $this->getRequest()->getSession()->write('OTP', $otp);
                        $twilioService = new TwilioService();
                        $callSid = $twilioService->sendVoiceOTP($phone_no, $otp);
                        $this->Flash->success(__('login successful'));
                        $this->redirect(['action' => 'verify']);
                    } else {
                        $this->Flash->success(__('login successful'));
                        $this->redirect(['action' => 'profile']);
                    }
                } else {
                    $this->Flash->error(__('Incorrect password, try again'));
                }
               
            } else {
                $this->Flash->error(__('Username does not exit.'));
            }

        }
    }

    public function verify()
    {
        if ($this->getRequest()->getSession()->check('OTP') && $this->getRequest()->getSession()->check('username')) {
          echo  $sessionOTP = $this->getRequest()->getSession()->read('OTP');
            $sessionUsername = $this->getRequest()->getSession()->read('username');
            $membersTable = new MembersTable();
            $user = $membersTable->findByUsername($sessionUsername )->first();
            $message="You will receive your OTP via a phone call at ".$user['phone_no'];
            if ($this->request->is('post')) {
                if($sessionOTP==$this->request->getData('otp')) {
                    $user->verify_status = "Verified";
                    $membersTable->save($user);
                    $this->Flash->success(__('Account verified successfully'));
                    $this->redirect(['action' => 'profile']);
                } else {
                    $this->Flash->error(__('Invalid OTP.'));
                }
            }
            $this->set(compact('message'));
        } else  {
            $this->redirect(['action' => 'login']);
        }
    }
    public function profile(): void
    {
        if ($this->getRequest()->getSession()->check('username')) {
            $sessionUsername = $this->getRequest()->getSession()->read('username');
            $membersTable = new MembersTable();
            $user = $membersTable->findByUsername($sessionUsername)->first();

            if($sessionUsername===$user['username']){
                    if($user['verify_status']==='Verified'){
                        $this->set(compact('user'));
                    } else {
                        $this->Flash->error(__('You must Verify your account to have access to the profile page'));
                        $this->redirect(['action' => 'login']);
                    }
                $this->set(compact('user'));
            } else {
                $this->Flash->error(__('You must login to have access to the profile page'));
                $this->redirect(['action' => 'login']);
            }
        } else {
            $this->Flash->error(__('You must login session have expired.'));
            $this->redirect(['action' => 'login']);
        }
    }
}