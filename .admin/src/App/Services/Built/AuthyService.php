<?php

namespace App;


/**
 * Service Class
 * Provide Response for the backend controler
 */
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\BuilderLayout;
use ApiGoat\Utility\BuilderMenus;
use ApiGoat\Handlers\BuilderReturn;
use ApiGoat\Handlers\PropelErrorHandler;
use ApiGoat\Api\ApiResponse;
use ApiGoat\Api\Api;
use Selective\Config\Configuration;
use ApiGoat\Sessions\AuthySession as AuthySession;


class AuthyService
{

    /**
     * return abstract
     * @var array
     */
    public $content=['html'=>'', 'onReadyJs'=>'', 'js'=>'', 'json' =>''];
    /**
     *
     * @var BuilderLayout object
     */
    public $BuilderLayout;
    /**
     * legacy variable for all arguments
     * @var array
     */
    public $request=[];
    /**
     *
     * @var PSR-7 response object
     * immutable object
     */
    private $response;

    /**
     * Add custom callable actions
     *
     * @var array
     */
    public $customActions;
    public $rawRequest;
    public $Form;
    public $contentType;
    public $headers;

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function __construct($request, $response, $args )
    {
        $this->rawRequest = $request;
        $this->response = $response;
        $this->BuilderLayout = new BuilderLayout(new BuilderMenus($args));
        // legacy
        $this->request = $args;
    }

    /**
     * Get the proper response
     * @return string
     */
    public function getResponse()
    {
        $this->content = "Unknown method";

        switch($this->request['a']){
            case '':
            case 'list':
                $this->content = $this->list();
            break;
            case 'edit':
            case 'view':
                $this->content = $this->edit();
            break;
            case 'update':
            case 'insert':
                $this->content = $this->saveUpdate();
                $this->content['onReadyJs'] .= "sw_message('Saved');";
                return $this->BuilderLayout->renderXHR($this->content);
            case 'delete':
                $this->content = $this->deleteOne();
                return $this->BuilderLayout->renderXHR($this->content);




                case 'NtNsaveAuthyGroupX':
                    $this->content = $this->NtNsaveAuthyGroupX();
                break;

                /**
                *   Child table
                **/
                case 'AuthyGroupX':
                    $this->content = $this->Form->getAuthyGroupXList($this->request['i'], $this->request);
                break;

                /**
                *   Child table
                **/
                case 'AuthyLog':
                    $this->content = $this->Form->getAuthyLogList($this->request['i'], $this->request);
                break;


            case 'login':
                return $this->BuilderLayout->renderLogin($this->login());
            break;
            case 'logout':
                return $this->BuilderLayout->renderXHR($this->logout());
            break;
            case 'auth':
                $ApiResponse = new ApiResponse($this->request, $this->response, $this->auth());
                return $ApiResponse->getResponse();
            break;

            default:
                if (method_exists($this, $this->customActions[$this->request['a']])) {
                    $callable = $this->customActions[$this->request['a']];
                    $this->content = $this->$callable($this->request);
                }
        }



        if($this->request['ui']){
            return $this->BuilderLayout->renderXHR($this->content);
        }else{
            return $this->BuilderLayout->render($this->content);
        }
    }
    
    /**
    * Get the proper api response
    * @return array
    */
    public function getApiResponse()
    {
        $this->body = ['status' => 'failure', 'errors' => ['Unknown method'], 'data' => null, 'messages' => null];
        $Api = new Api('Authy', $this);

        if (isset($this->customActions[$this->request['a']]) && method_exists($this, $this->customActions[$this->request['a']])) {
            $callable = $this->customActions[$this->request['a']];
            $this->body = $this->$callable($Api);
        }else{
            switch($this->request['method']){
                case 'AUTH':
                    $dispatch = $this->request['a'];
                    $this->body = $this->$dispatch();
                    break;
                case 'GET':
                    $this->body = $Api->getJson($this->request);
                    break;
                case 'POST':
                case 'PATCH':
                    if ($this->request['a'] == 'list') {
                        $this->body = $Api->getJson($this->request);
                    } else {
                        $this->body = $Api->setJson($this->request);
                    }
                    break;
                case 'PUT':
                    $this->body = $Api->file($this->request);
                    break;
                case 'DELETE':
                    $this->body = $Api->deleteJson($this->request);
                    break;
            }
        }



        $ApiResponse = new ApiResponse($this->request, $this->response, $this->body);
        return $ApiResponse->getResponse();
    }


