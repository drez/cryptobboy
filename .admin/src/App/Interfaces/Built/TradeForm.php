<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Trade' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\FormHelper as Helper;

class TradeForm extends Trade
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
        $this->model_name = 'Trade';
        $this->virtualClassName = 'Trade';
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

        $q = new TradeQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                
                #required trade
                ->leftJoinWith('Exchange')
                #required trade
                ->leftJoinWith('Symbol')
                #default
                ->leftJoinWith('Token');

        if( isset($this->searchMs['Type']) ) {
            $criteria = \Criteria::IN;
            $value = $this->searchMs['Type'];

            $q->filterByType($value, $criteria);
        }
        if( isset($this->searchMs['IdExchange']) ) {
            $criteria = \Criteria::IN;
            $value = $this->searchMs['IdExchange'];

            $q->filterByIdExchange($value, $criteria);
        }
        if( isset($this->searchMs['Date']) ) {
            $criteria = \Criteria::EQUAL;

            $this->searchMs['Date_max'] = strtotime($value) + 86400;

            $value = $this->setCriteria($this->searchMs['Date'], $criteria);

            $q->filterByDate($value, \Criteria::GREATER_EQUAL)
                                            ->filterByDate($this->searchMs['Date_max'], \Criteria::LESS_THAN);
        }
        if( isset($this->searchMs['Date']) ) {
            $criteria = \Criteria::EQUAL;

            $this->searchMs['Date_max'] = strtotime($value) + 86400;

            $value = $this->setCriteria($this->searchMs['Date'], $criteria);

            $q->filterByDate($value, \Criteria::GREATER_EQUAL)
                                            ->filterByDate($this->searchMs['Date_max'], \Criteria::LESS_THAN);
        }
        if( isset($this->searchMs['Date']) ) {
            $criteria = \Criteria::EQUAL;

            $this->searchMs['Date_max'] = strtotime($value) + 86400;

            $value = $this->setCriteria($this->searchMs['Date'], $criteria);

            $q->filterByDate($value, \Criteria::GREATER_EQUAL)
                                            ->filterByDate($this->searchMs['Date_max'], \Criteria::LESS_THAN);
        }
                
        }else{
            if(json_decode($IdParent)){
                        $q = new TradeQuery();
                        $pmpoData = $q::create()
                            ->filterBy(json_decode($IdParent))
                            
                #required trade
                ->leftJoinWith('Exchange')
                #required trade
                ->leftJoinWith('Symbol')
                #default
                ->leftJoinWith('Token')
                            

                            ->paginate($page, $maxPerPage);
                    }
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                
                #required trade
                ->leftJoinWith('Exchange')
                #required trade
                ->leftJoinWith('Symbol')
                #default
                ->leftJoinWith('Token');
                
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
                                $(\"#TradeListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("State"), " th='sorted' c='Type' title='" . _('State')."' ")
.th(_("Exchange"), " th='sorted' c='Exchange.Name' title='"._('Exchange.Name')."' ")
.th(_("Trading pair"), " th='sorted' c='Symbol.Name' title='"._('Symbol.Name')."' ")
.th(_("Date"), " th='sorted' c='Date' title='" . _('Date')."' ")
.th(_("Qty"), " th='sorted' c='Qty' title='" . _('Qty')."' ")
.th(_("Price"), " th='sorted' c='GrossUsd' title='" . _('Price')."' ")
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
                
        $this->arrayIdExchangeOptions = $this->selectBoxTrade_IdExchange($this, $emptyVar, $data);
        $this->arrayIdSymbolOptions = $this->selectBoxTrade_IdSymbol($this, $emptyVar, $data);
        $this->arrayCommissionAssetOptions = $this->selectBoxTrade_CommissionAsset($this, $emptyVar, $data);
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(selectboxCustomArray('Type[]', array( '0' => array('0'=>_("Buy"), '1'=>"Buy"),'1' => array('0'=>_("Sell"), '1'=>"Sell"), ), _('Type'), '  size="1" t="1"   multiple  ', $this->searchMs['Type']), '', 'class="multiple-select ac-search-item"  title="'._('Type').'"').div(selectboxCustomArray('IdExchange[]', $this->arrayIdExchangeOptions, 'Exchange' , "v='ID_EXCHANGE'  s='d' class='select-label js-select-label' multiple size='1'  ", $this->searchMs['IdExchange'], '', false), '', ' class="ac-search-item multiple-select"').div(input('date', 'Date', $this->searchMs['Date'], '  j="date"  title="'._('Date').'" placeholder="'._('Date').'"',''),'','class="ac-search-item"').div(input('date', 'Date', $this->searchMs['Date'], '  j="date"  title="'._('Date before').'" placeholder="'._('Date before').'"',''),'','class="ac-search-item"').div(input('date', 'Date', $this->searchMs['Date'], '  j="date"  title="'._('Date after').'" placeholder="'._('Date after').'"',''),'','class="ac-search-item"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msTradeBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msTradeBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsTrade'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addTrade' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'Trade';
        $altValue = array (
  'IdTrade' => '',
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
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Trade/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Trade/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Trade/');

        if (method_exists($this, 'beforeList')){ $this->beforeList($request, $pmpoDataIn );}
        
        $default_order[]['Date']='DESC';
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
                if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteTrade' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                                    $Exchange_Name = "";
                                    if($data->getExchange()){
                                        $Exchange_Name = $data->getExchange()->getName();
                                    }
                                    $Symbol_Name = "";
                                    if($data->getSymbol()){
                                        $Symbol_Name = $data->getSymbol()->getName();
                                    }
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Type']) ? $altValue['Type'] : isntPo($data->getType())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Type' class='center'  j='editTrade'") . 
                td(span((($altValue['IdExchange']) ? $altValue['IdExchange'] : $Exchange_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdExchange' class=''  j='editTrade'") . 
                td(span((($altValue['IdSymbol']) ? $altValue['IdSymbol'] : $Symbol_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdSymbol' class=''  j='editTrade'") . 
                td(span((($altValue['Date']) ? $altValue['Date'] : $data->getDate()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Date' class=''  j='editTrade'") . 
                td(span((($altValue['Qty']) ? $altValue['Qty'] : str_replace(',', '.', $data->getQty())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Qty' class='right'  j='editTrade'") . 
                td(span((($altValue['GrossUsd']) ? $altValue['GrossUsd'] : str_replace(',', '.', $data->getGrossUsd())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='GrossUsd' class='right'  j='editTrade'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='TradeRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountTrade', $i);
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
                
                .div($controlsContent,'TradeControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='TradeTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'TradeListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#TradeListForm td[j='editTrade']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#TradeListForm [j='deleteTrade']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#TradePager').bindPaging({
            tableName:'Trade'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msTradeBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msTradeBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsTrade').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsTrade .js-select-label').SelectBox();
            $('#formMsTrade input[type=text]').first().focus();
            $('#formMsTrade input[type=text]').first().putCursorAtEnd();
            $('#msTradeBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsTrade').keydown(function(e) {
        if(e.which == 13) {
            $('#msTradeBt').click();
        }
    });

    $('#msTradeBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsTrade input[type=text]:first-of-type').focus().putCursorAtEnd();
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

        if($('#addTradeAutoc').length > 0) {
            $('#addTradeAutoc').bind('click', function () {
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
    public function setCreateDefaultsTrade($data)
    {

        unset($data['IdTrade']);
        $e = new Trade();
        
        
        if(!$data['Type']){
            $data['Type'] = "Buy";
        } 
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setQty( ($data['Qty'] == '' ) ? null : $data['Qty']);
        //integer not required
        $e->setGrossUsd( ($data['GrossUsd'] == '' ) ? null : $data['GrossUsd']);
        //integer not required
        $e->setCommission( ($data['Commission'] == '' ) ? null : $data['Commission']);
        //foreign
        $e->setCommissionAsset(( $data['CommissionAsset'] == '' ) ? null : $data['CommissionAsset']);
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
    public function setUpdateDefaultsTrade($data)
    {

        
        $e = TradeQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!$data['Type']){
            $data['Type'] = "Buy";
        } 
        $e->fromArray($data );

        
        
        if(isset($data['Qty'])){
            $e->setQty( ($data['Qty'] == '' ) ? null : $data['Qty']);
        }
        if(isset($data['GrossUsd'])){
            $e->setGrossUsd( ($data['GrossUsd'] == '' ) ? null : $data['GrossUsd']);
        }
        if(isset($data['Commission'])){
            $e->setCommission( ($data['Commission'] == '' ) ? null : $data['Commission']);
        }
        if( isset($data['CommissionAsset']) ){
            $e->setCommissionAsset(( $data['CommissionAsset'] == '' ) ? null : $data['CommissionAsset']);
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
     * Produce a formated form of Trade
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

        $je = "TradeTable";

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
                
                case 'Exchange':
                    $data['IdExchange'] = $data['ip'];
                    break;
                case 'Asset':
                    $data['IdAsset'] = $data['ip'];
                    break;
                case 'Symbol':
                    $data['IdSymbol'] = $data['ip'];
                    break;
                case 'Token':
                    $data['CommissionAsset'] = $data['ip'];
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
        if(($_SESSION[_AUTH_VAR]->hasRights('Trade', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Trade', 'w') and $id) || $this->setReadOnly) {
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
                $('#formTrade #saveTrade').unbind('click.saveTrade');
                $('#formTrade #saveTrade').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Trade', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addTrade' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = TradeQuery::create()
            
                #required trade
                ->leftJoinWith('Exchange')
                #required trade
                ->leftJoinWith('Symbol')
                #default
                ->leftJoinWith('Token')
            ;
            


            $dataObj = $q->filterByIdTrade($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Trade['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Trade();
            $this->Trade['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Trade['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


                                    ($dataObj->getExchange())?'':$dataObj->setExchange( new Exchange() );
                                    ($dataObj->getSymbol())?'':$dataObj->setSymbol( new Symbol() );
                                    ($dataObj->getToken())?'':$dataObj->setToken( new Token() );

        
        $this->arrayIdExchangeOptions = $this->selectBoxTrade_IdExchange($this, $dataObj, $data);
        $this->arrayIdSymbolOptions = $this->selectBoxTrade_IdSymbol($this, $dataObj, $data);
        $this->arrayCommissionAssetOptions = $this->selectBoxTrade_CommissionAsset($this, $dataObj, $data);
        
        
        
        
        
        
$this->fields['Trade']['Type']['html'] = stdFieldRow(_("State"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Buy"), '1'=>"Buy"),'1' => array('0'=>_("Sell"), '1'=>"Sell"), ), "", "s='d'  ", $dataObj->getType(), '', false), 'Type', "", $this->commentsType, $this->commentsType_css, '', ' ', 'no');
$this->fields['Trade']['IdExchange']['html'] = stdFieldRow(_("Exchange"), selectboxCustomArray('IdExchange', $this->arrayIdExchangeOptions, "", "v='ID_EXCHANGE'  s='d'  val='".$dataObj->getIdExchange()."'", $dataObj->getIdExchange()), 'IdExchange', "", $this->commentsIdExchange, $this->commentsIdExchange_css, '', ' ', 'no');
$this->fields['Trade']['IdSymbol']['html'] = stdFieldRow(_("Trading pair"), selectboxCustomArray('IdSymbol', $this->arrayIdSymbolOptions, "", "v='ID_SYMBOL'  s='d'  val='".$dataObj->getIdSymbol()."'", $dataObj->getIdSymbol()), 'IdSymbol', "", $this->commentsIdSymbol, $this->commentsIdSymbol_css, '', ' ', 'no');
$this->fields['Trade']['Date']['html'] = stdFieldRow(_("Date"), input('datetime-local', 'Date', $dataObj->getDate(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD hh:mm:ss' size='30'  s='d' class='' title='Date'"), 'Date', "", $this->commentsDate, $this->commentsDate_css, '', ' ', 'no');
$this->fields['Trade']['Qty']['html'] = stdFieldRow(_("Qty"), input('text', 'Qty', $dataObj->getQty(), "  placeholder='".str_replace("'","&#39;",_('Qty'))."'  v='QTY' size='10' s='d' class='req'"), 'Qty', "", $this->commentsQty, $this->commentsQty_css, '', ' ', 'no');
$this->fields['Trade']['GrossUsd']['html'] = stdFieldRow(_("Price"), input('text', 'GrossUsd', $dataObj->getGrossUsd(), "  placeholder='".str_replace("'","&#39;",_('Price'))."'  v='GROSS_USD' size='10' s='d' class=''"), 'GrossUsd', "", $this->commentsGrossUsd, $this->commentsGrossUsd_css, '', ' ', 'no');
$this->fields['Trade']['Commission']['html'] = stdFieldRow(_("Commission"), input('text', 'Commission', $dataObj->getCommission(), "  placeholder='".str_replace("'","&#39;",_('Commission'))."'  v='COMMISSION' size='10' s='d' class=''"), 'Commission', "", $this->commentsCommission, $this->commentsCommission_css, '', ' ', 'no');
$this->fields['Trade']['CommissionAsset']['html'] = stdFieldRow(_("commissionAsset"), selectboxCustomArray('CommissionAsset', $this->arrayCommissionAssetOptions, _('commissionAsset'), "v='COMMISSION_ASSET'  s='d'  val='".$dataObj->getCommissionAsset()."'", $dataObj->getCommissionAsset()), 'CommissionAsset', "", $this->commentsCommissionAsset, $this->commentsCommissionAsset_css, '', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveTrade', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedTrade','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdTrade', $dataObj->getIdTrade(), " s='d' pk").input('hidden', 'IdAsset', $dataObj->getIdAsset(), " s='d' nodesc").input('hidden', 'OrderId', $dataObj->getOrderId(), "   v='ORDER_ID' size='5' s='d' class=''").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formTrade [j='date']\").attr('type', 'text');
            $(\"#formTrade [j='date']\").each(function(){
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
                div('Trade', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
$this->fields['Trade']['Type']['html']
.$this->fields['Trade']['IdExchange']['html']
.$this->fields['Trade']['IdSymbol']['html']
.$this->fields['Trade']['Date']['html']
.$this->fields['Trade']['Qty']['html']
.$this->fields['Trade']['GrossUsd']['html']
.$this->fields['Trade']['Commission']['html']
.$this->fields['Trade']['CommissionAsset']['html']
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntTrade", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formTrade' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['Trade']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Trade']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Trade']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Trade']['ixmemautocapp'];
            unset($_SESSION['mem']['Trade']['ixmemautocapp']);
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
            $(\"#formTrade [s='d'], #formTrade .js-select-label, #formTrade [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formTrade .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Trade']['Type']['html'] = stdFieldRow(_("State"), div( $dataObj->getType(), 'Type_label' , "class='readonly' s='d'")
                .input('hidden', 'Type', $dataObj->getType(), "s='d'"), 'Type', "", $this->commentsType, $this->commentsType_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['IdExchange']['html'] = stdFieldRow(_("Exchange"), div( ($dataObj->getExchange())?$dataObj->getExchange()->getName():'', 'IdExchange_label' , "class='readonly' s='d'")
                .input('hidden', 'IdExchange', $dataObj->getIdExchange(), "s='d'"), 'IdExchange', "", $this->commentsIdExchange, $this->commentsIdExchange_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['IdSymbol']['html'] = stdFieldRow(_("Trading pair"), div( ($dataObj->getSymbol())?$dataObj->getSymbol()->getName():'', 'IdSymbol_label' , "class='readonly' s='d'")
                .input('hidden', 'IdSymbol', $dataObj->getIdSymbol(), "s='d'"), 'IdSymbol', "", $this->commentsIdSymbol, $this->commentsIdSymbol_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['Date']['html'] = stdFieldRow(_("Date"), div( $dataObj->getDate(), 'Date_label' , "class='readonly' s='d'")
                .input('hidden', 'Date', $dataObj->getDate(), "s='d'"), 'Date', "", $this->commentsDate, $this->commentsDate_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['Qty']['html'] = stdFieldRow(_("Qty"), div( $dataObj->getQty(), 'Qty_label' , "class='readonly' s='d'")
                .input('hidden', 'Qty', $dataObj->getQty(), "s='d'"), 'Qty', "", $this->commentsQty, $this->commentsQty_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['GrossUsd']['html'] = stdFieldRow(_("Price"), div( $dataObj->getGrossUsd(), 'GrossUsd_label' , "class='readonly' s='d'")
                .input('hidden', 'GrossUsd', $dataObj->getGrossUsd(), "s='d'"), 'GrossUsd', "", $this->commentsGrossUsd, $this->commentsGrossUsd_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['Commission']['html'] = stdFieldRow(_("Commission"), div( $dataObj->getCommission(), 'Commission_label' , "class='readonly' s='d'")
                .input('hidden', 'Commission', $dataObj->getCommission(), "s='d'"), 'Commission', "", $this->commentsCommission, $this->commentsCommission_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Trade']['CommissionAsset']['html'] = stdFieldRow(_("commissionAsset"), div( ($dataObj->getToken())?$dataObj->getToken()->getTicker():'', 'CommissionAsset_label' , "class='readonly' s='d'")
                .input('hidden', 'CommissionAsset', $dataObj->getCommissionAsset(), "s='d'"), 'CommissionAsset', "", $this->commentsCommissionAsset, $this->commentsCommissionAsset_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Trade'] as $field => $ar) {
                $this->fields['Trade'][$field]['html'] = $this->fieldsRo['Trade'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Trade'][$field]['html'] = $this->fieldsRo['Trade'][$field]['html'];
            }
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
}
