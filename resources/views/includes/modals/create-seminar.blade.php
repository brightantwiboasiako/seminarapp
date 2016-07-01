<div class="modal fade" tabindex="-1" role="dialog" id="create-seminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Seminar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" v-model="newSeminar.title" placeholder="Seminar Title"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" v-model="newSeminar.location" placeholder="Where will this seminar happen?"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control datetime" v-model="newSeminar.date" placeholder="When is the seminar?"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control datetime" v-model="newSeminar.registration_deadline" placeholder="Registration Deadline"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left processing"></span>
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-xs btn-primary" @click="createSeminar">Create</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->