        #update for checkboxes NtN
        private function NtNsaveAuthyGroupX()
        {
            $response['status'] = 'failure';

            $data['i'] = json_decode($this->request['i'], true);

            if(!$_SESSION[_AUTH_VAR]->hasRights('Authy', 'w')){
                security_redirect(false);
            }
            if(is_array($data['i'])){
                $e = AuthyGroupXQuery::create()->findPk($data['i']);
                if($e){
                    $e->delete();
                    $response['status'] = 'success';
                    $response['messages'][] = 'Removed';
                }else{
                    $e = new AuthyGroupX();
                    $e->setPrimaryKey($data['i']);
                     if ($e->validate()) {
                        $e->save();
                        $response['status'] = 'success';
                        $response['messages'][] = 'Added';
                    }else{
                        $return['msg'] = handleValidationError($e, $this->request['data']['ui'], _('User'), $extValidationErr);
                        $return['error'] = $return['msg'];
                        $response['messages'][] = 'Something went wrong';
                    }
                }
            }
            header('Content-type: application/json;charset=UTF-8');
            die(json_encode($response));

        }





    public function deleteOne()
    {
        $error = [];
        $messages = '';

        $obj = AuthyQuery::create()->findPk(json_decode($this->request['i']));


            if($obj->countAuthyGroupxes()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Group'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAuthyLogs()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Login log'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAuthiesRelatedByIdAuthy0()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'User'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAuthiesRelatedByIdAuthy1()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'User'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countCountriesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Country'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countCountriesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Country'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAssetsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Asset'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAssetsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Asset'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAssetExchangesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Wallet'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAssetExchangesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Wallet'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTradesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Trade'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTradesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Trade'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countExchangesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Exchange'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countExchangesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Exchange'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTokensRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Token'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTokensRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Token'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countSymbolsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Symbol'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countSymbolsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Symbol'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAuthyGroupsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Group'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countAuthyGroupsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Group'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countConfigsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Setting'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countConfigsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Setting'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countApiRbacsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'API ACL'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countApiRbacsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'API ACL'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTemplatesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Template'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTemplatesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'Template'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTemplateFilesRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'File'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countTemplateFilesRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." 'File'. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countMessageI18nsRelatedByIdCreation()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." ''. ", '', true,'User'); die( $error['onReadyJs'] );
            }
            if($obj->countMessageI18nsRelatedByIdModification()){
                $error = handleNotOkResponse(_("This entry cannot be deleted. It is in use in ")." ''. ", '', true,'User'); die( $error['onReadyJs'] );
            }

        $obj->delete();



        $BuilderReturn = new BuilderReturn($this->request, $error, $messages);
        return $BuilderReturn->return();
    }

    public function saveUpdate()
    {
        $messages = null;
        $error = null;

        $extValidationErr = false;
        parse_str ($this->request['d'], $data );

        $data['i'] = ( $data['IdAuthy'] ) ? $data['IdAuthy'] : $this->request['i'];
        $data['ip'] = urldecode($this->request['data']['ip']);
        $data['pc'] = urldecode($this->request['data']['pc']);
        $this->Authy['request'] = $this->request;

        if(!empty($data['i'])) {
            ## Save

            $e = $this->Form->setUpdateDefaultsAuthy($data);


            if ($e->validate() && !$extValidationErr) {
                $e->save();
                $this->request['i'] = json_encode($e->getPrimaryKey());


            }else{
                $PropelErrorHandler = new PropelErrorHandler($e, $this->request['data']['ui'],_('Form field'), $extValidationErr, $this->virtualClassName);
                $error = $PropelErrorHandler->getValidationErrors();
            }
        } else {
            ## Create


            $e = $this->Form->setCreateDefaultsAuthy($data);

            if ($e->validate() && !$extValidationErr) {
                $e->save();
                $this->request['i'] = json_encode($e->getPrimaryKey());



            }else{
                $PropelErrorHandler = new PropelErrorHandler($e, $this->request['data']['ui'],_('Form field'), $extValidationErr, $this->virtualClassName);
                $error = $PropelErrorHandler->getValidationErrors();
            }
        }

        $BuilderReturn = new BuilderReturn($this->request, $error, $messages);
        return $BuilderReturn->return();
    }



    /**
    * Return the main edit form, including child lists
    * @return string
    */
    private function edit()
    {
        $this->Authy['request'] = $this->request;
        $this->Authy['parentId'] = $this->request['data']['ip'];


        $relData = $this->request;
        $output = $this->Form->getEditForm($this->request['i'], $this->request['ui'], $relData, '', $this->request['data']['je'], $this->request['data']['jet']);

        return $output;
    }

