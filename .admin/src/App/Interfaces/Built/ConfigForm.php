<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Config' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\FormHelper as Helper;

class ConfigForm extends Config
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
        $this->model_name = 'Config';
        $this->virtualClassName = 'Config';
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

        $q = new ConfigQuery();
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
                                $(\"#ConfigListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Category"), " th='sorted' c='Category' title='" . _('Category')."' ")
.th(_("Setting"), " th='sorted' c='Config' title='" . _('Setting')."' ")
.th(_("Value"), " th='sorted' c='Value' title='" . _('Value')."' ")
.th(_("Description"), " th='sorted' c='Description' title='" . _('Description')."' ")
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
                if($_SESSION[_AUTH_VAR]->hasRights('Config', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addConfig' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'Config';
        $altValue = array (
  'IdConfig' => NULL,
  'Category' => NULL,
  'Config' => NULL,
  'Value' => NULL,
  'System' => NULL,
  'Description' => NULL,
  'Type' => NULL,
  'DateCreation' => NULL,
  'DateModification' => NULL,
  'IdGroupCreation' => NULL,
  'IdCreation' => NULL,
  'IdModification' => NULL,
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Config/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Config/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Config/');

        
        
        
        
        
        

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
                if($_SESSION[_AUTH_VAR]->hasRights('Config', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteConfig' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Category'] !== null ) ? $altValue['Category'] : isntPo($data->getCategory()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Category' class='center'  j='editConfig'") . 
                td(span((($altValue['Config'] !== null ) ? $altValue['Config'] : $data->getConfig())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Config' class=''  j='editConfig'") . 
                td(span((($altValue['Value'] !== null ) ? $altValue['Value'] : substr(strip_tags($data->getValue()), 0, 100))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Value' class=''  j='editConfig'") . 
                td(span((($altValue['Description'] !== null ) ? $altValue['Description'] : $data->getDescription())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Description' class=''  j='editConfig'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='ConfigRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                $altValue = null;
            }
            $tr .= input('hidden', 'rowCountConfig', $i);
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
                
                .div($controlsContent,'ConfigControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='ConfigTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'ConfigListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#ConfigListForm td[j='editConfig']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#ConfigListForm [j='deleteConfig']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#ConfigPager').bindPaging({
            tableName:'Config'
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

        if($('#addConfigAutoc').length > 0) {
            $('#addConfigAutoc').bind('click', function () {
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
    public function setCreateDefaultsConfig($data)
    {

        unset($data['IdConfig']);
        $e = new Config();
        
        
        if(!$data['Category']){
            $data['Category'] = "General";
        } 
        if( $data['System'] == '' )unset($data['System']);
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setValue( ($data['Value'] == '' ) ? null : $data['Value']);
        $e->setSystem(($data['System'] == '' ) ? null : $data['System']);
        //integer not required
        $e->setDescription( ($data['Description'] == '' ) ? null : $data['Description']);
        //integer not required
        $e->setType( ($data['Type'] == '' ) ? null : $data['Type']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30') ? null : $data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30') ? null : $data['DateModification'] );
        //foreign
        $e->setIdGroupCreation(( $data['IdGroupCreation'] == '' ) ? null : $data['IdGroupCreation']);
        //foreign
        $e->setIdCreation(( $data['IdCreation'] == '' ) ? null : $data['IdCreation']);
        //foreign
        $e->setIdModification(( $data['IdModification'] == '' ) ? null : $data['IdModification']);
        #
        
        return $e;
    }

    /*
    *	Make sure default value are set before save
    */
    public function setUpdateDefaultsConfig($data)
    {

        
        $e = ConfigQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!$data['Category']){
            $data['Category'] = "General";
        } 
        if( $data['System'] == '' )unset($data['System']);
        $e->fromArray($data );

        
        
        if(isset($data['System'])){
            $e->setSystem(($data['System'] == '' ) ? null : $data['System']);
        }
        if(isset($data['DateCreation'])){
            $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30') ? null : $data['DateCreation'] );
        }
        if(isset($data['DateModification'])){
            $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30') ? null : $data['DateModification'] );
        }
        if( isset($data['IdGroupCreation']) ){
            $e->setIdGroupCreation(( $data['IdGroupCreation'] == '' ) ? null : $data['IdGroupCreation']);
        }
        if( isset($data['IdCreation']) ){
            $e->setIdCreation(( $data['IdCreation'] == '' ) ? null : $data['IdCreation']);
        }
        if( isset($data['IdModification']) ){
            $e->setIdModification(( $data['IdModification'] == '' ) ? null : $data['IdModification']);
        }
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Config
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

        $je = "ConfigTable";

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
                
                case 'AuthyGroup':
                    $data['IdGroupCreation'] = $data['ip'];
                    break;
                case 'Authy':
                    $data['IdModification'] = $data['ip'];
                    break;
            }
            $IdParent = $data['ip'];
        }

        if($error == ''){
            unset($error);
        }

        

        // save button and action
        $this->SaveButtonJs = "";
        if(($_SESSION[_AUTH_VAR]->hasRights('Config', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Config', 'w') and $id) || $this->setReadOnly) {
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
                $('#formConfig #saveConfig').unbind('click.saveConfig');
                $('#formConfig #saveConfig').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Config', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addConfig' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = ConfigQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdConfig($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Config['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Config();
            $this->Config['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Config['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        



        
        
        
        
        
        
        
$this->fields['Config']['Category']['html'] = stdFieldRow(_("Category"), selectboxCustomArray('Category', array( '0' => array('0'=>_("General"), '1'=>"General"),'1' => array('0'=>_("API"), '1'=>"API"),'2' => array('0'=>_("Control panel"), '1'=>"Control panel"), ), "", "s='d'  ", $dataObj->getCategory(), '', false), 'Category', "", $this->commentsCategory, $this->commentsCategory_css, '', ' ', 'no');
$this->fields['Config']['Config']['html'] = stdFieldRow(_("Setting"), input('text', 'Config', htmlentities($dataObj->getConfig()), "   placeholder='".str_replace("'","&#39;",_('Setting'))."' size='35'  v='CONFIG' s='d' class='req'  ")."", 'Config', "", $this->commentsConfig, $this->commentsConfig_css, '', ' ', 'no');
$this->fields['Config']['Value']['html'] = stdFieldRow(_("Value"), textarea('Value', htmlentities($dataObj->getValue()) ,"placeholder='".str_replace("'","&#39;",_('Value'))."' cols='71' v='VALUE' s='d'  class=' ' style='' spellcheck='false'"), 'Value', "", $this->commentsValue, $this->commentsValue_css, '', ' ', 'no');
$this->fields['Config']['Description']['html'] = stdFieldRow(_("Description"), input('text', 'Description', htmlentities($dataObj->getDescription()), "   placeholder='".str_replace("'","&#39;",_('Description'))."' size='35'  v='DESCRIPTION' s='d' class=''  ")."", 'Description', "", $this->commentsDescription, $this->commentsDescription_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveConfig', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedConfig','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdConfig', $dataObj->getIdConfig(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formConfig [j='date']\").attr('type', 'text');
            $(\"#formConfig [j='date']\").each(function(){
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
                div('Setting', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['Config']['Category']['html']
.$this->fields['Config']['Config']['html']
.$this->fields['Config']['Value']['html']
.$this->fields['Config']['Description']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntConfig", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formConfig' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['Config']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Config']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Config']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Config']['ixmemautocapp'];
            unset($_SESSION['mem']['Config']['ixmemautocapp']);
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
            $(\"#formConfig [s='d'], #formConfig .js-select-label, #formConfig [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formConfig .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Config']['Category']['html'] = stdFieldRow(_("Category"), div( $dataObj->getCategory(), 'Category_label' , "class='readonly' s='d'")
                .input('hidden', 'Category', $dataObj->getCategory(), "s='d'"), 'Category', "", $this->commentsCategory, $this->commentsCategory_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Config']['Config']['html'] = stdFieldRow(_("Setting"), div( $dataObj->getConfig(), 'Config_label' , "class='readonly' s='d'")
                .input('hidden', 'Config', $dataObj->getConfig(), "s='d'"), 'Config', "", $this->commentsConfig, $this->commentsConfig_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Config']['Value']['html'] = stdFieldRow(_("Value"), div( $dataObj->getValue(), 'Value_label' , "class='readonly' s='d'")
                .input('hidden', 'Value', $dataObj->getValue(), "s='d'"), 'Value', "", $this->commentsValue, $this->commentsValue_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Config']['Description']['html'] = stdFieldRow(_("Description"), div( $dataObj->getDescription(), 'Description_label' , "class='readonly' s='d'")
                .input('hidden', 'Description', $dataObj->getDescription(), "s='d'"), 'Description', "", $this->commentsDescription, $this->commentsDescription_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Config'] as $field => $ar) {
                $this->fields['Config'][$field]['html'] = $this->fieldsRo['Config'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Config'][$field]['html'] = $this->fieldsRo['Config'][$field]['html'];
            }
        }
    }
}
