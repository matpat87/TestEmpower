<script type="text/javascript" src="modules/jckl_DashboardTemplates/js/select2.min.js"></script>
<script type="text/javascript" src="modules/jckl_DashboardTemplates/js/deploy.js"></script>
<link rel="stylesheet" href="modules/jckl_DashboardTemplates/css/select2.min.css">
<link rel="stylesheet" href="modules/jckl_DashboardTemplates/css/select2.bootstrap.min.css">
<div class="moduleTitle">
    <h1>{$MOD.LBL_MODULE_NAME}</h1>
</div>
<br/>
<form action="index.php?module={$MODULE}&action={$ACTION}&step={$NEXT_STEP}&template={$TEMPLATE_ID}">
    <input type="hidden" name="module" value="{$MODULE}">
    <input type="hidden" name="action" value="{$ACTION}">
    <input type="hidden" name="template" value="{$TEMPLATE_ID}">
    <input type="hidden" name="step" value="{$NEXT_STEP}">
    <table class="panelContainer">
        <tbody>
            <tr class="row" style="line-height: 30px">
                <td>
                    <label for="deploy_type">{$MOD.LBL_SELECT_DEPLOY_TO_LIST}:</label>
                </td>
            </tr>
            <tr class="row" style="line-height: 30px">
                <td>
                    <div class="form-group">
                        <select class="form-control" name="deploy_type" id="deploy_type" required >
                            {html_options options=$DEPLOY_OPTIONS  }
                        </select>
                    </div>
                </td>
            </tr>
            <tr class="row table_row" style="line-height: 30px">
                <td><input type="submit" class="button" value="{$MOD.LBL_STEP_SUBMIT}"></td>
            </tr>
        </tbody>
    </table>
</form>