    /**
    * Retrun the main list
    * @return string
    */
    private function list()
    {
        $output = $this->Form->getList($this->request);

        return $output;
    }


    

public $omMap;
public $isConnected;
public $lang;
public $group;
public $userRights;
public $loginFormClass;
# custom variables
public $sessVar = array();





    /**
     * Main login function
     * @param string $username
     * @param string $passHash
     * @param booleen $isWs
     * @param booleen $stay
     */
    public function tryLog($username, $passHash, $isWs=false, $stay=true, $csrf='')
    {
        $settings = new Configuration(require _BASE_DIR . 'config/settings.php');
        $jwt_settings = $settings->getArray('jwt_middleware');
        $tocken = [];

        if(!$isWs){
            $CsrfError = false;

            if($_SESSION[_AUTH_VAR]->getCsrf() != $csrf){
                $CsrfError = true;
            }
        }else{
            $CsrfError = false;
        }
        
        if($stay){
            $en_de_txt = en_de('encrypt', json_encode(array($username, $passHash)));
            setcookie("authy", NULL, -1, '/; samesite=strict', $_SERVER['SERVER_NAME'], true, true);
            setcookie("authy", $en_de_txt, time() + (10 * 365 * 24 * 60 * 60), '/; samesite=strict', $_SERVER['SERVER_NAME'], true, true);
        }
        
        $attemptOk = $this->checkAttemptsOk($username);

        if($attemptOk && !$CsrfError && !strstr($passHash, '%') && !strstr($username, '%') && !strstr($passHash, ' ') && !strstr($passHash, ' ')){
            $Authy = $this->queryUser($username, $passHash);        
            $this->lastTry = time();
        }elseif($attemptOk == false){
            $return[] = "Too many attempts, try again later";
        }elseif($CsrfError){
            $return[] = "Something went wrong, please refresh the page and try again";
        }
        
        if(!$isWs){
            $this->setSession($Authy);
        }else{
            if(empty($return)){
                $jwt = $this->getToken($Authy, $jwt_settings['secret'], $jwt_settings['expire']);
            }
        }
        
        $this->setAuthyLog($username, $jwt);
        
        if (is_array($jwt)) {
            return $jwt;
        }

        return $return;
    }

    /**
     * 
     * @param type $username
     * @param type $passHash
     * @return type
     */
    private function queryUser($username, $passHash)
    {
        $q = new AuthyQuery();
        $q
            ->filterByUsername(mres($username))->_or()
            ->filterByEmail(strtolower(mres($username)))
            ->filterByPasswdHash(mres($passHash))
            ->filterByDeactivate('No')->_or()->filterByDeactivate(null, \Criteria::EQUAL)
            ;
        return $q->findOne(); 
    }

    /**
     * return a JWT tocken if the user is valid
     * @param type $pmpoData
     * @param type $username
     * @param type $secret
     * @return array response data
     */
    public function getToken($pmpoData, $secret, $expire="now +2 hours")
    {
        if( !empty($pmpoData) ){
            $now = new \DateTime();
            $future = new \DateTime($expire);
            $jti = (new \Tuupola\Base62)->encode(random_bytes(16));
            
            $payload = [
                "iat" => $now->getTimeStamp(),
                "exp" => $future->getTimeStamp(),
                "jti" => $jti,
                "sub" => $_SERVER["PHP_AUTH_USER"],
                "scope" => [],
                "username" => $pmpoData->getUsername(),
                "authyId" => $pmpoData->getIdAuthy(),
                "group" => $pmpoData->getIdAuthyGroup(),
                "isRoot" => $pmpoData->getIsRoot()
            ];

            $token = \Firebase\JWT\JWT::encode($payload, $secret, "HS256");

            $data["token"] = $token;
            $data["expires"] = $future->getTimeStamp();
            $data["status"] = 'success';
            return $data;
        }elseif(empty($pmpoData)){
            return ["status" => "failure", "messages" => ["Unknown username or password"] ];
        }else{
            return ["status" => "failure"];
        }
    }

