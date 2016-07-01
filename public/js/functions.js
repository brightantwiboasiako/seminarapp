/**
 * Created by Bright on 6/29/2016.
 */
/**
 * Gets the base of the application
 * @returns {string}
 */
function baseUrl() {
    return $('meta[name=app-root]').attr('content').replace(/\/$/, "");
}

function bindErrors(errors, parentElement){
    errors = prepareErrors(errors);
    errors.forEach(function(errorSet){
        console.log(errorSet);
        $(parentElement).find('[name='+ errorSet.key +']').validationEngine('showPrompt', errorSet.value[0], 'error');
    });
}

function prepareErrors(errors){
    return  $.map(errors, function(value, index){
        return [{
            'key': index,
            'value': value
        }];
    });
}


function pushInfo(reference, message){
    reference.html(message);
}

function clearInfo(reference){
    reference.html('');
}


function alert(message, type, onOk){

    var icon = '<i class="fa fa-check-circle fa-fw fa-lg"></i>';

    if(type === undefined || type === 'success'){
        type = 'success';
        title = icon + ' SUCCESS';
    }else if(type === 'danger'){
        icon = '<i class="fa fa-times-circle fa-fw fa-lg"></i>';
        title = icon + ' DANGER';
    }else if(type === 'warning'){
        icon = '<i class="fa fa-warning fa-fw fa-lg"></i>';
        title = icon + ' WARNING';
    }else{
        icon = '<i class="fa fa-info-circle fa-fw fa-lg"></i>';
        title = icon + ' INFORMATION';
    }


    alertify.alert()
        .setting({
            'label':'OK',
            'message': message ,
            'onok': onOk,
            'closable': false,
            'title': title,
            'transition':'zoom'
        }).show();

    var types = ["danger", "warning", "info", "success"];
    var index = types.indexOf(type);

    if(index > -1){
        types.slice(index, 1);
    }

    types.forEach(function(t){
        $('.ajs-header').removeClass('ajs-'+t);
    });

    $('.ajs-header').addClass('ajs-'+type);

}

function confirm(message, onOk, onCancel, onClose){

    alertify.confirm("<i class='fa fa-exclamation-circle'></i> CONFIRMATION", message, function(){
            onOk();
        },function(){
            onCancel();
        })
        .setting({
            'closable': false,
            'transition':'zoom',
            'onclose': onClose
        }).show();

    $('.ajs-header').addClass('ajs-warning');
}