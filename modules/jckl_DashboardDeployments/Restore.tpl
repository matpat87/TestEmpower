<script src="modules/jckl_DashboardDeployments/js/restore.js"></script>
<link rel="stylesheet" href="modules/jckl_DashboardTemplates/css/select2.bootstrap.min.css">
<div class="moduleTitle">
    <h1>{$MOD.LBL_MODULE_NAME}</h1>
</div>
<br/>
<form action="index.php?module={$MODULE}&action={$ACTION}&record={$DEPLOYMENT_ID}" method="POST">
    <input type="hidden" name="module" value="{$MODULE}">
    <input type="hidden" name="action" value="{$ACTION}">
    <input type="hidden" name="record" id="deployment_record" value="{$DEPLOYMENT_ID}">
    <input type="hidden" name="confirm" value="true">
    <table class="panelContainer">
        <tbody>
        <tr class="row" style="line-height: 30px">
            <td colspan="2">
                <h2>{$MOD.LBL_CONFIRM_RESTORE} {$USER_NAME}</h2>
                <p>{$MOD.LBL_CONFIRM_DETAIL}</p>
            </td>
        </tr>

        <tr class="row table_row" style="line-height: 30px">
            <td><input type="submit" class="button" value="{$MOD.LBL_SUBMIT}"></td>
            <td><button class="button" id="cancel_restore">{$MOD.LBL_CANCEL_RESTORE}</button></td>
        </tr>
        </tbody>
    </table>
</form>
<br/>



