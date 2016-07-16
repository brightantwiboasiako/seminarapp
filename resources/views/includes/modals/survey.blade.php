<div class="modal fade" tabindex="-1" role="dialog" id="type-in-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Just before you go...</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 text-left">
                        <label>Would you like the programme to be organized again?</label>
                        <select v-model="typeInQuestions.again" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 text-left">
                        <label>What is your view about the timing (Date and Time) of the programme?</label>
                        <input type="text" class="form-control" v-model="typeInQuestions.date_time"/>
                    </div>
                    <div class="form-group col-md-12 text-left">
                        <label>Any other thing we need to know?</label>
                        <textarea class="form-control" v-model="typeInQuestions.any_other"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left processing"></span>
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal" @click="previous">Close</button>
                <button type="button" class="btn btn-xs btn-success" @click="submit">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->