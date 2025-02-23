<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'AuthyLog' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\FormHelper as Helper;

class AuthyLogForm extends AuthyLog
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
        $this->model_name = 'AuthyLog';
        $this->virtualClassName = 'AuthyLog';
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

        $q = new AuthyLogQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                ;
                
                
        }else{
            
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                ;
                
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
                                $(\"#AuthyLogListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Date"), " th='sorted' c='Timestamp' title='" . _('Date')."' ")
.th(_("Username"), " th='sorted' c='Login' title='" . _('Username')."' ")
.th(_("Ip"), " th='sorted' c='Ip' title='" . _('Ip')."' ")
.th(_("Count"), " th='sorted' c='Count' title='" . _('Count')."' ")
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
                
                
                ;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addAuthyLog' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'AuthyLog';
        $altValue = array (
  'IdAuthyLog' => '',
  'IdAuthy' => '',
  'Timestamp' => '',
  'Login' => '',
  'Userid' => '',
  'Result' => '',
  'Ip' => '',
  'Count' => '',
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'AuthyLog/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'AuthyLog/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'AuthyLog/');

        
        
        $default_order[]['Timestamp']='DESC';
        if(empty($this->searchOrder)){
            $this->searchOrder = $default_order;
        }
        
        
        
        

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
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAuthyLog' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span(((isset($altValue['Timestamp']) && !empty($altValue['Timestamp'])) ? $altValue['Timestamp'] : $data->getTimestamp())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Timestamp' class=''  j='editAuthyLog'") . 
                td(span(((isset($altValue['Login']) && !empty($altValue['Login'])) ? $altValue['Login'] : $data->getLogin())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Login' class=''  j='editAuthyLog'") . 
                td(span(((isset($altValue['Ip']) && !empty($altValue['Ip'])) ? $altValue['Ip'] : $data->getIp())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Ip' class=''  j='editAuthyLog'") . 
                td(span(((isset($altValue['Count']) && !empty($altValue['Count'])) ? $altValue['Count'] : $data->getCount())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Count' class=''  j='editAuthyLog'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='AuthyLogRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountAuthyLog', $i);
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
                
                .div($controlsContent,'AuthyLogControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='AuthyLogTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'AuthyLogListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#AuthyLogListForm td[j='editAuthyLog']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#AuthyLogListForm [j='deleteAuthyLog']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#AuthyLogPager').bindPaging({
            tableName:'AuthyLog'
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

        if($('#addAuthyLogAutoc').length > 0) {
            $('#addAuthyLogAutoc').bind('click', function () {
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
    public function setCreateDefaultsAuthyLog($data)
    {

        unset($data['IdAuthyLog']);
        $e = new AuthyLog();
        
        
        $e->fromArray($data );

        #
        
        //foreign
        $e->setIdAuthy(( $data['IdAuthy'] == '' ) ? null : $data['IdAuthy']);
        $e->setTimestamp( ($data['Timestamp'] == '' || $data['Timestamp'] == 'null' || substr($data['Timestamp'],0,10) == '-0001-11-30') ? null : $data['Timestamp'] );
        //integer not required
        $e->setUserid( ($data['Userid'] == '' ) ? null : $data['Userid']);
        //integer not required
        $e->setCount( ($data['Count'] == '' ) ? null : $data['Count']);
        #
        
        return $e;
    }

    /*
    *	Make sure default value are set before save
    */
    public function setUpdateDefaultsAuthyLog($data)
    {

        
        $e = AuthyLogQuery::create()->findPk(json_decode($data['i']));
        
        
        $e->fromArray($data );

        
        
        if( isset($data['IdAuthy']) ){
            $e->setIdAuthy(( $data['IdAuthy'] == '' ) ? null : $data['IdAuthy']);
        }
        if(isset($data['Timestamp'])){
            $e->setTimestamp( ($data['Timestamp'] == '' || $data['Timestamp'] == 'null' || substr($data['Timestamp'],0,10) == '-0001-11-30') ? null : $data['Timestamp'] );
        }
        if(isset($data['Userid'])){
            $e->setUserid( ($data['Userid'] == '' ) ? null : $data['Userid']);
        }
        if(isset($data['Count'])){
            $e->setCount( ($data['Count'] == '' ) ? null : $data['Count']);
        }
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of AuthyLog
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

        $je = "AuthyLogTable";

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
        if(($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'w') and $id) || $this->setReadOnly) {
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
                $('#formAuthyLog #saveAuthyLog').unbind('click.saveAuthyLog');
                $('#formAuthyLog #saveAuthyLog').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addAuthyLog' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = AuthyLogQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdAuthyLog($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->AuthyLog['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new AuthyLog();
            $this->AuthyLog['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->AuthyLog['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        



        
        
        
        
        
        
        
$this->fields['AuthyLog']['Timestamp']['html'] = stdFieldRow(_("Date"), input('datetime-local', 'Timestamp', $dataObj->getTimestamp(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD hh:mm:ss' size='30'  s='d' class='' title='Date'"), 'Timestamp', "", $this->commentsTimestamp, $this->commentsTimestamp_css, '', ' ', 'no');
$this->fields['AuthyLog']['Login']['html'] = stdFieldRow(_("Username"), input('text', 'Login', htmlentities($dataObj->getLogin()), "   placeholder='".str_replace("'","&#39;",_('Username'))."' size='35'  v='LOGIN' s='d' class='req'  ")."", 'Login', "", $this->commentsLogin, $this->commentsLogin_css, '', ' ', 'no');
$this->fields['AuthyLog']['Ip']['html'] = stdFieldRow(_("Ip"), input('text', 'Ip', htmlentities($dataObj->getIp()), "   placeholder='".str_replace("'","&#39;",_('Ip'))."' size='15'  v='IP' s='d' class='req'  ")."", 'Ip', "", $this->commentsIp, $this->commentsIp_css, '', ' ', 'no');
$this->fields['AuthyLog']['Count']['html'] = stdFieldRow(_("Count"), input('number', 'Count', $dataObj->getCount(), " step='1' placeholder='".str_replace("'","&#39;",_('Count'))."' v='COUNT' size='0' s='d' class=''"), 'Count', "", $this->commentsCount, $this->commentsCount_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveAuthyLog', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedAuthyLog','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdAuthyLog', $dataObj->getIdAuthyLog(), " s='d' pk").input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " s='d' nodesc").input('hidden', 'Userid', $dataObj->getUserid(), "   v='USERID' size='0' s='d' class=''")
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
            $jqueryDatePicker = " $(\"#formAuthyLog [j='date']\").attr('type', 'text');
            $(\"#formAuthyLog [j='date']\").each(function(){
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
                div('Login log', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['AuthyLog']['Timestamp']['html']
.$this->fields['AuthyLog']['Login']['html']
.$this->fields['AuthyLog']['Ip']['html']
.$this->fields['AuthyLog']['Count']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntAuthyLog", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formAuthyLog' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['AuthyLog']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['AuthyLog']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['AuthyLog']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['AuthyLog']['ixmemautocapp'];
            unset($_SESSION['mem']['AuthyLog']['ixmemautocapp']);
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
            $(\"#formAuthyLog [s='d'], #formAuthyLog .js-select-label, #formAuthyLog [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formAuthyLog .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['AuthyLog']['Timestamp']['html'] = stdFieldRow(_("Date"), div( $dataObj->getTimestamp(), 'Timestamp_label' , "class='readonly' s='d'")
                .input('hidden', 'Timestamp', $dataObj->getTimestamp(), "s='d'"), 'Timestamp', "", $this->commentsTimestamp, $this->commentsTimestamp_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyLog']['Login']['html'] = stdFieldRow(_("Username"), div( $dataObj->getLogin(), 'Login_label' , "class='readonly' s='d'")
                .input('hidden', 'Login', $dataObj->getLogin(), "s='d'"), 'Login', "", $this->commentsLogin, $this->commentsLogin_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyLog']['Ip']['html'] = stdFieldRow(_("Ip"), div( $dataObj->getIp(), 'Ip_label' , "class='readonly' s='d'")
                .input('hidden', 'Ip', $dataObj->getIp(), "s='d'"), 'Ip', "", $this->commentsIp, $this->commentsIp_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyLog']['Count']['html'] = stdFieldRow(_("Count"), div( $dataObj->getCount(), 'Count_label' , "class='readonly' s='d'")
                .input('hidden', 'Count', $dataObj->getCount(), "s='d'"), 'Count', "", $this->commentsCount, $this->commentsCount_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['AuthyLog'] as $field => $ar) {
                $this->fields['AuthyLog'][$field]['html'] = $this->fieldsRo['AuthyLog'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['AuthyLog'][$field]['html'] = $this->fieldsRo['AuthyLog'][$field]['html'];
            }
        }
    }
}
