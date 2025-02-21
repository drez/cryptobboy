<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Asset' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class AssetForm extends Asset
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
        $this->model_name = 'Asset';
        $this->virtualClassName = 'Asset';
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

        $q = new AssetQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                
                #required asset
                ->leftJoinWith('Token')
                #default
                ->leftJoinWith('Symbol');

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
                
                #required asset
                ->leftJoinWith('Token')
                #default
                ->leftJoinWith('Symbol');
                
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
                                $(\"#AssetListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Token ticker"), " th='sorted' c='Token.Ticker' title='"._('Token.Ticker')."' ")
.th(_("Avg. price"), " th='sorted' c='AvgPrice' title='" . _('Avg. price')."' ")
.th(_("Free"), " th='sorted' c='FreeToken' title='" . _('Free')."' ")
.th(_("Value USD"), " th='sorted' c='UsdValue' title='" . _('Value USD')."' ")
.th(_("Total"), " th='sorted' c='TotalToken' title='" . _('Total')."' ")
.th(_("Profit"), " th='sorted' c='Profit' title='" . _('Profit')."' ")
.th(_("Staked"), " th='sorted' c='StakedToken' title='" . _('Staked')."' ")
.th(_("Flexible"), " th='sorted' c='FlexibleToken' title='" . _('Flexible')."' ")
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
                
        $this->arrayIdTokenOptions = $this->selectBoxAsset_IdToken($this, $emptyVar, $data);
        $this->arrayIdSymbolOptions = $this->selectBoxAsset_IdSymbol($this, $emptyVar, $data);
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(selectboxCustomArray('IdToken[]', $this->arrayIdTokenOptions, 'Token' , "v='ID_TOKEN'  s='d' class='select-label js-select-label' multiple size='1'  ", $this->searchMs['IdToken'], '', false), '', ' class="ac-search-item multiple-select"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msAssetBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msAssetBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsAsset'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('Asset', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addAsset' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'Asset';
        $altValue = array (
  'IdAsset' => '',
  'IdToken' => '',
  'AvgPrice' => '',
  'FreeToken' => '',
  'UsdValue' => '',
  'TotalToken' => '',
  'Profit' => '',
  'StakedToken' => '',
  'IdSymbol' => '',
  'FlexibleToken' => '',
  'LockedToken' => '',
  'FreezeToken' => '',
  'LastSync' => '',
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
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Asset/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Asset/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Asset/');

        if (method_exists($this, 'beforeList')){ $this->beforeList($request, $pmpoDataIn );}
        
        $default_order[]['TotalToken']='DESC';
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
                if($_SESSION[_AUTH_VAR]->hasRights('Asset', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAsset' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
        $altValue['Token_Ticker'] = "";
        if($data->getToken()){
            $altValue['Token_Ticker'] = $data->getToken()->getTicker();
        }
                if (method_exists($this, 'beforeListTr')){ $this->beforeListTr($altValue, $data, $i, $hook, $cCmoreCols);}
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= $hook['tr_before'].tr(
                td(span((($altValue['IdToken']) ? $altValue['IdToken'] : $altValue['Token_Ticker']) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdToken' class=''  j='editAsset'") . 
                td(span((($altValue['AvgPrice']) ? $altValue['AvgPrice'] : str_replace(',', '.', $data->getAvgPrice())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='AvgPrice' class='right'  j='editAsset'") . 
                td(span((($altValue['FreeToken']) ? $altValue['FreeToken'] : str_replace(',', '.', $data->getFreeToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FreeToken' class='right'  j='editAsset'") . 
                td(span((($altValue['UsdValue']) ? $altValue['UsdValue'] : str_replace(',', '.', $data->getUsdValue())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='UsdValue' class='right'  j='editAsset'") . 
                td(span((($altValue['TotalToken']) ? $altValue['TotalToken'] : str_replace(',', '.', $data->getTotalToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='TotalToken' class='right'  j='editAsset'") . 
                td(span((($altValue['Profit']) ? $altValue['Profit'] : str_replace(',', '.', $data->getProfit())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Profit' class='right'  j='editAsset'") . 
                td(span((($altValue['StakedToken']) ? $altValue['StakedToken'] : str_replace(',', '.', $data->getStakedToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='StakedToken' class='right'  j='editAsset'") . 
                td(span((($altValue['FlexibleToken']) ? $altValue['FlexibleToken'] : str_replace(',', '.', $data->getFlexibleToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FlexibleToken' class='right'  j='editAsset'") . $hook['td'].$cCmoreCols.$actionCell
                , " ".$hook['tr']."
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='AssetRow".$data->getPrimaryKey()."'")
                .$hook['tr_after'];
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountAsset', $i);
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
                
                .div($controlsContent,'AssetControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='AssetTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'AssetListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#AssetListForm td[j='editAsset']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#AssetListForm [j='deleteAsset']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#AssetPager').bindPaging({
            tableName:'Asset'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msAssetBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msAssetBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsAsset').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsAsset .js-select-label').SelectBox();
            $('#formMsAsset input[type=text]').first().focus();
            $('#formMsAsset input[type=text]').first().putCursorAtEnd();
            $('#msAssetBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsAsset').keydown(function(e) {
        if(e.which == 13) {
            $('#msAssetBt').click();
        }
    });

    $('#msAssetBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsAsset input[type=text]:first-of-type').focus().putCursorAtEnd();
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

        if($('#addAssetAutoc').length > 0) {
            $('#addAssetAutoc').bind('click', function () {
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
    public function setCreateDefaultsAsset($data)
    {

        unset($data['IdAsset']);
        $e = new Asset();
        
        
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setAvgPrice( ($data['AvgPrice'] == '' ) ? null : $data['AvgPrice']);
        //integer not required
        $e->setFreeToken( ($data['FreeToken'] == '' ) ? null : $data['FreeToken']);
        //integer not required
        $e->setUsdValue( ($data['UsdValue'] == '' ) ? null : $data['UsdValue']);
        //integer not required
        $e->setTotalToken( ($data['TotalToken'] == '' ) ? null : $data['TotalToken']);
        //integer not required
        $e->setProfit( ($data['Profit'] == '' ) ? null : $data['Profit']);
        //integer not required
        $e->setStakedToken( ($data['StakedToken'] == '' ) ? null : $data['StakedToken']);
        //foreign
        $e->setIdSymbol(( $data['IdSymbol'] == '' ) ? null : $data['IdSymbol']);
        //integer not required
        $e->setFlexibleToken( ($data['FlexibleToken'] == '' ) ? null : $data['FlexibleToken']);
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
    public function setUpdateDefaultsAsset($data)
    {

        
        $e = AssetQuery::create()->findPk(json_decode($data['i']));
        
        
        $e->fromArray($data );

        
        
        if(isset($data['AvgPrice'])){
            $e->setAvgPrice( ($data['AvgPrice'] == '' ) ? null : $data['AvgPrice']);
        }
        if(isset($data['FreeToken'])){
            $e->setFreeToken( ($data['FreeToken'] == '' ) ? null : $data['FreeToken']);
        }
        if(isset($data['UsdValue'])){
            $e->setUsdValue( ($data['UsdValue'] == '' ) ? null : $data['UsdValue']);
        }
        if(isset($data['TotalToken'])){
            $e->setTotalToken( ($data['TotalToken'] == '' ) ? null : $data['TotalToken']);
        }
        if(isset($data['Profit'])){
            $e->setProfit( ($data['Profit'] == '' ) ? null : $data['Profit']);
        }
        if(isset($data['StakedToken'])){
            $e->setStakedToken( ($data['StakedToken'] == '' ) ? null : $data['StakedToken']);
        }
        if( isset($data['IdSymbol']) ){
            $e->setIdSymbol(( $data['IdSymbol'] == '' ) ? null : $data['IdSymbol']);
        }
        if(isset($data['FlexibleToken'])){
            $e->setFlexibleToken( ($data['FlexibleToken'] == '' ) ? null : $data['FlexibleToken']);
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
     * Produce a formated form of Asset
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

        $je = "AssetTable";

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
                
                case 'Token':
                    $data['IdToken'] = $data['ip'];
                    break;
                case 'Symbol':
                    $data['IdSymbol'] = $data['ip'];
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
        if(($_SESSION[_AUTH_VAR]->hasRights('Asset', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Asset', 'w') and $id) || $this->setReadOnly) {
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
                $('#formAsset #saveAsset').unbind('click.saveAsset');
                $('#formAsset #saveAsset').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Asset', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addAsset' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = AssetQuery::create()
            
                #required asset
                ->leftJoinWith('Token')
                #default
                ->leftJoinWith('Symbol')
            ;
            


            $dataObj = $q->filterByIdAsset($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Asset['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Asset();
            $this->Asset['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Asset['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


                                    ($dataObj->getToken())?'':$dataObj->setToken( new Token() );
                                    ($dataObj->getSymbol())?'':$dataObj->setSymbol( new Symbol() );

        
        $this->arrayIdTokenOptions = $this->selectBoxAsset_IdToken($this, $dataObj, $data);
        $this->arrayIdSymbolOptions = $this->selectBoxAsset_IdSymbol($this, $dataObj, $data);
        
        
        
        
        
        
$this->fields['Asset']['IdToken']['html'] = stdFieldRow(_("Token"), selectboxCustomArray('IdToken', $this->arrayIdTokenOptions, "", "v='ID_TOKEN'  s='d'  val='".$dataObj->getIdToken()."'", $dataObj->getIdToken()), 'IdToken', "", $this->commentsIdToken, $this->commentsIdToken_css, '', ' ', 'no');
$this->fields['Asset']['AvgPrice']['html'] = stdFieldRow(_("Avg. price"), input('text', 'AvgPrice', $dataObj->getAvgPrice(), "  placeholder='".str_replace("'","&#39;",_('Avg. price'))."'  v='AVG_PRICE' size='10' s='d' class=''"), 'AvgPrice', "", $this->commentsAvgPrice, $this->commentsAvgPrice_css, '', ' ', 'no');
$this->fields['Asset']['FreeToken']['html'] = stdFieldRow(_("Free"), input('text', 'FreeToken', $dataObj->getFreeToken(), "  placeholder='".str_replace("'","&#39;",_('Free'))."'  v='FREE_TOKEN' size='10' s='d' class='req'"), 'FreeToken', "", $this->commentsFreeToken, $this->commentsFreeToken_css, '', ' ', 'no');
$this->fields['Asset']['UsdValue']['html'] = stdFieldRow(_("Value USD"), input('text', 'UsdValue', $dataObj->getUsdValue(), "  placeholder='".str_replace("'","&#39;",_('Value USD'))."'  v='USD_VALUE' size='10' s='d' class=''"), 'UsdValue', "", $this->commentsUsdValue, $this->commentsUsdValue_css, '', ' ', 'no');
$this->fields['Asset']['TotalToken']['html'] = stdFieldRow(_("Total"), input('text', 'TotalToken', $dataObj->getTotalToken(), "  placeholder='".str_replace("'","&#39;",_('Total'))."'  v='TOTAL_TOKEN' size='10' s='d' class=''"), 'TotalToken', "", $this->commentsTotalToken, $this->commentsTotalToken_css, '', ' ', 'no');
$this->fields['Asset']['Profit']['html'] = stdFieldRow(_("Profit"), input('text', 'Profit', $dataObj->getProfit(), "  placeholder='".str_replace("'","&#39;",_('Profit'))."'  v='PROFIT' size='10' s='d' class=''"), 'Profit', "", $this->commentsProfit, $this->commentsProfit_css, '', ' ', 'no');
$this->fields['Asset']['StakedToken']['html'] = stdFieldRow(_("Staked"), input('text', 'StakedToken', $dataObj->getStakedToken(), "  placeholder='".str_replace("'","&#39;",_('Staked'))."'  v='STAKED_TOKEN' size='10' s='d' class=''"), 'StakedToken', "", $this->commentsStakedToken, $this->commentsStakedToken_css, '', ' ', 'no');
$this->fields['Asset']['IdSymbol']['html'] = stdFieldRow(_("Trading pair"), selectboxCustomArray('IdSymbol', $this->arrayIdSymbolOptions, _('Trading pair'), "v='ID_SYMBOL'  s='d'  val='".$dataObj->getIdSymbol()."'", $dataObj->getIdSymbol()), 'IdSymbol', "", $this->commentsIdSymbol, $this->commentsIdSymbol_css, '', ' ', 'no');
$this->fields['Asset']['FlexibleToken']['html'] = stdFieldRow(_("Flexible"), input('text', 'FlexibleToken', $dataObj->getFlexibleToken(), "  placeholder='".str_replace("'","&#39;",_('Flexible'))."'  v='FLEXIBLE_TOKEN' size='10' s='d' class=''"), 'FlexibleToken', "", $this->commentsFlexibleToken, $this->commentsFlexibleToken_css, '', ' ', 'no');
$this->fields['Asset']['LockedToken']['html'] = stdFieldRow(_("Locked"), input('text', 'LockedToken', $dataObj->getLockedToken(), "  placeholder='".str_replace("'","&#39;",_('Locked'))."'  v='LOCKED_TOKEN' size='10' s='d' class=''"), 'LockedToken', "", $this->commentsLockedToken, $this->commentsLockedToken_css, '', ' ', 'no');
$this->fields['Asset']['FreezeToken']['html'] = stdFieldRow(_("Frozen"), input('text', 'FreezeToken', $dataObj->getFreezeToken(), "  placeholder='".str_replace("'","&#39;",_('Frozen'))."'  v='FREEZE_TOKEN' size='10' s='d' class=''"), 'FreezeToken', "", $this->commentsFreezeToken, $this->commentsFreezeToken_css, '', ' ', 'no');
$this->fields['Asset']['LastSync']['html'] = stdFieldRow(_("Last sync"), input('datetime-local', 'LastSync', $dataObj->getLastSync(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD hh:mm:ss' size='30'  s='d' class='' title='Last sync'"), 'LastSync', "", $this->commentsLastSync, $this->commentsLastSync_css, '', ' ', 'no');


        $this->lockFormField(array(0=>'FreeToken',1=>'StakedToken',2=>'TotalToken',3=>'UsdValue',4=>'LockedToken',5=>'FlexibleToken',6=>'FreezeToken',7=>'LastSync',8=>'AvgPrice',9=>'Profit',10=>'LastSync',), $dataObj);

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }


        if( !isset($this->Asset['request']['ChildHide']) ) {

            # define child lists 'Trade'
            $ongletTab['0']['t'] = _('Trade');
            $ongletTab['0']['p'] = 'Trade';
            $ongletTab['0']['lkey'] = 'IdAsset';
            $ongletTab['0']['fkey'] = 'IdAsset';
            # define child lists 'Wallet'
            $ongletTab['1']['t'] = _('Wallet');
            $ongletTab['1']['p'] = 'AssetExchange';
            $ongletTab['1']['lkey'] = 'IdAsset';
            $ongletTab['1']['fkey'] = 'IdAsset';
        if(!empty($ongletTab) and $dataObj->getIdAsset()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights($value['p'], 'r')){

                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        $ChildOnglet .= li(
                                        htmlLink(	_($value['t'])
                                            ,'javascript:',"p='".$value['p']."' act='list' j=conglet_Asset ip='".$dataObj->$getLocalKey()."' class='ui-state-default' ")
                                    ,"  class='' j=sm  ");
                    }
                }
            }

            if($ChildOnglet){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Asset]').bind('click', function (data){
                        pp = $(this).attr('p');
                        $('#cntAssetChild').html( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg') );
                        $.get('"._SITE_URL."Asset/'+pp+'/'+$(this).attr('ip'), { ui: pp+'Table', 'pui':'".$uiTabsId."', pc:'".$data['pc']."'}, function(data){
                            $('#cntAssetChild').html(data);
                            $('[j=conglet_Asset]').parent().attr('class','ui-state-default');
                            $('[j=conglet_Asset][p='+pp+']').parent().attr('class',' ui-state-default ui-state-active');
                        }).fail(function(data) {
                            $('#cntAssetChild').html('Error: try again or contact your administrator.');
                            console.log(data);
                        });;
                    });
                ";
                if($_SESSION['mem']['Asset']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['mem']['Asset']['child']['list'][$dataObj->$getLocalKey()];
                    $childTable['onReadyJs'] .= " $('[j=conglet_Asset][p=".$onglet_p."]').first().click();";
                }else{
                    $childTable['onReadyJs'] .= " $('[j=conglet_Asset]').first().click();";
                }
            }
        }
        }
        $ongletf =
            div(
                ul(li(htmlLink(_('Asset'),'#ogf_Asset',' j="ogf" p="Asset" class="ui-tabs-anchor" '))
                    .li(htmlLink(_('Other'),'#ogf_locked_token',' j="ogf" class="ui-tabs-anchor" p="Asset" ')))
            ,'cntOngletAsset',' class="cntOnglet"')
        ;
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveAsset', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedAsset','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdAsset', $dataObj->getIdAsset(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
                            .$this->hookListSearchButton
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        if (method_exists($this, 'afterFormObj')){ $this->afterFormObj($data, $dataObj);}
        

        //Form header
        $header_top = div(
                            div(href(span(_('Display/Hide menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                        .$this->formAddButton,'','class="default-controls"')
                        .$this->printLink
                            .$this->hookSwHeader.$HelpDiv
                        , '', 'class="sw-header"');
        $header_top_onglet = $this->formTitle.$ongletf;

        /*if(!isMobile()) {
            $jqueryDatePicker = " $(\"#formAsset [j='date']\").attr('type', 'text');
            $(\"#formAsset [j='date']\").each(function(){
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
                div('Asset', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
                    '<div id="ogf_Asset">'.
$this->fields['Asset']['IdToken']['html']
.$this->fields['Asset']['AvgPrice']['html']
.$this->fields['Asset']['FreeToken']['html']
.$this->fields['Asset']['UsdValue']['html']
.$this->fields['Asset']['TotalToken']['html']
.$this->fields['Asset']['Profit']['html']
.$this->fields['Asset']['StakedToken']['html']
.$this->fields['Asset']['IdSymbol']['html']
.$this->fields['Asset']['FlexibleToken']['html']
.'</div><div id="ogf_locked_token"  class=" ui-tabs-panel">'
.$this->fields['Asset']['LockedToken']['html']
.$this->fields['Asset']['FreezeToken']['html']
.$this->fields['Asset']['LastSync']['html'].'</div>'
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntAsset", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formAsset' class='mainForm formContent' ")
        .$this->hookFormBottom;


        //if not new, show child table
        if($dataObj->getIdAsset()) {
            if($ChildOnglet) {
                $return['html'] .= div(
                                        div('Child(s)', '', "class='panel-heading'")
                                        . ul($ChildOnglet, " class=' ui-tabs-nav ' ")
                                        . div('','cntAssetChild',' class="" ')
                                    , 'pannelAsset', " class='child_pannel ui-tabs childCntClass'");
            }
        }

        if($id and $_SESSION['mem']['Asset']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Asset']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Asset']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Asset']['ixmemautocapp'];
            unset($_SESSION['mem']['Asset']['ixmemautocapp']);
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
            $(\"#formAsset [s='d'], #formAsset .js-select-label, #formAsset [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formAsset .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Asset']['IdToken']['html'] = stdFieldRow(_("Token"), div( ($dataObj->getToken())?$dataObj->getToken()->getTicker():'', 'IdToken_label' , "class='readonly' s='d'")
                .input('hidden', 'IdToken', $dataObj->getIdToken(), "s='d'"), 'IdToken', "", $this->commentsIdToken, $this->commentsIdToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['AvgPrice']['html'] = stdFieldRow(_("Avg. price"), div( $dataObj->getAvgPrice(), 'AvgPrice_label' , "class='readonly' s='d'")
                .input('hidden', 'AvgPrice', $dataObj->getAvgPrice(), "s='d'"), 'AvgPrice', "", $this->commentsAvgPrice, $this->commentsAvgPrice_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['FreeToken']['html'] = stdFieldRow(_("Free"), div( $dataObj->getFreeToken(), 'FreeToken_label' , "class='readonly' s='d'")
                .input('hidden', 'FreeToken', $dataObj->getFreeToken(), "s='d'"), 'FreeToken', "", $this->commentsFreeToken, $this->commentsFreeToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['UsdValue']['html'] = stdFieldRow(_("Value USD"), div( $dataObj->getUsdValue(), 'UsdValue_label' , "class='readonly' s='d'")
                .input('hidden', 'UsdValue', $dataObj->getUsdValue(), "s='d'"), 'UsdValue', "", $this->commentsUsdValue, $this->commentsUsdValue_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['TotalToken']['html'] = stdFieldRow(_("Total"), div( $dataObj->getTotalToken(), 'TotalToken_label' , "class='readonly' s='d'")
                .input('hidden', 'TotalToken', $dataObj->getTotalToken(), "s='d'"), 'TotalToken', "", $this->commentsTotalToken, $this->commentsTotalToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['Profit']['html'] = stdFieldRow(_("Profit"), div( $dataObj->getProfit(), 'Profit_label' , "class='readonly' s='d'")
                .input('hidden', 'Profit', $dataObj->getProfit(), "s='d'"), 'Profit', "", $this->commentsProfit, $this->commentsProfit_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['StakedToken']['html'] = stdFieldRow(_("Staked"), div( $dataObj->getStakedToken(), 'StakedToken_label' , "class='readonly' s='d'")
                .input('hidden', 'StakedToken', $dataObj->getStakedToken(), "s='d'"), 'StakedToken', "", $this->commentsStakedToken, $this->commentsStakedToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['IdSymbol']['html'] = stdFieldRow(_("Trading pair"), div( ($dataObj->getSymbol())?$dataObj->getSymbol()->getName():'', 'IdSymbol_label' , "class='readonly' s='d'")
                .input('hidden', 'IdSymbol', $dataObj->getIdSymbol(), "s='d'"), 'IdSymbol', "", $this->commentsIdSymbol, $this->commentsIdSymbol_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['FlexibleToken']['html'] = stdFieldRow(_("Flexible"), div( $dataObj->getFlexibleToken(), 'FlexibleToken_label' , "class='readonly' s='d'")
                .input('hidden', 'FlexibleToken', $dataObj->getFlexibleToken(), "s='d'"), 'FlexibleToken', "", $this->commentsFlexibleToken, $this->commentsFlexibleToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['LockedToken']['html'] = stdFieldRow(_("Locked"), div( $dataObj->getLockedToken(), 'LockedToken_label' , "class='readonly' s='d'")
                .input('hidden', 'LockedToken', $dataObj->getLockedToken(), "s='d'"), 'LockedToken', "", $this->commentsLockedToken, $this->commentsLockedToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['FreezeToken']['html'] = stdFieldRow(_("Frozen"), div( $dataObj->getFreezeToken(), 'FreezeToken_label' , "class='readonly' s='d'")
                .input('hidden', 'FreezeToken', $dataObj->getFreezeToken(), "s='d'"), 'FreezeToken', "", $this->commentsFreezeToken, $this->commentsFreezeToken_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Asset']['LastSync']['html'] = stdFieldRow(_("Last sync"), div( $dataObj->getLastSync(), 'LastSync_label' , "class='readonly' s='d'")
                .input('hidden', 'LastSync', $dataObj->getLastSync(), "s='d'"), 'LastSync', "", $this->commentsLastSync, $this->commentsLastSync_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Asset'] as $field => $ar) {
                $this->fields['Asset'][$field]['html'] = $this->fieldsRo['Asset'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Asset'][$field]['html'] = $this->fieldsRo['Asset'][$field]['html'];
            }
        }
    }

    /**
     * Query for Asset_IdToken selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxAsset_IdToken(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = TokenQuery::create();

            $q->addAsColumn('selDisplay', ''.TokenPeer::TICKER.'');
            $q->select(array('selDisplay', 'IdToken'));
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
     * Query for Asset_IdSymbol selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxAsset_IdSymbol(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = SymbolQuery::create();

            if( $dataObj != ''){
                            $q->filterByIdToken($dataObj->getIdToken() );
                
                            
                        };
            $q->select(array('Name', 'IdSymbol'));
            $q->orderBy('Name', 'ASC');
        
            if(!$array){
                return $q;
            }else{
                $pcDataO = $q->find();
            }

            if(method_exists($this, 'selectboxDataAsset_IdSymbol')){ 
                $this->selectboxDataAsset_IdSymbol($pcDataO, $q, $override); 
            }


        
        if($override === false){
            $arrayOpt = $pcDataO->toArray();

            return assocToNum($arrayOpt , true);;
        }else{
            return $override;
        }
}

    /**
     * Query for Trade_IdExchange selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxTrade_IdExchange(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
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

    /**
     * Query for Trade_IdSymbol selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxTrade_IdSymbol(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = SymbolQuery::create();

            if( $dataObj != ''){
                            $q->filterByIdToken($dataObj->getIdToken() );
                
                            
                        };
            $q->select(array('Name', 'IdSymbol'));
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

    /**
     * Query for Trade_CommissionAsset selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxTrade_CommissionAsset(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
 $override=false;
        $q = TokenQuery::create();

            $q->addAsColumn('selDisplay', ''.TokenPeer::TICKER.'');
            $q->select(array('selDisplay', 'IdToken'));
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
     * function getTradeList
     * @param string $IdAsset
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getTradeList(String $IdAsset, array $request)
    {

        $this->TableName = 'Trade';
        $altValue = array (
  'IdTrade' => '',
  'StartAvg' => '',
  'Type' => '',
  'IdExchange' => '',
  'IdAsset' => '',
  'IdSymbol' => '',
  'Date' => '',
  'Qty' => '',
  'GrossUsd' => '',
  'Commission' => '',
  'CommissionAsset' => '',
  'OrderId' => '',
  'DateCreation' => '',
  'DateModification' => '',
  'IdGroupCreation' => '',
  'IdCreation' => '',
  'IdModification' => '',
);
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntAssetChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Asset/Trade');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'Asset/Trade');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Asset/Trade');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->Asset['request']['noHeader']) && $this->Asset['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdAsset'] = $IdAsset;
        if($dataObj == null){
            $dataObj = new Asset();
            $dataObj->setIdAsset($IdAsset);
        }

        $this->Trade['list_add'] = "
        $('#TradeListForm #addTrade').bindEdit({
                modelName: 'Trade',
                destUi: 'editDialog',
                pc:'{$this->virtualClassName}',
                ip:'".$IdAsset."',
                jet:'refreshChild',
                tp:'Trade',
                description: 'Trade'
        });
        ";
        $this->Trade['list_delete'] = "
        $(\"[j='deleteTrade']\").bindDelete({
            modelName:'Trade',
            ui:'cntTradedivChild',
            title: 'Trade',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'r')){
            $this->Trade['list_edit'] = "
        $(\"#TradeTable tr td[j='editTrade']\").bind('click', function (){
            
        $('#editDialog').html( $('<div>').append( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg').css('width', '300px')).css('width', '300px').css('margin', 'auto') );
        $('#editDialog').dialog({width:'auto'}).dialog('open');
        $.get('"._SITE_URL."Trade/edit/'+$(this).attr('i'),
                { ip:'".$IdAsset."', ui:'editDialog', pc:'{$this->virtualClassName}', je:'TradeTableCntnr', jet:'refreshChild', 'it-pos':$(this).data('iterator-pos') },
            function(data){ 
                dialogWidthClass($('#editDialog')); 
                $('#editDialog').html(data).dialog({width:'auto'});  
        });
        });";
        }

        #filters validation
        
        $filterKey = $IdAsset;
        $this->IdPk = $IdAsset;
        
        
        #main query
        
        // Normal query
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = TradeQuery::create();
        
        
        $q
                #required trade
                ->leftJoinWith('Exchange')
                #required trade
                ->leftJoinWith('Symbol')
                #default
                ->leftJoinWith('Token') 
            
            ->filterByIdAsset( $filterKey );; 
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
           
        
        $this->queryObjTrade = $q;
        
        $pmpoData =$q->paginate($search['page'], $maxPerPage);
        $resultsCount = $pmpoData->getNbResults();
        
        //custom hook
        if (method_exists($this, 'beforeChildListTrade')){
            $this->beforeChildListTrade();
        }
         
        #options building
        
        $this->arrayIdExchangeOptions = $this->selectBoxTrade_IdExchange($this, $dataObj, $data);
        $this->arrayIdSymbolOptions = $this->selectBoxTrade_IdSymbol($this, $dataObj, $data);
        $this->arrayCommissionAssetOptions = $this->selectBoxTrade_CommissionAsset($this, $dataObj, $data);
        
        
          
        
        if(isset($this->Asset['request']['noHeader']) && $this->Asset['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("Avg"), " th='sorted' c='StartAvg' title='" . _('Avg')."' ")
.th(_("State"), " th='sorted' c='Type' title='" . _('State')."' ")
.th(_("Exchange"), " th='sorted' c='Exchange.Name' title='"._('Exchange.Name')."' ")
.th(_("Trading pair"), " th='sorted' c='Symbol.Name' title='"._('Symbol.Name')."' ")
.th(_("Date"), " th='sorted' c='Date' title='" . _('Date')."' ")
.th(_("Qty"), " th='sorted' c='Qty' title='" . _('Qty')."' ")
.th(_("Price"), " th='sorted' c='GrossUsd' title='" . _('Price')."' ")
.'' . $actionRowHeader, " ln='Trade' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No Trade found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Trade' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellTrade = '';
                $actionRow = '';
                
                
                
                if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'd')){
                    $actionRow = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteTrade' i='".json_encode($data->getPrimaryKey())."'");
                }
                
                
                
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellTrade.$actionRow," class='actionrow'") : "";
                
                                    $Exchange_Name = "";
                                    if($data->getExchange()){
                                        $Exchange_Name = $data->getExchange()->getName();
                                    }
                                    $Symbol_Name = "";
                                    if($data->getSymbol()){
                                        $Symbol_Name = $data->getSymbol()->getName();
                                    }
                
                
                ;
                
                
                
                // custom hooks
                if (method_exists($this, 'beforeListTrTrade')){ 
                    $this->beforeListTrTrade($altValue, $data, $i, $param, $actionRow);
                }
                
                $tr .= $param['tr_before'].
                        tr(
                            (isset($this->hookListColumnsTradeFirst)?$this->hookListColumnsTradeFirst:'').
                            
                td(span((($altValue['StartAvg']) ? $altValue['StartAvg'] : isntPo($data->getStartAvg())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='StartAvg' class='center'  j='editTrade'") . 
                td(span((($altValue['Type']) ? $altValue['Type'] : isntPo($data->getType())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Type' class='center'  j='editTrade'") . 
                td(span((($altValue['IdExchange']) ? $altValue['IdExchange'] : $Exchange_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdExchange' class=''  j='editTrade'") . 
                td(span((($altValue['IdSymbol']) ? $altValue['IdSymbol'] : $Symbol_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdSymbol' class=''  j='editTrade'") . 
                td(span((($altValue['Date']) ? $altValue['Date'] : $data->getDate()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Date' class=''  j='editTrade'") . 
                td(span((($altValue['Qty']) ? $altValue['Qty'] : str_replace(',', '.', $data->getQty())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Qty' class='right'  j='editTrade'") . 
                td(span((($altValue['GrossUsd']) ? $altValue['GrossUsd'] : str_replace(',', '.', $data->getGrossUsd())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='GrossUsd' class='right'  j='editTrade'") . 
                            (isset($this->hookListColumnsTrade)?$this->hookListColumnsTrade:'').
                            $actionRow
                            .$param['tr_after']
                        ,"id='TradeRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='Trade' ".$param['tr']." ");
                        
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(
                                    div($total_child,'','class="nolink"')
                            ,'trTrade'," ln='Trade' class=''").$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    if(($_SESSION[_AUTH_VAR]->hasRights('Trade', 'a')) ){
        $add_button_child = htmlLink(span(_("Add")), "Javascript:","title='Add "._('Trade')."' id='addTrade' class='button-link-blue add-button'");
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookTradeListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookTradeTableFooter
                                , "id='TradeTable' class='tablesorter'")
                            , 'childlistTrade')
                            .$this->hookTradeListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'TradeListForm')
            ,'cntTradedivChild', "class='childListWrapper'");

            
            

            $return['onReadyJs'] =
                $this->hookListReadyJsFirstTrade
                .""
                .$this->Trade['list_add']
                .$this->Trade['list_delete']
                .$this->Trade['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
                
        /* PAGINATION */
        $('#TradePager').bindPaging({
            tableName:'Trade'
            , parentId:'".$IdAsset."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/Trade/$IdAsset'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'Trade',
            url:'".$this->virtualClassName."/Trade/$IdAsset',
            destUi:'".$uiTabsId."'
        });
       
        $('#cntAssetChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "
                "
                . $this->hookListReadyJsTrade;
        return $return;
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
    /**
     * function getAssetExchangeList
     * @param string $IdAsset
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getAssetExchangeList(String $IdAsset, array $request)
    {

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
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntAssetChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Asset/AssetExchange');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'Asset/AssetExchange');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Asset/AssetExchange');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->Asset['request']['noHeader']) && $this->Asset['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdAsset'] = $IdAsset;
        if($dataObj == null){
            $dataObj = new Asset();
            $dataObj->setIdAsset($IdAsset);
        }

        $this->AssetExchange['list_add'] = "
        $('#AssetExchangeListForm #addAssetExchange').bindEdit({
                modelName: 'AssetExchange',
                destUi: 'editDialog',
                pc:'{$this->virtualClassName}',
                ip:'".$IdAsset."',
                jet:'refreshChild',
                tp:'AssetExchange',
                description: 'Wallet'
        });
        ";
        $this->AssetExchange['list_delete'] = "
        $(\"[j='deleteAssetExchange']\").bindDelete({
            modelName:'AssetExchange',
            ui:'cntAssetExchangedivChild',
            title: 'Wallet',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'r')){
            $this->AssetExchange['list_edit'] = "
        $(\"#AssetExchangeTable tr td[j='editAssetExchange']\").bind('click', function (){
            
        $('#editDialog').html( $('<div>').append( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg').css('width', '300px')).css('width', '300px').css('margin', 'auto') );
        $('#editDialog').dialog({width:'auto'}).dialog('open');
        $.get('"._SITE_URL."AssetExchange/edit/'+$(this).attr('i'),
                { ip:'".$IdAsset."', ui:'editDialog', pc:'{$this->virtualClassName}', je:'AssetExchangeTableCntnr', jet:'refreshChild', 'it-pos':$(this).data('iterator-pos') },
            function(data){ 
                dialogWidthClass($('#editDialog')); 
                $('#editDialog').html(data).dialog({width:'auto'});  
        });
        });";
        }

        #filters validation
        
        $filterKey = $IdAsset;
        $this->IdPk = $IdAsset;
        
        
        #main query
        
        // Normal query
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = AssetExchangeQuery::create();
        
        
        $q
                #required asset_exchange
                ->leftJoinWith('Exchange') 
            
            ->filterByIdAsset( $filterKey );; 
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
           
        
        $this->queryObjAssetExchange = $q;
        
        $pmpoData =$q->paginate($search['page'], $maxPerPage);
        $resultsCount = $pmpoData->getNbResults();
        
         
        #options building
        
        $this->arrayIdExchangeOptions = $this->selectBoxAssetExchange_IdExchange($this, $dataObj, $data);
        
        
          
        
        if(isset($this->Asset['request']['noHeader']) && $this->Asset['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("Type"), " th='sorted' c='Type' title='" . _('Type')."' ")
.th(_("Exchange"), " th='sorted' c='Exchange.Name' title='"._('Exchange.Name')."' ")
.th(_("Free"), " th='sorted' c='FreeToken' title='" . _('Free')."' ")
.th(_("Locked"), " th='sorted' c='LockedToken' title='" . _('Locked')."' ")
.th(_("Frozen"), " th='sorted' c='FreezeToken' title='" . _('Frozen')."' ")
.'' . $actionRowHeader, " ln='AssetExchange' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No Wallet found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='AssetExchange' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellAssetExchange = '';
                $actionRow = '';
                
                
                
                if($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'd')){
                    $actionRow = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAssetExchange' i='".json_encode($data->getPrimaryKey())."'");
                }
                
                
                
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellAssetExchange.$actionRow," class='actionrow'") : "";
                
                                    $Exchange_Name = "";
                                    if($data->getExchange()){
                                        $Exchange_Name = $data->getExchange()->getName();
                                    }
                
                
                ;
                
                
                
                $tr .= 
                        tr(
                            (isset($this->hookListColumnsAssetExchangeFirst)?$this->hookListColumnsAssetExchangeFirst:'').
                            
                td(span((($altValue['Type']) ? $altValue['Type'] : isntPo($data->getType())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Type' class='center'  j='editAssetExchange'") . 
                td(span((($altValue['IdExchange']) ? $altValue['IdExchange'] : $Exchange_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdExchange' class=''  j='editAssetExchange'") . 
                td(span((($altValue['FreeToken']) ? $altValue['FreeToken'] : str_replace(',', '.', $data->getFreeToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FreeToken' class='right'  j='editAssetExchange'") . 
                td(span((($altValue['LockedToken']) ? $altValue['LockedToken'] : str_replace(',', '.', $data->getLockedToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='LockedToken' class='right'  j='editAssetExchange'") . 
                td(span((($altValue['FreezeToken']) ? $altValue['FreezeToken'] : str_replace(',', '.', $data->getFreezeToken())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='FreezeToken' class='right'  j='editAssetExchange'") . 
                            (isset($this->hookListColumnsAssetExchange)?$this->hookListColumnsAssetExchange:'').
                            $actionRow
                            
                        ,"id='AssetExchangeRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='AssetExchange'  ");
                        
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(
                                    div($total_child,'','class="nolink"')
                            ,'trAssetExchange'," ln='AssetExchange' class=''").$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    if(($_SESSION[_AUTH_VAR]->hasRights('AssetExchange', 'a')) ){
        $add_button_child = htmlLink(span(_("Add")), "Javascript:","title='Add "._('Wallet')."' id='addAssetExchange' class='button-link-blue add-button'");
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookAssetExchangeListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookAssetExchangeTableFooter
                                , "id='AssetExchangeTable' class='tablesorter'")
                            , 'childlistAssetExchange')
                            .$this->hookAssetExchangeListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'AssetExchangeListForm')
            ,'cntAssetExchangedivChild', "class='childListWrapper'");

            
            

            $return['onReadyJs'] =
                $this->hookListReadyJsFirstAssetExchange
                .""
                .$this->AssetExchange['list_add']
                .$this->AssetExchange['list_delete']
                .$this->AssetExchange['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
                
        /* PAGINATION */
        $('#AssetExchangePager').bindPaging({
            tableName:'AssetExchange'
            , parentId:'".$IdAsset."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/AssetExchange/$IdAsset'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'AssetExchange',
            url:'".$this->virtualClassName."/AssetExchange/$IdAsset',
            destUi:'".$uiTabsId."'
        });
       
        $('#cntAssetChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "
                "
                . $this->hookListReadyJsAssetExchange;
        return $return;
    }
}