    /**
     * Set the session object AuthySession
     * @param propel collection $pmpoData
     * @param string $username
     * @param booleen $isWs
     */
    public function setSession($pmpoData)
    {
        if( !empty($pmpoData) ){
            if(($pmpoData->getExpire() != null && $pmpoData->getExpire() <= date('Y-m-d'))){
                $_SESSION[_AUTH_VAR]->set('isConnected','NO');
                $return[] = "Oh! User has expired.";
            }else{
                $passHash = $pmpoData->getPasswdHash();
                $_SESSION[_AUTH_VAR]->set('sess_id', md5(session_id()));
                $_SESSION[_AUTH_VAR]->set('isConnected','YES');
                $_SESSION[_AUTH_VAR]->set('id',$pmpoData->getIdAuthy());
                $_SESSION[_AUTH_VAR]->set('isRoot',($pmpoData->getIsRoot() == 'Yes')?true:false);
                $_SESSION[_AUTH_VAR]->set('passHash',$passHash);
                $_SESSION[_AUTH_VAR]->set('email',$pmpoData->getEmail());
                $_SESSION[_AUTH_VAR]->config_changed = 'no';
                $_SESSION[_AUTH_VAR]->set('username',$pmpoData->getUsername());
                $rightsGroup = array (
  'All' => 'RightsAll',
  'Owner' => 'RightsOwner',
  'Group' => 'RightsGroup',
);
                if(is_array($rightsGroup)){
                    foreach($rightsGroup as $group => $columnName){
                        $getColumn = "get{$columnName}";
                        $userRightsAr[$group] = json_decode($pmpoData->$getColumn(), true);
                    }
                    $_SESSION[_AUTH_VAR]->setRights( $userRightsAr );
                }

                if($pmpoData->getAuthyGroupRelatedByIdAuthyGroup()){
                    $_SESSION[_AUTH_VAR]->setPrimaryGroup( $pmpoData->getIdAuthyGroup(), $pmpoData->getAuthyGroupRelatedByIdAuthyGroup()->getAdmin() );
                }
                $_SESSION[_AUTH_VAR]->setGroups();
                
                $_SESSION[_AUTH_VAR]->set('lastMsg', _("Connection succesful"));
                $this->sessionVarSet($pmpoData);
                
            $_SESSION['mem'] = unserialize($pmpoData->getOnglet());
                
                return true;
            }
        }else{
            $_SESSION[_AUTH_VAR]->set('isConnected','NO');
            $return[] = "The username/password combination is not know to us!";
        }
        return $return;
    }

