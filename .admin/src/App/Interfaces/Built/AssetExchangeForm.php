<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'AssetExchange' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class AssetExchangeForm extends AssetExchange
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
        $this->model_name = 'AssetExchange';
        $this->virtualClassName = 'AssetExchange';
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

        $q = new AssetExchangeQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                
                #required asset_exchange
                ->leftJoinWith('Exchange');

        if( isset($this->searchMs['IdToken']) ) {
            $criteria = \Criteria::IN;
            $value = $this->searchMs['IdToken'];

            $q->filterByIdToken($value, $criteria);
        }
                
        }else{
            
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                
                #required asset_exchange
                ->leftJoinWith('Exchange');
                
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
                                $(\"#AssetExchangeListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Type"), " th='sorted' c='Type' title='" . _('Type')."' ")
.th(_("Exchange"), " th='sorted' c='Exchange.Name' title='"._('Exchange.Name')."' ")
.th(_("Free"), " th='sorted' c='FreeToken' title='" . _('Free')."' ")
.th(_("Locked"), " th='sorted' c='LockedToken' title='" . _('Locked')."' ")
.th(_("Frozen"), " th='sorted' c='FreezeToken' title='" . _('Frozen')."' ")
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
                
        $this->arrayIdExchangeOptions = $this->selectBoxAssetExchange_IdExchange($this, $emptyVar, $data);
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(input('text', 'IdToken', $this->searchMs['IdToken'], '  title="'._('Token').'" placeholder="'._('Token').'"',''),'','class="ac-search-item"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msAssetExchangeBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msAssetExchangeBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsAssetExchange'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addAssetExchange' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'AssetExchange';
        $altValue = array (
  'IdAssetExchange' => '',
  'IdAsset' => '',
  'Type' => '',
  'IdExchange' => '',
  'IdToken' => '',
  'FreeToken' => '',
  'LockedToken' => '',
  'FreezeToken' => '',
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
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'AssetExchange/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'AssetExchange/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'AssetExchange/');

        
        
        $default_order[]['FreeToken']='DESC';
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
                if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAssetExchange' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                                    $Exchange_Name = "";
                                    if($data->getExchange()){
                                        $Exchange_Name = $data->getExchange()->getName();
                                    }
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Type']) ? $altValue['Type'] : isntPo($data->getType())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Type' class='center'  j='editAssetExchange'") . 
                td(span((($altValue['IdExchange']) ? $altValue['IdExchange'] : $Exchange_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdExchange' class=''  j='editAssetExchange'") . 
                td(span((($altValue['FreeToken']) ? $altValue['FreeToken'] : str_replace(',', '.', $data->getFreeToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FreeToken' class='right'  j='editAssetExchange'") . 
                td(span((($altValue['LockedToken']) ? $altValue['LockedToken'] : str_replace(',', '.', $data->getLockedToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='LockedToken' class='right'  j='editAssetExchange'") . 
                td(span((($altValue['FreezeToken']) ? $altValue['FreezeToken'] : str_replace(',', '.', $data->getFreezeToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FreezeToken' class='right'  j='editAssetExchange'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='AssetExchangeRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountAssetExchange', $i);
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
                
                .div($controlsContent,'AssetExchangeControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='AssetExchangeTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'AssetExchangeListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#AssetExchangeListForm td[j='editAssetExchange']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#AssetExchangeListForm [j='deleteAssetExchange']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#AssetExchangePager').bindPaging({
            tableName:'AssetExchange'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msAssetExchangeBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msAssetExchangeBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsAssetExchange').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsAssetExchange .js-select-label').SelectBox();
            $('#formMsAssetExchange input[type=text]').first().focus();
            $('#formMsAssetExchange input[type=text]').first().putCursorAtEnd();
            $('#msAssetExchangeBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsAssetExchange').keydown(function(e) {
        if(e.which == 13) {
            $('#msAssetExchangeBt').click();
        }
    });

    $('#msAssetExchangeBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsAssetExchange input[type=text]:first-of-type').focus().putCursorAtEnd();
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

        if($('#addAssetExchangeAutoc').length > 0) {
            $('#addAssetExchangeAutoc').bind('click', function () {
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
    public function setCreateDefaultsAssetExchange($data)
    {

        unset($data['IdAssetExchange']);
        $e = new AssetExchange();
        
        
        if(!$data['Type']){
            $data['Type'] = "Spot";
        } 
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setFreeToken( ($data['FreeToken'] == '' ) ? null : $data['FreeToken']);
        //integer not required
        $e->setLockedToken( ($data['LockedToken'] == '' ) ? null : $data['LockedToken']);
        //integer not required
        $e->setFreezeToken( ($data['FreezeToken'] == '' ) ? null : $data['FreezeToken']);
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
    public function setUpdateDefaultsAssetExchange($data)
    {

        
        $e = AssetExchangeQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!$data['Type']){
            $data['Type'] = "Spot";
        } 
        $e->fromArray($data );

        
        
        if(isset($data['FreeToken'])){
            $e->setFreeToken( ($data['FreeToken'] == '' ) ? null : $data['FreeToken']);
        }
        if(isset($data['LockedToken'])){
            $e->setLockedToken( ($data['LockedToken'] == '' ) ? null : $data['LockedToken']);
        }
        if(isset($data['FreezeToken'])){
            $e->setFreezeToken( ($data['FreezeToken'] == '' ) ? null : $data['FreezeToken']);
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
     * Produce a formated form of AssetExchange
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

        $je = "AssetExchangeTable";

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
                
                case 'Asset':
                    $data['IdAsset'] = $data['ip'];
                    break;
                case 'Exchange':
                    $data['IdExchange'] = $data['ip'];
                    break;
                case 'Token':
                    $data['IdToken'] = $data['ip'];
                    break;
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
        if(($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'w') and $id) || $this->setReadOnly) {
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
                $('#formAssetExchange #saveAssetExchange').unbind('click.saveAssetExchange');
                $('#formAssetExchange #saveAssetExchange').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addAssetExchange' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = AssetExchangeQuery::create()
            
                #required asset_exchange
                ->leftJoinWith('Exchange')
            ;
            


            $dataObj = $q->filterByIdAssetExchange($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->AssetExchange['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new AssetExchange();
            $this->AssetExchange['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->AssetExchange['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


                                    ($dataObj->getExchange())?'':$dataObj->setExchange( new Exchange() );

        
        $this->arrayIdExchangeOptions = $this->selectBoxAssetExchange_IdExchange($this, $dataObj, $data);
        
        
        
        
        
        
$this->fields['AssetExchange']['Type']['html'] = stdFieldRow(_("Type"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Spot"), '1'=>"Spot"),'1' => array('0'=>_("Locked"), '1'=>"Locked"),'2' => array('0'=>_("Flexible"), '1'=>"Flexible"), ), "", "s='d'  ", $dataObj->getType(), '', false), 'Type', "", $this->commentsType, $this->commentsType_css, '', ' ', 'no');
$this->fields['AssetExchange']['IdExchange']['html'] = stdFieldRow(_("Exchange"), selectboxCustomArray('IdExchange', $this->arrayIdExchangeOptions, "", "v='ID_EXCHANGE'  s='d'  val='".$dataObj->getIdExchange()."'", $dataObj->getIdExchange()), 'IdExchange', "", $this->commentsIdExchange, $this->commentsIdExchange_css, '', ' ', 'no');
$this->fields['AssetExchange']['FreeToken']['html'] = stdFieldRow(_("Free"), input('text', 'FreeToken', $dataObj->getFreeToken(), "  placeholder='".str_replace("'","&#39;",_('Free'))."'  v='FREE_TOKEN' size='10' s='d' class=''"), 'FreeToken', "", $this->commentsFreeToken, $this->commentsFreeToken_css, '', ' ', 'no');
$this->fields['AssetExchange']['LockedToken']['html'] = stdFieldRow(_("Locked"), input('text', 'LockedToken', $dataObj->getLockedToken(), "  placeholder='".str_replace("'","&#39;",_('Locked'))."'  v='LOCKED_TOKEN' size='10' s='d' class=''"), 'LockedToken', "", $this->commentsLockedToken, $this->commentsLockedToken_css, '', ' ', 'no');
$this->fields['AssetExchange']['FreezeToken']['html'] = stdFieldRow(_("Frozen"), input('text', 'FreezeToken', $dataObj->getFreezeToken(), "  placeholder='".str_replace("'","&#39;",_('Frozen'))."'  v='FREEZE_TOKEN' size='10' s='d' class=''"), 'FreezeToken', "", $this->commentsFreezeToken, $this->commentsFreezeToken_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        $ongletf =
            div(
                ul(li(htmlLink(_('Wallet'),'#ogf_AssetExchange',' j="ogf" p="AssetExchange" class="ui-tabs-anchor" '))
                    .li(htmlLink(_('Other'),'#ogf_locked_token',' j="ogf" class="ui-tabs-anchor" p="AssetExchange" ')))
            ,'cntOngletAssetExchange',' class="cntOnglet"')
        ;
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveAssetExchange', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedAssetExchange','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdAssetExchange', $dataObj->getIdAssetExchange(), " s='d' pk").input('hidden', 'IdAsset', $dataObj->getIdAsset(), " s='d' nodesc").input('hidden', 'IdToken', $dataObj->getIdToken(), " s='d' nodesc").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formAssetExchange [j='date']\").attr('type', 'text');
            $(\"#formAssetExchange [j='date']\").each(function(){
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
                div('Wallet', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
                    '<div id="ogf_AssetExchange">'.
$this->fields['AssetExchange']['Type']['html']
.$this->fields['AssetExchange']['IdExchange']['html']
.$this->fields['AssetExchange']['FreeToken']['html']
.'</div><div id="ogf_locked_token"  class=" ui-tabs-panel">'
.$this->fields['AssetExchange']['LockedToken']['html']
.$this->fields['AssetExchange']['FreezeToken']['html'].'</div>'
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntAssetExchange", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formAssetExchange' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['AssetExchange']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['AssetExchange']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['AssetExchange']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['AssetExchange']['ixmemautocapp'];
            unset($_SESSION['mem']['AssetExchange']['ixmemautocapp']);
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
            $(\"#formAssetExchange [s='d'], #formAssetExchange .js-select-label, #formAssetExchange [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formAssetExchange .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['AssetExchange']['Type']['html'] = stdFieldRow(_("Type"), div( $dataObj->getType(), 'Type_label' , "class='readonly' s='d'")
                .input('hidden', 'Type', $dataObj->getType(), "s='d'"), 'Type', "", $this->commentsType, $this->commentsType_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AssetExchange']['IdExchange']['html'] = stdFieldRow(_("Exchange"), div( ($dataObj->getExchange())?$dataObj->getExchange()->getName():'', 'IdExchange_label' , "class='readonly' s='d'")
                .input('hidden', 'IdExchange', $dataObj->getIdExchange(), "s='d'"), 'IdExchange', "", $this->commentsIdExchange, $this->commentsIdExchange_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AssetExchange']['FreeToken']['html'] = stdFieldRow(_("Free"), div( $dataObj->getFreeToken(), 'FreeToken_label' , "class='readonly' s='d'")
                .input('hidden', 'FreeToken', $dataObj->getFreeToken(), "s='d'"), 'FreeToken', "", $this->commentsFreeToken, $this->commentsFreeToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AssetExchange']['LockedToken']['html'] = stdFieldRow(_("Locked"), div( $dataObj->getLockedToken(), 'LockedToken_label' , "class='readonly' s='d'")
                .input('hidden', 'LockedToken', $dataObj->getLockedToken(), "s='d'"), 'LockedToken', "", $this->commentsLockedToken, $this->commentsLockedToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['AssetExchange']['FreezeToken']['html'] = stdFieldRow(_("Frozen"), div( $dataObj->getFreezeToken(), 'FreezeToken_label' , "class='readonly' s='d'")
                .input('hidden', 'FreezeToken', $dataObj->getFreezeToken(), "s='d'"), 'FreezeToken', "", $this->commentsFreezeToken, $this->commentsFreezeToken_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['AssetExchange'] as $field => $ar) {
                $this->fields['AssetExchange'][$field]['html'] = $this->fieldsRo['AssetExchange'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['AssetExchange'][$field]['html'] = $this->fieldsRo['AssetExchange'][$field]['html'];
            }
        }
    }

    /**
     * Query for AssetExchange_IdExchange selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxAssetExchange_IdExchange(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = ExchangeQuery::create();

            $q->select(array('Name', 'IdExchange'));
            $q->orderBy('Name', 'ASC');
        
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
