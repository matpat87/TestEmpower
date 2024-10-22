<script type="text/javascript" src="modules/jckl_DashboardTemplates/js/select2.min.js"></script>
<script type="text/javascript" src="modules/jckl_DashboardTemplates/js/deploy.js"></script>
<link rel="stylesheet" href="modules/jckl_DashboardTemplates/css/select2.min.css">
<link rel="stylesheet" href="modules/jckl_DashboardTemplates/css/select2.bootstrap.min.css">
<div class="moduleTitle">
    <h1>{$MOD.LBL_MODULE_NAME}</h1>
</div>
<br/>
<form action="index.php?module={$MODULE}&action={$ACTION}&step={$NEXT_STEP}&template={$TEMPLATE_ID}" method="post">
    <input type="hidden" name="module" value="{$MODULE}">
    <input type="hidden" name="action" value="{$ACTION}">
    <input type="hidden" name="step" value="{$NEXT_STEP}">
    <input type="hidden" name="deploy_type" value="{$DEPLOY_TYPE}">
    <input type="hidden" name="template" value="{$TEMPLATE_ID}">
    <table class="panelContainer" style="width:50%">
        <tbody>
        <tr class="row" style="line-height: 30px">
            <td>
                <label for="select_deployment_ids">{if $DEPLOY_TYPE eq 'role'}
                    {$MOD.LBL_OPTION_TYPE_ROLES} <br/>{$MOD.LBL_DEPLOY_ONLY_WITH_USERS}
                {elseif $DEPLOY_TYPE eq 'users'}
                    {$MOD.LBL_OPTION_TYPE_USERS}
                {else}
                    {$MOD.LBL_OPTION_TYPE_GROUPS} <br/>{$MOD.LBL_DEPLOY_ONLY_WITH_USERS}
                {/if}
                </label>
            </td>
        </tr>
        <tr class="row" style="line-height: 30px">
            <td>
                <div class="form-group">
                    <select class="form-control" name="select_deployment_ids[]" id="select_deployment_ids" required="required" multiple="multiple">
                        {html_options options=$SELECTIONS }
                    </select>
                </div>
            </td>
            <td>
                <input type="button" id="select_all" class="button" value="{$MOD.LBL_SELECT_ALL_BUTTON}">
            </td>
        </tr>
        <tr class="row table_row" style="line-height: 30px">
            <td><input type="submit" class="button" value="{$MOD.LBL_STEP_COMMIT}"></td>
        </tr>
        </tbody>
    </table>
</form>
