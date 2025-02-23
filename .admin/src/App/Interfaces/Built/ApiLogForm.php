<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'ApiLog' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\FormHelper as Helper;

class ApiLogForm extends ApiLog
{

    use Helper;
    use \ApiGoat\ACL\AuthyACL;

    /**
    *   Virtual name of the object (class)
    */
    public $request = null;
    public $args = null;
    public $model_name = '';
    public $isChild;
    public $IdPk;
    public $in;
    public $TableName;
    public $tableDescription;
    public $uiTabsId;
    public $maxPerPage;
    public $childMaxPerPage;
    public $VirtualClassName;
    public $virtualClassName;
    public $listActionCell = '';

    public $setReadOnly;
    public $forceInlineEdit;
    public $forcePopUpEdit;
    public $arrayData;

    public $searchAr;
    public $searchMs;
    public $searchOrder;

    public $hookFormTop;
    public $hookFormInnerTop;
    public $hookFormBottom;
    public $hookFormInnerBottom;

    public $hookFormReadyJsFirst;
    public $hookFormReadyJs;
    public $hookFormIncludeJs;

    public $hookFormRoTop;
    public $hookFormRoBottom;

    public $hookChildListRoTop;
    public $hookChildListRoBottom;

    public $hookListTop;
    public $hookListBottom;
    public $hookListColumns;
    public $hookListSearchTop;
    public $hookListSearchButton;
    public $hookListReadyJs;
    public $hookListJs;
    public $hookListReadyJsFirst;
    public $setListRemoveDelete;
    public $hookSwHeader;
    public $printLink;
    public $formTitle;
    public $ccStdFormOptions;
    public $cCMainTableHeader;
    public $cCmoreColsHeader;
    public $hookLogin;

    public $canDelete;


    
    /**
    *   Ressource object for the database
    *   @type object
    **/
    public $pmpoData;

    /**
     * Constructor
     *
     * @param Request|array|null $request
     * @param array $args
     */
    function __construct(Request|array|null $request, array $args)
    {
        $this->request = $request;
        $this->args = $args;
        $this->model_name = 'ApiLog';
        $this->virtualClassName = 'ApiLog';
        $this->childMaxPerPage = (defined('app_child_max_per_page')) ? app_child_max_per_page : 30;
        $this->maxPerPage = (defined('app_max_per_page')) ? app_max_per_page : 50;
        $this->hookFormBottom = '';
        $this->hookFormReadyJs = '';
        
    }

