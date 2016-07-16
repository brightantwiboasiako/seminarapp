<div class="modal fade" tabindex="-1" role="dialog" id="edit-seminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit @{{ selected.title }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 text-left">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="selected.title" placeholder="Seminar Title"/>
                    </div>
                    <div class="form-group col-md-6 text-left">
                        <label>Location</label>
                        <input type="text" class="form-control" v-model="selected.location" placeholder="Where will this seminar happen?"/>
                    </div>
                    <div class="form-group col-md-6 text-left">
                        <label>Date</label>
                        <input type="text" class="form-control datetime" v-model="selected.date" placeholder="When is the seminar?"/>
                    </div>
                    <div class="form-group col-md-6 text-left">
                        <label>Registration Deadline</label>
                        <input type="text" class="form-control datetime" v-model="selected.registration_deadline" placeholder="Registration Deadline"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left processing"></span>
                <input type="hidden" v-model="selected.id"/>
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-xs btn-primary" @click="modifySelected">Modify</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->