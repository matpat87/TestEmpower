<div id="management-update-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="background-color: white;">
        <div class="modal-header">
            <h5 class="modal-title" style="font-weight: bolder">Management Update: {$pageData.bean.moduleDir}</h5>
        </div>
        <div class="modal-body col-md-12">
            
                <div class="row">
                    <input type="hidden" class="form-control" name="current_module" value={$pageData.bean.moduleDir} />
                    <input type="hidden" class="form-control" name="activity_module" value='' />
                    <input type="hidden" class="form-control" name="record_id" value='' />
                    <input type="hidden" class="form-control" name="return_module" value={$pageData.bean.moduleDir} />
                </div>
                <div class="row">
                    <div class="col-md-5" style="text-align: center;">
                        <span>Management Update</span>
                    </div>
                    <div class="col-md-5">
                        <textarea type="text" class="form-control" name="management_update" id="management_update"></textarea>
                    </div>
                    
                </div>
                
            
        </div>
        <div class="modal-footer" style="display: flex;justify-content: start;">
            <button type="button" class="btn btn-primary" id="sar_management_update_submit" style="margin-bottom:0;">Save</button>
            <button type="button" class="btn btn-secondary" id="sar_management_update_close" data-dismiss="modal">Cancel</button>
        </div>
        
    </div>
</div>