<script type='text/javascript' src='{sugar_getjspath file='custom/include/js/custom-listview.js'}'></script>

<td  nowrap='nowrap' align="right" class='paginationChangeButtons' width="1%" style="vertical-align: top">
    {if $pageData.urls.startPage}
        <button type='button' id='listViewStartButton_{$action_menu_location}' name='listViewStartButton' title='{$navStrings.start}' class='btn btn-sm' {if $prerow}onclick='return sListView.save_checks(0, "{$moduleString}");'{else} onClick='location.href="{$pageData.urls.startPage}"' {/if}>
            <span class='suitepicon suitepicon-action-first'></span>
        </button>
    {else}
        <button type='button' id='listViewStartButton_{$action_menu_location}' name='listViewStartButton' title='{$navStrings.start}' class='btn-sm' disabled='disabled' style="padding:7px 10px;height:30px;">
            <span class='suitepicon suitepicon-action-first'></span>
        </button>
    {/if}
    {if $pageData.urls.prevPage}
        <button style="padding-right:20px" type='button' id='listViewPrevButton_{$action_menu_location}' name='listViewPrevButton' title='{$navStrings.previous}' class='btn btn-sm' {if $prerow}onclick='return sListView.save_checks({$pageData.offsets.prev}, "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.prevPage}"'{/if}>
            <span class='suitepicon suitepicon-action-left'></span>
        </button>
    {else}
        <button type='button' id='listViewPrevButton_{$action_menu_location}' name='listViewPrevButton' class='btn-sm' title='{$navStrings.previous}' disabled='disabled' style="padding:7px 10px;height:30px;">
            <span class='suitepicon suitepicon-action-left'></span>
        </button>
    {/if}
</td>
{ custom_listview_pagination pageDataOffsets=$pageData.offsets moduleString=$moduleString action_menu_location=$action_menu_location prerow=$prerow pageData=$pageData}

<td nowrap='nowrap' align="right" class='paginationActionButtons' width="1%" style="vertical-align: top">
    {if $pageData.urls.nextPage}
        <button type='button' style="margin-right:0;" id='listViewNextButton_{$action_menu_location}' name='listViewNextButton' title='{$navStrings.next}' class='btn btn-sm' {if $prerow}onclick='return sListView.save_checks({$pageData.offsets.next}, "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.nextPage}"'{/if}>
            <span class='suitepicon suitepicon-action-right'></span>
        </button>
    {else}
        <button type='button' id='listViewNextButton_{$action_menu_location}' name='listViewNextButton' class='btn-sm' title='{$navStrings.next}' disabled='disabled' style="padding:7px 10px;height:30px;">
            <span class='suitepicon suitepicon-action-right'></span>
        </button>
    {/if}
    {if $pageData.urls.endPage  && $pageData.offsets.total != $pageData.offsets.lastOffsetOnPage}
        <button type='button' id='listViewEndButton_{$action_menu_location}' name='listViewEndButton' title='{$navStrings.end}' class='btn btn-sm' {if $prerow}onclick='return sListView.save_checks("end", "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.endPage}"'{/if}>
            <span class='suitepicon suitepicon-action-last'></span>
        </button>
    {elseif !$pageData.offsets.totalCounted || $pageData.offsets.total == $pageData.offsets.lastOffsetOnPage}
        <button type='button' id='listViewEndButton_{$action_menu_location}' name='listViewEndButton' title='{$navStrings.end}' class='btn-sm' disabled='disabled' style="padding:7px 10px;height:30px;">
            <span class='suitepicon suitepicon-action-last'></span>
        </button>
    {/if}

</td>


<td nowrap='nowrap' width="4px" class="paginationActionButtons" style='border-top-right-radius: 4px;'></td> {* APX Custom Codes: Added Style *}