<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Template' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class TemplateForm extends Template
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
        $this->model_name = 'Template';
        $this->virtualClassName = 'Template';
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

        $q = new TemplateQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                ;

        if( isset($this->searchMs['Name']) ) {
            $criteria = \Criteria::LIKE;


            $value = $this->setCriteria($this->searchMs['Name'], $criteria);

            $q->filterByName($value, $criteria);
        }
                
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
                                $(\"#TemplateListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Name"), " th='sorted' c='Name' title='" . _('Name')."' ")
.th(_("Subject"), " th='sorted' c='Subject' title='" . _('Subject')."' ")
.th(_("Status"), " th='sorted' c='Status' title='" . _('Status')."' ")
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
                
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(input('text', 'Name', $this->searchMs['Name'], '  title="'._('Name').'" placeholder="'._('Name').'"',''),'','class="ac-search-item"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msTemplateBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msTemplateBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsTemplate'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('Template', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addTemplate' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'Template';
        $altValue = array (
  'IdTemplate' => '',
  'Name' => '',
  'Subject' => '',
  'Color1' => '',
  'Color2' => '',
  'Color3' => '',
  'Status' => '',
  'Body' => '',
  'DateCreation' => '',
  'DateModification' => '',
  'IdGroupCreation' => '',
  'IdCreation' => '',
  'IdModification' => '',
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Template/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Template/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Template/');

        
        
        $default_order[]['DateCreation']='DESC';
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
                if($_SESSION[_AUTH_VAR]->hasRights('Template', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteTemplate' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Name']) ? $altValue['Name'] : $data->getName()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Name' class=''  j='editTemplate'") . 
                td(span((($altValue['Subject']) ? $altValue['Subject'] : $data->getSubject()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Subject' class=''  j='editTemplate'") . 
                td(span((($altValue['Status']) ? $altValue['Status'] : isntPo($data->getStatus())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Status' class='center'  j='editTemplate'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='TemplateRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountTemplate', $i);
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
                
                .div($controlsContent,'TemplateControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='TemplateTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'TemplateListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#TemplateListForm td[j='editTemplate']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#TemplateListForm [j='deleteTemplate']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#TemplatePager').bindPaging({
            tableName:'Template'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msTemplateBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msTemplateBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsTemplate').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsTemplate .js-select-label').SelectBox();
            $('#formMsTemplate input[type=text]').first().focus();
            $('#formMsTemplate input[type=text]').first().putCursorAtEnd();
            $('#msTemplateBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsTemplate').keydown(function(e) {
        if(e.which == 13) {
            $('#msTemplateBt').click();
        }
    });

    $('#msTemplateBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsTemplate input[type=text]:first-of-type').focus().putCursorAtEnd();
                sw_message_remove('search-reset');
        });

        return false;
    });
        
        
        $('#tabsContain .js-select-label').SelectBox();
        ".$this->hookListReadyJsFirst.$editEvent."
       $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'".$this->virtualClassName."',
            destUi:'".$uiTabsId."'
        });

        if($('#addTemplateAutoc').length > 0) {
            $('#addTemplateAutoc').bind('click', function () {
                $.post('"._SITE_URL."GuiManager', {a:'ixmemautoc', p:'{$this->virtualClassName}',}, function(data) {
                    document.location = '"._SITE_URL.$this->virtualClassName."/edit/';
                });
            });
        }
        
        
        ".$this->orderReadyJsOrder."
        ".$this->hookListReadyJs;
        $return['js'] .= "";
        return $return;
    }
    /*
    *	Make sure default value are set before save
    */
    public function setCreateDefaultsTemplate($data)
    {

        unset($data['IdTemplate']);
        $e = new Template();
        
        
        if(!$data['Status']){
            $data['Status'] = "Active";
        } 
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setSubject( ($data['Subject'] == '' ) ? null : $data['Subject']);
        //integer not required
        $e->setColor1( ($data['Color1'] == '' ) ? null : $data['Color1']);
        //integer not required
        $e->setColor2( ($data['Color2'] == '' ) ? null : $data['Color2']);
        //integer not required
        $e->setColor3( ($data['Color3'] == '' ) ? null : $data['Color3']);
        //integer not required
        $e->setBody( ($data['Body'] == '' ) ? null : $data['Body']);
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
    public function setUpdateDefaultsTemplate($data)
    {

        
        $e = TemplateQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!$data['Status']){
            $data['Status'] = "Active";
        } 
        $e->fromArray($data );

        
        
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
     * Produce a formated form of Template
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

        $je = "TemplateTable";

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
        if(($_SESSION[_AUTH_VAR]->hasRights('Template', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Template', 'w') and $id) || $this->setReadOnly) {
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
                $('#formTemplate #saveTemplate').unbind('click.saveTemplate');
                $('#formTemplate #saveTemplate').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Template', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addTemplate' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = TemplateQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdTemplate($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Template['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Template();
            $this->Template['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Template['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        



        
        
        
        
        
        
        
$this->fields['Template']['Name']['html'] = stdFieldRow(_("Name"), input('text', 'Name', htmlentities($dataObj->getName()), "   placeholder='".str_replace("'","&#39;",_('Name'))."' size='35'  v='NAME' s='d' class='req'  ")."", 'Name', "", $this->commentsName, $this->commentsName_css, '', ' ', 'no');
$this->fields['Template']['Subject']['html'] = stdFieldRow(_("Subject"), input('text', 'Subject', htmlentities($dataObj->getSubject()), "   placeholder='".str_replace("'","&#39;",_('Subject'))."' size='69'  v='SUBJECT' s='d' class=''  ")."", 'Subject', "", $this->commentsSubject, $this->commentsSubject_css, '', ' ', 'no');
$this->fields['Template']['Color1']['html'] = stdFieldRow(_("Color 1"), input('text', 'Color1', htmlentities($dataObj->getColor1()), "   placeholder='".str_replace("'","&#39;",_('Color 1'))."' size='15'  v='COLOR_1' s='d' class=''  ")."", 'Color1', "", $this->commentsColor1, $this->commentsColor1_css, '', ' ', 'no');
$this->fields['Template']['Color2']['html'] = stdFieldRow(_("Color 2"), input('text', 'Color2', htmlentities($dataObj->getColor2()), "   placeholder='".str_replace("'","&#39;",_('Color 2'))."' size='15'  v='COLOR_2' s='d' class=''  ")."", 'Color2', "", $this->commentsColor2, $this->commentsColor2_css, '', ' ', 'no');
$this->fields['Template']['Color3']['html'] = stdFieldRow(_("Color 3"), input('text', 'Color3', htmlentities($dataObj->getColor3()), "   placeholder='".str_replace("'","&#39;",_('Color 3'))."' size='15'  v='COLOR_3' s='d' class=''  ")."", 'Color3', "", $this->commentsColor3, $this->commentsColor3_css, '', ' ', 'no');
$this->fields['Template']['Status']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Status', array( '0' => array('0'=>_("Active"), '1'=>"Active"),'1' => array('0'=>_("Inactive"), '1'=>"Inactive"), ), "", "s='d'  ", $dataObj->getStatus(), '', false), 'Status', "", $this->commentsStatus, $this->commentsStatus_css, '', ' ', 'no');
$this->fields['Template']['Body']['html'] = stdFieldRow(_("Body"), textarea('Body', htmlentities($dataObj->getBody()) ,"placeholder='".str_replace("'","&#39;",_('Body'))."' cols='71' v='BODY' s='d'  class=' tinymce ' style='' spellcheck='false'"), 'Body', "", $this->commentsBody, $this->commentsBody_css, 'istinymce', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }


        if( !isset($this->Template['request']['ChildHide']) ) {

            # define child lists 'File'
            $ongletTab['0']['t'] = _('File');
            $ongletTab['0']['p'] = 'TemplateFile';
            $ongletTab['0']['lkey'] = 'IdTemplate';
            $ongletTab['0']['fkey'] = 'IdTemplate';
        if(!empty($ongletTab) and $dataObj->getIdTemplate()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights($value['p'], 'r')){

                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        $ChildOnglet .= li(
                                        htmlLink(	_($value['t'])
                                            ,'javascript:',"p='".$value['p']."' act='list' j=conglet_Template ip='".$dataObj->$getLocalKey()."' class='ui-state-default' ")
                                    ,"  class='' j=sm  ");
                    }
                }
            }

            if($ChildOnglet){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Template]').bind('click', function (data){
                        pp = $(this).attr('p');
                        $('#cntTemplateChild').html( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg') );
                        $.get('"._SITE_URL."Template/'+pp+'/'+$(this).attr('ip'), { ui: pp+'Table', 'pui':'".$uiTabsId."', pc:'".$data['pc']."'}, function(data){
                            $('#cntTemplateChild').html(data);
                            $('[j=conglet_Template]').parent().attr('class','ui-state-default');
                            $('[j=conglet_Template][p='+pp+']').parent().attr('class',' ui-state-default ui-state-active');
                        }).fail(function(data) {
                            $('#cntAssetChild').html('Error: try again or contact your administrator.');
                            console.log(data);
                        });;
                    });
                ";
                if($_SESSION['mem']['Template']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['mem']['Template']['child']['list'][$dataObj->$getLocalKey()];
                    $childTable['onReadyJs'] .= " $('[j=conglet_Template][p=".$onglet_p."]').first().click();";
                }else{
                    $childTable['onReadyJs'] .= " $('[j=conglet_Template]').first().click();";
                }
            }
        }
        }
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveTemplate', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedTemplate','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdTemplate', $dataObj->getIdTemplate(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formTemplate [j='date']\").attr('type', 'text');
            $(\"#formTemplate [j='date']\").each(function(){
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
                div('Template', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['Template']['Name']['html']
.$this->fields['Template']['Subject']['html']
.$this->fields['Template']['Color1']['html']
.$this->fields['Template']['Color2']['html']
.$this->fields['Template']['Color3']['html']
.$this->fields['Template']['Status']['html']
.$this->fields['Template']['Body']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntTemplate", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formTemplate' class='mainForm formContent' ")
        .$this->hookFormBottom;


        //if not new, show child table
        if($dataObj->getIdTemplate()) {
            if($ChildOnglet) {
                $return['html'] .= div(
                                        div('Child(s)', '', "class='panel-heading'")
                                        . ul($ChildOnglet, " class=' ui-tabs-nav ' ")
                                        . div('','cntTemplateChild',' class="" ')
                                    , 'pannelTemplate', " class='child_pannel ui-tabs childCntClass'");
            }
        }

        if($id and $_SESSION['mem']['Template']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Template']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Template']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Template']['ixmemautocapp'];
            unset($_SESSION['mem']['Template']['ixmemautocapp']);
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

    setTimeout(function (){
        $('#formTemplate .tinymce').each(function() {
           $(this).ckeditor();
        });
    }, 200);
            
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
            $(\"#formTemplate [s='d'], #formTemplate .js-select-label, #formTemplate [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formTemplate .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Template']['Name']['html'] = stdFieldRow(_("Name"), div( $dataObj->getName(), 'Name_label' , "class='readonly' s='d'")
                .input('hidden', 'Name', $dataObj->getName(), "s='d'"), 'Name', "", $this->commentsName, $this->commentsName_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Subject']['html'] = stdFieldRow(_("Subject"), div( $dataObj->getSubject(), 'Subject_label' , "class='readonly' s='d'")
                .input('hidden', 'Subject', $dataObj->getSubject(), "s='d'"), 'Subject', "", $this->commentsSubject, $this->commentsSubject_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Color1']['html'] = stdFieldRow(_("Color 1"), div( $dataObj->getColor1(), 'Color1_label' , "class='readonly' s='d'")
                .input('hidden', 'Color1', $dataObj->getColor1(), "s='d'"), 'Color1', "", $this->commentsColor1, $this->commentsColor1_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Color2']['html'] = stdFieldRow(_("Color 2"), div( $dataObj->getColor2(), 'Color2_label' , "class='readonly' s='d'")
                .input('hidden', 'Color2', $dataObj->getColor2(), "s='d'"), 'Color2', "", $this->commentsColor2, $this->commentsColor2_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Color3']['html'] = stdFieldRow(_("Color 3"), div( $dataObj->getColor3(), 'Color3_label' , "class='readonly' s='d'")
                .input('hidden', 'Color3', $dataObj->getColor3(), "s='d'"), 'Color3', "", $this->commentsColor3, $this->commentsColor3_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Status']['html'] = stdFieldRow(_("Status"), div( $dataObj->getStatus(), 'Status_label' , "class='readonly' s='d'")
                .input('hidden', 'Status', $dataObj->getStatus(), "s='d'"), 'Status', "", $this->commentsStatus, $this->commentsStatus_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Template']['Body']['html'] = stdFieldRow(_("Body"), div( $dataObj->getBody(), 'Body_label' , "class='readonly' s='d'")
                .input('hidden', 'Body', $dataObj->getBody(), "s='d'"), 'Body', "", $this->commentsBody, $this->commentsBody_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Template'] as $field => $ar) {
                $this->fields['Template'][$field]['html'] = $this->fieldsRo['Template'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Template'][$field]['html'] = $this->fieldsRo['Template'][$field]['html'];
            }
        }
    }	
    /**
     * function getTemplateFileList
     * @param string $IdTemplate
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getTemplateFileList(String $IdTemplate, array $request)
    {

        $this->TableName = 'TemplateFile';
        $altValue = array (
  'IdTemplateFile' => '',
  'IdTemplate' => '',
  'Name' => '',
  'File' => '',
  'DateCreation' => '',
  'DateModification' => '',
  'IdGroupCreation' => '',
  'IdCreation' => '',
  'IdModification' => '',
);
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntTemplateChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Template/TemplateFile');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'Template/TemplateFile');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Template/TemplateFile');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->Template['request']['noHeader']) && $this->Template['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdTemplate'] = $IdTemplate;
        if($dataObj == null){
            $dataObj = new Template();
            $dataObj->setIdTemplate($IdTemplate);
        }

        $this->TemplateFile['list_add'] = "
        $('#TemplateFileListForm #addTemplateFile').bindEdit({
                modelName: 'TemplateFile',
                destUi: 'editDialog',
                pc:'{$this->virtualClassName}',
                ip:'".$IdTemplate."',
                jet:'refreshChild',
                tp:'TemplateFile',
                description: 'File'
        });
        ";
        $this->TemplateFile['list_delete'] = "
        $(\"[j='deleteTemplateFile']\").bindDelete({
            modelName:'TemplateFile',
            ui:'cntTemplateFiledivChild',
            title: 'File',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('TemplateFile', 'r')){
            $this->TemplateFile['list_edit'] = "
        $(\"#TemplateFileTable tr td[j='editTemplateFile']\").bind('click', function (){
            
        $('#editDialog').html( $('<div>').append( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg').css('width', '300px')).css('width', '300px').css('margin', 'auto') );
        $('#editDialog').dialog({width:'auto'}).dialog('open');
        $.get('"._SITE_URL."TemplateFile/edit/'+$(this).attr('i'),
                { ip:'".$IdTemplate."', ui:'editDialog', pc:'{$this->virtualClassName}', je:'TemplateFileTableCntnr', jet:'refreshChild', 'it-pos':$(this).data('iterator-pos') },
            function(data){ 
                dialogWidthClass($('#editDialog')); 
                $('#editDialog').html(data).dialog({width:'auto'});  
        });
        });";
        }

        #filters validation
        
        $filterKey = $IdTemplate;
        $this->IdPk = $IdTemplate;
        
        
        #main query
        
        // Normal query
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = TemplateFileQuery::create();
        
        
        $q 
            
            ->filterByIdTemplate( $filterKey );; 
               // Search
        
               // orderring
           
        if( is_array( $search['order'] ) ) {
            foreach ($search['order'] as $order) {
                foreach ($order as $col => $sens) {
                    if( $sens ) {
                        $tOrd = explode('.', $col);
                        $orderBy = "use" . $tOrd[0] . "Query";
                        if( $tOrd[1] && method_exists( $q, $orderBy )) {
                            $q->$orderBy( '', \Criteria::LEFT_JOIN )->orderBy( $tOrd[1], $sens )->endUse();
                        }elseif( method_exists( $q, 'filterBy' . $col )) {
                            $q->orderBy( $col, $sens );
                        }

                        $orderReadyJs .= "
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('order','on');
                        ";
                    }
                }
            }
        }
            // group by
           
        
        $this->queryObjTemplateFile = $q;
        
        $pmpoData =$q->paginate($search['page'], $maxPerPage);
        $resultsCount = $pmpoData->getNbResults();
        
         
        #options building
        
        
        
          
        
        if(isset($this->Template['request']['noHeader']) && $this->Template['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('TemplateFile', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("Name"), " th='sorted' c='Name' title='" . _('Name')."' ")
.th(_("File"), " th='sorted' c='File' title='" . _('File')."' ")
.'' . th('Tools') . $actionRowHeader, " ln='TemplateFile' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No File found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='TemplateFile' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellTemplateFile = '';
                $actionRow = '';
                
                
                
                if($_SESSION[_AUTH_VAR]->hasRights('TemplateFile', 'd')){
                    $actionRow = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteTemplateFile' i='".json_encode($data->getPrimaryKey())."'");
                }
                
                $imgPath = _SITE_URL.$data->getFile();
        $actionRow = htmlLink(img(_SITE_URL.$data->getFile(), '24', ''), $imgPath, "style='padding-top: 3px;' j='imageTemplateFile' i='".$data->getPrimaryKey()."' target='_blank'")
                       .htmlLink("<i class='ri-folder-download-line'></i>", _SITE_URL."TemplateFile/file/".$data->getPrimaryKey(), "style='padding-top: 3px;' title='"._('Download')."'j='fileTemplateFile' i='".$data->getPrimaryKey()."' target='_blank'")
                       .$actionRow;
                
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellTemplateFile.$actionRow," class='actionrow'") : "";
                
                
                
                ;
                
                
                
                $tr .= 
                        tr(
                            (isset($this->hookListColumnsTemplateFileFirst)?$this->hookListColumnsTemplateFileFirst:'').
                            
                td(span((($altValue['Name']) ? $altValue['Name'] : $data->getName()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Name' class=''  j='editTemplateFile'") . 
                td(span((($altValue['File']) ? $altValue['File'] : $data->getFile()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='File' class=''  j='editTemplateFile'") . 
                            (isset($this->hookListColumnsTemplateFile)?$this->hookListColumnsTemplateFile:'')
                .td(htmlLink(span(addslashes(_('To editor'))),'javascript:', " class='button-link-blue' data-clipboard-text='"._SITE_URL.$data->getFile()."' title='Click to copy me.' i='".$data->getPrimaryKey()."'  j='copy_link' "))
                .
                            $actionRow
                            
                        ,"id='TemplateFileRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='TemplateFile'  ");
                        
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(
                                    div($total_child,'','class="nolink"')
                            ,'trTemplateFile'," ln='TemplateFile' class=''").$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    if(($_SESSION[_AUTH_VAR]->hasRights('TemplateFile', 'a')) ){
        $add_button_child =
        $add_button_child .=
                        div(
                            htmlLink(
                                _("Upload new file")
                            , "Javascript:","id='pickfiles' title='" . _('Upload new file') . "' class='button-link-blue add-button'")
                        .div('', 'filelist')
                        ,'upload-TemplateFile',' class="listHeaderItem swf-upload-button" ');
        ;
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookTemplateFileListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookTemplateFileTableFooter
                                , "id='TemplateFileTable' class='tablesorter'")
                            , 'childlistTemplateFile')
                            .$this->hookTemplateFileListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'TemplateFileListForm')
            ,'cntTemplateFiledivChild', "class='childListWrapper'");

            

                $return['js'] .= script("
$(function(){
    var fileStatus = [];
    var error = false;
    $('#alertDialog p').html('');
    var uploader = new plupload.Uploader({
        runtimes : 'html5,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-TemplateFile'),
        url: '"._SITE_URL."TemplateFile/upload',
        drop_element : 'pickfiles',
        multipart_params: {
            'ip':'".$filterKey."',
            'IdUser':'".$_SESSION[_AUTH_VAR]->get('id')."'
        },

        filters : {\"max_file_size\":\"10mb\"},
        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function(up, files) {
                $('#alertDialog p').html('Uploading ... (<span></span>%)').show();
                $('#alertDialog').dialog('open');
                plupload.each(files, function(file) {
                    uploader.start();
                    return false;
                });
            },
            UploadProgress: function(up, file) {
                $('#alertDialog p span').text(file.percent);
            },
            Error: function(up, err) {
                $('#alertDialog p').html('Error ' + err.code+ '<br>'+err.message).show();
                $('#alertDialog').dialog('open');
            },
            FileUploaded: function(upldr, file, response) {
                if(response.response){
                    var resp = JSON.parse(response.response);
                    if(resp.status == 'failure'){
                        fileStatus.push(resp.errors);
                        error = true;
                    }
                }
            },
            UploadComplete: function(up, files) {
                if(error){
                    $('#alertDialog p').html('Errors: '+JSON.stringify(fileStatus));
                }else{
                    $('#alertDialog').dialog('close');
                    $('[j=conglet_Template][p=\"TemplateFile\"]').click();
                }
                $('body').css('cursor', 'default');

            }
        }
    });
    uploader.init();
});");


            $return['onReadyJs'] =
                $this->hookListReadyJsFirstTemplateFile
                .""
                .$this->TemplateFile['list_add']
                .$this->TemplateFile['list_delete']
                .$this->TemplateFile['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
                
        /* PAGINATION */
        $('#TemplateFilePager').bindPaging({
            tableName:'TemplateFile'
            , parentId:'".$IdTemplate."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/TemplateFile/$IdTemplate'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'TemplateFile',
            url:'".$this->virtualClassName."/TemplateFile/$IdTemplate',
            destUi:'".$uiTabsId."'
        });
        
        $('#cntTemplateChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "

            $('[j=\"copy_link\"]').click(function (){
                var myValue = $(this).data('clipboard-text');
                var currentInstance = null;
                for ( var i in CKEDITOR.instances ){
                    if(CKEDITOR.instances[i].focusManager.hasFocus){
                        var currentInstance = i;
                        break;
                    }
                }
                if(currentInstance){
                    CKEDITOR.instances[currentInstance].insertHtml(\"<img src='\"+myValue+\"'>\");
                }else{
                    alertb('Warning', 'Please place the cursor in the editor to insert the image.');
                }
            });"
                . $this->hookListReadyJsTemplateFile;
        return $return;
    }
}
