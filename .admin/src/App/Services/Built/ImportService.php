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


class ImportService
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

            case 'upload':
                return $this->file();
            break;
            case 'file':
            case 'open':
                return $this->getFileContent();
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
        $Api = new Api('Import', $this);

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



    public function getFileContent()
    {
        if($this->request['i']) {
            $pc = ImportQuery::create()->findPk($this->request['i']);
            //echo _BASE_DIR.$pc->getFile();
            if(file_exists(_BASE_DIR.$pc->getFile())) {
                $this->Name = $pc->getName();
                $this->length = filesize(_BASE_DIR.$pc->getFile());
                $this->contentType = mime_content_type(_BASE_DIR.$pc->getFile());
                return file_get_contents(_BASE_DIR.$pc->getFile());
            } else {
                return false;
            }
        }
    }

    public function file()
    {
        $this->contentType = "application/json";

        if (!isset($_FILES["file"]) || !is_uploaded_file($_FILES["file"]["tmp_name"]) || $_FILES["file"]["error"] != 0) {
            $ret['status'] = 'failure';
            $ret['messages'][] = "File missing";
            return json_encode($ret);
        } else {
            $size = round($_FILES["file"]["size"] / 1024, 2);

            $allowedSize = intval('10mb')*1024; /* assumes Mb*/
            if($size > $allowedSize){ /* Size in Kb */
                $ret['status'] = 'error';
                $ret['messages'][] = "File too big";
                return json_encode($ret);
            }

            $tab_style = getimagesize($_FILES['file']['tmp_name']);
            $path_info = pathinfo($_FILES['file']['name']);
            $path_info["extension"] = strtolower($path_info["extension"]);

            if($path_info["extension"]) {

                $data = array(
                                'data' => [
                                    'name' => $_FILES['file']['name'],
                                    'size' => $size,
                                    'extension' => $path_info['extension'],
                                    'ip' => $this->request['data']['ip']
                                ]
                        );
                $tabIp = explode(',', $this->request['data']['ip']);
                if($tabIp) {
                    foreach(array_unique($tabIp) as $ip) {
                        $e = $this->Form->setCreateDefaultsImport($data['data']);

                        $e->setName($_FILES['file']['name']);
                        $path_dest = 'public/file/';
                        $path_file= 'public/file/Import/';


                        if($data['error'] == '') {

                            if(!is_dir(_INSTALL_PATH.'/'.$path_dest)) {
                                mkdir(_INSTALL_PATH.'/'.$path_dest);
                                $fp = fopen(_INSTALL_PATH.'/'."public/file/index.php", "w");
                                fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
                                fclose($fp);
                            }
                            if(!is_dir(_INSTALL_PATH.'/'.$path_file)) {
                                mkdir(_INSTALL_PATH.'/'.$path_file);
                                $fp = fopen(_INSTALL_PATH.'/'.$path_file."/index.php", "w");
                                fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
                                fclose($fp);
                            }

                            $e->setFile('tmp-placeholder');

                            if ($e->validate()) {
                                $e->save();
                                $data['idPk'] = $e->getPrimaryKey();
                                copy($_FILES['file']['tmp_name'], _INSTALL_PATH.'/'.$path_file.md5($data['idPk']) . "." . $path_info["extension"] . "");
                                $data['File'] = $path_file.md5($data['idPk']) . "." . $path_info["extension"];

                                $e->setFile($data['File']);
                                $e->save();
                                $data['data']['IdImportFile'] = $e->getPrimaryKey();

                                $data['status'] = 'success';
                            } else {
                                $data['messages'][] = "Db error";
                                $msg = handleValidationError($e, ((isset($this->request['data']['ui']) ? $this->request['data']['ui'] : '')), _('User'), $extValidationErr);
                                $data['messages'][] = $msg['txt'];
                                $data['status'] = 'failure';
                            }
                        }
                    }

                    if(is_file($_FILES['file']['tmp_name'])) {
                        unlink($_FILES['file']['tmp_name']);
                    }
                }

            }

            return json_encode($data);
        }
    }



    public function deleteOne()
    {
        $error = [];
        $messages = '';

        $obj = ImportQuery::create()->findPk(json_decode($this->request['i']));



        $obj->delete();

            if(is_file(_INSTALL_PATH.$obj->getFile())) {
                unlink(_INSTALL_PATH.$obj->getFile());
            }




        $BuilderReturn = new BuilderReturn($this->request, $error, $messages);
        return $BuilderReturn->return();
    }

    public function saveUpdate()
    {
        $messages = null;
        $error = null;

        $extValidationErr = false;
        parse_str ($this->request['d'], $data );

        $data['i'] = ( $data['IdImport'] ) ? $data['IdImport'] : $this->request['i'];
        $data['ip'] = urldecode($this->request['data']['ip']);
        $data['pc'] = urldecode($this->request['data']['pc']);
        $this->Import['request'] = $this->request;

        if(!empty($data['i'])) {
            ## Save

            $e = $this->Form->setUpdateDefaultsImport($data);


            if ($e->validate() && !$extValidationErr) {
                $e->save();
                $this->request['i'] = json_encode($e->getPrimaryKey());


            }else{
                $PropelErrorHandler = new PropelErrorHandler($e, $this->request['data']['ui'],_('Form field'), $extValidationErr, $this->virtualClassName);
                $error = $PropelErrorHandler->getValidationErrors();
            }
        } else {
            ## Create


            $e = $this->Form->setCreateDefaultsImport($data);

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
        $this->Import['request'] = $this->request;
        $this->Import['parentId'] = $this->request['data']['ip'];


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



}
