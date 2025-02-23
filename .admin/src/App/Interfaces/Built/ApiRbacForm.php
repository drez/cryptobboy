<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'ApiRbac' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class ApiRbacForm extends ApiRbac
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
        $this->model_name = 'ApiRbac';
        $this->virtualClassName = 'ApiRbac';
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

        $q = new ApiRbacQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                ;

        if( isset($this->searchMs['Scope']) ) {
            $criteria = \Criteria::EQUAL;
            $value = $this->searchMs['Scope'];

            $q->filterByScope($value, $criteria);
        }
        if( isset($this->searchMs['Model']) ) {
            $criteria = \Criteria::LIKE;


            $value = $this->setCriteria($this->searchMs['Model'], $criteria);

            $q->filterByModel($value, $criteria);
        }
        if( isset($this->searchMs['Action']) ) {
            $criteria = \Criteria::LIKE;


            $value = $this->setCriteria($this->searchMs['Action'], $criteria);

            $q->filterByAction($value, $criteria);
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
                                $(\"#ApiRbacListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Date"), " th='sorted' c='DateCreation' title='" . _('Date')."' ")
.th(_("Description"), " th='sorted' c='Description' title='" . _('Description')."' ")
.th(_("Model"), " th='sorted' c='Model' title='" . _('Model')."' ")
.th(_("Action"), " th='sorted' c='Action' title='" . _('Action')."' ")
.th(_("Body"), " th='sorted' c='Body' title='" . _('Body')."' ")
.th(_("Method"), " th='sorted' c='Method' title='" . _('Method')."' ")
.th(_("Scope"), " th='sorted' c='Scope' title='" . _('Scope')."' ")
.th(_("Rule"), " th='sorted' c='Rule' title='" . _('Rule')."' ")
.th(_("Used count"), " th='sorted' c='Count' title='" . _('Used count')."' ")
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
                form(div(selectboxCustomArray('Scope', array( '0' => array('0'=>_("Private"), '1'=>"Private"),'1' => array('0'=>_("Public"), '1'=>"Public"), ), _('Scope'), '  size="1" t="1"   ', $this->searchMs['Scope']), '', 'class=" ac-search-item"  title="'._('Scope').'"').div(input('text', 'Model', $this->searchMs['Model'], '  title="'._('Model').'" placeholder="'._('Model').'"',''),'','class="ac-search-item"').div(input('text', 'Action', $this->searchMs['Action'], '  title="'._('Action').'" placeholder="'._('Action').'"',''),'','class="ac-search-item"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msApiRbacBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msApiRbacBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsApiRbac'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('ApiRbac', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addApiRbac' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'ApiRbac';
        $altValue = array (
  'IdApiRbac' => '',
  'DateCreation' => '',
  'Description' => '',
  'Model' => '',
  'Action' => '',
  'Body' => '',
  'Query' => '',
  'Method' => '',
  'Scope' => '',
  'Rule' => '',
  'Count' => '',
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
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'ApiRbac/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'ApiRbac/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'ApiRbac/');

        
        
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
                if($_SESSION[_AUTH_VAR]->hasRights('ApiRbac', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteApiRbac' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span(((isset($altValue['DateCreation']) && !empty($altValue['DateCreation'])) ? $altValue['DateCreation'] : $data->getDateCreation())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='DateCreation' class=''  j='editApiRbac'") . 
                td(span(((isset($altValue['Description']) && !empty($altValue['Description'])) ? $altValue['Description'] : substr(strip_tags($data->getDescription()), 0, 100))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Description' class=''  j='editApiRbac'") . 
                td(span(((isset($altValue['Model']) && !empty($altValue['Model'])) ? $altValue['Model'] : $data->getModel())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Model' class=''  j='editApiRbac'") . 
                td(span(((isset($altValue['Action']) && !empty($altValue['Action'])) ? $altValue['Action'] : $data->getAction())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Action' class=''  j='editApiRbac'") . 
                td(span(((isset($altValue['Body']) && !empty($altValue['Body'])) ? $altValue['Body'] : substr(strip_tags($data->getBody()), 0, 100))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Body' class=''  j='editApiRbac'") . 
                td(span(((isset($altValue['Method']) && !empty($altValue['Method'])) ? $altValue['Method'] : isntPo($data->getMethod()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Method' class='center'  j='editApiRbac'") . 
                td(span(((isset($altValue['Scope']) && !empty($altValue['Scope'])) ? $altValue['Scope'] : isntPo($data->getScope()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Scope' class='center'  j='editApiRbac'") . 
                td(span(((isset($altValue['Rule']) && !empty($altValue['Rule'])) ? $altValue['Rule'] : isntPo($data->getRule()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Rule' class='center'  j='editApiRbac'") . 
                td(span(((isset($altValue['Count']) && !empty($altValue['Count'])) ? $altValue['Count'] : $data->getCount())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Count' class=''  j='editApiRbac'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='ApiRbacRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountApiRbac', $i);
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
                
                .div($controlsContent,'ApiRbacControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='ApiRbacTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'ApiRbacListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#ApiRbacListForm td[j='editApiRbac']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#ApiRbacListForm [j='deleteApiRbac']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#ApiRbacPager').bindPaging({
            tableName:'ApiRbac'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msApiRbacBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msApiRbacBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsApiRbac').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsApiRbac .js-select-label').SelectBox();
            $('#formMsApiRbac input[type=text]').first().focus();
            $('#formMsApiRbac input[type=text]').first().putCursorAtEnd();
            $('#msApiRbacBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsApiRbac').keydown(function(e) {
        if(e.which == 13) {
            $('#msApiRbacBt').click();
        }
    });

    $('#msApiRbacBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsApiRbac input[type=text]:first-of-type').focus().putCursorAtEnd();
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

        if($('#addApiRbacAutoc').length > 0) {
            $('#addApiRbacAutoc').bind('click', function () {
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
    public function setCreateDefaultsApiRbac($data)
    {

        unset($data['IdApiRbac']);
        $e = new ApiRbac();
        
        
        if(!$data['Method']){
            $data['Method'] = "GET";
        } 
        if(!$data['Scope']){
            $data['Scope'] = "Private";
        } 
        if(!$data['Rule']){
            $data['Rule'] = "Deny";
        } 
        $e->fromArray($data );

        #
        
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'], 0, 10) == '-0001-11-30')?date('Y-m-d'):$data['DateCreation'] );
        //integer not required
        $e->setDescription( ($data['Description'] == '' ) ? null : $data['Description']);
        //integer not required
        $e->setAction( ($data['Action'] == '' ) ? null : $data['Action']);
        //integer not required
        $e->setBody( ($data['Body'] == '' ) ? null : $data['Body']);
        //integer not required
        $e->setQuery( ($data['Query'] == '' ) ? null : $data['Query']);
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
    public function setUpdateDefaultsApiRbac($data)
    {

        
        $e = ApiRbacQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!$data['Method']){
            $data['Method'] = "GET";
        } 
        if(!$data['Scope']){
            $data['Scope'] = "Private";
        } 
        if(!$data['Rule']){
            $data['Rule'] = "Deny";
        } 
        $e->fromArray($data );

        
        
        if(isset($data['DateCreation'])){
            $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'], 0, 10) == '-0001-11-30') ? null : $data['DateCreation'] );
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
     * Produce a formated form of ApiRbac
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

        $je = "ApiRbacTable";

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
        if(($_SESSION[_AUTH_VAR]->hasRights('ApiRbac', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('ApiRbac', 'w') and $id) || $this->setReadOnly) {
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
                $('#formApiRbac #saveApiRbac').unbind('click.saveApiRbac');
                $('#formApiRbac #saveApiRbac').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('ApiRbac', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addApiRbac' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = ApiRbacQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdApiRbac($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->ApiRbac['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new ApiRbac();
            $this->ApiRbac['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->ApiRbac['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        



        
        
        
        
        
        
        
$this->fields['ApiRbac']['DateCreation']['html'] = stdFieldRow(_("Date"), input('date', 'DateCreation', $dataObj->getDateCreation(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD' size='10'  s='d' class='' title='Date'"), 'DateCreation', "", $this->commentsDateCreation, $this->commentsDateCreation_css, '', ' ', 'no');
$this->fields['ApiRbac']['Description']['html'] = stdFieldRow(_("Description"), textarea('Description', htmlentities($dataObj->getDescription()) ,"placeholder='".str_replace("'","&#39;",_('Description'))."' cols='71' v='DESCRIPTION' s='d'  class=' ' style='' spellcheck='false'"), 'Description', "", $this->commentsDescription, $this->commentsDescription_css, '', ' ', 'no');
$this->fields['ApiRbac']['Model']['html'] = stdFieldRow(_("Model"), input('text', 'Model', htmlentities($dataObj->getModel()), "   placeholder='".str_replace("'","&#39;",_('Model'))."' size='69'  v='MODEL' s='d' class='req'  ")."", 'Model', "", $this->commentsModel, $this->commentsModel_css, '', ' ', 'no');
$this->fields['ApiRbac']['Action']['html'] = stdFieldRow(_("Action"), input('text', 'Action', htmlentities($dataObj->getAction()), "   placeholder='".str_replace("'","&#39;",_('Action'))."' size='69'  v='ACTION' s='d' class=''  ")."", 'Action', "", $this->commentsAction, $this->commentsAction_css, '', ' ', 'no');
$this->fields['ApiRbac']['Body']['html'] = stdFieldRow(_("Body"), textarea('Body', htmlentities($dataObj->getBody()) ,"placeholder='".str_replace("'","&#39;",_('Body'))."' cols='71' v='BODY' s='d'  class=' ' style='' spellcheck='false'"), 'Body', "", $this->commentsBody, $this->commentsBody_css, '', ' ', 'no');
$this->fields['ApiRbac']['Query']['html'] = stdFieldRow(_("Query"), textarea('Query', htmlentities($dataObj->getQuery()) ,"placeholder='".str_replace("'","&#39;",_('Query'))."' cols='71' v='QUERY' s='d'  class=' ' style='' spellcheck='false'"), 'Query', "", $this->commentsQuery, $this->commentsQuery_css, '', ' ', 'no');
$this->fields['ApiRbac']['Method']['html'] = stdFieldRow(_("Method"), selectboxCustomArray('Method', array( '0' => array('0'=>_("GET"), '1'=>"GET"),'1' => array('0'=>_("POST"), '1'=>"POST"),'2' => array('0'=>_("PATCH"), '1'=>"PATCH"),'3' => array('0'=>_("PUT"), '1'=>"PUT"),'4' => array('0'=>_("DELETE"), '1'=>"DELETE"),'5' => array('0'=>_("ALL"), '1'=>"ALL"), ), "", "s='d'  ", $dataObj->getMethod(), '', false), 'Method', "", $this->commentsMethod, $this->commentsMethod_css, '', ' ', 'no');
$this->fields['ApiRbac']['Scope']['html'] = stdFieldRow(_("Scope"), selectboxCustomArray('Scope', array( '0' => array('0'=>_("Private"), '1'=>"Private"),'1' => array('0'=>_("Public"), '1'=>"Public"), ), "", "s='d'  ", $dataObj->getScope(), '', false), 'Scope', "", $this->commentsScope, $this->commentsScope_css, '', ' ', 'no');
$this->fields['ApiRbac']['Rule']['html'] = stdFieldRow(_("Rule"), selectboxCustomArray('Rule', array( '0' => array('0'=>_("Allow"), '1'=>"Allow"),'1' => array('0'=>_("Deny"), '1'=>"Deny"), ), "", "s='d'  ", $dataObj->getRule(), '', false), 'Rule', "", $this->commentsRule, $this->commentsRule_css, '', ' ', 'no');
$this->fields['ApiRbac']['Count']['html'] = stdFieldRow(_("Used count"), input('number', 'Count', $dataObj->getCount(), " step='1' placeholder='".str_replace("'","&#39;",_('Used count'))."' v='COUNT' size='0' s='d' class='req'"), 'Count', "", $this->commentsCount, $this->commentsCount_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }


        if( !isset($this->ApiRbac['request']['ChildHide']) ) {

            # define child lists 'API log'
            $ongletTab['0']['t'] = _('API log');
            $ongletTab['0']['p'] = 'ApiLog';
            $ongletTab['0']['lkey'] = 'IdApiRbac';
            $ongletTab['0']['fkey'] = 'IdApiRbac';
        if(!empty($ongletTab) and $dataObj->getIdApiRbac()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights($value['p'], 'r')){

                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        $ChildOnglet .= li(
                                        htmlLink(	_($value['t'])
                                            ,'javascript:',"p='".$value['p']."' act='list' j=conglet_ApiRbac ip='".$dataObj->$getLocalKey()."' class='ui-state-default' ")
                                    ,"  class='' j=sm  ");
                    }
                }
            }

            if($ChildOnglet){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_ApiRbac]').bind('click', function (data){
                        pp = $(this).attr('p');
                        $('#cntApiRbacChild').html( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg') );
                        $.get('"._SITE_URL."ApiRbac/'+pp+'/'+$(this).attr('ip'), { ui: pp+'Table', 'pui':'".$uiTabsId."', pc:'".$data['pc']."'}, function(data){
                            $('#cntApiRbacChild').html(data);
                            $('[j=conglet_ApiRbac]').parent().attr('class','ui-state-default');
                            $('[j=conglet_ApiRbac][p='+pp+']').parent().attr('class',' ui-state-default ui-state-active');
                        }).fail(function(data) {
                            $('#cntAssetChild').html('Error: try again or contact your administrator.');
                            console.log(data);
                        });;
                    });
                ";
                if($_SESSION['mem']['ApiRbac']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['mem']['ApiRbac']['child']['list'][$dataObj->$getLocalKey()];
                    $childTable['onReadyJs'] .= " $('[j=conglet_ApiRbac][p=".$onglet_p."]').first().click();";
                }else{
                    $childTable['onReadyJs'] .= " $('[j=conglet_ApiRbac]').first().click();";
                }
            }
        }
        }
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveApiRbac', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedApiRbac','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdApiRbac', $dataObj->getIdApiRbac(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formApiRbac [j='date']\").attr('type', 'text');
            $(\"#formApiRbac [j='date']\").each(function(){
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
                div('API ACL', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['ApiRbac']['DateCreation']['html']
.$this->fields['ApiRbac']['Description']['html']
.$this->fields['ApiRbac']['Model']['html']
.$this->fields['ApiRbac']['Action']['html']
.$this->fields['ApiRbac']['Body']['html']
.$this->fields['ApiRbac']['Query']['html']
.$this->fields['ApiRbac']['Method']['html']
.$this->fields['ApiRbac']['Scope']['html']
.$this->fields['ApiRbac']['Rule']['html']
.$this->fields['ApiRbac']['Count']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntApiRbac", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formApiRbac' class='mainForm formContent' ")
        .$this->hookFormBottom;


        //if not new, show child table
        if($dataObj->getIdApiRbac()) {
            if($ChildOnglet) {
                $return['html'] .= div(
                                        div('Child(s)', '', "class='panel-heading'")
                                        . ul($ChildOnglet, " class=' ui-tabs-nav ' ")
                                        . div('','cntApiRbacChild',' class="" ')
                                    , 'pannelApiRbac', " class='child_pannel ui-tabs childCntClass'");
            }
        }

        if($id and $_SESSION['mem']['ApiRbac']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['ApiRbac']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['ApiRbac']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['ApiRbac']['ixmemautocapp'];
            unset($_SESSION['mem']['ApiRbac']['ixmemautocapp']);
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
            $(\"#formApiRbac [s='d'], #formApiRbac .js-select-label, #formApiRbac [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formApiRbac .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['ApiRbac']['DateCreation']['html'] = stdFieldRow(_("Date"), div( $dataObj->getDateCreation(), 'DateCreation_label' , "class='readonly' s='d'")
                .input('hidden', 'DateCreation', $dataObj->getDateCreation(), "s='d'"), 'DateCreation', "", $this->commentsDateCreation, $this->commentsDateCreation_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Description']['html'] = stdFieldRow(_("Description"), div( $dataObj->getDescription(), 'Description_label' , "class='readonly' s='d'")
                .input('hidden', 'Description', $dataObj->getDescription(), "s='d'"), 'Description', "", $this->commentsDescription, $this->commentsDescription_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Model']['html'] = stdFieldRow(_("Model"), div( $dataObj->getModel(), 'Model_label' , "class='readonly' s='d'")
                .input('hidden', 'Model', $dataObj->getModel(), "s='d'"), 'Model', "", $this->commentsModel, $this->commentsModel_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Action']['html'] = stdFieldRow(_("Action"), div( $dataObj->getAction(), 'Action_label' , "class='readonly' s='d'")
                .input('hidden', 'Action', $dataObj->getAction(), "s='d'"), 'Action', "", $this->commentsAction, $this->commentsAction_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Body']['html'] = stdFieldRow(_("Body"), div( $dataObj->getBody(), 'Body_label' , "class='readonly' s='d'")
                .input('hidden', 'Body', $dataObj->getBody(), "s='d'"), 'Body', "", $this->commentsBody, $this->commentsBody_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Query']['html'] = stdFieldRow(_("Query"), div( $dataObj->getQuery(), 'Query_label' , "class='readonly' s='d'")
                .input('hidden', 'Query', $dataObj->getQuery(), "s='d'"), 'Query', "", $this->commentsQuery, $this->commentsQuery_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Method']['html'] = stdFieldRow(_("Method"), div( $dataObj->getMethod(), 'Method_label' , "class='readonly' s='d'")
                .input('hidden', 'Method', $dataObj->getMethod(), "s='d'"), 'Method', "", $this->commentsMethod, $this->commentsMethod_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Scope']['html'] = stdFieldRow(_("Scope"), div( $dataObj->getScope(), 'Scope_label' , "class='readonly' s='d'")
                .input('hidden', 'Scope', $dataObj->getScope(), "s='d'"), 'Scope', "", $this->commentsScope, $this->commentsScope_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Rule']['html'] = stdFieldRow(_("Rule"), div( $dataObj->getRule(), 'Rule_label' , "class='readonly' s='d'")
                .input('hidden', 'Rule', $dataObj->getRule(), "s='d'"), 'Rule', "", $this->commentsRule, $this->commentsRule_css, 'readonly', ' ', 'no');

        $this->fieldsRo['ApiRbac']['Count']['html'] = stdFieldRow(_("Used count"), div( $dataObj->getCount(), 'Count_label' , "class='readonly' s='d'")
                .input('hidden', 'Count', $dataObj->getCount(), "s='d'"), 'Count', "", $this->commentsCount, $this->commentsCount_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['ApiRbac'] as $field => $ar) {
                $this->fields['ApiRbac'][$field]['html'] = $this->fieldsRo['ApiRbac'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['ApiRbac'][$field]['html'] = $this->fieldsRo['ApiRbac'][$field]['html'];
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
    /**
     * function getApiLogList
     * @param string $IdApiRbac
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getApiLogList(String $IdApiRbac, array $request)
    {

        $this->TableName = 'ApiLog';
        $altValue = array (
  'IdApiLog' => '',
  'IdApiRbac' => '',
  'IdAuthy' => '',
  'Time' => '',
);
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntApiRbacChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'ApiRbac/ApiLog');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'ApiRbac/ApiLog');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'ApiRbac/ApiLog');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->ApiRbac['request']['noHeader']) && $this->ApiRbac['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdApiRbac'] = $IdApiRbac;
        if($dataObj == null){
            $dataObj = new ApiRbac();
            $dataObj->setIdApiRbac($IdApiRbac);
        }

        $this->ApiLog['list_add'] = "
        $('#ApiLogListForm #addApiLog').bindEdit({
                modelName: 'ApiLog',
                destUi: 'editDialog',
                pc:'{$this->virtualClassName}',
                ip:'".$IdApiRbac."',
                jet:'refreshChild',
                tp:'ApiLog',
                description: 'API log'
        });
        ";
        $this->ApiLog['list_delete'] = "
        $(\"[j='deleteApiLog']\").bindDelete({
            modelName:'ApiLog',
            ui:'cntApiLogdivChild',
            title: 'API log',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'r')){
            $this->ApiLog['list_edit'] = "
        $(\"#ApiLogTable tr td[j='editApiLog']\").bind('click', function (){
            
        $('#editDialog').html( $('<div>').append( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg').css('width', '300px')).css('width', '300px').css('margin', 'auto') );
        $('#editDialog').dialog({width:'auto'}).dialog('open');
        $.get('"._SITE_URL."ApiLog/edit/'+$(this).attr('i'),
                { ip:'".$IdApiRbac."', ui:'editDialog', pc:'{$this->virtualClassName}', je:'ApiLogTableCntnr', jet:'refreshChild', 'it-pos':$(this).data('iterator-pos') },
            function(data){ 
                dialogWidthClass($('#editDialog')); 
                $('#editDialog').html(data).dialog({width:'auto'});  
        });
        });";
        }

        #filters validation
        
        $filterKey = $IdApiRbac;
        $this->IdPk = $IdApiRbac;
        
        
        #main query
        
        // Normal query
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = ApiLogQuery::create();
        
        
        $q
                #required api_log
                ->leftJoinWith('ApiRbac') 
            
            ->filterByIdApiRbac( $filterKey );; 
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
           
        
        $this->queryObjApiLog = $q;
        
        $pmpoData =$q->paginate($search['page'], $maxPerPage);
        $resultsCount = $pmpoData->getNbResults();
        
         
        #options building
        
        $this->arrayIdApiRbacOptions = $this->selectBoxApiLog_IdApiRbac($this, $dataObj, $data);
        
        
          
        
        if(isset($this->ApiRbac['request']['noHeader']) && $this->ApiRbac['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("API ACL model"), " th='sorted' c='ApiRbac.Model' title='"._('ApiRbac.Model')."' ")
.th(_('API ACL action'), "t='mc' th='sorted' c='ApiRbac.Action'").th(_('API ACL query'), "t='mc' th='sorted' c='ApiRbac.Query'").th(_("Time"), " th='sorted' c='Time' title='" . _('Time')."' ")
.'' . $actionRowHeader, " ln='ApiLog' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No API log found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='ApiLog' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellApiLog = '';
                $actionRow = '';
                
                
                
                if($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'd')){
                    $actionRow = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteApiLog' i='".json_encode($data->getPrimaryKey())."'");
                }
                
                
                
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellApiLog.$actionRow," class='actionrow'") : "";
                
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
                
                
                ;
                
                
                
                $tr .= 
                        tr(
                            (isset($this->hookListColumnsApiLogFirst)?$this->hookListColumnsApiLogFirst:'').
                            
                td(span(((isset($altValue['IdApiRbac']) && !empty($altValue['IdApiRbac'])) ? $altValue['IdApiRbac'] : $altValue['ApiRbac_Model'])." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdApiRbac' class=''  j='editApiLog'") . td(span($altValue['ApiRbac_Action'].""), " c='ApiRbac__Action' j='editApiLog' i='".json_encode($data->getPrimaryKey())."'").
                            td(span($altValue['ApiRbac_Query'].""), " c='ApiRbac__Query' j='editApiLog' i='".json_encode($data->getPrimaryKey())."'").
                            
                td(span(((isset($altValue['Time']) && !empty($altValue['Time'])) ? $altValue['Time'] : $data->getTime())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Time' class=''  j='editApiLog'") . 
                            (isset($this->hookListColumnsApiLog)?$this->hookListColumnsApiLog:'').
                            $actionRow
                            
                        ,"id='ApiLogRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='ApiLog'  ");
                        
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(
                                    div($total_child,'','class="nolink"')
                            ,'trApiLog'," ln='ApiLog' class=''").$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    if(($_SESSION[_AUTH_VAR]->hasRights('ApiLog', 'a')) ){
        $add_button_child = htmlLink(span(_("Add")), "Javascript:","title='Add "._('API log')."' id='addApiLog' class='button-link-blue add-button'");
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookApiLogListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookApiLogTableFooter
                                , "id='ApiLogTable' class='tablesorter'")
                            , 'childlistApiLog')
                            .$this->hookApiLogListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'ApiLogListForm')
            ,'cntApiLogdivChild', "class='childListWrapper'");

            
            

            $return['onReadyJs'] =
                $this->hookListReadyJsFirstApiLog
                .""
                .$this->ApiLog['list_add']
                .$this->ApiLog['list_delete']
                .$this->ApiLog['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
                
        /* PAGINATION */
        $('#ApiLogPager').bindPaging({
            tableName:'ApiLog'
            , parentId:'".$IdApiRbac."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/ApiLog/$IdApiRbac'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'ApiLog',
            url:'".$this->virtualClassName."/ApiLog/$IdApiRbac',
            destUi:'".$uiTabsId."'
        });
       
        $('#cntApiRbacChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "
                "
                . $this->hookListReadyJsApiLog;
        return $return;
    }
}