    /**
     * function getListSearch
     * @param integer $IdParent
     * @param array $search
     * @return type
     */
    public function getListSearch($IdParent='', $search='')
    {
        $this->in = 'getListSearch';

        $q = new ApiLogQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                
                #required api_log
                ->leftJoinWith('ApiRbac');
                
                
        }else{
            
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                
                #required api_log
                ->leftJoinWith('ApiRbac');
                
            }
        }

        
            if(!empty($this->searchOrder)){
                $f=0;
                foreach($this->searchOrder as $order){
                    foreach($order as $col => $sens){
                        if($sens){
                            $tOrd = explode('.',$col);
                            if($tOrd[1]){
                                $q->join($tOrd[0]." order".$f);
                                $orderBy = "use".$tOrd[0]."Query";
                                $q->$orderBy("order".$f, 'left join')->orderBy($tOrd[1], $sens)->endUse();
                            }else{
                                $q->orderBy($col,$sens);
                            }
                            $this->orderReadyJsOrder .="
                                $(\"#ApiLogListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
                                    .attr('order', 'on').addClass('sorted');
                            ";
                        }
                        $f++;
                    }
                }
            }
            
        
        

        $this->pmpoData = $q;
        

        return $this->pmpoData;
    }

    /**
     * function getListHeader
     * @param string $act
     * @return string
     */
    public function getListHeader($act)
    {
        $this->in = 'getListHeader';
        $trSearch = '';
        $trHeadMod = '';

        switch($act) {
            case 'head':
                $trHead = th(_("API ACL model"), " th='sorted' c='ApiRbac.Model' title='"._('ApiRbac.Model')."' ")
.th(_('API ACL action'), "t='mc' th='sorted' c='ApiRbac.Action'").th(_('API ACL query'), "t='mc' th='sorted' c='ApiRbac.Query'").th(_("Time"), " th='sorted' c='Time' title='" . _('Time')."' ")
. $this->cCmoreColsHeader;
                if(!$this->setReadOnly){
                    $trHead .= th('&nbsp;',' class="actionrow delete" ');
                }
                $trHead = thead(tr($trHead));
                return $trHead;

            case 'list-button':
                $listButton = '';
                
                
                return $listButton;

            case 'search':
                
        $this->arrayIdApiRbacOptions = $this->selectBoxApiLog_IdApiRbac($this, $emptyVar, $data);
                
                ;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addApiLog' title='"._('Add')."' class='button-link-blue add-button'");
            }

            return $this->listAddButton;
            break;
            case 'quickadd':
                return $trHeadMod;
        }
    }

    /**
     * produce a list of table items
     * @param	string $uiTabsId	html destination container Id
     * @param	string $page		nbr. of line per pages
     * param	string $IdParent	Parent id (if necessary)
     * param	obj $pmpoDataIn	PropelModelPager reference to show instead of default search OR a standard propel collection
     * @param	array $search		search params for custom search query
     * 						[ms]	pre set with progXform/search_items behavior
     *					custom search
     *						[f]	filter	[v]	value	use by progXform/child_menu_query
     *						[u]	use		[f]	filter	[uv] use filter value
     * @return string
     */
    public function getList( $request, $uiTabsId = 'tabsContain', $IdParent = null , $pmpoDataIn = null)
    {
        $HelpDivJs = '';
        $HelpDiv = '';
        $this->in = 'getList';
        $this->isChild = '';
        $this->TableName = 'ApiLog';
        $altValue = array (
  'IdApiLog' => '',
  'IdApiRbac' => '',
  'IdAuthy' => '',
  'Time' => '',
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'ApiLog/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'ApiLog/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'ApiLog/');

        
        
        
        
        
        

        $maxPerPage = $this->maxPerPage;

        if(empty($pmpoDataIn)) {
            $pmpoData = $this->getListSearch($IdParent, $search);
            $pmpoData = $pmpoData->paginate($search['page'], $maxPerPage);
            $resultsCount = $pmpoData->getNbResults();

        }else{
            $pmpoData = $pmpoDataIn;
        }

        $trHead = $this->getListHeader('head');

        if( $pmpoData->isEmpty() ) {
            $tr .= tr(	td(p(span(_("Nothing here at the moment")),'class="no-results"'), "t='empty' colspan='100%' "));

        }else{
            if( get_class($pmpoData) == 'PropelModelPager' ) {
                $pcData = $pmpoData->getResults();
            }else{
                $pcData = $pmpoData;
            }

            $this->arrayData = $pcData->toArray();

            /**
            *	Main list loop
            **/
            $i=0;
            
            if(!$this->setReadOnly && !$this->setListRemoveDelete){
                if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteApiLog' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
        $altValue['ApiRbac_Model'] = "";
        if($data->getApiRbac()){
            $altValue['ApiRbac_Model'] = $data->getApiRbac()->getModel();
        }
        $altValue['ApiRbac_Action'] = "";
        if($data->getApiRbac()){
            $altValue['ApiRbac_Action'] = $data->getApiRbac()->getAction();
        }
        $altValue['ApiRbac_Query'] = "";
        if($data->getApiRbac()){
            $altValue['ApiRbac_Query'] = $data->getApiRbac()->getQuery();
        }
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span(((isset($altValue['IdApiRbac']) && !empty($altValue['IdApiRbac'])) ? $altValue['IdApiRbac'] : $altValue['ApiRbac_Model'])." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdApiRbac' class=''  j='editApiLog'") . td(span($altValue['ApiRbac_Action'].""), " c='ApiRbac__Action' j='editApiLog' i='".json_encode($data->getPrimaryKey())."'").
                            td(span($altValue['ApiRbac_Query'].""), " c='ApiRbac__Query' j='editApiLog' i='".json_encode($data->getPrimaryKey())."'").
                            
                td(span(((isset($altValue['Time']) && !empty($altValue['Time'])) ? $altValue['Time'] : $data->getTime())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Time' class=''  j='editApiLog'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='ApiLogRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountApiLog', $i);
        }

        

        ## @Paging
        $pagerRow = $this->getPager($pmpoData, $resultsCount, $search);
        $bottomRow = div($pagerRow,'bottomPagerRow', "class='tablesorter'");

        

        $controlsContent = $this->getListHeader('list-button');

        $return['html'] =
            $this->hookListTop
            .div(
                href(span(_('Open/close menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                .$this->getListHeader('add')
                
                .div($controlsContent,'ApiLogControlsList', "class='custom-controls'")
                .$this->hookSwHeader.$HelpDiv
            ,'','class="sw-header"')

            .$this->getListHeader('search')
            /*.div(
                $this->getListHeader('add')
                .button('', 'class="scroll-top" type="button"')
            , '' ,'class="ac-list-form-header ac-show-scroll"')*/
            .div(
                input('hidden', 'rowCount', $i, "s='d'")
                .input('hidden', 'ip', $IdParent, "s='d'")
                 .div(
                     div(
                        table($trHead.$tr, "id='ApiLogTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'ApiLogListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#ApiLogListForm td[j='editApiLog']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#ApiLogListForm [j='deleteApiLog']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#ApiLogPager').bindPaging({
            tableName:'ApiLog'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        
        
        
        $('#tabsContain .js-select-label').SelectBox();
        ".$this->hookListReadyJsFirst.$editEvent."
       $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'".$this->virtualClassName."',
            destUi:'".$uiTabsId."'
        });

        if($('#addApiLogAutoc').length > 0) {
            $('#addApiLogAutoc').bind('click', function () {
                $.post('"._SITE_URL."GuiManager', {a:'ixmemautoc', p:'{$this->virtualClassName}',}, function(data) {
                    document.location = '"._SITE_URL.$this->virtualClassName."/edit/';
                });
            });
        }
        
        
        ".$this->orderReadyJsOrder."
        ".$this->hookListReadyJs;
        
        $return['js'] .= script("". $this->hookListJs);
        return $return;
    }
    /*
    *	Make sure default value are set before save
    */
    public function setCreateDefaultsApiLog($data)
    {

        unset($data['IdApiLog']);
        $e = new ApiLog();
        
        
        $e->fromArray($data );

        #
        
        //foreign
        $e->setIdAuthy(( $data['IdAuthy'] == '' ) ? null : $data['IdAuthy']);
        $e->setTime( ($data['Time'] == '' || $data['Time'] == 'null' || substr($data['Time'], 0, 10) == '-0001-11-30')?date('Y-m-d'):$data['Time'] );
        #
        
        return $e;
    }

    /*
    *	Make sure default value are set before save
    */
    public function setUpdateDefaultsApiLog($data)
    {

        
        $e = ApiLogQuery::create()->findPk(json_decode($data['i']));
        
        
        $e->fromArray($data );

        
        
        if( isset($data['IdAuthy']) ){
            $e->setIdAuthy(( $data['IdAuthy'] == '' ) ? null : $data['IdAuthy']);
        }
        if(isset($data['Time'])){
            $e->setTime( ($data['Time'] == '' || $data['Time'] == 'null' || substr($data['Time'], 0, 10) == '-0001-11-30') ? null : $data['Time'] );
        }
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of ApiLog
     * @param	string $id			PrimaryKey of the record to show
     * @param	string $uiTabsId	Present everywhere, javascript id of the html container
     * @param	string $data 		If present, will skip the query and show the data
     * @param	array $error			Error to display
     * @param	array $jsElement		container to append new event results
     * @param	array $jsElementType	container type to append new event results
     * @return	array standard html retrun array
    */

    public function getEditForm($id, $uiTabsId = 'tabsContain', $data=[], $error=[], $jsElement='', $jsElementType='')
    {
        $this->in = "getEditForm";

        $HelpDivJs = '';
        $HelpDiv = '';
        $childTable = [];
        $script_autoc_one = '';
        $ongletf = '';
        $mceInclude = '';
        $ip_save = '';
        $ip_save = '';
        $IdParent = 0;
        $editDialog = ( $data['dialog'] ) ? $data['dialog'] : 'editDialog';
        $uiTabsId = ( $uiTabsId === null ) ? 'tabsContain' : $uiTabsId;
        $jet = 'tr';

        $je = "ApiLogTable";

        if($jsElement)	{
            $je = $jsElement;
        }

        if($jsElementType)	{
            $jet = $jsElementType;
        }

        if($data['data']['ip']){
            $data['ip'] = $data['data']['ip'];
            $data['pc'] = $data['data']['pc'];
            $data['tp'] = $data['data']['tp'];
        }

        if($data['pc']) {
            switch($data['pc']){
                
                case 'ApiRbac':
                    $data['IdApiRbac'] = $data['ip'];
                    break;
                case 'Authy':
                    $data['IdAuthy'] = $data['ip'];
                    break;
            }
            $IdParent = $data['ip'];
        }

        if($error == ''){
            unset($error);
        }

        

        // save button and action
        $this->SaveButtonJs = "";
        if(($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'w') and $id) || $this->setReadOnly) {
            $this->SaveButtonJs = "
            $('#form" . $this->virtualClassName . " #save" . $this->virtualClassName . "').bindSave({
                modelName: '" . $this->virtualClassName . "',
                destUi: '" . $uiTabsId . "',
                pc:'" . $data['pc'] . "',
                ip:'" . $IdParent . "',
                je:'" . $jsElement . "',
                jet:'" . $jsElementType . "',
                tp:'" . $data['tp'] . "',
                dialog:'" . $editDialog . "'
            });
        ";
        }else{
            $this->SaveButtonJs = "
                $('#formApiLog #saveApiLog').unbind('click.saveApiLog');
                $('#formApiLog #saveApiLog').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addApiLog' title='"._('Add')."' class='button-link-blue add-button'");
            $this->bindEditJs = "$('.sw-header #add" . $this->virtualClassName . "').bindEdit({
                modelName: '" . $this->virtualClassName . "',
                destUi: '" . $uiTabsId . "',
                pc:'" . $data['pc'] . "',
                ip:'" . $IdParent . "',
                je:'" . $jsElement . "',
                jet:'" . $jsElementType . "'
            });";
        }

        if($id && !$data['reload']) {
            

            $q = ApiLogQuery::create()
            
                #required api_log
                ->leftJoinWith('ApiRbac')
            ;
            


            $dataObj = $q->filterByIdApiLog($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->ApiLog['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new ApiLog();
            $this->ApiLog['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->ApiLog['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


                                    ($dataObj->getApiRbac())?'':$dataObj->setApiRbac( new ApiRbac() );

        
        $this->arrayIdApiRbacOptions = $this->selectBoxApiLog_IdApiRbac($this, $dataObj, $data);
        
        
        
        
        
        
$this->fields['ApiLog']['IdApiRbac']['html'] = stdFieldRow(_("Rule"), selectboxCustomArray('IdApiRbac', $this->arrayIdApiRbacOptions, "", "v='ID_API_RBAC'  s='d'  val='".$dataObj->getIdApiRbac()."'", $dataObj->getIdApiRbac()), 'IdApiRbac', "", $this->commentsIdApiRbac, $this->commentsIdApiRbac_css, '', ' ', 'no');
$this->fields['ApiLog']['Time']['html'] = stdFieldRow(_("Time"), input('datetime-local', 'Time', $dataObj->getTime(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD hh:mm:ss' size='30'  s='d' class='req' title='Time'"), 'Time', "", $this->commentsTime, $this->commentsTime_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveApiLog', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedApiLog','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdApiLog', $dataObj->getIdApiLog(), " s='d' pk").input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " s='d' nodesc")
                            .$this->hookListSearchButton
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        

        //Form header
        $header_top = div(
                            div(href(span(_('Display/Hide menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                        .$this->formAddButton,'','class="default-controls"')
                        .$this->printLink
                            .$this->hookSwHeader.$HelpDiv
                        , '', 'class="sw-header"');
        $header_top_onglet = $this->formTitle.$ongletf;

        /*if(!isMobile()) {
            $jqueryDatePicker = " $(\"#formApiLog [j='date']\").attr('type', 'text');
            $(\"#formApiLog [j='date']\").each(function(){
                $(this).datepicker({dateFormat: 'yy-mm-dd ',changeYear: true, changeMonth: true, yearRange: '1940:2040', showOtherMonths: true, selectOtherMonths: true});
            });";
        }*/

        // Form
        $return['html'] =
        $this->hookFormTop
        .$mceInclude
        .$header_top
        .form(

            div(
                div('API log', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['ApiLog']['IdApiRbac']['html']
.$this->fields['ApiLog']['Time']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntApiLog", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formApiLog' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['ApiLog']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['ApiLog']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['ApiLog']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['ApiLog']['ixmemautocapp'];
            unset($_SESSION['mem']['ApiLog']['ixmemautocapp']);
        }

        $return['data'] .= $data;
        $return['js'] .= $childTable['js']
        . script($this->hookFormIncludeJs) ."
        ";

        $return['onReadyJs'] =
        $this->hookFormReadyJsFirst.
        "
        
        ".$jqueryDatePicker."
        $('#ui-datepicker-div').css('font-size', '12px');
        ".$this->bindEditJs."
        ".$this->SaveButtonJs."
        
        ".$childTable['onReadyJs']."
        ".$error['onReadyJs']."
        if($('#form" . $this->virtualClassName . "').inDialog()){
            $('.ui-dialog .sw-header').remove();
        }
        if($('#loader').css('display') == 'block') {
            $('#loader').hide();
        }
        ".$tabs_act."
        ".$this->hookFormReadyJs
        .$script_autoc_one
        .$HelpDivJs."

        setTimeout(function() {
            $(\"#formApiLog [s='d'], #formApiLog .js-select-label, #formApiLog [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formApiLog .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['ApiLog']['IdApiRbac']['html'] = stdFieldRow(_("Rule"), div( ($dataObj->getApiRbac())?$dataObj->getApiRbac()->getModel():'', 'IdApiRbac_label' , "class='readonly' s='d'")
                .input('hidden', 'IdApiRbac', $dataObj->getIdApiRbac(), "s='d'"), 'IdApiRbac', "", $this->commentsIdApiRbac, $this->commentsIdApiRbac_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiLog']['Time']['html'] = stdFieldRow(_("Time"), div( $dataObj->getTime(), 'Time_label' , "class='readonly' s='d'")
                .input('hidden', 'Time', $dataObj->getTime(), "s='d'"), 'Time', "", $this->commentsTime, $this->commentsTime_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['ApiLog'] as $field => $ar) {
                $this->fields['ApiLog'][$field]['html'] = $this->fieldsRo['ApiLog'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['ApiLog'][$field]['html'] = $this->fieldsRo['ApiLog'][$field]['html'];
            }
        }
    }

    /**
     * Query for ApiLog_IdApiRbac selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxApiLog_IdApiRbac(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = ApiRbacQuery::create();

            $q->addAsColumn('selDisplay', 'CONCAT_WS ( ", ", '.ApiRbacPeer::MODEL.', '.ApiRbacPeer::ACTION.', '.ApiRbacPeer::QUERY.' )');
            $q->select(array('selDisplay', 'IdApiRbac'));
            $q->orderBy('selDisplay', 'ASC');
        
            if(!$array){
                return $q;
            }else{
                $pcDataO = $q->find();
            }


        
        if($override === false){
            $arrayOpt = $pcDataO->toArray();

            return assocToNum($arrayOpt , true);;
        }else{
            return $override;
        }
}
}
