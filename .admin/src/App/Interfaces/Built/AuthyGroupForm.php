<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'AuthyGroup' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class AuthyGroupForm extends AuthyGroup
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
        $this->model_name = 'AuthyGroup';
        $this->virtualClassName = 'AuthyGroup';
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

        $q = new AuthyGroupQuery();
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
                                $(\"#AuthyGroupListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
.th(_("Description"), " th='sorted' c='Desc' title='" . _('Description')."' ")
.th(_("Default"), " th='sorted' c='DefaultGroup' title='" . _('Default')."' ")
.th(_("Admin"), " th='sorted' c='Admin' title='" . _('Admin')."' ")
.th(_("Rights"), " th='sorted' c='RightsAll' title='" . _('Rights')."' ")
.th(_("Rights owner"), " th='sorted' c='RightsOwner' title='" . _('Rights owner')."' ")
.th(_("Rights group"), " th='sorted' c='RightsGroup' title='" . _('Rights group')."' ")
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
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroup', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addAuthyGroup' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'AuthyGroup';
        $altValue = array (
  'IdAuthyGroup' => '',
  'Name' => '',
  'Desc' => '',
  'DefaultGroup' => '',
  'Admin' => '',
  'RightsAll' => '',
  'RightsOwner' => '',
  'RightsGroup' => '',
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
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'AuthyGroup/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'AuthyGroup/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'AuthyGroup/');

        
        
        
        
        
        

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
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroup', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAuthyGroup' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span(((isset($altValue['Name']) && !empty($altValue['Name'])) ? $altValue['Name'] : $data->getName())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Name' class=''  j='editAuthyGroup'") . 
                td(span(((isset($altValue['Desc']) && !empty($altValue['Desc'])) ? $altValue['Desc'] : $data->getDesc())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Desc' class=''  j='editAuthyGroup'") . 
                td(span(((isset($altValue['DefaultGroup']) && !empty($altValue['DefaultGroup'])) ? $altValue['DefaultGroup'] : isntPo($data->getDefaultGroup()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='DefaultGroup' class='center'  j='editAuthyGroup'") . 
                td(span(((isset($altValue['Admin']) && !empty($altValue['Admin'])) ? $altValue['Admin'] : isntPo($data->getAdmin()))." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Admin' class='center'  j='editAuthyGroup'") . 
                td(span(((isset($altValue['RightsAll']) && !empty($altValue['RightsAll'])) ? $altValue['RightsAll'] : $data->getRightsAll())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='RightsAll' class=''  j='editAuthyGroup'") . 
                td(span(((isset($altValue['RightsOwner']) && !empty($altValue['RightsOwner'])) ? $altValue['RightsOwner'] : $data->getRightsOwner())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='RightsOwner' class=''  j='editAuthyGroup'") . 
                td(span(((isset($altValue['RightsGroup']) && !empty($altValue['RightsGroup'])) ? $altValue['RightsGroup'] : $data->getRightsGroup())." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='RightsGroup' class=''  j='editAuthyGroup'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='AuthyGroupRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountAuthyGroup', $i);
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
                
                .div($controlsContent,'AuthyGroupControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='AuthyGroupTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'AuthyGroupListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#AuthyGroupListForm td[j='editAuthyGroup']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#AuthyGroupListForm [j='deleteAuthyGroup']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#AuthyGroupPager').bindPaging({
            tableName:'AuthyGroup'
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

        if($('#addAuthyGroupAutoc').length > 0) {
            $('#addAuthyGroupAutoc').bind('click', function () {
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
    public function setCreateDefaultsAuthyGroup($data)
    {

        unset($data['IdAuthyGroup']);
        $e = new AuthyGroup();
        
        if($data['noRights'] != 'y'){

            $data['RightsAll'] = serializeRights($data, 'RightsAll');
            $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
            $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
        }
        
        if(!$data['DefaultGroup']){
            $data['DefaultGroup'] = "No";
        } 
        if(!$data['Admin']){
            $data['Admin'] = "No";
        } 
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setName( ($data['Name'] == '' ) ? null : $data['Name']);
        //integer not required
        $e->setDesc( ($data['Desc'] == '' ) ? null : $data['Desc']);
        //integer not required
        $e->setRightsAll( ($data['RightsAll'] == '' ) ? null : $data['RightsAll']);
        //integer not required
        $e->setRightsOwner( ($data['RightsOwner'] == '' ) ? null : $data['RightsOwner']);
        //integer not required
        $e->setRightsGroup( ($data['RightsGroup'] == '' ) ? null : $data['RightsGroup']);
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
    public function setUpdateDefaultsAuthyGroup($data)
    {

        
        $e = AuthyGroupQuery::create()->findPk(json_decode($data['i']));
        
        if($data['noRights'] != 'y'){

            $data['RightsAll'] = serializeRights($data, 'RightsAll');
            $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
            $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
        }
        
        if(!$data['DefaultGroup']){
            $data['DefaultGroup'] = "No";
        } 
        if(!$data['Admin']){
            $data['Admin'] = "No";
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
     * Produce a formated form of AuthyGroup
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

        $je = "AuthyGroupTable";

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
        if(($_SESSION[_AUTH_VAR]->hasRights('AuthyGroup', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('AuthyGroup', 'w') and $id) || $this->setReadOnly) {
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
                $('#formAuthyGroup #saveAuthyGroup').unbind('click.saveAuthyGroup');
                $('#formAuthyGroup #saveAuthyGroup').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroup', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addAuthyGroup' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = AuthyGroupQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdAuthyGroup($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->AuthyGroup['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new AuthyGroup();
            $this->AuthyGroup['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->AuthyGroup['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        



        
        
        
        
    ## Rights for RightsGroup
    if($_SESSION[_AUTH_VAR]->get('group') == 'Admin'){
        $rightsGroup = array (
  'All' => 'RightsAll',
  'Owner' => 'RightsOwner',
  'Group' => 'RightsGroup',
);
        if(is_array($rightsGroup)){
            foreach($rightsGroup as $group => $columnName){
                $getColumn = "get{$columnName}";
                $userRightsAr[$group] = json_decode($dataObj->$getColumn(), true);
            }

            if(!isset($this->omMap)){
                require _BASE_DIR."config/permissions.php";
                $this->omMap = $omMap;
            }
            unset($rightTables);
            foreach($this->omMap as $key => $row){
                $name[$key] = $row['display'];
            }
                array_multisort($name,SORT_ASC,$this->omMap);
                $rightTables = \ApiGoat\Renderers\Rights::getRightsTable('All', $this->omMap, $userRightsAr['All']);
                $rightTables .= \ApiGoat\Renderers\Rights::getRightsTable('Group', $this->omMap, $userRightsAr['Group']);
                $rightTables .= \ApiGoat\Renderers\Rights::getRightsTable('Owner', $this->omMap, $userRightsAr['Owner']);

            $tabRights = new tabs(
                    [
                        'All' => ['id' => 'RigthsAllTab', 'targetDiv' => '#RigthsAll', 'defaultSelected' => 'true'], 'Group' => ['id' => 'RigthsGroupTab', 'targetDiv' => '#RigthsGroup'], 'Owner' => ['id' => 'RigthsOwnerTab', 'targetDiv' => '#RigthsOwner']
                    ],
                    "RightsTabs",
                    '',
                    'Rights'
                );
            $tabRights->setParentContentDivId("RigthsContainer");
            $tabRights->setLabel("Set the rights (All gives unrestricted access; Group refers to the creation group; Owner refers to the creation user) ");

            $rightInputRightsAll = $tabRights->getHtml()
                . div(
                    $rightTables,
                    'RigthsContainer'
                );
        }

    }
    
        
        
        
$this->fields['AuthyGroup']['Name']['html'] = stdFieldRow(_("Name"), input('text', 'Name', htmlentities($dataObj->getName()), "   placeholder='".str_replace("'","&#39;",_('Name'))."' size='35'  v='NAME' s='d' class='req'  ")."", 'Name', "", $this->commentsName, $this->commentsName_css, '', ' ', 'no');
$this->fields['AuthyGroup']['Desc']['html'] = stdFieldRow(_("Description"), input('text', 'Desc', htmlentities($dataObj->getDesc()), "   placeholder='".str_replace("'","&#39;",_('Description'))."' size='35'  v='DESC' s='d' class=''  ")."", 'Desc', "", $this->commentsDesc, $this->commentsDesc_css, '', ' ', 'no');
$this->fields['AuthyGroup']['DefaultGroup']['html'] = stdFieldRow(_("Default"), selectboxCustomArray('DefaultGroup', array( '0' => array('0'=>_("No"), '1'=>"No"),'1' => array('0'=>_("Yes"), '1'=>"Yes"), ), "", "s='d'  ", $dataObj->getDefaultGroup(), '', false), 'DefaultGroup', "", $this->commentsDefaultGroup, $this->commentsDefaultGroup_css, '', ' ', 'no');
$this->fields['AuthyGroup']['Admin']['html'] = stdFieldRow(_("Admin"), selectboxCustomArray('Admin', array( '0' => array('0'=>_("No"), '1'=>"No"),'1' => array('0'=>_("Yes"), '1'=>"Yes"), ), "", "s='d'  ", $dataObj->getAdmin(), '', false), 'Admin', "", $this->commentsAdmin, $this->commentsAdmin_css, '', ' ', 'no');
$this->fields['AuthyGroup']['RightsAll']['html'] = stdFieldRow(_("Rights"), $rightInputRightsAll, 'RightsAll', "", $this->commentsRightsAll, $this->commentsRightsAll_css, ' rightsTr', ' ', 'no');
$this->fields['AuthyGroup']['RightsOwner']['html'] = stdFieldRow(_("Rights owner"), $rightInputRightsOwner, 'RightsOwner', "", $this->commentsRightsOwner, $this->commentsRightsOwner_css, ' rightsTr', ' ', 'no');
$this->fields['AuthyGroup']['RightsGroup']['html'] = stdFieldRow(_("Rights group"), $rightInputRightsGroup, 'RightsGroup', "", $this->commentsRightsGroup, $this->commentsRightsGroup_css, ' rightsTr', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        $ongletf =
            div(
                ul(li(htmlLink(_('Group'),'#ogf_AuthyGroup',' j="ogf" p="AuthyGroup" class="ui-tabs-anchor" '))
                    .li(htmlLink(_('Rights'),'#ogf_Array',' j="ogf" class="ui-tabs-anchor" p="AuthyGroup" ')))
            ,'cntOngletAuthyGroup',' class="cntOnglet"')
        ;
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveAuthyGroup', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedAuthyGroup','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdAuthyGroup', $dataObj->getIdAuthyGroup(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formAuthyGroup [j='date']\").attr('type', 'text');
            $(\"#formAuthyGroup [j='date']\").each(function(){
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
                div('Group', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
                    '<div id="ogf_AuthyGroup">'.
$this->fields['AuthyGroup']['Name']['html']
.$this->fields['AuthyGroup']['Desc']['html']
.$this->fields['AuthyGroup']['DefaultGroup']['html']
.$this->fields['AuthyGroup']['Admin']['html']
.$this->fields['AuthyGroup']['RightsAll']['html']
.$this->fields['AuthyGroup']['RightsOwner']['html']
.$this->fields['AuthyGroup']['RightsGroup']['html'].'</div>'
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntAuthyGroup", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formAuthyGroup' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['AuthyGroup']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['AuthyGroup']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['AuthyGroup']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['AuthyGroup']['ixmemautocapp'];
            unset($_SESSION['mem']['AuthyGroup']['ixmemautocapp']);
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
        
{$tabRights?->getOnReadyJs()}
$('[j=mass-action-Rights]').bind('click', function(){
    var target = $(this).attr('target');
    if( $(this).prop('checked')){
        $(\"[j='rcRights\"+target+\"']\").prop('checked',true);
    }else{
        $(\"[j='rcRights\"+target+\"']\").prop('checked',false);
    }
});
$(\"[j='chkRights']\").click(function(){
    if($(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked')){
        $(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked',false);
    }else{
        $(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked',true);
    }
});
if($('#formAuthy #Group').val() == 'Admin'){
    $('#formAuthy #genRightsCtnr').hide();
}else{
    $('#formAuthy #genRightsCtnr').show();
}
$('#formAuthy #Group').change(function (){
    if($('#formAuthy #Group').val() == 'Admin'){
        $('#formAuthy #genRightsCtnr').hide();
    }else{
        $('#formAuthy #genRightsCtnr').show();
    }
});

$('.cntOnglet').parent().tabs();
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
            $(\"#formAuthyGroup [s='d'], #formAuthyGroup .js-select-label, #formAuthyGroup [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formAuthyGroup .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['AuthyGroup']['Name']['html'] = stdFieldRow(_("Name"), div( $dataObj->getName(), 'Name_label' , "class='readonly' s='d'")
                .input('hidden', 'Name', $dataObj->getName(), "s='d'"), 'Name', "", $this->commentsName, $this->commentsName_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['Desc']['html'] = stdFieldRow(_("Description"), div( $dataObj->getDesc(), 'Desc_label' , "class='readonly' s='d'")
                .input('hidden', 'Desc', $dataObj->getDesc(), "s='d'"), 'Desc', "", $this->commentsDesc, $this->commentsDesc_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['DefaultGroup']['html'] = stdFieldRow(_("Default"), div( $dataObj->getDefaultGroup(), 'DefaultGroup_label' , "class='readonly' s='d'")
                .input('hidden', 'DefaultGroup', $dataObj->getDefaultGroup(), "s='d'"), 'DefaultGroup', "", $this->commentsDefaultGroup, $this->commentsDefaultGroup_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['Admin']['html'] = stdFieldRow(_("Admin"), div( $dataObj->getAdmin(), 'Admin_label' , "class='readonly' s='d'")
                .input('hidden', 'Admin', $dataObj->getAdmin(), "s='d'"), 'Admin', "", $this->commentsAdmin, $this->commentsAdmin_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['RightsAll']['html'] = stdFieldRow(_("Rights"), div( $dataObj->getRightsAll(), 'RightsAll_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsAll', $dataObj->getRightsAll(), "s='d'"), 'RightsAll', "", $this->commentsRightsAll, $this->commentsRightsAll_css, 'readonly rightsTr', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['RightsOwner']['html'] = stdFieldRow(_("Rights owner"), div( $dataObj->getRightsOwner(), 'RightsOwner_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsOwner', $dataObj->getRightsOwner(), "s='d'"), 'RightsOwner', "", $this->commentsRightsOwner, $this->commentsRightsOwner_css, 'readonly rightsTr', ' ', 'no');

        $this->fieldsRo['AuthyGroup']['RightsGroup']['html'] = stdFieldRow(_("Rights group"), div( $dataObj->getRightsGroup(), 'RightsGroup_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsGroup', $dataObj->getRightsGroup(), "s='d'"), 'RightsGroup', "", $this->commentsRightsGroup, $this->commentsRightsGroup_css, 'readonly rightsTr', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['AuthyGroup'] as $field => $ar) {
                $this->fields['AuthyGroup'][$field]['html'] = $this->fieldsRo['AuthyGroup'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['AuthyGroup'][$field]['html'] = $this->fieldsRo['AuthyGroup'][$field]['html'];
            }
        }
    }
}
