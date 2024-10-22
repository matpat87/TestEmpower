{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}
<!--Start Responsive Top Navigation Menu -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="dropdown">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="dropdown-menu mobile_menu" role="menu" id="mobile_menu">
                {foreach from=$groupTabs item=modules key=group name=groupList}
                    {if $smarty.foreach.groupList.last}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                        {foreach from=$modules.modules item=module key=modulekey}
                            <li role="presentation" data-test="1">
                                {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                <a href="javascript:void(0)" onclick="window.location.href = '{sugar_link id=$moduleTabId module=$modulekey link_only=1 data=$module extraparams=$extraparams}'">
                                    {$module}
                                    {if $modulekey !='Home' && $modulekey !='Calendar'}
                                        <span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'index.php?action=EditView&module={$modulekey}'"></span>
                                        {*<span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'http://google.com'"></span>*}
                                    {/if}
                                </a>
                            </li>
                        {/foreach}
                        {foreach from=$modules.extra item=submodulename key=submodule}
                            <li role="presentation" data-test="2">
                                <a href="javascript:void(0)" onclick="window.location.href = '{sugar_link module=$submodule link_only=1 extraparams=$extraparams}'">
                                    {$submodulename}
                                    <span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'index.php?action=EditView&module={$submodule}'"></span>
                                    {*<span class="glyphicon glyphicon-plus"  onclick="window.location.href = 'http://google.com'"></span>*}
                                </a>
                            </li>
                        {/foreach}
                    {/if}
                {/foreach}

            </ul>
            <div id="mobileheader" class="mobileheader">
                <div id="modulelinks" class="modulelinks">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <span class="modulename" data-toggle="dropdown" aria-expanded="false">
                                {sugar_link id="moduleTab_$name" module=$name data=$module caret=true}
                            </span>
                                <ul class="dropdown-menu" role="menu">
                                {if $name !='Home'}
                                    {if is_array($shortcutTopMenu.$name) && count($shortcutTopMenu.$name) > 0}
                                        <li class="mobile-current-actions" role="presentation">
                                           <ul class="mobileCurrentTab">
                                               {foreach from=$shortcutTopMenu.$name item=item}
                                                   {if $item.URL == "-"}
                                                       <li class="mobile-action"><a></a><span>&nbsp;</span></li>
                                                   {else}
                                                       <li class="mobile-action"><a href="{$item.URL}">{$item.LABEL}</a></li>
                                                   {/if}
                                               {/foreach}
                                           </ul>
                                        </li>
                                    {else}
                                        <li class="mobile-action"><a>{$APP.LBL_NO_SHORTCUT_MENU}</a></li>
                                    {/if}
                            {/if}

                                    {if is_array($recentRecords) && count($recentRecords) > 0}
                                        <li class="recent-links-title" role="presentation">
                                            <a><strong>{$APP.LBL_LAST_VIEWED}</strong></a>
                                        </li>
                                        <li role="presentation">
                                            <ul class="recent-list">
                                                {foreach from=$recentRecords item=item name=lastViewed }
                                                    {if $smarty.foreach.lastViewed.iteration < 4} {* limit to 3 results *}
                                                        <li class="recentlinks" role="presentation">
                                                            <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                               accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                               href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                                <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                                                <span aria-hidden="true">{$item.item_summary_short}</span>
                                                            </a>
                                                            {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id}{/capture}
                                                            {if $access}
                                                                <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                            {/if}
                                                        </li>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                         </li>
                                    {/if}

                                    {if is_array($favoriteRecords) && count($favoriteRecords) > 0}
                                        <li class="favorite-links-title" role="presentation">
                                            <a><strong>{$APP.LBL_FAVORITES}</strong></a>
                                        </li>
                                        <li>
                                            <ul class="favorite-list">
                                                {foreach from=$favoriteRecords item=item name=lastViewed}
                                                    {if $smarty.foreach.lastViewed.iteration < 4} {* limit to 3 results *}
                                                        <li class="favoritelinks" role="presentation">
                                                            <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                               accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                               href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}"  class="favorite-links-detail">
                                                                <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                                                <span aria-hidden="true">{$item.item_summary_short}</span>
                                                            </a>
                                                            {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.id}{/capture}
                                                            {if $access}
                                                                <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                            {/if}
                                                        </li>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                        </li>
                                    {/if}
                                </ul>

                        {/if}
                    {/foreach}
                </div>
            </div>
        </div>
        <div class="desktop-toolbar" id="toolbar">
            {if $USE_GROUP_TABS}
                <ul class="nav navbar-nav">
                    <li class="navbar-brand-container">
                            <a class="navbar-brand with-home-icon suitepicon suitepicon-action-home" href="index.php?module=Home&action=index"></a>
                    </li>
                    {assign var="groupSelected" value=false}
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            {if $name != 'Home'}
                                <li class="topnav currentModule">
                                    <span class="currentTabLeft">&nbsp;</span>
                                    <span class="currentTab">{sugar_link id="moduleTab_$name" module=$name data=$module}</span>
                                    <span>&nbsp;</span>
                                    {* check, is there any recent items *}
                                    {assign var=foundRecents value=false}
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            {assign var=foundRecents value=true}
                                        {/if}
                                    {/foreach}


                                    {* check, is there any favorite items *}
                                    {assign var=foundFavorits value=false}
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $name}
                                            {assign var=foundFavorits value=true}
                                        {/if}
                                    {/foreach}
                                    {if $foundRecents || $foundFavorits
                                        || (is_array($shortcutTopMenu.$name) && count($shortcutTopMenu.$name) > 0)}

                                        <ul class="dropdown-menu" role="menu">
                                            <li class="current-module-action-links">
                                                <ul>
                                                    {if is_array($shortcutTopMenu.$name)
                                                        && count($shortcutTopMenu.$name) > 0}
                                                        {foreach from=$shortcutTopMenu.$name item=item}
                                                            {if $item.URL == "-"}
                                                                {*<li><a></a><span>&nbsp;</span></li>*}
                                                            {else}
                                                                <li><a href="{$item.URL}"><span class="topnav-fake-icon">{* fakes the space the icon takes *}</span><span aria-hidden="true">{$item.LABEL}</span></a></li>
                                                            {/if}
                                                        {/foreach}
                                                    {/if}
                                                </ul>
                                            </li>

                                            {* when records are found for the current submodule show recent header *}
                                            {counter start=0 name="submoduleRecentRecordsTotal" assign="submoduleRecentRecordsTotal"  print=false}
                                            {foreach from=$recentRecords item=item name=lastViewed}
                                                {if $item.module_name == $name and $submoduleRecentRecordsTotal == 0}
                                                    <li class="recent-links-title"><a><strong>{$APP.LBL_LAST_VIEWED}</strong></a></li>
                                                    {counter name="submoduleRecentRecordsTotal" print=false}
                                                {/if}
                                            {/foreach}
                                                <li class="current-module-recent-links">
                                                    <ul>
                                                        {* when records are found for the current submodule show the first 3 records *}
                                                        {counter start=0 name="submoduleRecentRecords" assign="submoduleRecentRecords"  print=false}
                                                        {foreach from=$recentRecords item=item name=lastViewed}
                                                            {if $item.module_name == $name and $submoduleRecentRecords < 3}
                                                                <li class="recentlinks" role="presentation">
                                                                    <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">

                                                                        <span aria-hidden="true">{$item.item_summary_short}</span>
                                                                    </a>
                                                                    {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                                                    {if $access}
                                                                        <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                                    {/if}
                                                                </li>
                                                                {counter name="submoduleRecentRecords" print=false}
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </li>





                                            {counter start=0 name="submoduleFavoriteRecordsTotal" assign="submoduleFavoriteRecordsTotal"  print=false}
                                            {foreach from=$favoriteRecords item=item name=lastViewed}
                                                {if $item.module_name == $name and $submoduleFavoriteRecordsTotal == 0}
                                                    <li class="favorite-links-title"><a><strong>{$APP.LBL_FAVORITES}</strong></a></li>
                                                    {counter name="submoduleFavoriteRecordsTotal" print=false}
                                                {/if}
                                            {/foreach}
                                            <li class="current-module-favorite-links">
                                                <ul>
                                                    {* when records are found for the current submodule show the first 3 records *}
                                                    {counter start=0 name="submoduleFavoriteRecords" assign="submoduleFavoriteRecords" print=false}
                                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                                        {if $item.module_name == $name and $submoduleFavoriteRecords < 3}
                                                            <li class="favoritelinks" role="presentation">
                                                                <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                                   accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                                   href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                                                    <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                                                    <span aria-hidden="true">{$item.item_summary_short}</span>
                                                                </a>
                                                                {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.id }{/capture}
                                                                {if $access}
                                                                    <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                                {/if}
                                                            </li>
                                                            {counter name="submoduleFavoriteRecords" print=false}
                                                        {/if}
                                                    {/foreach}
                                                </ul>
                                            </li>
                                        </ul>

                                    {/if}
                                 </li>
                            {/if}

                        {/if}
                    {/foreach}
                    {foreach from=$groupTabs item=modules key=group name=groupList}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                        <li class="topnav {if $smarty.foreach.groupList.last}all{/if}">
                            <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab">
                            <a href="#" id="grouptab_{$smarty.foreach.groupList.index}" class="dropdown-toggle grouptab"
                               data-toggle="dropdown">{$group}</a>
                            <span class="notCurrentTabRight">&nbsp;</span>
                            <ul class="dropdown-menu" role="menu" {if $smarty.foreach.groupList.last} class="All"{/if}>
                                {foreach from=$modules.modules item=module key=modulekey}
                                    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                                    </li>
                                {/foreach}
                                {foreach from=$modules.extra item=submodulename key=submodule}
                                    <li>
                                        <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    {/foreach}
                </ul>
                {* 7.8 Hide filter menu items when the window is too small to display them *}
            {literal}
                <script>
                  var windowResize = function() {
                    // Since the height can be changed in Sass.
                    // Take a measurement of the initial desktop navigation bar height with just one menu item
                    $('.desktop-toolbar ul.navbar-nav > li').not('.all').not('.currentModule').addClass('hidden');
                    var dth = $('.desktop-toolbar').outerHeight();

                    // Show all desktop menu items
                    $('.desktop-toolbar ul.navbar-nav > li.hidden').removeClass('hidden');

                    // Remove the each menu item from the end of the toolbar until
                    // the navigation bar is the matches the initial height.
                    while($('.desktop-toolbar').outerHeight() > dth) {
                      ti = $('.desktop-toolbar ul.navbar-nav > li').not('.hidden').not('.all');
                      $(ti).last().addClass('hidden');
                    }
                  };
                  $(window).resize(windowResize);
                  $(document).ready(windowResize);
                </script>
            {/literal}
            {else}

                <ul class="nav navbar-nav navbar-horizontal-fluid">
                    <li class="navbar-brand-container">
                        <a class="navbar-brand with-home-icon" href="index.php?module=Home&action=index">
                            <span class="suitepicon suitepicon-action-home"></span>
                        </a>
                    </li>
                    {foreach from=$groupTabs item=modules key=group name=groupList}
                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                    {/foreach}

                    <!--nav items with actions -->
                    {foreach from=$modules.modules item=submodulename key=submodule}
                        {if $submodule != "Home"}
                            <li class="topnav with-actions">
                                <span class="notCurrentTabLeft">&nbsp;</span>
                                <span class="dropdown-toggle headerlinks notCurrentTab"> <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a> </span>
                                <span class="notCurrentTabRight">&nbsp;</span>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <ul>
                                            {if is_array($shortcutTopMenu) && count($shortcutTopMenu) > 0}
                                                {foreach from=$shortcutTopMenu.$submodule item=item}
                                                    {if $item.URL == "-"}
                                                        {*<li><a></a><span>&nbsp;</span></li>*}
                                                    {else}
                                                        <li><a href="{$item.URL}"><span class="topnav-fake-icon">{* fakes the space the icon takes *}</span><span aria-hidden="true">{$item.LABEL}</span></a></li>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </ul>
                                    </li>
                                    {* when records are found for the current submodule show recent header *}
                                    {counter start=0 name="submoduleRecentRecordsTotal" assign="submoduleRecentRecordsTotal"  print=false}
                                    {foreach from=$recentRecords item=item name=lastViewed}
                                        {if $item.module_name == $submodule and $submoduleRecentRecordsTotal == 0}
                                            <li class="recent-links-title"><a><strong>{$APP.LBL_LAST_VIEWED}</strong></a></li>
                                            {counter name="submoduleRecentRecordsTotal" print=false}
                                        {/if}
                                    {/foreach}
                                    <li>
                                        <ul>
                                            {* when records are found for the current submodule show the first 3 records *}
                                            {counter start=0 name="submoduleRecentRecords" assign="submoduleRecentRecords"  print=false}
                                            {foreach from=$recentRecords item=item name=lastViewed}
                                                {if $item.module_name == $submodule and $submoduleRecentRecords < 3}
                                                    <li class="recentlinks" role="presentation">
                                                        <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                           accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                           href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}" class="recent-links-detail">
                                                            <span aria-hidden="true">{$item.item_summary_short}</span>
                                                        </a>
                                                        {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                                        {if $access}
                                                            <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class=" glyphicon glyphicon-pencil"></a>
                                                        {/if}
                                                    </li>
                                                    {counter name="submoduleRecentRecords" print=false}
                                                {/if}
                                            {/foreach}
                                        </ul>
                                    </li>
                                    {* when records are found for the current submodule show favorites header *}
                                    {counter start=0 name="submoduleFavoriteRecordsTotal" assign="submoduleFavoriteRecordsTotal"  print=false}
                                    {foreach from=$favoriteRecords item=item name=lastViewed}
                                        {if $item.module_name == $submodule and $submoduleFavoriteRecordsTotal == 0}
                                            <li class="favorite-links-title"><a><strong>{$APP.LBL_FAVORITES}</strong></a></li>
                                            {counter name="submoduleFavoriteRecordsTotal" print=false}
                                        {/if}
                                    {/foreach}
                                    <li>
                                        <ul>
                                        {* when records are found for the current submodule show the first 3 records *}
                                        {counter start=0 name="submoduleFavoriteRecords" assign="submoduleFavoriteRecords" print=false}
                                        {foreach from=$favoriteRecords item=item name=lastViewed}
                                            {if $item.module_name == $submodule and $submoduleFavoriteRecords < 3}
                                                <li class="favoritelinks" role="presentation">
                                                    <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                                                        <span aria-hidden="true">{$item.item_summary_short}</span>
                                                    </a>
                                                    {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.id }{/capture}
                                                    {if $access}
                                                        <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                                    {/if}
                                                </li>
                                                {counter name="submoduleFavoriteRecords" print=false}
                                            {/if}
                                        {/foreach}
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                    {/foreach}
                    <li class="topnav overflow-toggle-menu">
                        <span class="notCurrentTabLeft">&nbsp;</span>
                        <span class="dropdown-toggle headerlinks notCurrentTab"><a href="#">{$APP.LBL_MORE}</a></span>
                        <span class="notCurrentTabRight">&nbsp;</span>
                        <ul id="overflow-menu" class="dropdown-menu" role="menu">
                            <!--nav items without actions -->
                            {foreach from=$modules.extra item=submodulename key=submodule}
                                <li class="topnav without-actions">
                                    <span class=" notCurrentTab"> <a href="{sugar_link module=$submodule link_only=1 extraparams=$extraparams}">{$submodulename}</a> </span>
                                </li>
                            {/foreach}
                        </ul>
                    </li>
                </ul>
                <div class="hidden hidden-actions"></div>
                {* Hide nav items when the window size is too small to display them *}
                {literal}
                    <script>
                        var windowResize = function() {
                            // reset navbar
                            var $navCollapsedItems = $('ul#overflow-menu > li.with-actions');
                            if(typeof $navCollapsedItems !== "undefined") {
                                $($navCollapsedItems).each(function() {
                                    $(this).addClass('topnav');
                                    $(this).insertBefore('.overflow-toggle-menu');
                                });
                            }



                            var $navItemMore = $('.navbar-horizontal-fluid > li.overflow-toggle-menu'),
                                    $navItems = $('.navbar-horizontal-fluid > li.with-actions'),
                                    navItemMoreWidth = navItemWidth = $navItemMore.width(),
                                    windowWidth = $(window).width() - ($(window).width()  * 0.55),
                                    navItemMoreLeft, offset, navOverflowWidth;

                            $navItems.each(function() {
                                navItemWidth += $(this).width();
                            });

                            // Remove nav items that are cause the right hand nav-bar items to wrap
                            while (navItemWidth > windowWidth) {
                                navItemWidth -= $navItems.last().width();
                                $navItems.last().removeClass('topnav');
                                $navItems.last().prependTo('#overflow-menu');
                                $navItems.splice(-1,1);
                            }

                            navItemMoreLeft = $('.navbar-horizontal-fluid .overflow-toggle-menu').offset().left;
                            navOverflowWidth = $('#overflow-menu').width();
                            offset = navItemMoreLeft + navItemMoreWidth - navOverflowWidth;
                        };
                        $(window).resize(windowResize);
                        windowResize();
                    </script>
                {/literal}

            {/if}
        </div>

        <!-- Right side of the main navigation -->
        <div class="mobile-bar">
            <ul id="toolbar" class="toolbar">
                <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        QUICK CREATE <span class="suitepicon suitepicon-action-caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=index">Account</a></li>
                        <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DContacts%26action%3DEditView%26return_module%3DContacts%26return_action%3Dindex">Contact</a></li>
                        <li><a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">Call</a></li>
                        <li><a href="index.php?module=Meetings&action=EditView&return_module=Meetings&return_action=DetailView">Meeting</a></li>
                        <li><a href="index.php?module=Notes&action=EditView&return_module=Notes&return_action=DetailView">Note/Attachment</a></li>
                        <li><a href="index.php?module=Cases&action=EditView&return_module=Cases&return_action=DetailView">Customer Issue</a></li>
                        <li><a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">Opportunity</a></li>

                        {if $CURRENT_USER_MAPS_ACCESS }
                            <li><a href="index.php?module=jjwg_Maps&action=quick_radius&return_module=jjwg_Maps&return_action=index">Quick Radius Map</a></li>
                        {/if}

                        {if $CURRENT_USER_IS_ADMIN }
                            <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOTR_OnTrack%26action%3DEditView%26return_module%3DOTR_OnTrack%26return_action%3DDetailView">On Track</a></li>
                        {/if}
                    </ul>
                </li>
                <li id="" class="dropdown nav navbar-nav navbar-search">
                    <button id="searchbutton" class="dropdown-toggle btn btn-default searchbutton suitepicon suitepicon-action-search" data-toggle="dropdown" aria-expanded="true">
                    </button>
                    <div class="dropdown-menu" role="menu" aria-labelledby="searchbutton">
                        <form id="searchformdropdown" class="searchformdropdown" name='UnifiedSearch' action='index.php'
                              onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                            <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                            <input type="hidden" class="form-control" name="module" value="Home">
                            <input type="hidden" class="form-control" name="search_form" value="false">
                            <input type="hidden" class="form-control" name="advanced" value="false">
                            <div class="input-group">
                                <input type="text" class="form-control query_string" name="query_string" id="query_string"
                                       placeholder="{$APP.LBL_SEARCH_BUTTON}..." value="{$SEARCH}"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                            </span>
                            </div>
                        </form>
                    </div>
                </li>
                <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
                    <button class="alertsButton btn dropdown-toggle suitepicon suitepicon-action-alerts" data-toggle="dropdown"
                            aria-expanded="false">
                        <span class="alert_count hidden">0</span>
                    </button>
                    <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>
                </li>
                <li>
                    <form id="searchform" class="navbar-form searchform" name='UnifiedSearch' action='index.php'
                          onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                        <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                        <input type="hidden" class="form-control" name="module" value="Home">
                        <input type="hidden" class="form-control" name="search_form" value="false">
                        <input type="hidden" class="form-control" name="advanced" value="false">
                        <div class="input-group">
                            <input type="text" class="form-control query_string " name="query_string" id="query_string"
                                   placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                    </span>
                        </div>
                    </form>
                </li>
                <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-mobile">

                    <button id="usermenucollapsed" class="dropdown-toggle btn btn-default usermenucollapsed" data-toggle="dropdown" aria-expanded="true">
                        <span class="suitepicon suitepicon-action-user-small"></span>
                    </button>
                    <ul class="dropdown-menu user-dropdown user-menu" role="menu" aria-labelledby="dropdownMenu2">
                        <li role="presentation">
                            <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>
                                {$APP.LBL_PROFILE}
                            </a>
                        </li>
                        {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                            <li role="presentation">
                                <a id="{$gcl_key}_link"
                                   href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                            </li>
                        {/foreach}
                        <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}'
                                                   class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="tablet-bar">
            <ul id="toolbar" class="toolbar">
                <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        QUICK CREATE<span class="suitepicon suitepicon-action-caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                       <li><a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=index">Account</a></li>
                        <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DContacts%26action%3DEditView%26return_module%3DContacts%26return_action%3Dindex">Contact</a></li>
                        <li><a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">Call</a></li>
                        <li><a href="index.php?module=Meetings&action=EditView&return_module=Meetings&return_action=DetailView">Meeting</a></li>
                        <li><a href="index.php?module=Notes&action=EditView&return_module=Notes&return_action=DetailView">Note/Attachment</a></li>
                        <li><a href="index.php?module=Cases&action=EditView&return_module=Cases&return_action=DetailView">Customer Issue</a></li>
                        <li><a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">Opportunity</a></li>
                        
                        {if $CURRENT_USER_MAPS_ACCESS }
                            <li><a href="index.php?module=jjwg_Maps&action=quick_radius&return_module=jjwg_Maps&return_action=index">Quick Radius Map</a></li>
                        {/if}
                        {if $CURRENT_USER_IS_ADMIN }
                            <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOTR_OnTrack%26action%3DEditView%26return_module%3DOTR_OnTrack%26return_action%3DDetailView">On Track</a></li>
                        {/if}
                    </ul>
                </li>
                <li id="" class="dropdown nav navbar-nav navbar-search">
                    <button id="searchbutton" class="dropdown-toggle btn btn-default searchbutton suitepicon suitepicon-action-search" data-toggle="dropdown" aria-expanded="true">
                    </button>
                    <div class="dropdown-menu" role="menu" aria-labelledby="searchbutton">
                        <form id="searchformdropdown" class="searchformdropdown" name='UnifiedSearch' action='index.php'
                              onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                            <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                            <input type="hidden" class="form-control" name="module" value="Home">
                            <input type="hidden" class="form-control" name="search_form" value="false">
                            <input type="hidden" class="form-control" name="advanced" value="false">
                            <div class="input-group">
                                <input type="text" class="form-control query_string" name="query_string" id="query_string"
                                       placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                            </span>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <form id="searchform" class="navbar-form searchform" name='UnifiedSearch' action='index.php'
                          onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                        <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                        <input type="hidden" class="form-control" name="module" value="Home">
                        <input type="hidden" class="form-control" name="search_form" value="false">
                        <input type="hidden" class="form-control" name="advanced" value="false">
                        <div class="input-group">
                            <input type="text" class="form-control query_string" name="query_string" id="query_string"
                                   placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                    </span>
                        </div>
                    </form>
                </li>
                <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
                    <button class="alertsButton btn dropdown-toggle suitepicon suitepicon-action-alerts" data-toggle="dropdown"
                            aria-expanded="false">
                        <span class="alert_count hidden">0</span>
                    </button>
                    <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>
                </li>
                <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-mobile">

                    <button id="usermenucollapsed" class="dropdown-toggle btn btn-default usermenucollapsed" data-toggle="dropdown"
                            aria-expanded="true">
                        <span class="suitepicon suitepicon-action-current-user"></span>
                    </button>
                    <ul class="dropdown-menu user-dropdown user-menu" role="menu" aria-labelledby="dropdownMenu2">
                        <li role="presentation">
                            <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>
                                {$APP.LBL_PROFILE}
                            </a>
                        </li>
                        {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                            <li role="presentation">
                                <a id="{$gcl_key}_link"
                                   href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                            </li>
                        {/foreach}
                        <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}'
                                                   class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="desktop-bar">
            <ul id="toolbar" class="toolbar">
                <li id="quickcreatetop" class="create dropdown nav navbar-nav quickcreatetop">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        QUICK CREATE<span class="suitepicon suitepicon-action-caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=index">Account</a></li>
                        <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DContacts%26action%3DEditView%26return_module%3DContacts%26return_action%3Dindex">Contact</a></li>
                        <li><a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">Call</a></li>
                        <li><a href="index.php?module=Meetings&action=EditView&return_module=Meetings&return_action=DetailView">Meeting</a></li>
                        <li><a href="index.php?module=Notes&action=EditView&return_module=Notes&return_action=DetailView">Note/Attachment</a></li>
                        <li><a href="index.php?module=Cases&action=EditView&return_module=Cases&return_action=DetailView">Customer Issue</a></li>
                        <li><a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">Opportunity</a></li>
                        
                        {if $CURRENT_USER_MAPS_ACCESS }
                            <li><a href="index.php?module=jjwg_Maps&action=quick_radius&return_module=jjwg_Maps&return_action=index">Quick Radius Map</a></li>
                        {/if}
                        {if $CURRENT_USER_IS_ADMIN }
                            <li><a href="index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOTR_OnTrack%26action%3DEditView%26return_module%3DOTR_OnTrack%26return_action%3DDetailView">On Track</a></li>
                        {/if}
                    </ul>
                </li>
                <li id="" class="dropdown nav navbar-nav navbar-search">
                    <button id="searchbutton" class="dropdown-toggle btn btn-default searchbutton suitepicon suitepicon-action-search" data-toggle="dropdown" aria-expanded="true">
                    </button>
                    <div class="dropdown-menu" role="menu" aria-labelledby="searchbutton">
                        <form id="searchformdropdown" class="searchformdropdown" name='UnifiedSearch' action='index.php'
                              onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                            <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                            <input type="hidden" class="form-control" name="module" value="Home">
                            <input type="hidden" class="form-control" name="search_form" value="false">
                            <input type="hidden" class="form-control" name="advanced" value="false">
                            <div class="input-group">
                                <input type="text" class="form-control query_string" name="query_string" id="query_string"
                                       placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                            </span>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <form id="searchform" class="navbar-form searchform" name='UnifiedSearch' action='index.php'
                          onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
                        <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
                        <input type="hidden" class="form-control" name="module" value="Home">
                        <input type="hidden" class="form-control" name="search_form" value="false">
                        <input type="hidden" class="form-control" name="advanced" value="false">
                        <div class="input-group">
                            <input type="text" class="form-control query_string" name="query_string" id="query_string"
                                   placeholder="{$APP.LBL_SEARCH}..." value="{$SEARCH}"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default suitepicon suitepicon-action-search"></button>
                    </span>
                        </div>
                    </form>
                </li>
                <li id="desktop_notifications" class="dropdown nav navbar-nav desktop_notifications">
                    <button class="alertsButton btn dropdown-toggle suitepicon suitepicon-action-alerts" data-toggle="dropdown"
                            aria-expanded="false">
                        <span class="alert_count hidden">0</span>
                    </button>
                    <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>
                </li>
                <li id="globalLinks" class="dropdown nav navbar-nav globalLinks-desktop">
                    <button id="with-label" class="dropdown-toggle user-menu-button" title="{$CURRENT_USER}"data-toggle="dropdown" aria-expanded="true">
                        <span class="suitepicon suitepicon-action-current-user"></span>
                        <span>{$CURRENT_USER}</span>
                        <span class="suitepicon suitepicon-action-caret"></span>
                    </button>
                    <ul class="dropdown-menu user-dropdown user-menu" role="menu" aria-labelledby="with-label">
                        <li role="presentation">
                            <a href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>
                                {$APP.LBL_PROFILE}
                            </a>
                        </li>
                        {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                            <li role="presentation">
                                <a id="{$gcl_key}_link"
                                   href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                            </li>
                        {/foreach}
                        <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}'
                                                   class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                    </ul>
                </li>
            </ul>

        </div>
</nav>
<!--End Responsive Top Navigation Menu -->
{if $THEME_CONFIG.display_sidebar}
    <!--Start Page Container and Responsive Sidebar -->
    <div id='sidebar_container' class="container-fluid sidebar_container">

        <a id="buttontoggle" class="buttontoggle"><span></span></a>
                
        <!--<div class="row">-->
            <!--<div {if $smarty.cookies.sidebartoggle == 'collapsed'}style="display:none"{/if}
                 class="col-sm-3 col-md-2 sidebar">-->
             <div {if $smarty.cookies.sidebartoggle == 'collapsed'}style="display:none"{/if}
             class="sidebar">
                
                 <!-- Add is QA Indicator based on $sugar_config['isQA'] -->
                 {if $isQA}
                    <div id="actionMenuSidebar" class="actionMenuSidebar">
                        <ul><h2 class="recent_h3 is_qa_notice text-center">Running: EmpowerCRM QA</h2></ul>
                    </div>
                 {/if}

                <div id="actionMenuSidebar" class="actionMenuSidebar">
                    {foreach from=$moduleTopMenu item=module key=name name=moduleList}
                        {if $name == $MODULE_TAB}
                            <ul>
                                {if isset($shortcutTopMenu.$name) && is_array($shortcutTopMenu)
                                    && count($shortcutTopMenu.$name) > 0}
                                    <h2 class="recent_h3">{$APP.LBL_LINK_ACTIONS}</h2>
                                    {foreach from=$shortcutTopMenu.$name item=item}
                                        {if $item.URL == "-"}
                                            <li><a></a><span>&nbsp;</span></li>
                                        {else}
                                            <li class="actionmenulinks" role="presentation">
                                                <a href="{$item.URL}" data-action-name="{$item.MODULE_NAME}">
                                                    <div class="side-bar-action-icon">
                                                        <span class="suitepicon suitepicon-action-{$item.MODULE_NAME|lower|replace:'_':'-'}"></span>
                                                    </div>
                                                    <div class="actionmenulink">{$item.LABEL}</div>
                                                </a>
                                            </li>
                                        {/if}
                                    {/foreach}
                                {/if}
                            </ul>
                        {/if}
                    {/foreach}
                </div>


                <!--
                    * @author Steven Kyamko
                    * @date 6/14/2018
                    * @description This will enable admin to log back from a user to admin 
                -->
                {* Custom SVGs *}
                {assign var="strTitle" value=""}
                <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-lab" viewBox="0 0 32 32">
                        <title>lab</title>
                        <path d="M29.884 25.14l-9.884-16.47v-6.671h1c0.55 0 1-0.45 1-1s-0.45-1-1-1h-10c-0.55 0-1 0.45-1 1s0.45 1 1 1h1v6.671l-9.884 16.47c-2.264 3.773-0.516 6.86 3.884 6.86h20c4.4 0 6.148-3.087 3.884-6.86zM7.532 20l6.468-10.779v-7.221h4v7.221l6.468 10.779h-16.935z"></path>
                        </symbol>
                    </defs>
                </svg>

                <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-dollar" viewBox="0 0 16 28">
                        <title>dollar</title>
                        <path d="M15.281 18.516c0 3.187-2.281 5.703-5.594 6.25v2.734c0 0.281-0.219 0.5-0.5 0.5h-2.109c-0.266 0-0.5-0.219-0.5-0.5v-2.734c-3.656-0.516-5.656-2.703-5.734-2.797-0.156-0.187-0.172-0.453-0.031-0.641l1.609-2.109c0.078-0.109 0.219-0.172 0.359-0.187s0.281 0.031 0.375 0.141c0.031 0.016 2.219 2.109 4.984 2.109 1.531 0 3.187-0.812 3.187-2.578 0-1.5-1.844-2.234-3.953-3.078-2.812-1.109-6.312-2.516-6.312-6.438 0-2.875 2.25-5.25 5.516-5.875v-2.812c0-0.281 0.234-0.5 0.5-0.5h2.109c0.281 0 0.5 0.219 0.5 0.5v2.75c3.172 0.359 4.859 2.078 4.922 2.141 0.156 0.172 0.187 0.406 0.078 0.594l-1.266 2.281c-0.078 0.141-0.203 0.234-0.359 0.25-0.156 0.031-0.297-0.016-0.422-0.109-0.016-0.016-1.906-1.687-4.25-1.687-1.984 0-3.359 0.984-3.359 2.406 0 1.656 1.906 2.391 4.125 3.25 2.875 1.109 6.125 2.375 6.125 6.141z"></path>
                    </symbol>
                </defs>
                </svg>

                <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-truck" viewBox="0 0 32 32">
                        <path d="M32 18l-4-8h-6v-4c0-1.1-0.9-2-2-2h-18c-1.1 0-2 0.9-2 2v16l2 2h2.536c-0.341 0.588-0.536 1.271-0.536 2 0 2.209 1.791 4 4 4s4-1.791 4-4c0-0.729-0.196-1.412-0.536-2h11.073c-0.341 0.588-0.537 1.271-0.537 2 0 2.209 1.791 4 4 4s4-1.791 4-4c0-0.729-0.196-1.412-0.537-2h2.537v-6zM22 18v-6h4.146l3 6h-7.146z"></path>
                        </symbol>
                    </defs>
                </svg>

                 <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-person-with-shopping-cart">
                            <path fill="currentColor" cx="91.208" cy="487.324" r="28.252" d="M4.153 16.942A0.982 0.982 0 0 1 3.171 17.924A0.982 0.982 0 0 1 2.189 16.942A0.982 0.982 0 0 1 4.153 16.942z"/>
                             <path fill="currentColor" cx="224.394" cy="487.324" r="28.252" d="M8.783 16.942A0.982 0.982 0 0 1 7.801 17.924A0.982 0.982 0 0 1 6.819 16.942A0.982 0.982 0 0 1 8.783 16.942z"/>
                             <path fill="currentColor" d="m0.291 9.672 2.018 5.819c0.008 0.046 0.052 0.133 0.099 0.134h6.194c0.047 0 0.088 -0.037 0.093 -0.084l0.004 -6.791c0 -0.043 0.038 -0.085 0.085 -0.085h0.748a0.085 0.085 0 0 0 0.085 -0.085v-0.483a0.085 0.085 0 0 0 -0.085 -0.085h-1.482a0.085 0.085 0 0 0 -0.085 0.085v1.391a0.085 0.085 0 0 1 -0.085 0.085H0.361c-0.047 0 -0.079 0.052 -0.071 0.098m7.711 4.812a0.085 0.085 0 0 1 -0.085 0.085H2.733a0.085 0.085 0 0 1 -0.085 -0.085v-0.425a0.085 0.085 0 0 1 0.085 -0.085h5.184a0.085 0.085 0 0 1 0.085 0.085v0.425zm0 -1.132a0.085 0.085 0 0 1 -0.085 0.085H2.274a0.085 0.085 0 0 1 -0.085 -0.085v-0.425a0.085 0.085 0 0 1 0.085 -0.085h5.643a0.085 0.085 0 0 1 0.085 0.085v0.425zm0 -1.122a0.085 0.085 0 0 1 -0.085 0.085H1.882a0.085 0.085 0 0 1 -0.085 -0.085V11.805a0.085 0.085 0 0 1 0.085 -0.085h6.035a0.085 0.085 0 0 1 0.085 0.085v0.425zM1.415 10.705a0.085 0.085 0 0 1 0.085 -0.085h6.417a0.085 0.085 0 0 1 0.085 0.085v0.425a0.085 0.085 0 0 1 -0.085 0.085H1.5a0.085 0.085 0 0 1 -0.085 -0.085z"/>
                             <path fill="currentColor" cx="365.202" cy="42.003" r="42.003" d="M14.157 1.46A1.46 1.46 0 0 1 12.697 2.921A1.46 1.46 0 0 1 11.236 1.46A1.46 1.46 0 0 1 14.157 1.46z"/>
                             <path fill="currentColor" d="M16.273 17.447c0.083 0.332 0.38 0.553 0.707 0.553 0.059 0 0.118 -0.007 0.177 -0.022 0.391 -0.097 0.629 -0.493 0.532 -0.884l-1.831 -7.347c0.193 -0.063 0.534 -0.289 0.437 -0.993L15.297 3.286c-0.032 -0.173 -0.189 -0.289 -0.351 -0.259l-2.253 0.433c-0.018 0.003 -0.036 0.006 -0.054 0.01l-0.032 0.006c-0.023 0.004 -0.044 0.011 -0.064 0.02 -0.184 0.066 -0.343 0.203 -0.429 0.395l-0.884 1.999s-1.038 0.244 -1.229 0.29l-0.404 0.094c-0.392 0.092 -0.636 0.484 -0.545 0.876 0.078 0.337 0.378 0.564 0.71 0.564 0.055 0 0.111 -0.006 0.166 -0.019l1.309 -0.305c0.036 -0.008 0.069 -0.022 0.101 -0.035l0.598 -0.141a0.747 0.747 0 0 0 0.505 -0.42l0.332 -0.736 0.6 3.379 -2.022 2.838a0.73 0.73 0 0 0 -0.134 0.373l-0.316 4.572c-0.028 0.402 0.276 0.75 0.678 0.778q0.026 0.002 0.051 0.002c0.38 0 0.7 -0.294 0.727 -0.679l0.302 -4.367 1.847 -2.592z"/>
                        </symbol>
                    </defs>
                 </svg>

                 <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-file-text2" viewBox="0 0 32 32">
                            <path d="M28.681 7.159c-0.694-0.947-1.662-2.053-2.724-3.116s-2.169-2.030-3.116-2.724c-1.612-1.182-2.393-1.319-2.841-1.319h-15.5c-1.378 0-2.5 1.121-2.5 2.5v27c0 1.378 1.122 2.5 2.5 2.5h23c1.378 0 2.5-1.122 2.5-2.5v-19.5c0-0.448-0.137-1.23-1.319-2.841zM24.543 5.457c0.959 0.959 1.712 1.825 2.268 2.543h-4.811v-4.811c0.718 0.556 1.584 1.309 2.543 2.268zM28 29.5c0 0.271-0.229 0.5-0.5 0.5h-23c-0.271 0-0.5-0.229-0.5-0.5v-27c0-0.271 0.229-0.5 0.5-0.5 0 0 15.499-0 15.5 0v7c0 0.552 0.448 1 1 1h7v19.5z"></path>
                            <path d="M23 26h-14c-0.552 0-1-0.448-1-1s0.448-1 1-1h14c0.552 0 1 0.448 1 1s-0.448 1-1 1z"></path>
                            <path d="M23 22h-14c-0.552 0-1-0.448-1-1s0.448-1 1-1h14c0.552 0 1 0.448 1 1s-0.448 1-1 1z"></path>
                            <path d="M23 18h-14c-0.552 0-1-0.448-1-1s0.448-1 1-1h14c0.552 0 1 0.448 1 1s-0.448 1-1 1z"></path>
                        </symbol>
                    </defs>
                </svg>

                <svg id="icon-tasks" style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tasks" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path>
                </svg>

                <svg id="icon-file-invoice-dollar" style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-invoice-dollar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                >
                    <path fill="currentColor" d="M377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zM64 72c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8V72zm0 80v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8zm144 263.88V440c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-24.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V232c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v24.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07z"></path>
                </svg>

                <svg id="icon-dollar-sign" style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512">
                    <path fill="currentColor" d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"></path>
                </svg>

                <svg version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 438.891 438.891"style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas">

                            <path d="M347.968,57.503h-39.706V39.74c0-5.747-6.269-8.359-12.016-8.359h-30.824c-7.314-20.898-25.6-31.347-46.498-31.347
                                c-20.668-0.777-39.467,11.896-46.498,31.347h-30.302c-5.747,0-11.494,2.612-11.494,8.359v17.763H90.923
                                c-23.53,0.251-42.78,18.813-43.886,42.318v299.363c0,22.988,20.898,39.706,43.886,39.706h257.045
                                c22.988,0,43.886-16.718,43.886-39.706V99.822C390.748,76.316,371.498,57.754,347.968,57.503z M151.527,52.279h28.735
                                c5.016-0.612,9.045-4.428,9.927-9.404c3.094-13.474,14.915-23.146,28.735-23.51c13.692,0.415,25.335,10.117,28.212,23.51
                                c0.937,5.148,5.232,9.013,10.449,9.404h29.78v41.796H151.527V52.279z M370.956,399.185c0,11.494-11.494,18.808-22.988,18.808
                                H90.923c-11.494,0-22.988-7.314-22.988-18.808V99.822c1.066-11.964,10.978-21.201,22.988-21.42h39.706v26.645
                                c0.552,5.854,5.622,10.233,11.494,9.927h154.122c5.98,0.327,11.209-3.992,12.016-9.927V78.401h39.706
                                c12.009,0.22,21.922,9.456,22.988,21.42V399.185z"/>
                            <path d="M179.217,233.569c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437,31.869l-14.106-14.629
                                c-3.919-4.131-10.425-4.363-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                C179.628,233.962,179.427,233.761,179.217,233.569z"/>
                            <path d="M329.16,256.034H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                c5.771,0,10.449-4.678,10.449-10.449S334.931,256.034,329.16,256.034z"/>
                            <path d="M179.217,149.977c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437,31.869l-14.106-14.629
                                c-3.919-4.131-10.425-4.364-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                C179.628,150.37,179.427,150.169,179.217,149.977z"/>
                            <path d="M329.16,172.442H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                c5.771,0,10.449-4.678,10.449-10.449S334.931,172.442,329.16,172.442z"/>
                            <path d="M179.217,317.16c-3.919-4.131-10.425-4.363-14.629-0.522l-33.437,31.869l-14.106-14.629
                                c-3.919-4.131-10.425-4.363-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                C179.628,317.554,179.427,317.353,179.217,317.16z"/>
                            <path d="M329.16,339.626H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                c5.771,0,10.449-4.678,10.449-10.449S334.931,339.626,329.16,339.626z"/>

                </svg>
                <svg class="svg-inline--fa fa-boxes fa-w-18" role="img" 
                id="icon-boxes-sign" style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="boxes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M488.6 250.2L392 214V105.5c0-15-9.3-28.4-23.4-33.7l-100-37.5c-8.1-3.1-17.1-3.1-25.3 0l-100 37.5c-14.1 5.3-23.4 18.7-23.4 33.7V214l-96.6 36.2C9.3 255.5 0 268.9 0 283.9V394c0 13.6 7.7 26.1 19.9 32.2l100 50c10.1 5.1 22.1 5.1 32.2 0l103.9-52 103.9 52c10.1 5.1 22.1 5.1 32.2 0l100-50c12.2-6.1 19.9-18.6 19.9-32.2V283.9c0-15-9.3-28.4-23.4-33.7zM358 214.8l-85 31.9v-68.2l85-37v73.3zM154 104.1l102-38.2 102 38.2v.6l-102 41.4-102-41.4v-.6zm84 291.1l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6zm240 112l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6z"/>
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460 512" role="img" id="icon-ontrack" style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas"
                    data-icon="ontrack" viewBox="0 0 576 512">
                    <path d="M220.6 130.3l-67.2 28.2V43.2L98.7 233.5l54.7-24.2v130.3l67.2-209.3zm-83.2-96.7l-1.3 4.7-15.2 52.9C80.6 106.7 52 145.8 52 191.5c0 52.3 34.3 95.9 83.4 105.5v53.6C57.5 340.1 0 272.4 0 191.6c0-80.5 59.8-147.2 137.4-158zm311.4 447.2c-11.2 11.2-23.1 12.3-28.6 10.5-5.4-1.8-27.1-19.9-60.4-44.4-33.3-24.6-33.6-35.7-43-56.7-9.4-20.9-30.4-42.6-57.5-52.4l-9.7-14.7c-24.7 16.9-53 26.9-81.3 28.7l2.1-6.6 15.9-49.5c46.5-11.9 80.9-54 80.9-104.2 0-54.5-38.4-102.1-96-107.1V32.3C254.4 37.4 320 106.8 320 191.6c0 33.6-11.2 64.7-29 90.4l14.6 9.6c9.8 27.1 31.5 48 52.4 57.4s32.2 9.7 56.8 43c24.6 33.2 42.7 54.9 44.5 60.3s.7 17.3-10.5 28.5zm-9.9-17.9c0-4.4-3.6-8-8-8s-8 3.6-8 8 3.6 8 8 8 8-3.6 8-8z"/>
                </svg>
                
                <svg id="icon-regulatory-request" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" role="img"  style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false" data-prefix="fas"  data-icon="regulatory-request">
                    <g id="Layer_1-2">
                        <g>
                            <line x1="215.07" y1="204.17" x2="151.09" y2="204.17" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:20px;" />
                            <line x1="215.07" y1="257.43" x2="151.09" y2="257.43" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:20px;"/>
                            <line x1="238.61" y1="310.69" x2="151.09" y2="310.69" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:20px;" />
                            <path d="m335.17,349.84v10.07c0,13.25-10.74,24-24,24H118.97c-13.25,0-24-10.74-24-24v-208.42" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:50px;" />
                            <path d="m172.87,73.59v60.9c0,9.39-7.61,17-17,17h-60.9l77.9-77.9h138.3c13.25,0,24,10.74,24,24v33.74" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:50px;" />
                            <line x1="443.74" y1="346.45" x2="388.44" y2="291.15" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:20px;" />
                            <circle cx="336.93" cy="239.63" r="71.21" style="fill:none; stroke:currentColor;stroke-linecap:round; stroke-linejoin:round; stroke-width:50px;" />
                        </g>
                    </g>
                </svg>
                {* End of Custom SVGs *}

                {if !empty($smarty.session.sudo_user_id)}
                <div id="actionMenuSidebar" class="actionMenuSidebar">
                    <ul>
                        <li class="actionmenulinks" role="presentation">
                            <a href="index.php?entryPoint=switchUserEntryPoint&back_to_sudo={$smarty.session.sudo_user_id}&back_to_admin=true" data-action-name="Logout Sudo">
                                <div class="side-bar-action-icon">
                                     <span class="suitepicon suitepicon-action-"></span>
                                </div>
                                <div class="actionmenulink">Sudo Logout</div>
                            </a>
                        </li>
                    </ul>
                </div>
                {/if}
                {if !empty($smarty.session.sudo_user_ids) && count($smarty.session.sudo_user_ids) > 1  }
                <div id="actionMenuSidebar" class="actionMenuSidebar">
                    <ul>
                        <li class="actionmenulinks" role="presentation">
                            <a href="index.php?entryPoint=sudoLoginUser&back_to_sudo={$smarty.session.sudo_user_id}" data-action-name="Logout Sudo">
                                <div class="side-bar-action-icon">
                                     <span class="suitepicon suitepicon-action-"></span>
                                </div>
                                <div class="actionmenulink">Sudo Logout as {$CURRENT_USER_NAME}</div>
                            </a>
                        </li>
                    </ul>
                </div>
                {/if}
                <!-- end of customization -->
                
                <div id="recentlyViewedSidebar" class="recentlyViewedSidebar">
                    {if is_array($recentRecords) && count($recentRecords) > 0}
                    <h2 class="recent_h3">{$APP.LBL_LAST_VIEWED}</h2>
                    {/if}
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$recentRecords item=item name=lastViewed}
                            {if $item.module_name != 'Emails' && $item.module_name != 'InboundEmail' && $item.module_name != 'EmailAddresses'}<!--Check to ensure that recently viewed emails or email addresses are not displayed in the recently viewed panel.-->
                                {if $smarty.foreach.lastViewed.index < 5}
                                    <div class="recently_viewed_link_container_sidebar">
                                        <li class="recentlinks" role="presentation">
                                            {* Custom Codes *}
                                            {if $item.module_name == 'AOS_Invoices'}
                                                {assign var="strTitle" value='Invoices'}
                                            {elseif $item.module_name == 'ODR_SalesOrders'}
                                                {assign var="strTitle" value='Orders'}
                                            {elseif $item.module_name == 'RRQ_RegulatoryRequests'}
                                                {assign var="strTitle" value='Regulatory Requests'}
                                            {elseif $item.module_name == 'OTR_OnTrack'}
                                                {assign var="strTitle" value='On Track'}
                                            {elseif $item.record_number == "" || $item.record_number == null }
                                                {if $item.module_name == 'CI_CustomerItems'}
                                                    {assign var="strTitle" value='Customer Products'}
                                                {else}
                                                    {assign var="strTitle" value="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"}
                                                {/if}
                                            {elseif $item.module_name == 'CI_CustomerItems'}
                                                {assign var="strTitle" value='Customer Products'}
                                            {elseif $item.module_name == 'MDM_ModuleManagement'}
                                                {assign var="strTitle" value='Module Management'}
                                            {else}
                                                {assign var="strTitle" value=$item.record_number}
                                            {/if}
                                            
                                            {assign var="module_class_name" value=$item.module_name}
                                            
                                            {if $item.module_name == 'Opportunities'}
                                                {assign var="module_class_name" value="opportunities-custom"}
                                            {elseif $item.module_name == 'AOS_Products'}
                                                {assign var="module_class_name" value="aos_products-custom"}
                                            {elseif $item.module_name == 'AOS_Invoices'}
                                                {assign var="module_class_name" value="aos_invoices-custom"}
                                            {elseif $item.module_name == 'ODR_SalesOrders'}
                                                {assign var="module_class_name" value="odr_salesorders-custom"}
                                            {elseif $item.module_name == 'OTR_OnTrack'}
                                                {assign var="module_class_name" value="ontrack-custom"}
                                            {elseif $item.module_name == 'RRQ_RegulatoryRequests'}
                                                {assign var="module_class_name" value="rrq_regulatoryrequests-custom"}
                                            {/if}
                                            {* End of Custom Codes *}

                                            <a title="{$strTitle}"
                                               accessKey="{$smarty.foreach.lastViewed.iteration}"
                                               href="{sugar_link module=$item.module_name action='DetailView' record=$item.item_id link_only=1}"
                                               class="recent-links-detail">
                                                <span class="suitepicon suitepicon-module-{$module_class_name|lower|replace:'_':'-'}">
                                                    {if $item.module_name == 'AOS_Products'} {* Custom Codes *}
                                                        <div><svg class="custom-svg-icon icon-lab"><use xlink:href="#icon-lab"></use></svg></div>
                                                    {elseif $item.module_name eq 'Opportunities'}
                                                        <div><svg class="custom-svg-icon icon-dollar"><use xlink:href="#icon-dollar"></use></svg></div>
                                                    {elseif $item.module_name eq 'TR_TechnicalRequests'}
                                                        <div><svg class="custom-svg-icon icon-file-text2"><use xlink:href="#icon-file-text2"></use></svg></div>
                                                    {elseif $item.module_name eq 'DSBTN_Distribution'}
                                                        <div><svg class="custom-svg-icon icon-truck"><use xlink:href="#icon-truck"></use></svg></div>
                                                    {elseif $item.module_name eq 'CI_CustomerItems'}
                                                        <div><svg class="custom-svg-icon icon-person-with-shopping-cart" transform="scale(-1 1)"><use xlink:href="#icon-person-with-shopping-cart"></use></svg></div>
                                                    {elseif $item.module_name eq 'TRI_TechnicalRequestItems'}
                                                        <div><svg class="custom-svg-icon icon-tasks"><use xlink:href="#icon-tasks"></use></svg></div>
                                                    {elseif $item.module_name eq 'AOS_Invoices'}
                                                        <div><svg class="custom-svg-icon file-invoice-dollar"><use xlink:href="#icon-file-invoice-dollar"></use></svg></div>
                                                    {elseif $item.module_name eq 'ODR_SalesOrders'}
                                                        <div><svg class="custom-svg-icon Capa_1"><use xlink:href="#Capa_1"></use></svg></div>
                                                    {elseif $item.module_name eq 'MDM_ModuleManagement'}
                                                        <div><svg class="custom-svg-icon icon-boxes-sign"><use xlink:href="#icon-boxes-sign"></use></svg></div>
                                                    {elseif $item.module_name eq 'OTR_OnTrack'}
                                                        <div><svg class="custom-svg-icon icon-ontrack"><use xlink:href="#icon-ontrack"></use></svg></div>
                                                    {elseif $item.module_name eq 'RRQ_RegulatoryRequests'}
                                                        <div><svg class="custom-svg-icon icon-regulatory-request"><use xlink:href="#icon-regulatory-request"></use></svg></div>
                                                    {/if} 
                                                    
                                                    {* End of Custom Codes *}
                                                </span>
                                                <span style="font-size: 13px;">{$item.item_summary_short}</span>
                                            </a>
                                            {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                                            {if $access}
                                                <a href="{sugar_link module=$item.module_name action='EditView' record=$item.item_id link_only=1}" class="recent-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                            {/if}
                                        </li>
                                    </div>
                                {/if}
                            {/if}
                        {/foreach}
                    </ul>
                </div>
                 <div id="favoritesSidebar" class="favoritesSidebar">
                {if is_array($favoriteRecords) && count($favoriteRecords) > 0}
                    <h2 class="recent_h3">{$APP.LBL_FAVORITES}</h2>
                {/if}
                    <ul class="nav nav-pills nav-stacked">
                        {foreach from=$favoriteRecords item=item name=lastViewed}
                            {if $smarty.foreach.lastViewed.index < 5}
                            <div class="recently_viewed_link_container_sidebar">
                                <li class="recentlinks" role="presentation">
                                    <a title="{sugar_translate module=$item.module_name label=LBL_MODULE_NAME}"
                                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}"
                                       class="favorite-links-detail">
                                        <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                                        <span aria-hidden="true">{$item.item_summary_short}</span>
                                    </a>
                                    {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.id }{/capture}
                                    {if $access}
                                        <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                                    {/if}
                                </li>
                            </div>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>
        <!--</div>-->
    </div>
    <!--End Responsive Sidebar -->
{/if}
<!--Start Page content -->

<!-- OnTrack #1480 -->
<link rel="stylesheet" type="text/css" href="./custom/include/DataTables/datatables.css"/>
<link rel="stylesheet" type="text/css" href="./custom/include/DataTables/select.dataTables.min.css"/>
<script src="./custom/include/DataTables/datatables.min.js"></script>
<script src="./custom/include/DataTables/dataTables.select.min.js"></script>