    /**
     * Permit only 5 attempts in 5 minutes
     * @return boolean
     */
    private function checkAttemptsOk($username)
    {
        $al = AuthyLogQuery::create()
                ->filterByIp($_SERVER['REMOTE_ADDR'])
                ->filterByResult('w')
                ->filterByTimestamp(strtotime('1 min ago'), \Criteria::GREATER_EQUAL)
                ->filterByCount(5, \Criteria::GREATER_EQUAL )
                ->filterByLogin( $username )
                ->count();
        
        if($al){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Log login attempts and results
     * @param string $username
     */
    private function setAuthyLog($username, $jwt = [])
    {        

        $jwt = (isset($jwt['status'])) ? $jwt : ['status' => ''];

        $al = AuthyLogQuery::create()
                ->filterByIp($_SERVER['REMOTE_ADDR'])
                ->filterByTimestamp(strtotime('5 min ago'), \Criteria::GREATER_EQUAL)
                ->filterByResult( (($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES' || $jwt['status'] == 'success')?'g':'w') )
                ->findOne();
        
        if(!$al){
            $al = new AuthyLog();
            $al->setIp($_SERVER['REMOTE_ADDR']);
        }
        
        $al->setTimestamp(time());
        $al->setLogin($username);
        
        if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES' || $jwt['status'] == 'success'){
            $al->setIdAuthy($_SESSION[_AUTH_VAR]->get('id'));
            $al->setResult('g');

        }else{
            $al->setCount( $al->getCount()+1 );
            $al->setIdAuthy(null);
            $al->setResult('w');
        }
        $al->save();
    }

    /**
     * Set predefined builder session variables
     * @param DataCollection $pmpoData
     */
    public function sessionVarSet($pmpoData)
    {
    
    }

    public function getRightsArray($arrayRights)
    {
        return json_decode($arrayRights, true);
    }

    /**
     * Check if connected
     * @return boolean
     */
    public function isConnected()
    {
        if($this->isConnected == 'YES')
            return true;
        else
            return false;
    }

    /**
     * Get the html login form
     * @return string
     */
    public function login()
    {
        return $this->Form->login();
    }

    /**
     * Logout and redirect
     * @return array
     */
    public function logout()
    {
        $_SESSION[_AUTH_VAR]->set('connected', 'NO');
        return ['html' => "Redirect", 'js' => script("document.location = 'login';")];
    }

    /**
     * Validate inputs, try to authenticate and respond
     * @return array
     */
    public function auth()
    {
        $return['status'] = 'failure';
        $return['messages'] = _('Unknown username or password');
        $return['error'] = 'fail-connect0';

        if(!$this->request['isApiCall'] && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
            $json['username'] = $_SESSION[_AUTH_VAR]->get('username');
            $return['messages'] = _('Already connected');
            $return['status'] = 'success';
            $return['error'] = 'user-connected';
        }else{
            if(!empty($this->request['data']['u']) && (!empty($this->request['data']['p']) || !empty($this->request['data']['pw']))) {
                $this->request['data']['p'] = ($this->request['data']['pw'])?$this->request['data']['pw']:$this->request['data']['p'];

                if($this->request['isApiCall'] || $_SESSION[_AUTH_VAR]->get('isConnected') == 'NO') {
                    if ($this->request['isApiCall']) {
                        // start a clean session for API auth call
                        unset($_SESSION[_AUTH_VAR]);
                        $_SESSION[_AUTH_VAR] = new AuthySession();
                    }
                    // try to Authenticate
                    $logReturn = $this->tryLog($this->request['data']['u'], $this->request['data']['p'], $this->request['isApiCall'], $this->request['stay'], $this->request['csrf']);

                    if($this->request['isApiCall']) {
                        return is_array($logReturn)?$logReturn:['status' => 'failure', 'messages' => $logReturn];
                    }

                    if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES') {
                        $return['messages'] = 'Connexion successful';
                        $return['status'] = 'success';
                        $return['success'] = 'success-connect';
                    }elseif($logReturn) {
                        $return['messages'] = $logReturn;
                        $return['error'] = 'fail-connect1';
                    }
                } else {
                    $return['error'] = 'fail-connect2';
                    $this->reload();
                }
            } else {
                $return['error'] = 'fail-connect3';
            }
        }

        $return['method'] = 'login';
        return $return;
    }

    public function passReset()
    {
        $data_user = AuthyQuery::create()
            ->filterByEmail($this->request['data']['c'])
            ->findOne();

        if($data_user && $data_user->getDeactivate() == 'No') {
            $newTmpPass = createRandomKey(10);
            $data_user->setPasswdHash( md5($newTmpPass) );
            $data_user->save();

            $body =
            '
                <html>
                    <head>
                        <style type="text/css">
                            @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800); table a:hover { text-decoration: underline !important; } .table tr td phone-fix-top, .table tr td phone-fix-top a { color: #FFF !important; text-decoration: none !important; } .phone-fix, .phone-fix a { color: #2f2f2f !important; text-decoration: none !important; }

                            @media screen and (max-width: 600px) {
                                .container { width: 100% !important; padding: 0 !important; }
                                * { text-align: center !important; }
                                table td{ display: block; width: 100% !important; padding: 20px 0 !important; }
                            }

                            a:hover { text-decoration: underline !important; }
                        </style>
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                    </head>
                    <body>
                        <div>
                            <center>
                                <div style="background: #0f1013; padding: 0; font-family: \'Roboto\', sans-serif;">
                                    <div class="container" style="width: 680px; margin: 0 auto; padding: 0 20px;">
                                        <table bgcolor="#0f1013" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 20px 0 20px 20px; width: 50%; vertical-align: middle;"><a href="'._SITE_URL.'"><img src="" width="165" /></a></td>
                                                    <td style="padding: 20px 20px 20px 0; width: 50%; vertical-align: middle; text-align: left; color: #00a4de; font-size: 20px; text-transform: uppercase; font-weight: 800;">Password <span style="display: block;"> rescue</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="container" style="width: 600px; margin: 50px auto; text-align: left;">
                                    <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif;">Someone initiated a password rescue process for this email address..</p>
                                    <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif;">This is your new password : <strong>'.$newTmpPass.'</strong>.</p>
                                    <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif; dispaly: block; padding-bottom: 40px; border-bottom: 1px solid #000;">Ignore this email if you didn\'t ask for that.</p>
                                </div>
                            </center>
                        </div>
                    </body>
                </html>
            ';

            $title = _("New password");
            sendHTMLemail($body, 'APIgoat.com', $this->request['data']['c'], $title, _FROM);
            $return['error'] = false;
            $return['msg'] = _('New password sent');
        }
        else if ($data_user && $data_user->getDeactivate() == 'Yes') {
            $return['error'] = true;
            $return['msg'] = _("Your account is not activated");
        }
        else {
            $return['error'] = true;
            $return['msg'] = _('Unknown email');
        }

         $return['method'] = 'restore';
        return json_encode($return);
    }

    public function renew(){
        $Authy = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->getIdAuthy());
        $settings = new Configuration(require _BASE_DIR . 'config/settings.php');
        $jwt_settings = $settings->getArray('jwt_middleware');

        return $this->$jwt = $this->getToken($Authy, $jwt_settings['secret'], $jwt_settings['expire']);
    }
}
